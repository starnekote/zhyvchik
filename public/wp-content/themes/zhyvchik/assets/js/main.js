document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('toggleBtn');
    const container = document.querySelector('.zhyvchik-container');

    btn.addEventListener('click', function(e) {
        e.preventDefault(); // Щоб кнопка не перезавантажувала сторінку
        container.classList.toggle('active');
    });
});

// Виносимо логіку створення кнопок в окрему функцію
function initQuantityButtons() {
    document.querySelectorAll('.woocommerce-cart-form input.qty').forEach(function (input) {
        // Запобігаємо повторному додаванню кнопок
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
}

// 1. Викликаємо при завантаженні сторінки
document.addEventListener('DOMContentLoaded', initQuantityButtons);

jQuery(function ($) {
    // 2. Викликаємо ПІСЛЯ того, як WooCommerce оновив фрагменти кошика через AJAX
    $(document.body).on('updated_wc_div', function() {
        initQuantityButtons();
    });

    // Ваш код для авто-оновлення при зміні кількості
    $(document).on('change', 'input.qty', function () {
        // Додаємо невеличку затримку (debounce), щоб уникнути спаму запитами, 
        // якщо користувач швидко клікає кілька разів поспіль
        clearTimeout(window.wc_cart_update_timeout);
        
        const $form = $(this).closest('form.woocommerce-cart-form');
        const $updateBtn = $form.find('button[name="update_cart"]');
        
        window.wc_cart_update_timeout = setTimeout(function() {
            $updateBtn.prop('disabled', false).trigger('click');
        }, 300); // 300 мілісекунд затримки
    });
});