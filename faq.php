<?php require_once 'includes/functions.php'; ?>
<?php include 'includes/header.php'; ?>

<div class="container py-5 mt-5">
    <h1 class="text-gold text-center mb-5">Frequently Asked Questions</h1>
    
    <div class="accordion" id="faqAccordion">
        <div class="accordion-item glass mb-3">
            <h2 class="accordion-header">
                <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#q1">Do you deliver across Tanzania?</button>
            </h2>
            <div id="q1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                <div class="accordion-body">Yes, we deliver to Dar es Salaam, Arusha, Mwanza, Zanzibar and all major regions.</div>
            </div>
        </div>
        <div class="accordion-item glass mb-3">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#q2">Are your perfumes 100% original?</button>
            </h2>
            <div id="q2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">Yes, all our perfumes are authentic from trusted suppliers in UAE, France, and Saudi Arabia.</div>
            </div>
        </div>
        <div class="accordion-item glass mb-3">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#q3">What payment methods do you accept?</button>
            </h2>
            <div id="q3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">M-Pesa, Tigo Pesa, Airtel Money, Bank Transfer, and Cash on Delivery.</div>
            </div>
        </div>
        <div class="accordion-item glass mb-3">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#q4">How long does delivery take?</button>
            </h2>
            <div id="q4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">Dar es Salaam: 1-2 days | Other regions: 3-7 days.</div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>