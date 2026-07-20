console.log("Ubicacion.js cargado");
document.addEventListener('DOMContentLoaded', async () => {

    const paisSelect = document.getElementById('inputCountry');
    const provinciaSelect = document.getElementById('inputProvince');
    const ciudadSelect = document.getElementById('inputCity');

    if (!paisSelect || !provinciaSelect || !ciudadSelect) {
        return;
    }
    const paisSeleccionado = window.ubicacion?.pais ?? '';
    const provinciaSeleccionada = window.ubicacion?.provincia ?? '';
    const ciudadSeleccionada = window.ubicacion?.ciudad ?? '';

    // Cargar países
    const paises = await fetch('/api/paises');
    const listaPaises = await paises.json();

    listaPaises.forEach(pais => {
        paisSelect.innerHTML += `
            <option
                value="${pais.id}"
                ${pais.id == paisSeleccionado ? 'selected' : ''}>

                ${pais.nombre}

            </option>
        `;
    });

    // Cuando cambia el país
    async function cargarProvincias() {

        provinciaSelect.innerHTML =
            '<option value="">Seleccione una provincia</option>';

        ciudadSelect.innerHTML =
            '<option value="">Seleccione una ciudad</option>';

        if (!paisSelect.value)
            return;

        const respuesta = await fetch(
            `/api/provincias/${paisSelect.value}`
        );

        const provincias = await respuesta.json();

        provincias.forEach(provincia => {

            provinciaSelect.innerHTML += `
                <option
                    value="${provincia.id}"
                    ${provincia.id == provinciaSeleccionada ? 'selected' : ''}>

                    ${provincia.nombre}

                </option>
            `;

        });

        // Si ya había una provincia seleccionada,
        // cargar automáticamente sus ciudades.
        if (provinciaSeleccionada) {
            await cargarCiudades();
        }

    }

    paisSelect.addEventListener('change', cargarProvincias);

    // Cuando cambia la provincia
    async function cargarCiudades() {

        ciudadSelect.innerHTML =
            '<option value="">Seleccione una ciudad</option>';

        if (!provinciaSelect.value)
            return;

        const respuesta = await fetch(
            `/api/ciudades/${provinciaSelect.value}`
        );

        const ciudades = await respuesta.json();

        ciudades.forEach(ciudad => {

            ciudadSelect.innerHTML += `
                <option
                    value="${ciudad.id}"
                    ${ciudad.id == ciudadSeleccionada ? 'selected' : ''}>

                    ${ciudad.nombre}

                </option>
            `;

        });

    }

    provinciaSelect.addEventListener('change', cargarCiudades);
    if (paisSeleccionado) {

        await cargarProvincias();

    }
});
