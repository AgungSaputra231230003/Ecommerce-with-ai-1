document.addEventListener('DOMContentLoaded', () => {
    const updateCartBadge = (count) => {
        const badge = document.querySelector('[data-cart-count]');

        if (!badge) {
            return;
        }

        badge.textContent = count;
    };

    const scrollTopButton = document.querySelector('[data-scroll-top]');

    if (scrollTopButton) {
        const toggleScrollButton = () => {
            const shouldShow = window.scrollY > 400;
            scrollTopButton.classList.toggle('hidden', !shouldShow);
        };

        toggleScrollButton();
        window.addEventListener('scroll', toggleScrollButton, { passive: true });
        scrollTopButton.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    const forms = document.querySelectorAll('form[data-ajax-form="true"]');

    forms.forEach((form) => {
        const targetSelector = form.dataset.ajaxTarget;

        if (!targetSelector) {
            return;
        }

        const targetNode = document.querySelector(targetSelector);

        if (!targetNode) {
            return;
        }

        const submitWithoutReload = (event) => {
            const currentScroll = window.scrollY;
            const method = (form.method || 'GET').toUpperCase();
            const action = form.action || window.location.href;
            const formData = new FormData(form);

            if (event) {
                event.preventDefault();
            }

            const requestUrl = method === 'GET'
                ? `${action}${new URLSearchParams(formData).toString() ? `?${new URLSearchParams(formData).toString()}` : ''}`
                : action;

            fetch(requestUrl, {
                method,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html',
                    'X-CSRF-TOKEN': formData.get('_token') || '',
                },
                body: method === 'GET' ? undefined : formData,
                credentials: 'same-origin',
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error('AJAX request failed');
                    }

                    return response.text();
                })
                .then((html) => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const nextTarget = doc.querySelector(targetSelector);

                    if (nextTarget) {
                        targetNode.innerHTML = nextTarget.innerHTML;
                        window.scrollTo(0, currentScroll);
                        return;
                    }

                    window.location.href = requestUrl;
                })
                .catch(() => {
                    form.submit();
                });
        };

        form.addEventListener('submit', (event) => {
            submitWithoutReload(event);
        });

        form.querySelectorAll('[data-ajax-trigger="change"]').forEach((trigger) => {
            trigger.addEventListener('change', (event) => {
                event.preventDefault();
                submitWithoutReload();
            });
        });
    });

    const cartForms = document.querySelectorAll('form[data-cart-submit="true"]');

    cartForms.forEach((form) => {
        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const formData = new FormData(form);
            const csrfToken = formData.get('_token');

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: formData,
                    credentials: 'same-origin',
                });

                if (!response.ok) {
                    throw new Error('Could not add item to cart');
                }

                const result = await response.json();
                updateCartBadge(result.count ?? 0);
            } catch (error) {
                form.submit();
            }
        });
    });
});
