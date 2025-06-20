document.addEventListener('DOMContentLoaded', function() {
    // Показываем прелоадер при начале загрузки страницы
    const preloader = document.querySelector('.preloader');
    
    // Скрываем прелоадер когда страница загружена
    window.addEventListener('load', function() {
        preloader.classList.add('hidden');
    });

    // Показываем прелоадер при переходе по ссылкам
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (link && !link.hasAttribute('data-no-preloader') && 
            link.hostname === window.location.hostname) {
            preloader.classList.remove('hidden');
        }
    });

    // Показываем прелоадер при отправке форм
    document.addEventListener('submit', function(e) {
        const form = e.target;
        if (!form.hasAttribute('data-no-preloader')) {
            preloader.classList.remove('hidden');
        }
    });
}); 