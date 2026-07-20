document.addEventListener('DOMContentLoaded', () => {
    const app = document.querySelector('.operator-app');
    const sidebar = document.getElementById('operatorSidebar');
    const overlay = document.querySelector('[data-sidebar-close]');

    const closeSidebar = () => {
        if (!sidebar || !app) {
            return;
        }

        sidebar.classList.remove('is-open');
        app.classList.remove('sidebar-open');
    };

    document.querySelectorAll('[data-sidebar-toggle]').forEach((button) => {
        button.addEventListener('click', () => {
            if (!sidebar || !app) {
                return;
            }

            sidebar.classList.toggle('is-open');
            app.classList.toggle('sidebar-open');
        });
    });

    overlay?.addEventListener('click', closeSidebar);

    document.querySelectorAll('.operator-nav a').forEach((link) => {
        const currentPath = window.location.pathname.replace(/\/+$/, '');
        const linkPath = new URL(link.href).pathname.replace(/\/+$/, '');

        if (currentPath === linkPath || currentPath.endsWith(linkPath)) {
            link.classList.add('is-active');
        }
    });

    document.querySelectorAll('[data-counter]').forEach((element) => {
        const targetValue = Number(String(element.dataset.counter || '0').replace(/\s/g, ''));

        if (Number.isNaN(targetValue)) {
            return;
        }

        const duration = 900;
        const startTime = performance.now();
        const startValue = 0;

        const frame = (now) => {
            const progress = Math.min((now - startTime) / duration, 1);
            const value = Math.round(startValue + (targetValue - startValue) * progress);
            element.textContent = value.toLocaleString('fr-FR');

            if (progress < 1) {
                requestAnimationFrame(frame);
            }
        };

        requestAnimationFrame(frame);
    });

    document.querySelectorAll('[data-grid-search]').forEach((input) => {
        const targetSelector = input.getAttribute('data-grid-search');
        const target = targetSelector ? document.querySelector(targetSelector) : null;

        if (!target) {
            return;
        }

        const items = () => Array.from(target.querySelectorAll('[data-search-item]'));

        input.addEventListener('input', () => {
            const query = input.value.trim().toLowerCase();

            items().forEach((item) => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(query) ? '' : 'none';
            });
        });
    });

    document.querySelectorAll('[data-delete-confirm]').forEach((link) => {
        link.addEventListener('click', (event) => {
            const message = link.getAttribute('data-delete-confirm') || 'Confirmer la suppression ?';

            if (!window.confirm(message)) {
                event.preventDefault();
            }
        });
    });

    if (sidebar && app && window.innerWidth <= 1100) {
        closeSidebar();
    }
});
