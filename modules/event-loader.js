// Загрузчик модулей для event.html

const modules = {
    left: [
        'header.html',
        'time-info.html', 
        'current-events.html',
        'schedule.html',
        'settings.html'
    ],
    right: [
        'heroes.html',
        'payment.html'
    ]
};

async function loadModules() {
    try {
        // Загружаем левую колонку
        const leftColumn = document.getElementById('leftColumn');
        for (const module of modules.left) {
            const response = await fetch(`modules/${module}`);
            const html = await response.text();
            const div = document.createElement('div');
            div.innerHTML = html;
            leftColumn.appendChild(div);
        }
        
        // Загружаем правую колонку
        const rightColumn = document.getElementById('rightColumn');
        for (const module of modules.right) {
            const response = await fetch(`modules/${module}`);
            const html = await response.text();
            const div = document.createElement('div');
            div.innerHTML = html;
            rightColumn.appendChild(div);
        }
        
        console.log('Все модули загружены');
        // Инициализируем логику после загрузки
        if (typeof initEventLogic === 'function') {
            initEventLogic();
        }
        
    } catch (error) {
        console.error('Ошибка загрузки модулей:', error);
        // Fallback: показываем простое сообщение
        document.getElementById('leftColumn').innerHTML = `
            <div class="module">
                <h2>Ошибка загрузки</h2>
                <p>Не удалось загрузить модули. Пожалуйста, обновите страницу.</p>
            </div>
        `;
    }
}

// Запускаем загрузку при полной загрузке DOM
document.addEventListener('DOMContentLoaded', loadModules);
