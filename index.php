<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>London Breweries</title>

	<!-- Define Stylesheets -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/2.5.0/introjs.min.css"/> 
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css">
	 
	 <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
   integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
   crossorigin=""/>
	<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
	<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.1/leaflet.css" />
	

   <?php include("./mapData.php"); ?>
</head>

<body onload="initialise()">

<div class="container page-header">
    <h1>LONDON BREWERIES INTERACTIVE MAP</h1>      
</div>


 <!--Map Container -->
<div id="mapid" class="container" data-step='1' data-intro='The aim of this page is to allow users to view the varios London Breweries currently open, 
which are categorised by the recommended beer on the map. The legend below explains the different icons. By click on any of the markers, you will be presented with various information
about the brewery. Should you prefer a different overlay for the map, click on the top right hand box under the brewery counter. The star button on the left hand corner re-adjusts your location
back to London Central.' data-position="right"></div>
<div id ="queryForm" class = "container col-sm-3" data-step='2' data-intro='This section allows users to query the map by type of beer, style of beer and brewpub. For more info check out 
ck out the below buttons.' data-position="left">
<div id="container" data-step='6' data-intro='These buttons provdide more infroamtion and resouces regarding the interactive map.'>
 <h2 ><u>About Breweries Map</u></h2>
   <button type="button" class="btn btn-warning btn-md" onclick="introJs().setOption('showProgress', true).start();">Take the tour</button>
  <a href="AboutMap.html" class="btn btn-warning btn-md" role="button">About Map and Breweries</a> 
  <a href="AboutBeer.html" class="btn btn-warning btn-md" role="button">About Beer</a>
  <button type="button" class="btn btn-warning btn-md" data-toggle="modal" data-target="#myModal">References</button>
</div>

  <!-- start modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id ="modalTitle">References</h4>
        </div>
        <div class="modal-body">
        <p> 
        		<a href="http://craftbeerlondon.com/">Craft Beer London(Main Source)</a><<br>
         <a href="https://www.boulevard.com/wp-content/uploads/2017/07/Berliner-Weisse-Diamond-Badge.png&imgrefurl=https:/www.boulevard.com/beerinfo/berliner-weisse/&h=1915&w=1914&tbnid=ehBFKryXPh68sM:&tbnh=186&tbnw=185&usg=__3LxB7lufVVW36IEBzFnwaciu3xE%3D&vet=10ahUKEwiCkbLMm4DbAhWBCewKHbD5CksQ_B0IyAEwDQ..i&docid=vHuBFK_3nDYPrM&itg=1&sa=X&ved=0ahUKEwiCkbLMm4DbAhWBCewKHbD5CksQ_B0IyAEwDQ">Images - Boulevard Brewing</a><br>
		<a href="http://www.thebeerstore.ca/beer-101/beer-types">Beer Types and Styles - Beer Store</a><br>
		<a href="https://www.craftybartending.com/types-of-beer/">Types of Beer - Crafty Bartending</a><br>
		<a href="https://en.wikipedia.org/wiki/Brewery">Brewery Info - Wikipedia</a><br>
		<a href="https://en.wikipedia.org/wiki/Microbrewery#Brewpub">Brewpub Info - Wikipedia </a><br>
		<a href="https://leafletjs.com/">Leaflet JS Library</a><br>
		<a href="https://introjs.com/">Intro JS Library </a><br>
		<a href="https://chartjs.org/">Chart JS Library</a><br>
		<a href="http://www.mapbox.com/beer-101/beer-types">Mapbox</a><br>

		<a href="https://github.com/CliffCloud/Leaflet.EasyButton">Leaflet  JS Easy Button </a><br>
		<a href="https://www.w3schools.com/bootstrap/default.asp">W3 Schools - Bootstrap </a><br>
		<a href="https://www.w3schools.com/howto/howto_css_modals.asp">W3 Schools - Modal </a><br>
		<a href="https://getbootstrap.com/">Bootstrap Library</a><<br></p>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>  
    </div>
  </div>  

  	<!--Initiate php-->
	<?php  
		echo "<form action='".$_SERVER['SCRIPT_NAME']."' method='get'>";
	?>
	<!--Start Data Selection-->
	<!--Query1-->
	<div class="container" data-step='3' data-intro='Here the user is able to query the map by type of beer, brewpub and style of beer. A type of beer can have many styles, therefore it makes sense to query by type and whether it is a brewpub or not. ' >
	<h3 style="text-align:left;">Select type of beer & brewpub</h3>
	<p>
	<input type=radio name=filter_beer  value="True" checked>Any<br>
	<input type=radio name=filter_beer value="Ale">Ale<br>
	<input type=radio name=filter_beer value="Lager">Lager<br>
	<input type=radio name=filter_beer value="Malt">Malt<br>
	<input type=radio name=filter_beer value="StoutPorter">StoutPorter<br>
	<input type=radio name=filter_beer value="Special">Special<br>
	
	<!--Query 2-->
	<p style ="
    position: absolute;
    right: 44%;
    top: 14%;"><br>
	<input type="radio" name=filter_brewpub value="True" checked>Any<br>
	<input type="radio" name=filter_brewpub value="Yes">Yes<br>
	<input type="radio" name=filter_brewpub value="No">No<br>
	
	<input type=submit value="Submit">

	</div>
	

	<div class = "container" data-step='4' data-intro='You can also query the map by selecting the style of beer. After you selected appropriate inputs, click submit to run the query. Should you make an error in selection, do not hesistate but click the reset button.'>
	
	<!--Query 3-->	
	<h3 style="text-align:left;">Style of Beer:</h3>
	<input type=radio name=filter_style  value="True" checked>All <br>
	<input type=radio name=filter_style value="Ale">Ale<br>
	<input type=radio name=filter_style value="Altbier">Altbier<br>
	<input type=radio name=filter_style value="Amber Ale">Amber Ale<br>
	<input type=radio name=filter_style value="Berliner_Weisse">Berliner Weisse<br>
	<input type=radio name=filter_style value="Bitter">Bitter<br>
	<input type=radio name=filter_style  value="Blonde">Blonde<br>
	<input type=radio name=filter_style value="IPA">IPA<br>
	<input type=radio name=filter_style value="Lager">Lager<br>
	<input type=radio name=filter_style value="Light Ale">Light Ale<br>

	</div>
	<div class = "conatiner" style = "position: absolute;
   	 top: 40%;
    right: 38%;">
	
	<input type=radio name=filter_style value="Other">Other<br>
	<input type=radio name=filter_style value="Oyster Stout">Oyster Stout<br>
	<input type=radio name=filter_style value="Pale Ale">Pale Ale<br>
	<input type=radio name=filter_style value="Pilsner">Pilsner<br>
	<input type=radio name=filter_style value="Porter">Porter<br>
	<input type=radio name=filter_style value="Red Ale">Red Ale<br>
	<input type=radio name=filter_style value="Ruby Ale">Ruby Ale<br>
	<input type=radio name=filter_style value="Saison">Saison<br>
	<input type=radio name=filter_style value="Stout">Stout<br>

<input type=submit value="Submit">
<input type="button" value="Reset" onClick="window.location.href='index.php'">
	</div>
	
<br>

<!--Start Chart-->
	<div class="container" data-step='5' data-intro='This chart is updated every time the user queries the system. The legend on the right better explains this chart.' data-position="top">
	<h2>Breakdown by Beer Type</h2>
	<canvas id="myChart"></canvas>
	 </div>   
</div>


<!--Script Calls-->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
   integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
   crossorigin=""></script>  
<script src="https://unpkg.com/leaflet-easybutton@2.0.0/src/easy-button.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/2.5.0/intro.js"></script>

 <script src="map.js"></script>
 <script src="london_boroughs_proper.geojson"></script>


</body>
</html>