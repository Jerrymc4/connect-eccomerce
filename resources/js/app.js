import './bootstrap';
import Alpine from 'alpinejs';
import feather from 'feather-icons';

// Make Alpine available globally
window.Alpine = Alpine;

// Initialize Alpine
Alpine.start();

// Initialize Feather Icons
document.addEventListener('DOMContentLoaded', () => {
    feather.replace();
});

// Re-initialize Feather Icons when Alpine updates the DOM
document.addEventListener('alpine:initialized', () => {
    feather.replace();
});

// Make Feather available globally
window.feather = feather;

// Custom admin JS
document.addEventListener('DOMContentLoaded', () => {
    // Mobile menu toggle
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }
});
