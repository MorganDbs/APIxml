window.Interoperabilite = (() => {
    let module = {};
    let map, parkingIcon;

    module.init = () => {
        let context = this;
        this.parkingIcon = L.icon({
            iconUrl: 'public/assets/leaflet/images/parking.png',

            iconSize:     [32, 37],
            iconAnchor:   [16, 35],
            popupAnchor:  [0, -35]
        });

        let pos = module.query('http://ip-api.com/json', 'GET', 'json')
        pos.done((position) => {
            this.map = L.map('map').setView([position.lat, position.lon], 13);
            L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(this.map);

            L.marker([position.lat, position.lon]).addTo(this.map)
                .bindPopup('Votre position')
                .openPopup();

            let prParkings = module.query('http://www.velostanlib.fr/service/carto', 'GET', 'xml')
            prParkings.done((data) => {
                $(data).find('marker').each((k, v) => {
                    module.addParking(v);
                });                
            });
        });       
    }

    module.query = (url, method, dataType, data = null) => {
        let pr = $.ajax(url, {
            type: method,
            dataType: dataType,
            context: this,
            data: data
        });
        pr.fail((jqXHR, status, error) => {
           console.log(error)
        })
        return pr;
    }

    module.addParking = (data) => {
        let number = $(data).attr('number')
        let nom = $(data).attr('name')
        let adresse = $(data).attr('address')
        let ouvert = ($(data).attr('open') == 1 ? 'Ouvert' : 'Fermé');
        
        let station = module.query(`http://www.velostanlib.fr/service/stationdetails/nancy/${number}`, 'GET', 'xml')
        station.done((s) => {
            let disponible = $(s).find('available').text();
            let libres = $(s).find('free').text();
            let total = $(s).find('total').text();

            L.marker([$(data).attr('lat'), $(data).attr('lng')], {
                icon: this.parkingIcon
            })
            .addTo(this.map)
            .bindPopup(`
                <h6>${nom}</h6>
                <p>Adresse : ${adresse}</p>
                <p>Vélos : ${disponible} / ${total}</p>
                <p>Places libres : ${libres}</p>
                <p>${ouvert}</p>
            `); 
        });
    }

    return module;
})();

$(() => {
	Interoperabilite.init();
});