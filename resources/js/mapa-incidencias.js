window.MapaIncidencias = {

    crearEditable: function (mapId, latInputId, lngInputId) {

        const latInput = document.getElementById(latInputId);
        const lngInput = document.getElementById(lngInputId);

        let lat = parseFloat(latInput.value) || -2.170998;
        let lng = parseFloat(lngInput.value) || -79.922359;

        const map = L.map(mapId).setView([lat, lng], 13);
        window.mapaIncidenciaActual = map;

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        const marker = L.marker([lat, lng], {
            draggable: true
        }).addTo(map);
        window.markerIncidenciaActual = marker;

        marker.on('dragend', function () {

            const pos = marker.getLatLng();

            latInput.value = pos.lat.toFixed(8);
            lngInput.value = pos.lng.toFixed(8);

        });

        map.on('click', function (e) {

            marker.setLatLng(e.latlng);

            latInput.value = e.latlng.lat.toFixed(8);
            lngInput.value = e.latlng.lng.toFixed(8);

        });

        return map;
    },

    crearSoloLectura: function (mapId, lat, lng) {

        lat = parseFloat(lat) || -2.170998;
        lng = parseFloat(lng) || -79.922359;

        const map = L.map(mapId).setView([lat, lng], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        L.marker([lat, lng]).addTo(map);

        return map;
    },
    
    centrarPorCiudad: function(selectId) {

        const ciudadSelect = document.getElementById(selectId);

        if (!ciudadSelect) {
            return;
        }

        ciudadSelect.addEventListener('change', function () {

            const opcion = this.options[this.selectedIndex];

            const lat = parseFloat(opcion.dataset.latitud);
            const lng = parseFloat(opcion.dataset.longitud);

            if (!lat || !lng) {
                return;
            }

            if (window.mapaIncidenciaActual && window.markerIncidenciaActual) {

                window.mapaIncidenciaActual.setView(
                    [lat, lng],
                    13
                );

                window.markerIncidenciaActual.setLatLng([
                    lat,
                    lng
                ]);

                document.getElementById('latitud').value =
                    lat.toFixed(8);

                document.getElementById('longitud').value =
                    lng.toFixed(8);
            }

        });

    }
    

};