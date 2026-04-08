document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('toggleBtn');
    const container = document.querySelector('.zhyvchik-container');

    btn.addEventListener('click', function(e) {
        e.preventDefault(); // Щоб кнопка не перезавантажувала сторінку
        container.classList.toggle('active');
    });
});

// ФУНКЦІЯ ЩО ОНОВЛЮЄ ПРОМІЖНУ ЦІНУ ТОВАРУ ПІСЛЯ ЗМІНИ КІЛЬКОСТІ
jQuery(function ($) {

    // При зміні кількості
    $(document).on('change', 'input.qty', function () {

        const $form = $(this).closest('form.woocommerce-cart-form');
        const $updateBtn = $form.find('button[name="update_cart"]');

        // Розблокувати кнопку (Woo її часто disable-ить)
        $updateBtn.prop('disabled', false);

        // Тригер стандартного submit
        $updateBtn.trigger('click');
    });

});

// ФУНКЦІЯ ЩО ДОДАЄ КАСТОМНІ СТРІЛКИ ДЛЯ ЗМІНИ КІЛЬКОСТІ ТОВАРУ
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.woocommerce-cart-form input.qty').forEach(function (input) {

        if (input.parentElement.classList.contains('qty-wrap')) return;

        const wrap = document.createElement('div');
        wrap.className = 'qty-wrap';

        const minus = document.createElement('button');
        minus.type = 'button';
        minus.textContent = '-';

        const plus = document.createElement('button');
        plus.type = 'button';
        plus.textContent = '+';

        input.parentNode.insertBefore(wrap, input);
        wrap.appendChild(minus);
        wrap.appendChild(input);
        wrap.appendChild(plus);

        minus.addEventListener('click', function () {
            let val = parseInt(input.value, 10);
            let min = parseInt(input.min, 10) || 1;

            if (val > min) {
                input.value = val - 1;
                input.dispatchEvent(new Event('change', { bubbles: true }));
            }
        });

        plus.addEventListener('click', function () {
            let val = parseInt(input.value, 10);
            let max = input.max ? parseInt(input.max, 10) : Infinity;

            if (val < max) {
                input.value = val + 1;
                input.dispatchEvent(new Event('change', { bubbles: true }));
            }
        });

    });

});