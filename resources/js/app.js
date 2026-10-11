import Alpine from 'alpinejs';

// ১. থিম ইনিশিয়ালাইজেশন ফাংশন (FOUC বা স্ক্রিন ফ্লিকার রোধে)
export function initTheme() {
    let theme = 'light';
    try {
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark' || savedTheme === 'light') {
            theme = savedTheme;
        } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
            theme = 'dark';
        }
    } catch (e) { }

    document.documentElement.classList.toggle('dark', theme === 'dark');
}

// অবিলম্বে থিম ক্লাস সেট করুন
initTheme();

// ২. হেডার কম্পোনেন্টের স্টেট ও অ্যাকশন
Alpine.data('headerNav', () => ({
    mobileMenuOpen: false,
    theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light',

    toggleTheme() {
        this.theme = this.theme === 'dark' ? 'light' : 'dark';
        document.documentElement.classList.toggle('dark', this.theme === 'dark');

        try {
            localStorage.setItem('theme', this.theme);
        } catch (e) { }
    },

    closeMobileMenu() {
        this.mobileMenuOpen = false;
    }
}));

window.Alpine = Alpine;
Alpine.start();