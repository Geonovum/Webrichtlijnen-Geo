<!DOCTYPE html>
<html lang="nl">
<head>
<meta charset="utf-8">
<meta name="robots" content="index, follow">
<title>Voorbeeld Webrichtlijnen en Geo: ligt mijn adres in een Natura2000 gebied?</title>
<style>
* {
    font-family: sans-serif;
}

body {
    padding: 10px 60px 10px 60px;
}

.resultaat {
    background-color: #ddffcc;
}

.antwoord {
    font-weight: normal;
    font-size: 1.6em;
}

h1, h2, h3 {
    font-weight: normal;
    color: #101010;
    border-bottom: 1px solid #A0A0A0;
}
</style>
</head>
<body>
<h1>Voorbeeld: vraag beantwoorden met geo-informatie</h1>
<p>Als een gebied als <a href='http://www.natura2000.nl/'>Natura2000 gebied</a> is aangemerkt, kan dat beperkingen met zich mee brengen voor dat gebied. Bijvoorbeeld in geval van een gewenste uitbreiding van een agrarisch bedrijf. Het kan daarom van belang zijn te weten of een bedrijf in de buurt van een Natura 2000 gebied ligt.</p>

<h2>Controleer hier uw adres</h2>
<p>Zoek hier of een adres in binnen 3 kilometer afstand van een Natura 2000 gebied ligt.</p>
<!-- 

Stap 1: invoer van het adres.

-->
<form action='index.php' method='get'>
    <label for='adres'>Zoek op adres of postcode / huisnummer:</label>
    <input type='text' name='adres' id='adres' size="40"> <input type='submit' value='zoeken'>
</form>
<p>Voorbeelden van invoer: <a href='index.php?adres=3601RE'>3601RE</a></li> | <a href='index.php?adres=Schalm+6+Renswoude'>Schalm 6, Renswoude</a> | <a href='index.php?adres=Stationsplein+Amersfoort'>Stationsplein Amersfoort</a> | <a href='index.php?adres=Barneveldseweg+14+Otterlo'>Barneveldseweg 14 Otterlo</a></p>

<?php
/*

Stap 2: zoek de coordinaten op van het adres via de geocoder

*/

// Voorbeeld OpenLS Geocoder zoekrequest (HTTP GET):
// http://geodata.nationaalgeoregister.nl/geocoder/Geocoder?zoekterm=3601RE
$adres=$_GET["adres"];
$coordinaten;

if ($adres){
    $geocoderRequest = 'http://geodata.nationaalgeoregister.nl/geocoder/Geocoder?zoekterm='.$adres;
    $geocoderResponse = simplexml_load_file($geocoderRequest);

    // Geef de XML namespaces op die in een openLS response gebruikt worden
    $geocoderResponse->registerXPathNamespace ("xls", "http://www.opengis.net/xls");
    $geocoderResponse->registerXPathNamespace ("gml", "http://www.opengis.net/gml");

    // Selecteer de coordinaten van het eerste adres via het volgende Xpath
    $xpathPos ="//xls:GeocodeResponse/xls:GeocodeResponseList[1]/xls:GeocodedAddress[1]/gml:Point/gml:pos";
    $coordinaten = $geocoderResponse->xpath($xpathPos)[0];

    // Sla de gevonden straat en plaats op voor de output (en daarna door naar Stap 3)
    echo "<div class='resultaat'><h2>Resultaat</h2>";
    if ($coordinaten) {
        $xpathStraat ="//xls:GeocodeResponse/xls:GeocodeResponseList[1]/xls:GeocodedAddress[1]/xls:Address/xls:StreetAddress/xls:Street";        
        $straat = $geocoderResponse->xpath($xpathStraat)[0];

        $xpathPlaats ="//xls:GeocodeResponse/xls:GeocodeResponseList[1]/xls:GeocodedAddress[1]/xls:Address/xls:Place[@type='MunicipalitySubdivision']";        
        $plaats = $geocoderResponse->xpath($xpathPlaats)[0];
    } else {
        echo "Geen resultaten gevonden voor het adres: ".$adres.". Probeer het adres anders in te voeren, bijvoorbeeld met een volledige postcode van 4 cijfers en 2 letters voor het huisnummer.</div>";        
    }
} 

/*

Stap 3: Bevraag met de coordinaten de Natura 2000 WFS (Web Feature Service) om gebieden te vinden waar het punt in valt of binnen een straal van 3 kilometer van zo'n gebied ligt.

*/
if ($adres && $coordinaten) {
    // Construeer het WFS request. Dit is een XML request dat via HTTP POST verstuurd wordt naar de WFS
    $wfsRequest = "<GetFeature
       version='2.0.0'
       service='WFS'
       handle='Example Query'
       xmlns='http://www.opengis.net/wfs/2.0'
       xmlns:fes='http://www.opengis.net/fes/2.0'
       xmlns:gml='http://www.opengis.net/gml/3.2'
       xmlns:natura2000='http://natura2000.geonovum.nl'
       xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance'
       xsi:schemaLocation='http://www.opengis.net/wfs/2.0
                           http://schemas.opengis.net/wfs/2.0/wfs.xsd
                           http://www.opengis.net/gml/3.2
                           http://schemas.opengis.net/gml/3.2.1/gml.xsd'>
       <Query typeNames='natura2000:natura2000' handle='Q01'>
          <PropertyName>natura2000:naam_n2k</PropertyName>
          <PropertyName>natura2000:status</PropertyName>
          <fes:Filter>
             <fes:DWithin>
                <fes:ValueReference>natura2000:geom</fes:ValueReference>
                <fes:Literal>
                   <gml:Point srsName='urn:fes:def:crs:EPSG::28992'>
                      <gml:pos>".$coordinaten."</gml:pos>
                   </gml:Point>
                </fes:Literal>
                <fes:Distance uom='m'>3000</fes:Distance>
             </fes:DWithin>
          </fes:Filter>
       </Query>
    </GetFeature>";

    // verstuur dit request en ga daarna de XML van het response verwerken. Als er features terugkomen, ligt het in een gebied en komt er minstens 1 feature terug.
    $wfsUrl = "http://geodata.nationaalgeoregister.nl/natura2000/wfs";

    // Gebruik CURL in dit geval
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $wfsUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, "$wfsRequest");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // om de data daadwerkelijk te krijgen moet dit op true
    $wfsresponse = curl_exec($ch);
    curl_close($ch);

    // Parse het Response: als er een resultaat is, ligt het punt in of vlakbij het gebied
    $natura2000gebieden = simplexml_load_string($wfsresponse);
    $natura2000gebieden->registerXPathNamespace ("natura2000", "http://natura2000.geonovum.nl");
    $natura2000gebieden->registerXPathNamespace ("gml", "http://www.opengis.net/gml");
    $natura2000gebieden->registerXPathNamespace ("wfs", "hhttp://www.opengis.net/wfs/2.0");    
    
    // Pak alleen het eerste resultaat, voor de eenvoud van het voorbeeld
    $xpathGebied = "//wfs:FeatureCollection/wfs:member[1]";
    $gebieden = $natura2000gebieden->xpath($xpathGebied);

    // Stel de rest van de output op
    if (strlen($straat) > 0) {
        $straat = $straat. " in ";
    }
    if ($gebieden) {
        echo "<span class='antwoord'>Ja</span>, " . $straat. $plaats." ligt in of binnen 3 kilometer van het Natura 2000 gebied: ";
        // Voor de volledigheid: geef de naam en status van het gebied weer
        $xpathNaam ="//wfs:FeatureCollection/wfs:member[1]/natura2000:natura2000/natura2000:naam_n2k";
        $gebiedsNamen = $natura2000gebieden->xpath($xpathNaam);
        echo $gebiedsNamen[0].".";
        $xpathStatus ="//wfs:FeatureCollection/wfs:member[1]/natura2000:natura2000/natura2000:status";
        $status = $natura2000gebieden->xpath($xpathStatus);
        echo "<br/>Dit gebied heeft de status: ".$status[0] . ".";
    } else {
        echo "<br/><span class='antwoord'>Nee</span>, ". $straat . $plaats." ligt niet in de buurt van een Natura2000 gebied.";
    }
    echo "</div>";
}
?>
<h2>Achtergrondinformatie</h2>
<p>Deze webpagina laat zien hoe je de vraag "Ligt mijn huis in een Natura 2000 gebied?" tekstueel kan beantwoorden: met ja/nee.Er is ook <a href='innatura2000gebiedmetkaart.php'>een versie met kaart</a> beschikbaar.
De <a href='innatura2000gebieduitleg.php'>achtergrondinformatie</a> bevat nadere uitleg en technische details.</p>
</body>
</html>