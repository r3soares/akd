document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.open-exercise-modal').forEach(btn => {
        btn.addEventListener('click', async () => {

            const url = btn.dataset.url;
            const response = await fetch(url);
            const html = await response.text();

            document.getElementById('modal-body-content').innerHTML = html;
        });
    });
});

