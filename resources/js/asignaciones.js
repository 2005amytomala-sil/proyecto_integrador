document.addEventListener('DOMContentLoaded', function () {

    const responsable = document.querySelector(
        'select[name="responsable_id"]'
    );

    const selectApoyo = document.getElementById(
        'selectApoyo'
    );

    const listaApoyos = document.getElementById(
        'listaApoyos'
    );


    if (!responsable || !selectApoyo || !listaApoyos) {
        return;
    }


    let apoyos = [];


    function actualizarLista() {

        listaApoyos.innerHTML = '';


        apoyos.forEach(usuario => {

            const div = document.createElement('div');

            div.className =
                'alert alert-secondary d-flex justify-content-between align-items-center';


            div.innerHTML = `
                <span>
                    ${usuario.nombre}
                </span>

                <button 
                    type="button"
                    class="btn btn-sm btn-danger">
                    X
                </button>

                <input 
                    type="hidden"
                    name="apoyos[]"
                    value="${usuario.id}">
            `;


            div.querySelector('button')
                .addEventListener('click', function () {

                    apoyos = apoyos.filter(
                        a => a.id != usuario.id
                    );

                    actualizarLista();

                });


            listaApoyos.appendChild(div);

        });

    }



    selectApoyo.addEventListener('change', function () {

        const id = this.value;


        if (!id) {
            return;
        }


        if (apoyos.some(a => a.id == id)) {

            this.value = '';
            return;

        }


        const nombre =
            this.options[this.selectedIndex]
                .dataset.nombre;


        apoyos.push({
            id,
            nombre
        });


        actualizarLista();


        this.value = '';

    });



    responsable.addEventListener('change', function () {


        const responsableId = this.value;


        Array.from(selectApoyo.options)
            .forEach(option => {

                option.disabled =
                    option.value === responsableId;

            });


        apoyos = apoyos.filter(
            a => a.id != responsableId
        );


        actualizarLista();

    });


});