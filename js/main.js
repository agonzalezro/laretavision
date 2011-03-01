/*
* address = A string with the location, if no address given deafault point is Galicia Lat Lng
* user = The user name
* avatar = The avatar's URL
* message = The chío message (or tweet)
* message_web = The message's URL
* time = The timestamp
*/
function showMessage(address, user, avatar, message, message_web, time) {
	if (geocoder) {
		geocoder.getLatLng(address, function(point) {
			if (!point) {
				point = new GLatLng(42.617791,-8.129883);
			}
			map.panTo(point);

			var marker = new GMarker(point, myicon);
			map.addOverlay(marker);

            arrayMarkers[++indexArray] = marker;
            if (indexArray > 5) { arrayMarkers[indexArray - 5].hide(); }

			GEvent.addListener(marker, "click", function() {
                marker.openInfoWindowHtml(
    				'<img class="avatar" src="' + avatar+ '" />' +
    				'<p class="user"><strong><a href="http://lareta.net/' + user + '">' + user + '</a></strong></p>' +
    				'<p class="message"><a href="' + message_web + '">'+ message + '</a></p>' +
    				'<p class="time">' + time + '</p>', { noCloseOnClick : true }
			    );
            });

            marker.openInfoWindowHtml(
    	    	'<img class="avatar" src="' + avatar+ '" />' +
    	    	'<p class="user"><strong><a href="http://lareta.net/' + user + '">' + user + '</a></strong></p>' +
        		'<p class="message"><a href="' + message_web + '">'+ message + '</a></p>' +
    			'<p class="time">' + time + '</p>', { noCloseOnClick : true }
			);
		});
	}
}

/*
var myicon = null;
var mysize = null;
var myshadowsize = null;
var geocoder = null;
var map = null;
*/
var arrayMarkers = new Array(5);
var indexArray = 0;
function initialize() {
	if (GBrowserIsCompatible()) {
		//Create the map with type_map selector, and zoom controls. Default position = Galicia
		map = new GMap2(document.getElementById("map"));
		map.setMapType(G_PHYSICAL_MAP);
		map.setCenter(new GLatLng(42.617791,-8.129883), 8);
		map.addControl(new GLargeMapControl());

		//By default show the new PHYSICAL type map
		map.addMapType(G_PHYSICAL_MAP);
		map.removeMapType(G_HYBRID_MAP); 
		//map.addControl(new GMapTypeControl());
		map.addControl(new GOverviewMapControl());

		//Get the postion by a string
		geocoder = new GClientGeocoder();

		//Define my personal icon, with the lareta logo
		myicon = new GIcon(G_DEFAULT_ICON);
		myicon.image = "images/bullet-lareta.png";
		mysize = new GSize(20,20);
		myicon.iconSize = mysize;
		myicon.shadow = "images/shadow.png";
		myshadowsize = new GSize(10,11);
		myicon.shadowSize = myshadowsize;
		myicon.iconAnchor = new GPoint(11, 16);


	}
}
