<?php
require_once __DIR__ . '/../includes/init.php';
$pageMeta = seoMeta(
    'Frequently Asked Questions — Wooden Homes',
    'Find answers to common questions about wooden homes in India — cost per sq ft, construction time, waterproofing, termite protection, lifespan, maintenance and more.',
    'wooden house cost India, how long wooden house construction, wooden house waterproof, wooden house termite resistant, wooden house FAQ'
);
require_once __DIR__ . '/../includes/header.php';
?>

    <section class="page-banner">
        <div class="container reveal-up">
            <h1 class="page-banner__title">Frequently Asked Questions</h1>
            <div class="page-banner__breadcrumb">
                <a href="<?= url() ?>">Home</a> &nbsp;/&nbsp; FAQ
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section__header reveal-up">
                <span class="section__label">Got Questions?</span>
                <h2 class="section__title">We Have Answers</h2>
            </div>

            <div class="faq-list reveal-up">
                <div class="faq-item">
                    <button class="faq-item__question">How much does a wooden house cost in India? <i class="fas fa-chevron-down"></i></button>
                    <div class="faq-item__answer">
                        <div class="faq-item__answer-inner">The cost depends on size, design complexity, wood species and your location. As a general range, prefab wooden homes start from approximately ₹2,500 per sq ft for basic designs and can go up to ₹6,000+ per sq ft for premium, fully customised builds with imported wood and luxury finishes. Contact us with your requirements and we'll provide a precise, no-obligation quotation within 48 hours.</div>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-item__question">How long does construction take? <i class="fas fa-chevron-down"></i></button>
                    <div class="faq-item__answer">
                        <div class="faq-item__answer-inner">After design approval, the typical timeline is 4–6 weeks for factory manufacturing plus 2–4 weeks for on-site assembly and finishing. A standard cottage can be move-in ready in 8–10 weeks. Larger or more complex projects like villas and resort clusters may take 12–16 weeks. This is significantly faster than conventional concrete construction.</div>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-item__question">Can you construct anywhere in India? <i class="fas fa-chevron-down"></i></button>
                    <div class="faq-item__answer">
                        <div class="faq-item__answer-inner">Yes, we deliver and construct wooden homes across India. Our prefabricated components are manufactured at our facility and transported to any location — whether it's the Himalayas, Goa's coastline, a farm in Maharashtra, or a resort site in Kerala. We've completed projects in multiple states and can work in remote locations with limited road access.</div>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-item__question">Is a wooden house waterproof? <i class="fas fa-chevron-down"></i></button>
                    <div class="faq-item__answer">
                        <div class="faq-item__answer-inner">Yes, when properly treated and constructed. We apply industrial-grade waterproof stains and sealants to all external timber. Our construction includes multi-layer waterproofing systems with membranes, flashing and drainage channels. Kiln-dried, pressure-treated wood resists moisture absorption, making our homes fully suited for India's monsoon seasons.</div>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-item__question">Is a wooden house termite resistant? <i class="fas fa-chevron-down"></i></button>
                    <div class="faq-item__answer">
                        <div class="faq-item__answer-inner">All our timber is pressure-treated with anti-termite chemicals during the manufacturing process. We also install physical termite barriers at the foundation level. With periodic re-treatment (typically every 5–7 years), your wooden home is well-protected against termite and pest infestation for its entire lifespan.</div>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-item__question">How long does a wooden house last? <i class="fas fa-chevron-down"></i></button>
                    <div class="faq-item__answer">
                        <div class="faq-item__answer-inner">A well-built and properly maintained wooden house can last 100–150 years. The durability depends on the quality of wood, treatment, construction technique and regular maintenance. Many historical wooden buildings around the world are centuries old. With our premium imported timber and modern preservation techniques, your home is built to last generations.</div>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-item__question">Can I customise the design? <i class="fas fa-chevron-down"></i></button>
                    <div class="faq-item__answer">
                        <div class="faq-item__answer-inner">Every home we build is customised to the client's requirements. You can specify the floor plan, number of rooms, exterior style, interior finishes, window placements, terrace design and more. Our architects work closely with you during the 3D design phase to ensure the final plan matches your vision exactly.</div>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-item__question">What kind of foundation is required? <i class="fas fa-chevron-down"></i></button>
                    <div class="faq-item__answer">
                        <div class="faq-item__answer-inner">Wooden homes are significantly lighter than masonry structures, so they require simpler foundations. Depending on the site conditions, we use concrete strip foundations, raised pier foundations or slab foundations. Our team evaluates the soil and terrain during the site visit and recommends the most suitable and cost-effective foundation type for your project.</div>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-item__question">Do you provide maintenance services? <i class="fas fa-chevron-down"></i></button>
                    <div class="faq-item__answer">
                        <div class="faq-item__answer-inner">Yes, we offer comprehensive maintenance and after-care services. This includes re-staining, waxing, UV protection application, roofing shingle replacement, caulking and general inspections. We recommend a maintenance check every 2–3 years to keep your home in optimum condition. We also provide clients with a maintenance guide at handover.</div>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-item__question">What type of wood do you use? <i class="fas fa-chevron-down"></i></button>
                    <div class="faq-item__answer">
                        <div class="faq-item__answer-inner">We primarily use premium pine and spruce wood imported from managed forests in British Columbia (Canada) and Scandinavian countries. Our wood is PEFC and FSC certified, ensuring it comes from responsibly managed, sustainable forestry operations. The wood is kiln-dried and pressure-treated to maximise durability and resistance to moisture, insects and UV damage.</div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-8 reveal-up">
                <p style="color: var(--color-text-muted); margin-bottom: var(--space-4);">Didn't find what you're looking for?</p>
                <a href="<?= url('pages/contact.php') ?>" class="btn btn--primary btn--lg btn-magnetic">Ask Us Directly</a>
            </div>
        </div>
    </section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>