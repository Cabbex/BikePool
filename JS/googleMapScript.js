
function initMap() {
    if (Modernizr.geolocation) {
        navigator.geolocation.getCurrentPosition(loadMap);
    }
}


function loadMap(position) {
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;
    console.log(latitude + ":" + longitude);
    //AIzaSyCe6YvYhgU76_ke2Z64dwv1sHTpj6OibHE
    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: latitude, lng: longitude},
        zoom: 10
    });
    var marker = new google.maps.Marker({
        position: {lat: latitude, lng: longitude},
        map: map
    });
}

    