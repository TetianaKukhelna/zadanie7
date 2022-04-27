$(document).ready(function() {

});

function initMap() {
    const input = document.getElementById("pac-input");
    const options = {

      componentRestrictions: { country: "us" },
    //   fields: ["address_components", "geometry", "icon", "name"],
      strictBounds: false,
      types: ["establishment"],
    };
    
    const autocomplete = new google.maps.places.Autocomplete(input, options);

    google.maps.event.addListener(autocomplete, 'place_changed', function(e) {
        const address = this.getPlace();
        const latlng = address.geometry.location.toJSON()
        const query = new URLSearchParams(latlng).toString()
        window.location = '?'+query
    });
}