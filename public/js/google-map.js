google.maps.event.addDomListener(window, 'load', initialize);
function initialize() {
    var input = document.getElementById('address');
    var address = new google.maps.places.Autocomplete(input);
    address.addListener('place_changed', function () {
        var place = address.getPlace();
        $('#latitude').val(place.geometry['location'].lat());
        $('#longitude').val(place.geometry['location'].lng());
        
        for (var i = 0; i < place.address_components.length; i++) {
            if(place.address_components[i].types[0] == 'administrative_area_level_1'){
                $('#state').val(place.address_components[i].long_name);
            }
            if(place.address_components[i].types[0] == 'locality'){
                $('#city').val(place.address_components[i].long_name);
            }
            if(place.address_components[i].types[0] == 'postal_code'){
                $('#zip_code').val(place.address_components[i].long_name);
            }
            if(place.address_components[i].types[0] == 'country'){
                $('#country').val(place.address_components[i].long_name);
            }
        }

    });
}