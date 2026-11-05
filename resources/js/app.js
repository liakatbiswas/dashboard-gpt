import Alpine from 'alpinejs';

export function initTheme() {
    return window.AppTheme?.get() ?? 'light';
}

Alpine.data('headerNav', () => ({
    mobileMenuOpen: false,
    theme: initTheme(),

    init() {
        window.addEventListener('app:theme-changed', (event) => {
            this.theme = event.detail.theme;
        });
    },

    toggleTheme() {
        window.AppTheme.toggle();
    },

    closeMobileMenu() {
        this.mobileMenuOpen = false;
    },
}));

document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
    button.addEventListener('click', () => window.AppTheme.toggle());
});

document.querySelectorAll('[data-image-preview]').forEach((input) => {
    input.addEventListener('change', () => {
        const preview = document.getElementById(input.dataset.imagePreview);
        const file = input.files?.[0];

        if (!preview || !file) return;

        const previousSource = preview.src;
        const objectUrl = URL.createObjectURL(file);
        const release = () => URL.revokeObjectURL(objectUrl);

        preview.onload = release;
        preview.onerror = () => {
            release();
            preview.onerror = null;
            preview.src = previousSource;
        };
        preview.src = objectUrl;
    });
});

window.Alpine = Alpine;
Alpine.start();
