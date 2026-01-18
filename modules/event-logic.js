// Основная логика для event.html

// Данные расписания
const scheduleCycle = [
    ["Улучшение героя", "Строительство поселения", "Улучшение войск", "Исследование технологий", "Усиление снаряжения", "Улучшение героя"],
    ["Строительство поселения", "Улучшение войск", "Исследование технологий", "Усиление снаряжения", "Улучшение героя", "Строительство поселения"],
    ["Улучшение войск", "Исследование технологий", "Усиление снаряжения", "Улучшение героя", "Строительство поселения", "Улучшение войск"],
    ["Исследование технологий", "Усиление снаряжения", "Улучшение героя", "Строительство поселения", "Улучшение войск", "Исследование технологий"],
    ["Усиление снаряжения", "Улучшение героя", "Строительство поселения", "Улучшение войск", "Исследование технологий", "Усиление снаряжения"],
    ["Улучшение героя", "Строительство поселения", "Улучшение войск", "Исследование технологий", "Усиление снаряжения", "Улучшение героя"],
    ["Строительство поселения", "Улучшение войск", "Исследование технологий", "Усиление снаряжения", "Улучшение героя", "Строительство поселения"]
];

const timeSlots = ["03:00", "07:00", "11:00", "15:00", "19:00", "23:00"];

// Настройки
let settings = {
    startDay: 1,
    lastAppliedDate: null,
    myPhoneNumber: "+7 (900) 123-45-67"
};

// Герои
const heroes = [
    { name: "Легионер", level: 45, power: 1200, health: 850, icon: "⚔️", color: "#ff6b6b" },
    { name: "Маг Огня", level: 38, power: 1500, health: 480, icon: "🔥", color: "#ffa502" },
    { name: "Лесной Лучник", level: 42, power: 980, health: 620, icon: "🏹", color: "#2ed573" },
    { name: "Жрец Света", level: 35, power: 750, health: 920, icon: "✨", color: "#ffeaa7" },
    { name: "Темный Рыцарь", level: 50, power: 1800, health: 1100, icon: "🛡️", color: "#6c5ce7" },
    { name: "Эльфийка-Ведьма", level: 40, power: 1350, health: 580, icon: "🌙", color: "#a29bfe" }
];

function initEventLogic() {
    console.log('Инициализация логики...');
    
    loadSettings();
    setupEventListeners();
    updateDateTime();
    setInterval(updateDateTime, 1000);
    
    // Устанавливаем номер телефона
    const phoneElement = document.getElementById('myPhoneNumber');
    if (phoneElement) {
        phoneElement.textContent = settings.myPhoneNumber;
    }
    
    // Обновляем сумму при изменении
    const amountInput = document.querySelector('input[type="number"]');
    if (amountInput) {
        amountInput.addEventListener('input', function() {
            const amountElement = document.getElementById('paymentAmount');
            if (amountElement) {
                amountElement.textContent = this.value + ' ₽';
            }
        });
    }
}

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

function setupEventListeners() {
    // Настройки
    const settingsBtn = document.querySelector('[onclick="toggleSettings()"]');
    if (settingsBtn) {
        settingsBtn.addEventListener('click', toggleSettings);
    }
    
    const applyBtn = document.querySelector('[onclick="applySettings()"]');
    if (applyBtn) {
        applyBtn.addEventListener('click', applySettings);
    }
    
    // Платежи
    const paymentForm = document.getElementById('paymentForm');
    if (paymentForm) {
        paymentForm.addEventListener('submit', processPayment);
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
    
    // Обновляем элементы, если они есть
    updateElementText('realTime', timeStr);
    updateElementText('currentDate', `Дата: ${dateStr}`);
    updateElementText('dayOfWeek', `День недели: ${dayOfWeekCapitalized}`);
    
    // День цикла
    const currentCycleDay = calculateCurrentCycleDay();
    updateElementText('currentCycleDay', currentCycleDay);
    
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
    
    // Обновляем информацию о событиях
    updateElementText('currentEventName', currentEvent);
    updateElementText('nextEventName', nextEvent);
    updateElementText('nextEventTime', timeSlots[nextSlotIndex]);
    updateElementText('timeUntil', timeSlots[nextSlotIndex]);
    
    updateElementText('countdownTimer', 
        `${hoursLeft.toString().padStart(2, '0')}:${minutesLeft.toString().padStart(2, '0')}:${secondsLeft.toString().padStart(2, '0')}`);
    
    // Обновляем таблицу расписания
    updateScheduleTable(daySchedule, currentSlotIndex, nextSlotIndex);
}

function updateElementText(id, text) {
    const element = document.getElementById(id);
    if (element) {
        element.textContent = text;
    }
}

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
        if (i === currentSlotIndex) eventCell.classList.add('current');
        if (i === nextSlotIndex) eventCell.classList.add('next');
        
        const eventType = daySchedule[i];
        const eventSpan = document.createElement('span');
        eventSpan.className = `event-type ${getEventClass(eventType)}`;
        eventSpan.textContent = eventType;
        eventCell.appendChild(eventSpan);
        
        row.appendChild(eventCell);
        scheduleBody.appendChild(row);
    }
}

function getEventClass(eventType) {
    const classes = {
        "Улучшение героя": "type-hero",
        "Строительство поселения": "type-settlement", 
        "Улучшение войск": "type-troops",
        "Исследование технологий": "type-tech",
        "Усиление снаряжения": "type-equipment"
    };
    return classes[eventType] || '';
}

function processPayment(event) {
    event.preventDefault();
    
    const form = event.target;
    const submitBtn = form.querySelector('.submit-btn');
    const successMessage = document.getElementById('successMessage');
    
    if (!submitBtn || !successMessage) return;
    
    // Блокируем кнопку
    submitBtn.disabled = true;
    submitBtn.textContent = '⏳ Обработка...';
    
    setTimeout(() => {
        // Сохраняем данные
        const paymentData = {
            date: new Date().toISOString(),
            amount: form.querySelector('input[type="number"]').value,
            recipientPhone: settings.myPhoneNumber
        };
        
        let payments = JSON.parse(localStorage.getItem('payments') || '[]');
        payments.push(paymentData);
        localStorage.setItem('payments', JSON.stringify(payments));
        
        // Показываем успешное сообщение
        successMessage.style.display = 'block';
        submitBtn.style.display = 'none';
        
        // Сбрасываем форму через 3 секунды
        setTimeout(() => {
            form.reset();
            updateElementText('paymentAmount', '200 ₽');
            successMessage.style.display = 'none';
            submitBtn.style.display = 'block';
            submitBtn.disabled = false;
            submitBtn.textContent = '✅ ПОДТВЕРДИТЬ ПЕРЕВОД';
        }, 3000);
        
        showNotification('Спасибо! Информация о переводе сохранена.');
    }, 1500);
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

// Экспортируем функцию для загрузчика
window.initEventLogic = initEventLogic;
