<script>
    (() => {
        const key = 'lnt-theme';
        const systemTheme = () => matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        const savedTheme = () => {
            try { return localStorage.getItem(key); } catch { return null; }
        };
        const applyTheme = theme => {
            document.documentElement.dataset.theme = theme;
            document.querySelectorAll('[data-theme-toggle]').forEach(button => {
                const next = theme === 'dark' ? 'sáng' : 'tối';
                button.dataset.themeCurrent = theme;
                button.setAttribute('aria-label', `Chuyển sang giao diện ${next}`);
                button.setAttribute('title', `Giao diện ${next}`);
                button.setAttribute('aria-pressed', theme === 'dark' ? 'true' : 'false');
            });
        };

        applyTheme(savedTheme() || systemTheme());

        document.addEventListener('DOMContentLoaded', () => {
            applyTheme(document.documentElement.dataset.theme);
            document.querySelectorAll('[data-theme-toggle]').forEach(button => {
                button.addEventListener('click', () => {
                    const theme = document.documentElement.dataset.theme === 'dark' ? 'light' : 'dark';
                    try { localStorage.setItem(key, theme); } catch {}
                    applyTheme(theme);
                });
            });
        });

        matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
            if (!savedTheme()) applyTheme(event.matches ? 'dark' : 'light');
        });
    })();
</script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Lora:ital,wght@0,400;0,500;0,600;1,400;1,500&display=swap" rel="stylesheet">
