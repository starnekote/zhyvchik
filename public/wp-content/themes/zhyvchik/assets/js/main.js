const yellow = document.querySelector('.contact-yellow');
const black = document.querySelector('.contact-black');

/*
  Масив секцій і кольорів:
  — selector: CSS-селектор блоку
  — color: 'yellow' або 'black'
*/
const colorMap = [
  { selector: '.header', color: 'yellow' },
  { selector: '.top-sales', color: 'black' },
  { selector: '.new-arrivals', color: 'black' },
  { selector: '.footer', color: 'yellow' }
];

function isIconOverBlock(block) {
  const rect = block.getBoundingClientRect();
  const iconY = window.innerHeight - 20 - 30; // bottom: 20px, height: 60px
  return iconY >= rect.top && iconY <= rect.bottom;
}

function updateIconColor() {
  let currentColor = 'black'; // колір за замовчуванням

  for (const entry of colorMap) {
    const blocks = document.querySelectorAll(entry.selector);
    for (const block of blocks) {
      if (isIconOverBlock(block)) {
        currentColor = entry.color;
        break;
      }
    }
  }

  if (currentColor === 'yellow') {
    yellow.classList.add('active');
    black.classList.remove('active');
  } else {
    yellow.classList.remove('active');
    black.classList.add('active');
  }
}

window.addEventListener('scroll', updateIconColor);
window.addEventListener('load', updateIconColor);


document.addEventListener("DOMContentLoaded", function () {
    const sortBtn = document.getElementById("sort-btn");
    const sort = document.getElementById("sort");
      sortBtn.addEventListener('click', function() {
        sort.classList.toggle("show");
      });
    });

document.addEventListener("DOMContentLoaded", function () {
  const filterBtn = document.getElementById("filter-btn");
  const filter = document.getElementById("filter");
  const cross = document.getElementById("cross");

  // відкриття/закриття при натисканні кнопки
  filterBtn.addEventListener("click", function () {
    filter.classList.toggle("show");
  });

  // закриття при натисканні на хрестик
  cross.addEventListener("click", function () {
    filter.classList.remove("show");
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const options = document.querySelectorAll(".option");

  options.forEach(option => {
    option.addEventListener("click", function () {
      // якщо елемент вже активний — нічого не робимо
      if (this.classList.contains("active")) return;

      // знімаємо активність з усіх інших
      options.forEach(opt => opt.classList.remove("active"));

      // робимо активним поточний
      this.classList.add("active");
    });
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const lengthPickers = document.querySelectorAll(".length-picker input");
  const colorPickers = document.querySelectorAll(".color-picker input");

  function makeSingleActive(inputs) {
    inputs.forEach(input => {
      input.addEventListener("change", function () {
        const parent = this.closest('label');

        if (this.checked) {
          // знімаємо активність з усіх у групі
          inputs.forEach(inp => {
            const p = inp.closest('label');
            p.classList.remove('active');
            inp.checked = false;
          });

          // робимо активним тільки цей
          parent.classList.add('active');
          this.checked = true;
        } else {
          // якщо input зняли — знімаємо клас
          parent.classList.remove('active');
        }
      });
    });
  }

  makeSingleActive(lengthPickers);
  makeSingleActive(colorPickers);
});

// MIXITUP
document.addEventListener('DOMContentLoaded', function () {
  var container = document.querySelector('[data-ref="container"]');
  var minSizeRangeInput = document.querySelector('[name="minSize"]');
  var maxSizeRangeInput = document.querySelector('[name="maxSize"]');
  var applyBtn = document.getElementById('apply-filter');
  var resetBtn = document.getElementById('clear-filter'); // опціонально, якщо є кнопка "Скинути"

  if (!container) {
    console.error('Контейнер не знайдено: [data-ref="container"]');
    return;
  }

  // Ініціалізація mixer
  var mixer = mixitup(container, {
    animation: {
      duration: 350
    },
    multifilter: {
      enable: true
    },
  });

  // Отримати поточний діапазон з інпутів (надійно)
  function getRange() {
    var minRaw = String(minSizeRangeInput && minSizeRangeInput.value).trim();
    var maxRaw = String(maxSizeRangeInput && maxSizeRangeInput.value).trim();

    var min = minRaw === '' ? -Infinity : Number(minRaw);
    var max = maxRaw === '' ? Infinity : Number(maxRaw);

    // захист від некоректних значень
    if (!Number.isFinite(min)) min = -Infinity;
    if (!Number.isFinite(max)) max = Infinity;

    // якщо мінімум більший за максимум — поміняти місцями
    if (min > max) {
      var t = min;
      min = max;
      max = t;
    }

    return { min: min, max: max };
  }

  // Фільтр-функція для mixitup (повертає testResult)
  function filterTestResult(testResult, target) {
    // safe-get елемента (target може бути MixItUp Item)
    var el = (target && target.dom && target.dom.el) ? target.dom.el : (target instanceof Element ? target : (target && target.el ? target.el : null));
    if (!el) return false;

    var raw = el.getAttribute('data-size');
    if (raw == null) return false;

    // очистка від зайвих символів і парсинг числа
    var cleaned = String(raw).replace(/[^\d.\-]+/g, '');
    var size = parseFloat(cleaned);
    if (!Number.isFinite(size)) return false;

    var range = getRange();

    if (range.min !== -Infinity && size < range.min) return false;
    if (range.max !== Infinity && size > range.max) return false;

    return testResult;
  }

  // Реєструємо фільтр (як і було)
  mixitup.Mixer.registerFilter('testResultEvaluateHideShow', 'range', filterTestResult);

  // Функція-аплікатор: викликаємо перерахунок фільтрів (тут — лише при натисканні)
  function applyRangeFilter() {
    // За бажання: якщо обидва поля пусті — показати всі
    var range = getRange();
    var noLimits = (range.min === -Infinity && range.max === Infinity);
    if (noLimits) {
      // Скидаємо всі додаткові фільтри, показуємо все
      mixer.filter('all');
      return;
    }

    // reapply поточного активного фільтра, щоб mixitup заново пройшов по всім registered filters,
    // у тому числі по нашому кастомному 'range' фільтру.
    var active = mixer.getState && mixer.getState().activeFilter ? mixer.getState().activeFilter : 'all';
    try {
      // Якщо active — функція чи селектор, reapply її, щоб наш registered filter спрацював
      mixer.filter(active);
    } catch (err) {
      // fallback — якщо щось пішло не так, застосуємо просто range як одиничну логіку
      console.warn('Помилка при повторному застосуванні activeFilter, робимо повний range-фільтр:', err);
      mixer.filter(function (item) {
        // використовуємо ту ж функцію перевірки
        var el = (item && item.dom && item.dom.el) ? item.dom.el : (item instanceof Element ? item : (item && item.el ? item.el : null));
        if (!el) return false;
        var raw = el.getAttribute('data-size');
        if (raw == null) return false;
        var cleaned = String(raw).replace(/[^\d.\-]+/g, '');
        var size = parseFloat(cleaned);
        if (!Number.isFinite(size)) return false;
        return size >= range.min && size <= range.max;
      });
    }
  }

  // Працює лише при кліку на кнопку "Застосувати"
  if (applyBtn) {
    applyBtn.addEventListener('click', function (e) {
      e.preventDefault();
      applyRangeFilter();
    });
  } else {
    console.warn('#apply-filter не знайдено — фільтрація по кнопці не прив’язана.');
  }

  // Якщо є кнопка "Скинути" — прив’язуємо її (опціонально)
  if (resetBtn) {
    resetBtn.addEventListener('click', function (e) {
      e.preventDefault();
      if (minSizeRangeInput) minSizeRangeInput.value = '';
      if (maxSizeRangeInput) maxSizeRangeInput.value = '';
      mixer.filter('all');
    });
  }

  // Раніше ти прив’язував change до input — тепер цього не відбувається,
  // але можна підписатись на input, щоб візуально оновлювати значення повзунка, якщо потрібно.
});