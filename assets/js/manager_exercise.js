document.addEventListener('DOMContentLoaded', () => {

    const searchInput = document.getElementById('search-exercise');
    const rows = document.querySelectorAll('#exercise-table tr');

    searchInput.addEventListener('input', e => {

        const filter = e.target.value.toLowerCase();

        rows.forEach(row => {

            const text = row.textContent.toLowerCase();

            row.style.display = text.includes(filter) ? '' : 'none';

        });
    });
});
