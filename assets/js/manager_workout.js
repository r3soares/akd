document.addEventListener('DOMContentLoaded', () => {

    const modal = document.getElementById('exercise_modal');

    if (!modal){
        console.warn('Modal não encontrado');
    }

    //Em vez de procurar os botoes, pega o botao que disparou o evento
    modal.addEventListener('show.bs.modal', function (event) {

        //Busca o botão que disparou o evento
        const button = event.relatedTarget;

        //Pega os dados deste botão
        const workoutId = button.dataset.workoutId;
        const workoutName = button.dataset.workoutName;

        //Adiciona os dados ao formulário do modal
        const form = document.getElementById('exercise_modal_dialog');
        if(!form){
            console.warn('Formulário não encontrado');
        }

        // input hidden dentro do form
        const workoutInput = form.querySelector('#workout_id');
        if (workoutInput) workoutInput.value = workoutId;

        // título dentro do modal
        const workoutTitle = form.querySelector('#workout_name');
        if (workoutTitle) workoutTitle.textContent = workoutName;

    });

    function onSelectDropdownMenu(e){
        const item = e.target.closest(".dropdown-item");
        if (!item) return;

        // sobe até o container .dropdown
        const dropdown = item.closest(".dropdown");

        // input visível e hidden dentro do mesmo dropdown
        const input = dropdown.querySelector("input.form-control");
        const hidden = dropdown.querySelector("input[type='hidden']");

        if (!input || !hidden) return;

        // preenche os valores
        input.value = item.dataset.name;   // mostrado no campo
        hidden.value = item.dataset.id;    // enviado no form

        // fecha o dropdown (Bootstrap)
        const bsDropdown = bootstrap.Dropdown.getInstance(input);
        if (bsDropdown) bsDropdown.hide();
    }

    // Função genérica para lidar com dropdowns do modal
    function setupDropdowns(modalSelector) {

        const modal = document.querySelector(modalSelector);
        if (!modal) return;

        // seleciona todos os menus de dropdown dentro do modal
        modal.querySelectorAll(".dropdown-menu").forEach(menu => {

            menu.addEventListener("click", onSelectDropdownMenu);
        });

    }

    // inicializa os dropdowns dentro do modal add_exercise_modal
    setupDropdowns("#exercise_modal");

    function setupAutocomplete(modalSelector) {
        const modal = document.querySelector(modalSelector);
        if (!modal) return;

        // percorre todos os dropdowns
        modal.querySelectorAll(".dropdown").forEach(dropdown => {
            const input = dropdown.querySelector("input.form-control");
            const menu = dropdown.querySelector(".dropdown-menu");

            if (!input || !menu) return;

            const items = Array.from(menu.querySelectorAll(".dropdown-item"));

            // 1️⃣ Filtra os itens enquanto digita
            input.addEventListener("input", () => {
                const val = input.value.toLowerCase();
                let hasVisible = false;

                items.forEach(item => {
                    const text = item.dataset.name.toLowerCase();
                    if (text.includes(val)) {
                        item.style.display = "";
                        hasVisible = true;
                    } else {
                        item.style.display = "none";
                    }
                });

                // abre o dropdown se houver resultados
                const bsDropdown = bootstrap.Dropdown.getOrCreateInstance(input);
                if (hasVisible) bsDropdown.show();
                else bsDropdown.hide();
            });

            // 2️⃣ Seleção do item
            menu.addEventListener("click", onSelectDropdownMenu);
        });
    }

    // inicializa autocomplete no modal
    setupAutocomplete("#exercise_modal");

});

