window.Interoperabilite = (() => {
	let module = {};
	let map, parkingIcon;

	module.init = (position, markers) => {
		$.ajaxPrefilter((options) => {
			if (options.crossDomain) {
				console.log(options.url)
				options.url = "tcp://www-cache:3128/" + encodeURIComponent(options.url);
				console.log(options.url)
				options.crossDomain = false;
			}
		});

		let context = this;
		this.parkingIcon = L.icon({
			iconUrl: 'public/assets/leaflet/images/parking.png',

			iconSize:     [32, 37],
			iconAnchor:   [16, 35],
			popupAnchor:  [0, -35]
		});

		this.map = L.map('map').setView([position.lat, position.lon], 13);
		L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
			attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
		}).addTo(this.map);

		L.marker([position.lat, position.lon]).addTo(this.map)
		.bindPopup('Votre position')
		.openPopup();

		module.addParking(markers);
	}

	module.addParking = (data) => {
		$.each(data, (k, p) => {
			let number = p.number;
			let nom = p.name;
			let adresse = p.address;
			let ouvert = (p.open == 1 ? 'Ouvert' : 'Fermé');
			
			let disponible = p.station.available;
			let libres = p.station.free;
			let total = p.station.total;

			L.marker([p.lat, p.lng], {
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
		})
	}

	return module;
})();