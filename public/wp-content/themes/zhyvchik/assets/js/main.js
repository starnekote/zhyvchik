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

document.addEventListener("DOMContentLoaded", function() {
    // Отримуємо радіокнопки за ім'ям групи
    const authRadios = document.querySelectorAll('input[name="auth_mode"]');
    
    // Отримуємо секції форм
    const loginSection = document.querySelector('.u-column1.col-1');
    const registerSection = document.querySelector('.u-column2.col-2');

    // Функція, яка перевіряє стан і показує потрібну форму
    function toggleForms() {
        const activeRadio = document.querySelector('input[name="auth_mode"]:checked');
        
        if (activeRadio.id === 'zhyvchik-login') {
            loginSection.style.display = 'block';
            registerSection.style.display = 'none';
        } else {
            loginSection.style.display = 'none';
            registerSection.style.display = 'block';
        }
    }

    // Додаємо прослуховувач подій для кожної радіокнопки в групі
    authRadios.forEach(radio => {
        radio.addEventListener('change', toggleForms);
    });

    // Викликаємо функцію відразу, щоб встановити правильний стан при завантаженні
    toggleForms();
});

jQuery(document).ready(function($) {
    var noticeTimeout, fadeTimeout;

    function initWooCommerceToasts() {
        var $wrapper = $('.woocommerce-notices-wrapper');

        // Перевіряємо, чи існує контейнер і чи є в ньому сповіщення
        if ($wrapper.length === 0 || $wrapper.children().length === 0) {
            return;
        }

        // Очищаємо попередні таймери, якщо користувач робить кілька дій поспіль
        clearTimeout(noticeTimeout);
        clearTimeout(fadeTimeout);

        // Повертаємо початковий стан перед анімацією
        $wrapper.removeClass('is-visible is-fading').show();

        // 1. Плавно показуємо сповіщення (з мікрозатримкою для спрацьовування CSS)
        setTimeout(function() {
            $wrapper.addClass('is-visible');
        }, 50);

        // 2. Через 4.5 секунди запускаємо зникнення
        noticeTimeout = setTimeout(function() {
            $wrapper.removeClass('is-visible').addClass('is-fading');

            // 3. Після завершення CSS-анімації (400мс) повністю ховаємо блок
            fadeTimeout = setTimeout(function() {
                $wrapper.removeClass('is-fading').hide();
            }, 400);

        }, 4500); // Час відображення сповіщення на екрані (у мілісекундах)
    }

    // Тригер 1: Працює при першому завантаженні сторінки
    initWooCommerceToasts();

    // Тригер 2: Словлюємо ВСІ AJAX-події WooCommerce (видалення товару, оновлення кошика, застосування купона)
    $(document.body).on('updated_wc_div updated_cart_totals removed_from_cart applied_coupon', function() {
        initWooCommerceToasts();
    });
});

jQuery(document).ready(function($) {
    // Зберігаємо ваші SVG у змінні. 
    // Увага: я змінив width та height на "100%", щоб вони адаптувались до розміру в CSS.
var emptyStar = '<svg width="100%" height="100%" viewBox="0 0 8 7" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2.34532 5.64419L3.65782 4.85253L4.97032 5.65461L4.62657 4.15461L5.78282 3.15461L4.26198 3.01919L3.65782 1.60253L3.05365 3.00877L1.53282 3.14419L2.68907 4.15461L2.34532 5.64419ZM1.39742 6.95105L1.99437 4.38056L0 2.65222L2.63138 2.42385L3.65782 0L4.68425 2.42385L7.31563 2.65222L5.32126 4.38056L5.91821 6.95105L3.65782 5.58728L1.39742 6.95105Z" fill="#A0A0A0"/></svg>';
/* ^^^ Змінено з #D0C5AF (світло-бежевий) на #A0A0A0 (помітний сірий) */

var filledStar = '<svg width="100%" height="100%" viewBox="0 0 9 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.59375 7.91667L2.27083 4.98958L0 3.02083L3 2.76042L4.16667 0L5.33333 2.76042L8.33333 3.02083L6.0625 4.98958L6.73958 7.91667L4.16667 6.36458L1.59375 7.91667Z" fill="#F0C000"/></svg>';
/* ^^^ Змінено з #775A19 (блідо-коричневий) на #F0C000 (яскравий золотий/жовтий) */

    var $starsContainer = $('.comment-form-rating .stars');
    var $stars = $starsContainer.find('a');

    if ($stars.length > 0) {
        
        // 1. При завантаженні сторінки вставляємо пусті зірочки замість тексту
        $stars.each(function() {
            $(this).html(emptyStar);
        });

        // 2. Логіка при наведенні мишки (Hover)
        $stars.on('mouseenter', function() {
            var hoverIndex = $(this).index(); // Отримуємо номер зірочки, на яку навели (0-4)
            
            $stars.each(function(i) {
                if (i <= hoverIndex) {
                    $(this).html(filledStar); // Заповнюємо поточну і всі попередні
                } else {
                    $(this).html(emptyStar);  // Наступні залишаємо пустими
                }
            });
        });

        // 3. Коли курсор йде з блоку зірок — повертаємо стан до обраної оцінки
        $starsContainer.on('mouseleave', function() {
            resetStars();
        });

        // 4. Логіка при кліку (фіксуємо вибір)
        $stars.on('click', function(e) {
            // WooCommerce автоматично додає клас "active" на клікнуту зірку та оновлює <select>.
            // Ми даємо скриптам WooCommerce 10 мілісекунд, щоб вони відпрацювали, 
            // після чого оновлюємо наші SVG відповідно до обраної оцінки.
            setTimeout(function() {
                resetStars();
            }, 10);
        });

        // Допоміжна функція: перевіряє, яка зірка активна і малює SVG
        function resetStars() {
            // Шукаємо зірку з класом active (цей клас ставить сам WooCommerce)
            var activeStar = $stars.filter('.active');
            var activeIndex = activeStar.length ? activeStar.index() : -1;

            $stars.each(function(i) {
                if (activeIndex >= 0 && i <= activeIndex) {
                    $(this).html(filledStar);
                } else {
                    $(this).html(emptyStar);
                }
            });
        }
    }
});

document.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', function() {
        // Прибираємо клас у попереднього активного посилання
        document.querySelector('a.current-page')?.classList.remove('current-page');
        // Додаємо клас тому посиланню, на яке щойно натиснули
        this.classList.add('current-page');
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const searchTrigger = document.querySelector('.search-trigger');
    const searchBox = document.querySelector('.search-box');
    const searchInput = document.querySelector('.aws-search-field');

    if (searchTrigger && searchBox) {
        // Відкриття пошуку
        searchTrigger.addEventListener('click', (e) => {
            e.stopPropagation();
            searchBox.classList.add('active');
            
            // Автофокус на поле введення
            setTimeout(() => {
                if (searchInput) searchInput.focus();
            }, 300);
        });
    }

    // Закриття пошуку при кліку в будь-яке інше місце екрана
    document.addEventListener('click', (e) => {
        if (searchBox && searchBox.classList.contains('active')) {
            // Якщо клікнули поза блоком пошуку
            if (!searchBox.contains(e.target)) {
                searchBox.classList.remove('active');
            }
        }
    });
});