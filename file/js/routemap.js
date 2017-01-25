$(function(){
        var SearchFrom = document.getElementById("autocomplete").value;
        var Searchto = document.getElementById("autocompleteto").value;
        var map;
            var origin = SearchFrom
            var destinations = [
               Searchto];
            var directionsDisplay;
            var directionsService = new google.maps.DirectionsService();

            function calculateDistances() {
                var service = new google.maps.DistanceMatrixService();
                service.getDistanceMatrix({
                    origins: [origin], //array of origins
                    destinations: destinations, //array of destinations
                    travelMode: google.maps.TravelMode.DRIVING,
                    unitSystem: google.maps.UnitSystem.METRIC,
                    avoidHighways: false,
                    avoidTolls: false
                }, callback);
            }

            function callback(response, status) {
                if (status != google.maps.DistanceMatrixStatus.OK) {
                    alert('Error was: ' + status);
                } else {
                    //we only have one origin so there should only be one row
                    var routes = response.rows[0];               
                    var sortable = [];
                    var resultText = "Origin: <b>" + origin + "</b><br/>";
                    resultText += "Possible Routes: <br/>";
                    for (var i = routes.elements.length - 1; i >= 0; i--) {
                        console.log(routes.elements[i].distance.value);
                        var rteLength = routes.elements[i].duration.value;
                        resultText += "Route: <b>" + destinations[i] + "</b>, " + "Route Length: <b>" + rteLength + "</b><br/>";
                        sortable.push([destinations[i], rteLength]);
                    }
                    //sort the result lengths from shortest to longest.
                    sortable.sort(function (a, b) {
                        return a[1] - b[1];
                    });
                    //build the waypoints.
                    var waypoints = [];
                    for (j = 0; j < sortable.length - 1; j++) {
                        console.log(sortable[j][0]);
                        waypoints.push({
                            location: sortable[j][0],
                            stopover: true
                        });
                    }
                    //start address == origin
                    var start = origin;
                    //end address is the furthest desitnation from the origin.
                    var end = sortable[sortable.length - 1][0];
                    //calculate the route with the waypoints        
                    calculateRoute(start, end, waypoints);
                    //log the routes and duration.
                    $('#results').html(resultText);
                }
            }

            //Calculate the route of the shortest distance we found.
            function calculateRoute(start, end, waypoints) {
                var request = {
                    origin: start,
                    destination: end,
                    waypoints: waypoints,
                    optimizeWaypoints: true,
                    travelMode: google.maps.TravelMode.DRIVING
                };
                directionsService.route(request, function (result, status) {
                    if (status == google.maps.DirectionsStatus.OK) {
                        directionsDisplay.setDirections(result);
                    }
                });
            }

            function initialize() {
                directionsDisplay = new google.maps.DirectionsRenderer();
                var centerPosition = new google.maps.LatLng(38.713107, -90.42984);
                var options = {
                    zoom: 12,
                    center: centerPosition,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                map = new google.maps.Map($('#map')[0], options);
                geocoder = new google.maps.Geocoder();
                directionsDisplay.setMap(map);
                calculateDistances();
            }

            google.maps.event.addDomListener(window, 'load', initialize);
    })