import './bootstrap';
import Alpine from 'alpinejs';

// Wait for Livewire to initialize
document.addEventListener('livewire:load', () => {
    window.Alpine = Alpine;
    Alpine.start();
});
