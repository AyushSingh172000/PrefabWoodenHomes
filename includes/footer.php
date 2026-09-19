    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer__grid">
                <div class="footer__brand">
                    <a href="<?= url() ?>" class="footer__logo" aria-label="<?= SITE_NAME ?> Home">
                        <img src="<?= asset('images/logo.jpeg') ?>" alt="<?= SITE_NAME ?> Logo" class="footer__logo-img" width="62" height="62" loading="lazy">
                        <span class="logo-text">
                            <span class="logo-text__name footer__logo-name">Prefab Wooden Homes</span>
                            <span class="logo-text__tagline footer__logo-tagline"><?= SITE_TAGLINE ?></span>
                        </span>
                    </a>
                    <p class="footer__desc">Premium custom-designed wooden homes engineered for comfort, durability and timeless beauty. A venture of PWH India Venture LLP, trusted across India for 15+ years.</p>
                    <div class="footer__social">
                        <a href="<?= SOCIAL_FACEBOOK ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="<?= SOCIAL_INSTAGRAM ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="<?= SOCIAL_YOUTUBE ?>" target="_blank" rel="noopener noreferrer" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                        <a href="https://wa.me/<?= CONTACT_WHATSAPP ?>" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>

                <div class="footer__links">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="<?= url('') ?>">Home</a></li>
                        <li><a href="<?= url('pages/about.php') ?>">About Us</a></li>
                        <li><a href="<?= url('pages/construction.php') ?>">Construction</a></li>
                        <li><a href="<?= url('pages/projects.php') ?>">Our Projects</a></li>
                        <li><a href="<?= url('pages/process.php') ?>">Our Process</a></li>
                        <li><a href="<?= url('pages/why-wooden.php') ?>">Why Wooden</a></li>
                        <li><a href="<?= url('pages/faq.php') ?>">FAQs</a></li>
                        <li><a href="<?= url('pages/contact.php') ?>">Contact Us</a></li>
                    </ul>
                </div>

                <div class="footer__links">
                    <h4>Our Services</h4>
                    <ul>
                        <li><a href="<?= url('pages/construction.php#prefab-houses') ?>">Prefab Wooden Houses</a></li>
                        <li><a href="<?= url('pages/construction.php#cottages') ?>">Wooden Cottages</a></li>
                        <li><a href="<?= url('pages/construction.php#farmhouses') ?>">Wooden Farmhouses</a></li>
                        <li><a href="<?= url('pages/construction.php#villas') ?>">Wooden Villas</a></li>
                        <li><a href="<?= url('pages/construction.php#resort-cottages') ?>">Resort Cottages</a></li>
                        <li><a href="<?= url('pages/construction.php#tree-houses') ?>">Tree Houses</a></li>
                        <li><a href="<?= url('pages/construction.php#stilt-houses') ?>">Wooden Stilt Houses</a></li>
                    </ul>
                </div>

                <div class="footer__contact">
                    <h4>Get in Touch</h4>
                    <ul>
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <span><?= CONTACT_ADDRESS ?></span>
                        </li>
                        <li>
                            <i class="fas fa-phone phone-icon-right"></i>
                            <a href="tel:<?= formatPhoneLink(CONTACT_PHONE_AMAN) ?>">Aman Jha: <?= CONTACT_PHONE_AMAN ?></a>
                        </li>
                        <li>
                            <i class="fas fa-phone phone-icon-right"></i>
                            <a href="tel:<?= formatPhoneLink(CONTACT_PHONE_RAJEEV) ?>">Rajeev Jha: <?= CONTACT_PHONE_RAJEEV ?></a>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <a href="mailto:<?= CONTACT_EMAIL ?>"><?= CONTACT_EMAIL ?></a>
                        </li>
                        <li>
                            <i class="fas fa-clock"></i>
                            <span>Mon – Sat: 9:30 AM – 7:00 PM</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="footer__bottom">
                <p>&copy; <?= date('Y') ?> <?= SITE_NAME ?> &middot; PWH India Venture LLP. All Rights Reserved.</p>
                <p class="footer__credit">Wooden House Construction in India &middot; Pan-India Projects &middot; Since 2015</p>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/<?= CONTACT_WHATSAPP ?>?text=Hi%2C%20I%27m%20interested%20in%20a%20wooden%20home.%20Please%20share%20details."
       class="whatsapp-float" target="_blank" rel="noopener noreferrer" aria-label="Chat on WhatsApp">
        <i class="fab fa-whatsapp"></i>
        <span class="whatsapp-float__text">Chat with us</span>
    </a>

    <!-- Back to Top -->
    <button class="back-to-top" id="backToTop" aria-label="Back to top">
        <i class="fas fa-chevron-up"></i>
    </button>

    <script>window.APP_BASE_URL = <?= json_encode(BASE_PATH) ?>;</script>
    <script src="<?= asset('js/main.js') ?>"></script>
</body>
</html>
