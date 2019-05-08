function initialise(){
	myMap = new L.Map('mapid');

	// create the tile layer with correct attribution
	//street layer
	var osmUrl='http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
	var osmAttrib='Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
	var osm = new L.TileLayer(osmUrl, {minZoom: 1, maxZoom: 12, attribution: osmAttrib});		

	//dark layer
	var darkUrl = 'https://api.mapbox.com/styles/v1/brejza/cjh27yb3n0vut2slgb61us4ni/tiles/256/{z}/{x}/{y}@2x?access_token=pk.eyJ1IjoiYnJlanphIiwiYSI6ImNqZWxkOG5sNzNmaTgzM283c2d5ZDk2Y2oifQ.S9f73b925qwu_NprkuugyA';
	var darkAttrib ='Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
	var dark = new L.TileLayer(darkUrl, {minZoom: 1, maxZoom: 12, attribution: darkAttrib});	

	//light layer
	var lightUrl = 'https://api.mapbox.com/styles/v1/brejza/cjh7p3gu70cqn2spipz3pi5gf/tiles/256/{z}/{x}/{y}@2x?access_token=pk.eyJ1IjoiYnJlanphIiwiYSI6ImNqZWxkOG5sNzNmaTgzM283c2d5ZDk2Y2oifQ.S9f73b925qwu_NprkuugyA';
	var lightAttrib = 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
	var light  = new L.TileLayer(lightUrl, {minZoom: 1, maxZoom: 12, attribution: lightAttrib});	


	// set the starting location
	myMap.setView(new L.LatLng(51.5, -0.127758),10);
	myMap.addLayer(osm); 

	//array of different tile layers
    	var baseMaps = {
        'Minimalist': dark,
        'Default': osm,
        'Light': light
   	 };

    //add layers
    L.control.layers(baseMaps).addTo(myMap);

	
    //define info box
    var info = L.control();

    //draw info box
    info.onAdd = function(myMmap) {
        this._div = L.DomUtil.create('div', 'info'); 
        this.update();
        return this._div;
    };

    //update counter box
    info.update = function() {
        if (mapData.length > 0) {
            this._div.innerHTML = '<h4>Number of Breweries</h4>' + '<b>' + mapData.length + '</b>';
        } else {
            this._div.innerHTML = '<h4>Number of Breweries</h4>' + '<b>No Breweries Found</b>';
        }
    };
	//add counter box
       info.addTo(myMap);

	//define polygon 
	var polygonStyle = {
		"color": "#0000ff",
		"weight": 3,
		"opacity": 0.3
	};

	// geojson styling support functions
	// adapted from: http://leafletjs.com/examples/choropleth/
	function getColor(d) {
    return d > 64 ? '#f7fcfd' :
           d > 32  ?'#e5f5f9' :
           d > 16  ? '#ccece6' :
           d > 8  ? '#99d8c9' :
           d > 4   ? '#66c2a4' :
           d > 2   ? '#41ae76' :
           d > 1   ? '#238b45' :
                      '#005824';
	}

	function stylePoly(feature) {
		return {
			fillColor: getColor(feature.properties.name.length),
			weight: 2,
			opacity: 1,
			color: 'white',
			dashArray: '3',
			fillOpacity: 0.7
		};
	}

	
	//insert geojson layer
	L.geoJSON(londonGeojson, {style: polygonStyle}).addTo(myMap);
	

	//define easy button
     var stateChangingButton = L.easyButton({
        states: [
            {
                stateName: 'zoom-london',
                icon: 'fa-bookmark',
                title: 'Zoom london',
                onClick: function(btn, map) {
                    myMap.flyTo([51.521045, -0.085146], 11);
                    btn.state('zoom-original'); 
                }
            },
            {
                stateName: 'zoom-original',
                icon: 'fa-undo',
                title: 'zoom to original position',
                onClick: function(btn, map) {
                    map.flyTo([51.521045, -0.085146], 9);
                    btn.state('zoom-london');
                }
            }
        ]
    });

    //add button to map
    stateChangingButton.addTo(myMap);

    // draw circle
    //var circle = L.circle([51.526053, -0.065796], {
    //color: 'red',
    //fillColor: '#f03',
    //fillOpacity: 0.5,
    //radius: 5400
	//	}).addTo(myMap);
	

	//distance line furthest breweries
	var longDist  =[
	[51.649173, -0.196984],
	[51.341734, 0.001725]
	]

	//draw and add map to line(now hidden)
	//var polyline = L.polyline(longDist, {color: 'red'}).addTo(myMap);
	
	//myMap.fitBounds(polyline.getBounds());

	//define count for chart
	if (mapData){
		var aleCount = 0;
		var lagerCount = 0;
		var maltCount = 0;
		var stoutPorCount =0;
		var specialCount =0;
		var defaultCount =0;
	
		//add to counter if beer category is true
		for(var item in mapData){
			var beerCat = mapData[item].beer_category;

			switch(beerCat){
			case 'Ale':
				aleCount++;
				break;
			case 'Lager':
				lagerCount++;
				break;
			case 'Malt':
				maltCount++;
				break;
			case 'StoutPorter':
				 stoutPorCount++;
				 break;
			case 'Special':
				specialCount++;
				break;
			default:
				defaultCount++;

		}

	//define beer icons
	var beerIcon = L.icon({
		iconUrl: mapData[item].beer_category + '.png'
	});
	
	//define popup
	var popupContent = "<h2>" + mapData[item].name + "</h2>";
	popupContent += "<br><strong>Recommended Type: </strong> " + mapData[item]. beer_category+ "</h4>";
	popupContent += "<br><strong>Recommended Style: </strong> " + mapData[item].type_of_beer+ "</h4>";
	popupContent += "<br><strong> Brewpub: </strong> " + mapData[item].brewpub ;
	popupContent += "<br><strong> Address: </strong> " + mapData[item].address ;
	popupContent += "<br><strong> Closest Station: </strong> " + mapData[item].closest_station ;
	popupContent += "<br><strong>URL</strong> <a href='" + mapData[item].url + "'>" + mapData[item].name+ "</a>";
	
	//define marker
	var marker = L.marker([mapData[item].latitude,mapData[item].longitude],
       {icon: beerIcon, title: mapData[item].name}).addTo(myMap);
	
	//add pop up
	marker.bindPopup(popupContent).addTo(myMap);	
}
	//draw chart
        var ctx = document.getElementById('myChart').getContext('2d');
        ctx.canvas.width = 400;
        ctx.canvas.height = 200;
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [
                    'Ale',
                    'Lager',
                    'Malt',
                    'Stout/Porter',
                    'Special'
                ],
                datasets: [
                    {
                        backgroundColor: ['#992207', '#d69304', '#352606', '#9b59b6', '#f1c40f'],
                        data: [
                            aleCount,
                            lagerCount,
                            maltCount,
                            stoutPorCount,
                            specialCount
                        ]
                    }
                ]
            },
            options: {
                responsive: false,
                legend: {
                    display: true,
                    position: 'right',
                    labels: {
                        boxWidth: 30,
			   fontSize: 18,
			   fontColor: '#fff'
			                     }
                }
            }
        });


}
}





