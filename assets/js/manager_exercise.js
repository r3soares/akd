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

    //Preenche os campos ao Editar
    //Busca por todos os botões com a tag de abrir modal
    document.querySelectorAll('.open-exercise_modal').forEach(button => {

        const {
            id = '',
            name = '',
            description = ''
        } = button.dataset;

        const form = document.getElementById('exercise_form');

        button.addEventListener('click', () => {

            document.getElementById('exercise_name').value = name;
            document.getElementById('exercise_description').value = description;
            form.action = id ?
                form.dataset.editTemplate.replace('__id__', id)
                : form.dataset.create;

        });

    });

});
