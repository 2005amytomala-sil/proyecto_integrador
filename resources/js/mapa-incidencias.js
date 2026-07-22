window.MapaIncidencias = {

    crearEditable: function (mapId, latInputId, lngInputId) {

        const latInput = document.getElementById(latInputId);
        const lngInput = document.getElementById(lngInputId);

        let lat = parseFloat(latInput.value) || -2.170998;
        let lng = parseFloat(lngInput.value) || -79.922359;

        const map = L.map(mapId).setView([lat, lng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        const marker = L.marker([lat, lng], {
            draggable: true
        }).addTo(map);

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
    }

};