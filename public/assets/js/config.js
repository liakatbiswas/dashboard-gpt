(() => {
    const root = document.documentElement;
    const defaults = {
        direction: 'ltr',
        theme: 'light',
        layout: { width: 'default', position: 'fixed' },
        topbar: { color: 'light' },
        menu: { color: 'light' },
        sidenav: { view: 'default' },
    };
    let saved = {};

    try {
        saved = JSON.parse(sessionStorage.getItem('__CONFIG__')) || {};
    } catch { /* Ignore unavailable storage and malformed saved settings. */ }

    const pick = (value, choices, fallback) => choices.includes(value) ? value : fallback;
    window.defaultConfig = JSON.parse(JSON.stringify(defaults));
    window.config = {
        direction: pick(saved.direction, ['ltr', 'rtl'], defaults.direction),
        theme: pick(saved.theme, ['light', 'dark'], defaults.theme),
        layout: {
            width: pick(saved.layout?.width, ['default', 'boxed'], defaults.layout.width),
            position: pick(saved.layout?.position, ['fixed', 'scrollable'], defaults.layout.position),
        },
        topbar: { color: pick(saved.topbar?.color, ['light', 'dark', 'brand', 'gradient'], defaults.topbar.color) },
        menu: { color: pick(saved.menu?.color, ['light', 'dark', 'brand', 'gradient'], defaults.menu.color) },
        sidenav: { view: pick(saved.sidenav?.view, ['default', 'sm', 'md', 'hidden', 'hover', 'hover-active', 'mobile'], defaults.sidenav.view) },
    };

    root.setAttribute('dir', window.config.direction);
    root.dataset.mode = window.config.theme;
    root.dataset.layoutWidth = window.config.layout.width;
    root.dataset.layoutPosition = window.config.layout.position;
    root.dataset.topbarColor = window.config.topbar.color;
    root.dataset.menuColor = window.config.menu.color;
    root.dataset.sidenavView = window.innerWidth <= 1140 ? 'mobile' : window.config.sidenav.view;
})();
