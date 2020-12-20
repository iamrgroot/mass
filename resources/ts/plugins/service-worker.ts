if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/vue/service-worker.js', { scope: '/' });
}