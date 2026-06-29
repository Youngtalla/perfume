<?php require_once 'includes/functions.php'; ?>
<?php include 'includes/header.php'; ?>

<div class="container py-5 mt-5">
    <h1 class="text-center mb-5">Get In Touch</h1>
    
    <div class="row">
        <div class="col-lg-6">
            <div class="glass p-4">
                <h4>Contact Information</h4>
                <p><strong>Address:</strong> Ilala Bungoni, Dar es Salaam, Tanzania</p>
                <p><strong>Phone:</strong> <?= getSetting('store_phone', '255 712 345 678') ?></p>
                <p><strong>Email:</strong> <?= getSetting('store_email', 'info@mouhdyperfumes.com') ?></p>
                
                <a href="https://wa.me/<?= getSetting('whatsapp_number', '255712345678') ?>" class="btn btn-success btn-lg w-100 mt-3">
                    <i class="fab fa-whatsapp"></i> Chat on WhatsApp
                </a>
            </div>
        </div>
        
        <div class="col-lg-6">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.5!2d39.25!3d-6.8!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwNDgnMDAuMCJTIDM5wrAxNScwMC4wIkU!5e0!3m2!1sen!2stz!4v123456789" width="100%" height="380" style="border:0;border-radius:12px;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>