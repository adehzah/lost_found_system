(function () {
    const THEME_KEYS = ['adminTheme', 'siteTheme', 'studentTheme'];

    function getSavedTheme() {
        for (let i = 0; i < THEME_KEYS.length; i++) {
            const value = localStorage.getItem(THEME_KEYS[i]);
            if (value === 'dark' || value === 'light') {
                return value;
            }
        }

        return 'light';
    }

    function saveTheme(theme) {
        THEME_KEYS.forEach(function (key) {
            localStorage.setItem(key, theme);
        });
    }

    function applyTheme(theme) {
        if (theme === 'dark') {
            document.documentElement.classList.add('dark-mode');
            document.documentElement.classList.add('admin-dark');
            document.body.classList.add('dark-mode');
            document.body.classList.add('admin-dark');
        } else {
            document.documentElement.classList.remove('dark-mode');
            document.documentElement.classList.remove('admin-dark');
            document.body.classList.remove('dark-mode');
            document.body.classList.remove('admin-dark');
        }
    }

    function syncToggleIcons(theme) {
        document.querySelectorAll('.js-admin-theme-toggle, .js-theme-toggle, #adminThemeToggle, #themeToggle, .theme-toggle').forEach(function (button) {
            button.setAttribute('aria-label', theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode');

            if (button.dataset.keepIcon === 'true') {
                return;
            }

            const currentText = button.textContent.trim();

            if (currentText === '☀' || currentText === '☾' || currentText === '◐') {
                button.textContent = theme === 'dark' ? '☀' : '☾';
            }
        });
    }

    const initialTheme = getSavedTheme();
    applyTheme(initialTheme);

    document.addEventListener('DOMContentLoaded', function () {
        const currentTheme = getSavedTheme();

        applyTheme(currentTheme);
        syncToggleIcons(currentTheme);

        document.querySelectorAll('.js-admin-theme-toggle, .js-theme-toggle, #adminThemeToggle, #themeToggle, .theme-toggle').forEach(function (button) {
            button.addEventListener('click', function (event) {
                event.preventDefault();

                const nextTheme = document.body.classList.contains('dark-mode') || document.body.classList.contains('admin-dark')
                    ? 'light'
                    : 'dark';

                saveTheme(nextTheme);
                applyTheme(nextTheme);
                syncToggleIcons(nextTheme);
            });
        });
    });
})();