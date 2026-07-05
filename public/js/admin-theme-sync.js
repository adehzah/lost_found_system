(function () {
    if (window.LostFoundTheme) {
        window.LostFoundTheme.apply();
        window.LostFoundTheme.bind();
        return;
    }

    const THEME_KEYS = ['siteTheme', 'adminTheme', 'studentTheme'];
    const TOGGLE_SELECTOR = '.js-admin-theme-toggle, #adminThemeToggle, .js-theme-toggle, #themeToggle, .theme-toggle';

    function readThemeKey(key) {
        try {
            return localStorage.getItem(key);
        } catch (error) {
            return null;
        }
    }

    function writeThemeKey(key, theme) {
        try {
            localStorage.setItem(key, theme);
        } catch (error) {
            // Ignore blocked storage; the page still updates for this visit.
        }
    }

    function savedTheme() {
        const canonical = readThemeKey('siteTheme');

        if (canonical === 'dark' || canonical === 'light') {
            return canonical;
        }

        const legacyValues = THEME_KEYS.map(readThemeKey);

        if (legacyValues.includes('dark')) {
            return 'dark';
        }

        if (legacyValues.includes('light')) {
            return 'light';
        }

        return 'light';
    }

    function saveTheme(theme) {
        THEME_KEYS.forEach(function (key) {
            writeThemeKey(key, theme);
        });
    }

    function syncToggles(theme) {
        document.querySelectorAll(TOGGLE_SELECTOR).forEach(function (button) {
            button.setAttribute('aria-label', theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode');
            button.setAttribute('aria-pressed', theme === 'dark' ? 'true' : 'false');
        });
    }

    function applyTheme(theme) {
        const isDark = theme === 'dark';

        document.documentElement.classList.toggle('dark-mode', isDark);
        document.documentElement.classList.toggle('admin-dark', isDark);
        document.documentElement.setAttribute('data-theme', isDark ? 'dark' : 'light');

        if (document.body) {
            document.body.classList.toggle('dark-mode', isDark);
            document.body.classList.toggle('admin-dark', isDark);
            document.body.setAttribute('data-theme', isDark ? 'dark' : 'light');
        }

        syncToggles(theme);
    }

    function toggleTheme() {
        const nextTheme = document.documentElement.classList.contains('dark-mode') ? 'light' : 'dark';

        saveTheme(nextTheme);
        applyTheme(nextTheme);

        window.dispatchEvent(new CustomEvent('lostfound:themechange', {
            detail: { theme: nextTheme }
        }));
    }

    function bindToggles() {
        document.querySelectorAll(TOGGLE_SELECTOR).forEach(function (button) {
            if (button.dataset.themeBound === 'true') {
                return;
            }

            button.dataset.themeBound = 'true';
            button.addEventListener('click', function (event) {
                event.preventDefault();
                toggleTheme();
            });
        });

        syncToggles(savedTheme());
    }

    window.LostFoundTheme = {
        apply: function () {
            applyTheme(savedTheme());
        },
        bind: bindToggles,
        current: savedTheme,
        set: function (theme) {
            const normalized = theme === 'dark' ? 'dark' : 'light';

            saveTheme(normalized);
            applyTheme(normalized);
        },
        toggle: toggleTheme
    };

    applyTheme(savedTheme());

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            applyTheme(savedTheme());
            bindToggles();
        });
    } else {
        applyTheme(savedTheme());
        bindToggles();
    }
})();
