// Выбираем все элементы с классом "fade-in"
const fadeInElements = document.querySelectorAll('.fade-in');

// Настройка Intersection Observer
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        // Если элемент виден
        if (entry.isIntersecting) {
            entry.target.classList.add('show'); // Добавляем класс, чтобы сделать элемент видимым
            entry.target.classList.remove('hidden'); // Убираем класс для скрытия
        } else {
            // Когда элемент уходит из зоны видимости
            entry.target.classList.remove('show'); // Убираем класс для появления
            entry.target.classList.add('hidden'); // Добавляем класс для исчезновения
        }
    });
}, { threshold: 0.1 }); // Запускать, когда хотя бы 10% элемента видны

// Подключаем наблюдатель ко всем элементам с классом "fade-in"
fadeInElements.forEach(el => {
    observer.observe(el);
});
