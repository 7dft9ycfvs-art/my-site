// Загрузчик для центрированной версии

const modules = {
    header: 'centered-header.html',
    topRow: 'centered-time.html',
    middleRow: 'centered-events.html',
    bottomLeft: 'centered-schedule.html',
    bottomRight: 'centered-sidebar.html',
    settingsRow: 'centered-settings.html'
};

async function loadCenteredModules() {
    try {
        // Загружаем каждый модуль в свой контейнер
        for (const [containerId, moduleFile] of Object.entries(modules)) {
            const container = document.getElementById(containerId);
            if (container) {
                const response = await fetch(`modules/${moduleFile}`);
                const html = await response.text();
                container.innerHTML = html;
            }
        }
        
        console.log('Все модули загружены');
        
        // Инициализируем логику после загрузки
        if (typeof initEventLogic === 'function') {
            initEventLogic();
        }
        
    } catch (error) {
        console.error('Ошибка загрузки модулей:', error);
        showErrorFallback();
    }
}

function showErrorFallback() {
    document.body.innerHTML = `
        <div style="padding: 40px; text-align: center;">
            <h1 style="color: #f0f6fc;">⚠️ Ошибка загрузки</h1>
            <p style="color: #8b949e;">Не удалось загрузить модули. Пожалуйста, обновите страницу.</p>
            <button onclick="location.reload()" style="
                background: #238636;
                color: white;
                border: none;
                padding: 12px 30px;
                border-radius: 8px;
                cursor: pointer;
                margin-top: 20px;
            ">
                Обновить страницу
            </button>
        </div>
    `;
}

// Запускаем загрузку
document.addEventListener('DOMContentLoaded', loadCenteredModules);
