
function initialize() {
  
    // Giving the map som options
    var mapOptions = {
      zoom: 4,
      center: new google.maps.LatLng(66.02219,12.63376)
    };
    
    // Creating the map
    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
    

    // Looping through all the entries from the JSON data
    for(var i = 0; i < json.length; i++) {
      
      // Current object
      var obj = json[i];
  
      // Adding a new marker for the object
      var marker = new google.maps.Marker({
        position: new google.maps.LatLng(obj.latitude,obj.longitude),
        map: map,
        title: obj.title // this works, giving the marker a title with the correct title
      });
      
    } // end loop
  
}
// Initialize the map
google.maps.event.addDomListener(window, 'load', initialize);