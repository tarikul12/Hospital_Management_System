window.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            const url = new URL(window.location.href);
            if (url.searchParams.has('search')) {
                url.searchParams.delete('search');
                window.location.href = url.toString(); // reloads the page without search query
            }
        }, 5000); // 5 seconds
    });