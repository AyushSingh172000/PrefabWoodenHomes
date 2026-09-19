<?php
/**
 * Enquiry Form Handler — Prefab Wooden Homes
 * Validates, sanitizes, stores in DB, and sends email notification.
 */

header('Content-Type: application/json');

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/security.php';

// Only POST allowed
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

// Honeypot check (bot trap)
if (!empty($_POST['honeypot'])) {
    echo json_encode(['success' => true, 'message' => 'Thank you!']);
    exit;
}

// CSRF validation
$token = $_POST['csrf_token'] ?? '';
if (!validateCSRFToken($token)) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Session expired. Please refresh the page and try again.']);
    exit;
}

// Rate limiting
$clientIP = getClientIP();
if (!checkRateLimit($clientIP)) {
    http_response_code(429);
    echo json_encode(['success' => false, 'message' => 'Too many submissions. Please wait a while before trying again.']);
    exit;
}

// Sanitize inputs
$name         = sanitizeInput($_POST['name'] ?? '');
$email        = sanitizeInput($_POST['email'] ?? '');
$phone        = sanitizeInput($_POST['phone'] ?? '');
$project_type = sanitizeInput($_POST['project_type'] ?? '');
$location     = sanitizeInput($_POST['location'] ?? '');
$message      = sanitizeInput($_POST['message'] ?? '');

// Validate required fields
$errors = [];
if (empty($name) || strlen($name) < 2) {
    $errors[] = 'Please enter a valid name.';
}
if (!validateEmail($email)) {
    $errors[] = 'Please enter a valid email address.';
}
if (!empty($phone) && !validatePhone($phone)) {
    $errors[] = 'Please enter a valid Indian phone number.';
}
if (empty($message) || strlen($message) < 10) {
    $errors[] = 'Please enter a message (at least 10 characters).';
}
if (strlen($message) > 2000) {
    $errors[] = 'Message is too long (max 2000 characters).';
}

if (!empty($errors)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
    exit;
}

// Store in database
try {
    $db = Database::getConnection();

    $stmt = $db->prepare("
        INSERT INTO enquiries (name, email, phone, project_type, location, message, ip_address, created_at)
        VALUES (:name, :email, :phone, :project_type, :location, :message, :ip, NOW())
    ");

    $stmt->execute([
        ':name'         => $name,
        ':email'        => $email,
        ':phone'        => $phone,
        ':project_type' => $project_type,
        ':location'     => $location,
        ':message'      => $message,
        ':ip'           => $clientIP,
    ]);

    // Send email notification
    $to = CONTACT_EMAIL;
    $subject = "New Enquiry — " . $name . " | " . SITE_NAME;
    $body = "New enquiry received:\n\n";
    $body .= "Name: {$name}\n";
    $body .= "Email: {$email}\n";
    $body .= "Phone: {$phone}\n";
    $body .= "Project Type: {$project_type}\n";
    $body .= "Location: {$location}\n";
    $body .= "Message:\n{$message}\n\n";
    $body .= "IP: {$clientIP}\n";
    $body .= "Date: " . date('d M Y, h:i A') . "\n";

    $headers = "From: noreply@prefabwoodenhomes.com\r\n";
    $headers .= "Reply-To: {$email}\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    @mail($to, $subject, $body, $headers);

    echo json_encode(['success' => true, 'message' => 'Enquiry submitted successfully.']);

} catch (PDOException $e) {
    error_log("Enquiry DB Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Unable to submit your enquiry at the moment. Please try WhatsApp or call us directly.']);
}
