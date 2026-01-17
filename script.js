// Волшебная кнопка
document.getElementById('magicBtn').addEventListener('click', function() {
    this.textContent = 'Волшебство! ✨';
    this.style.background = 'linear-gradient(45deg, #ff6b6b, #4ecdc4)';
    
    // Создаем эффект конфетти
    for(let i = 0; i < 20; i++) {
        const confetti = document.createElement('div');
        confetti.textContent = ['🎉', '✨', '🌟', '🥳'][Math.floor(Math.random() * 4)];
        confetti.style.position = 'fixed';
        confetti.style.left = Math.random() * 100 + 'vw';
        confetti.style.top = '-50px';
        confetti.style.fontSize = '25px';
        confetti.style.zIndex = '9999';
        confetti.style.animation = `fall ${Math.random() * 2 + 2}s linear forwards`;
        document.body.appendChild(confetti);
        
        setTimeout(() => confetti.remove(), 3000);
    }
});

// Форма обратной связи
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const message = document.getElementById('formMessage');
    message.textContent = 'Сообщение отправлено! (Это демо, на самом деле никуда не ушло)';
    message.style.color = 'green';
    message.style.fontWeight = 'bold';
    
    // Очищаем форму через 3 секунды
    setTimeout(() => {
        this.reset();
        message.textContent = '';
    }, 3000);
});

// Анимация падения конфетти
const style = document.createElement('style');
style.textContent = `
@keyframes fall {
    to {
        transform: translateY(100vh) rotate(360deg);
        opacity: 0;
    }
}
`;
document.head.appendChild(style);

// Плавная прокрутка для навигации
document.querySelectorAll('nav a').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const targetId = this.getAttribute('href');
        document.querySelector(targetId).scrollIntoView({
            behavior: 'smooth'
        });
    });
});