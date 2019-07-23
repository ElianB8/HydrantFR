var macarte : any = null;
// Fonction d'initialisation de la carte
function initMap() {
    // Créer l'objet "macarte" et l'insèrer dans l'élément HTML qui a l'ID "map"
    let lat = 42.740536;
    let lon = 2.9157895;
    let zoomMax : number = 20;
    let zoomMin : number = 9;
    let defaultZoom : number = 9;
    macarte = L.map('map').setView([lat, lon], defaultZoom);
    L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
        attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
        minZoom: zoomMin,
        maxZoom: zoomMax
    }).addTo(macarte);
    macarte.setZoom(15);
}

function getInfo() {
    $.getJSON('./map.php', function (data) {
        $.each(data, function (key, place) {
            var marker = L.marker([place.latitude, place.longitude])
                .addTo(macarte)
                .bindPopup(`<a href="display.php?id=${place.id}"><h5> ${place.nom} </h5></a>
                        <h6>Description: ${place.description}</h6>
                        <h6>Adresse : ${place.adresse}</h6>
                        <p>Latitude : ${place.latitude}</p>
                        <p>Longitude : ${place.longitude}</p>            
            `)
        });

    }).fail(function (error) {
        console.log(error);
    });
}



window.addEventListener('load', () => {
    initMap();
    getInfo();
});
