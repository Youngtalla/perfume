// main.js - Mouhdy Perfumes
document.addEventListener('DOMContentLoaded', function() {

    // Toast Notification Function
    window.showToast = function(message, type = 'success') {
        const toast = document.createElement('div');
        toast.style.cssText = `
            position: fixed; bottom: 20px; right: 20px; padding: 15px 25px; 
            border-radius: 8px; color: white; z-index: 9999;
            background: ${type === 'success' ? '#0F3D2E' : '#D9534F'};
            border: 1px solid #D4AF37;`;
        toast.textContent = message;
        document.body.appendChild(toast);
        
        setTimeout(() => toast.remove(), 3000);
    };

    // Add to Cart (Demo)
    window.addToCart = function(productId) {
        showToast('Added to cart! ✅');
        // You can expand this later with real cart system
    };

    console.log('%cMouhdy Perfumes Store loaded successfully', 'color:#D4AF37; font-size:14px');
});