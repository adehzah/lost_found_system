(function () {
    function applyTheme() {
        if (localStorage.getItem('studentTheme') === 'dark') {
            document.body.classList.add('dark-mode');
        } else {
            document.body.classList.remove('dark-mode');
        }
    }

    applyTheme();

    document.addEventListener('DOMContentLoaded', function () {
        applyTheme();

        document.querySelectorAll('.js-theme-toggle, #themeToggle').forEach(function (button) {
            button.addEventListener('click', function (event) {
                event.preventDefault();

                document.body.classList.toggle('dark-mode');

                if (document.body.classList.contains('dark-mode')) {
                    localStorage.setItem('studentTheme', 'dark');
                } else {
                    localStorage.setItem('studentTheme', 'light');
                }
            });
        });
    });
})();