document.addEventListener('DOMContentLoaded', () => {

    //Carrega modal definido em data-url dos botões
    document.querySelectorAll('.open-exercise-modal').forEach(btn => {
        btn.addEventListener('click', async () => {

            const modalBody = document.getElementById('modal-body-content');
            modalBody.innerHTML = 'Carregando...';

            const url = btn.dataset.url;
            const response = await fetch(url);
            modalBody.innerHTML = await response.text();
        });
    });
});
