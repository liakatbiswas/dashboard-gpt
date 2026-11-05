/* Shared by the guest layout, Tailwind and the Konrix customizer. */
(() => {
    const root = document.documentElement;
    const media = window.matchMedia('(prefers-color-scheme: dark)');
    const validTheme = (value) => value === 'light' || value === 'dark';
    let preference = null;

    try {
        const saved = localStorage.getItem('theme');
        preference = validTheme(saved) ? saved : null;
    } catch { /* Theme controls also work when browser storage is blocked. */ }

    const syncControls = (theme) => {
        document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
            const label = theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode';
            button.setAttribute('aria-label', label);
            button.setAttribute('title', label);
            button.setAttribute('aria-pressed', String(theme === 'dark'));
        });
        document.querySelectorAll('input[name="data-mode"]').forEach((input) => {
            input.checked = input.value === theme;
        });
    };

    const applyTheme = (theme) => {
        root.classList.toggle('dark', theme === 'dark');
        root.dataset.mode = theme;
        root.style.colorScheme = theme;

        if (window.config) {
            window.config.theme = theme;
            try {
                sessionStorage.setItem('__CONFIG__', JSON.stringify(window.config));
            } catch { /* Keep the current page usable without session storage. */ }
        }

        syncControls(theme);
        window.dispatchEvent(new CustomEvent('app:theme-changed', { detail: { theme } }));
    };

    const setTheme = (theme) => {
        if (!validTheme(theme)) return;
        preference = theme;
        try { localStorage.setItem('theme', theme); } catch { /* In-memory preference is enough. */ }
        applyTheme(theme);
    };

    window.AppTheme = {
        get: () => root.dataset.mode,
        set: setTheme,
        toggle: () => setTheme(root.dataset.mode === 'dark' ? 'light' : 'dark'),
    };

    applyTheme(preference ?? (media.matches ? 'dark' : 'light'));
    document.addEventListener('DOMContentLoaded', () => syncControls(root.dataset.mode));
    media.addEventListener('change', (event) => {
        if (!preference) applyTheme(event.matches ? 'dark' : 'light');
    });
    window.addEventListener('storage', (event) => {
        if (event.key !== 'theme' && event.key !== null) return;
        preference = validTheme(event.newValue) ? event.newValue : null;
        applyTheme(preference ?? (media.matches ? 'dark' : 'light'));
    });
})();
