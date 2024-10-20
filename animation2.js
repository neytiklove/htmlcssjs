// Функция для добавления/удаления класса видимости
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible'); // Добавляем класс "visible" при появлении в зоне видимости
        } else {
            entry.target.classList.remove('visible'); // Удаляем класс "visible" при выходе из зоны видимости
        }
    });
});

// Наблюдение за каждым элементом списка
document.querySelectorAll('.scroll-element').forEach((element) => {
    observer.observe(element);
});
