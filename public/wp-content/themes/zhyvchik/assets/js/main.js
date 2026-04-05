document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('toggleBtn');
    const container = document.querySelector('.zhyvchik-container');

    btn.addEventListener('click', function(e) {
        e.preventDefault(); // Щоб кнопка не перезавантажувала сторінку
        container.classList.toggle('active');
    });
});