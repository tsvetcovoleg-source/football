document.addEventListener('DOMContentLoaded', () => {
    const timers = document.querySelectorAll('.countdown[data-start]');

    function renderTimer(element) {
        const start = new Date(element.dataset.start).getTime();
        const diff = Math.max(0, Math.floor((start - Date.now()) / 1000));
        const hours = String(Math.floor(diff / 3600)).padStart(2, '0');
        const minutes = String(Math.floor((diff % 3600) / 60)).padStart(2, '0');
        const seconds = String(diff % 60).padStart(2, '0');
        element.textContent = `${hours}:${minutes}:${seconds}`;
        if (diff === 0) {
            element.closest('.match-card')?.classList.add('is-locked');
        }
    }

    if (timers.length) {
        timers.forEach(renderTimer);
        setInterval(() => timers.forEach(renderTimer), 1000);
    }
});
