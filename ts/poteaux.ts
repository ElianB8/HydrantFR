let chercher = () => {
    var ville = $("#pot_adresse").val();
    if (ville != "") {
        $.ajax({
            url: "https://api-adresse.data.gouv.fr/search/",
            type: 'get', // Requête de type GET
            data: "q=" + ville 
        }).done(function (response) {
            if (response != "") {
                let resLon = response['features'][0].geometry.coordinates[0];
                let resLat = response['features'][0].geometry.coordinates[1];
                let inputLon :any = document.getElementById('pot_longitude');
                let inputLat: any = document.getElementById('pot_latitude');
                inputLon.value = resLon;
                inputLat.value = resLat;
                //var marker = L.marker([resLat, resLon]).addTo(macarte);
            }
        }).fail(function (error) {
            alert(error);
        });
    }
}

window.addEventListener('load', () => {
    let saveBtn = document.getElementById("add_saved");
    let inputAdr: any = document.getElementById("pot_adresse");
    inputAdr.addEventListener('blur', () => {
        chercher();
    });
})