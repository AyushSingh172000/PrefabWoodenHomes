<?php
require_once __DIR__ . '/../includes/init.php';
$pageMeta = seoMeta(
    'Contact Us — Prefab Wooden Homes India',
    'Contact Prefab Wooden Homes for a free consultation and quote. Call +91 98104 33120 or visit our office in New Delhi. We construct wooden homes across India.',
    'contact wooden house builder, wooden house quote India, prefab homes enquiry, request site visit wooden home'
);
require_once __DIR__ . '/../includes/header.php';
?>

    <section class="page-banner">
        <div class="container reveal-up">
            <h1 class="page-banner__title">Contact Us</h1>
            <div class="page-banner__breadcrumb">
                <a href="<?= url() ?>">Home</a> &nbsp;/&nbsp; Contact Us
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="contact-grid reveal-up">
                <div class="contact-info">
                    <h2 class="contact-info__title">Let's Talk About Your Dream Home</h2>
                    <p class="contact-info__text">Whether you have a clear vision or are just exploring the idea of a wooden home, we'd love to hear from you. Get in touch for a free consultation, a no-obligation quote, or to schedule a site visit.</p>

                    <div class="contact-info__items">
                        <div class="contact-info__item">
                            <div class="contact-info__item-icon"><i class="fas fa-phone"></i></div>
                            <div>
                                <div class="contact-info__item-label">Call Us</div>
                                <div class="contact-info__item-value">
                                    <a href="tel:<?= formatPhoneLink(CONTACT_PHONE_AMAN) ?>">Aman Jha: <?= CONTACT_PHONE_AMAN ?></a><br>
                                    <a href="tel:<?= formatPhoneLink(CONTACT_PHONE_RAJEEV) ?>">Rajeev Jha: <?= CONTACT_PHONE_RAJEEV ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="contact-info__item">
                            <div class="contact-info__item-icon"><i class="fab fa-whatsapp"></i></div>
                            <div>
                                <div class="contact-info__item-label">WhatsApp</div>
                                <div class="contact-info__item-value">
                                    <a href="https://wa.me/<?= CONTACT_WHATSAPP ?>" target="_blank" rel="noopener"><?= CONTACT_PHONE_AMAN ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="contact-info__item">
                            <div class="contact-info__item-icon"><i class="fas fa-envelope"></i></div>
                            <div>
                                <div class="contact-info__item-label">Email</div>
                                <div class="contact-info__item-value">
                                    <a href="mailto:<?= CONTACT_EMAIL ?>"><?= CONTACT_EMAIL ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="contact-info__item">
                            <div class="contact-info__item-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <div>
                                <div class="contact-info__item-label">Visit Our Office</div>
                                <div class="contact-info__item-value"><?= CONTACT_ADDRESS ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="contact-form" id="contactFormWrapper">
                    <h3 style="font-family: var(--font-display); font-size: var(--text-2xl); margin-bottom: var(--space-6); color: var(--color-forest-900);">Send Us an Enquiry</h3>
                    <div class="form-message" id="formMessage"></div>
                    <form id="contactForm" method="POST" novalidate>
                        <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                        <input type="text" name="honeypot" style="display:none" tabindex="-1" autocomplete="off">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name">Full Name <span class="required">*</span></label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Your full name" required maxlength="100">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" id="phone" name="phone" class="form-control" placeholder="+91 98XXX XXXXX" maxlength="15">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address <span class="required">*</span></label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="your@email.com" required maxlength="150">
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="project_type">Project Type</label>
                                <select id="project_type" name="project_type" class="form-control">
                                    <option value="">Select project type</option>
                                    <option value="prefab-house">Prefab Wooden House</option>
                                    <option value="cottage">Wooden Cottage</option>
                                    <option value="farmhouse">Wooden Farmhouse</option>
                                    <option value="villa">Wooden Villa</option>
                                    <option value="resort-cottage">Resort Cottage</option>
                                    <option value="tree-house">Tree House</option>
                                    <option value="gazebo-pergola">Gazebo / Pergola</option>
                                    <option value="commercial">Commercial / Restaurant</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="location">Project Location</label>
                                <input type="text" id="location" name="location" class="form-control" placeholder="City, State" maxlength="100">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="message">Your Message <span class="required">*</span></label>
                            <textarea id="message" name="message" class="form-control" placeholder="Tell us about your project — size, requirements, budget range, timeline..." required maxlength="2000"></textarea>
                        </div>
                        <button type="submit" class="btn btn--primary btn--lg btn-magnetic" style="width: 100%;">
                            Submit Enquiry
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Map -->
    <section class="section section--alt">
        <div class="container">
            <div class="section__header reveal-up">
                <span class="section__label">Find Us</span>
                <h2 class="section__title">Our Location</h2>
            </div>
            <div class="map-container reveal-up">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3505.678!2d77.174!3d28.507!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjjCsDMwJzI1LjIiTiA3N8KwMTAnMjYuNCJF!5e0!3m2!1sen!2sin!4v1"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Prefab Wooden Homes Location"></iframe>
            </div>
        </div>
    </section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>