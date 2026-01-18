// Логика планировщика
const scheduleCycle = [
    ["Улучшение героя", "Строительство", "Улучшение войск", "Исследования", "Снаряжение", "Улучшение героя"],
    ["Строительство", "Улучшение войск", "Исследования", "Снаряжение", "Улучшение героя", "Строительство"],
    ["Улучшение войск", "Исследования", "Снаряжение", "Улучшение героя", "Строительство", "Улучшение войск"],
    ["Исследования", "Снаряжение", "Улучшение героя", "Строительство", "Улучшение войск", "Исследования"],
    ["Снаряжение", "Улучшение героя", "Строительство", "Улучшение войск", "Исследования", "Снаряжение"],
    ["Улучшение героя", "Строительство", "Улучшение войск", "Исследования", "Снаряжение", "Улучшение героя"],
    ["Строительство", "Улучшение войск", "Исследования", "Снаряжение", "Улучшение героя", "Строительство"]
];

const timeSlots = ["03:00", "07:00", "11:00", "15:00", "19:00", "23:00"];

let settings = {
    startDay: 1,
    lastAppliedDate: null
};

// Слайдер
let currentSlide = 1;
const totalSlides = 5;
const sliderImages = [
    "Фото 1: Старт игры",
    "Фото 2: Битва героев",
    "Фото 3: Развитие базы",
    "Фото 4: Исследования",
    "Фото 5: Достижения"
];

// Инициализация
document.addEventListener('DOMContentLoaded', function() {
    loadSettings();
    updateDateTime();
    setInterval(updateDateTime, 1000);
    updateSlider();
    document.getElementById('totalSlides').textContent = totalSlides;
});

function loadSettings() {
    const saved = localStorage.getItem('gameSchedulerSettings');
    if (saved) {
        const data = JSON.parse(saved);
        settings.startDay = data.startDay || 1;
        settings.lastAppliedDate = data.lastAppliedDate || null;
        const startDayInput = document.getElementById('startDay');
        if (startDayInput) {
            startDayInput.value = settings.startDay;
        }
    }
}

function toggleSettings() {
    const panel = document.getElementById('settingsPanel');
    if (panel) {
        panel.style.display = panel.style.display === 'block' ? 'none' : 'block';
    }
}

function applySettings() {
    const startDayInput = document.getElementById('startDay');
    if (!startDayInput) return;

    const startDay = parseInt(startDayInput.value);
    if (startDay < 1 || startDay > 7) {
        alert('Введите число от 1 до 7');
        return;
    }

    settings.startDay = startDay;
    settings.lastAppliedDate = new Date().toDateString();
    localStorage.setItem('gameSchedulerSettings', JSON.stringify(settings));

    const panel = document.getElementById('settingsPanel');
    if (panel) {
        panel.style.display = 'none';
    }

    updateDateTime();
    showNotification('Настройки сохранены!');
}

function calculateCurrentCycleDay() {
    if (settings.lastAppliedDate) {
        const startDate = new Date(settings.lastAppliedDate);
        const currentDate = new Date();
        const diffDays = Math.floor((currentDate - startDate) / (1000 * 60 * 60 * 24));
        return ((settings.startDay - 1 + diffDays) % 7) + 1;
    }
    return settings.startDay;
}

function updateDateTime() {
    const now = new Date();

    // Время и дата
    const timeStr = now.toLocaleTimeString('ru-RU', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false
    });

    const dateStr = now.toLocaleDateString('ru-RU', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });

    const dayOfWeek = now.toLocaleDateString('ru-RU', { weekday: 'long' });
    const dayOfWeekCapitalized = dayOfWeek.charAt(0).toUpperCase() + dayOfWeek.slice(1);

    // Обновляем элементы
    document.getElementById('realTime').textContent = timeStr;
    document.getElementById('currentDate').textContent = dateStr;
    document.getElementById('dayOfWeek').textContent = dayOfWeekCapitalized;

    // День цикла
    const currentCycleDay = calculateCurrentCycleDay();
    document.getElementById('currentCycleDay').textContent = currentCycleDay;

    // Расписание
    const daySchedule = scheduleCycle[currentCycleDay - 1];
    const currentHour = now.getHours();
    const currentMinute = now.getMinutes();

    let nextSlotIndex = -1;
    for (let i = 0; i < timeSlots.length; i++) {
        const slotHour = parseInt(timeSlots[i].split(':')[0]);
        if (currentHour < slotHour || (currentHour === slotHour && currentMinute < 0)) {
            nextSlotIndex = i;
            break;
        } else if (i === timeSlots.length - 1) {
            nextSlotIndex = 0;
        }
    }

    const currentSlotIndex = (nextSlotIndex - 1 + timeSlots.length) % timeSlots.length;
    const currentEvent = daySchedule[currentSlotIndex];
    const nextEvent = daySchedule[nextSlotIndex];

    // Время до следующего события
    let nextTime = new Date();
    nextTime.setHours(parseInt(timeSlots[nextSlotIndex].split(':')[0]));
    nextTime.setMinutes(0);
    nextTime.setSeconds(0);

    if (nextSlotIndex === 0 && currentSlotIndex === timeSlots.length - 1) {
        nextTime.setDate(nextTime.getDate() + 1);
    }

    const timeDiff = nextTime - now;
    const hoursLeft = Math.floor(timeDiff / (1000 * 60 * 60));
    const minutesLeft = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
    const secondsLeft = Math.floor((timeDiff % (1000 * 60)) / 1000);

    // Обновляем информацию
    document.getElementById('currentEventName').textContent = currentEvent;
    document.getElementById('nextEventName').textContent = nextEvent;
    document.getElementById('nextEventTime').textContent = timeSlots[nextSlotIndex];
    document.getElementById('timeUntil').textContent = timeSlots[nextSlotIndex];

    document.getElementById('countdownTimer').textContent = 
        `${hoursLeft.toString().padStart(2, '0')}:${minutesLeft.toString().padStart(2, '0')}:${secondsLeft.toString().padStart(2, '0')}`;

    // ОБНОВЛЯЕМ ТАБЛИЦУ С ОБВОДКАМИ
    updateScheduleTable(daySchedule, currentSlotIndex, nextSlotIndex);
}

// ОБНОВЛЕННАЯ ФУНКЦИЯ - добавляем обводки
function updateScheduleTable(daySchedule, currentSlotIndex, nextSlotIndex) {
    const scheduleBody = document.getElementById('scheduleBody');
    if (!scheduleBody) return;

    scheduleBody.innerHTML = '';

    for (let i = 0; i < timeSlots.length; i++) {
        const row = document.createElement('tr');

        // Время
        const timeCell = document.createElement('td');
        timeCell.className = 'time-cell';
        timeCell.textContent = timeSlots[i];
        row.appendChild(timeCell);

        // Событие
        const eventCell = document.createElement('td');
        eventCell.className = 'event-cell';

        if (i === currentSlotIndex) {
            eventCell.classList.add('current');
        } else if (i === nextSlotIndex) {
            eventCell.classList.add('next');
        }
        
        eventCell.textContent = daySchedule[i];
        row.appendChild(eventCell);
        scheduleBody.appendChild(row);
    }
}

// Слайдер
function updateSlider() {
    document.getElementById('sliderImage').textContent = sliderImages[currentSlide - 1];
    document.getElementById('currentSlide').textContent = currentSlide;
}

function prevSlide() {
    currentSlide = currentSlide > 1 ? currentSlide - 1 : totalSlides;
    updateSlider();
}

function nextSlide() {
    currentSlide = currentSlide < totalSlides ? currentSlide + 1 : 1;
    updateSlider();
}

// Копирование номера телефона
function copyPhoneNumber() {
    const phoneNumber = "+7 (968) 974-72-00";

    navigator.clipboard.writeText(phoneNumber)
        .then(() => {
            showNotification('Номер телефона скопирован!');
        })
        .catch(err => {
            console.error('Ошибка копирования:', err);
            showNotification('Не удалось скопировать номер');
        });
}

function showNotification(message) {
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: var(--accent-green);
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        font-weight: 500;
        z-index: 1000;
        animation: slideIn 0.3s ease;
    `;
    notification.textContent = message;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}
