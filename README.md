Webrichtlijnen en geo
=====================

Deze repository bevat code-voorbeelden voor Webrichtlijnen en geo-informatie. Onder andere het Toepassingskader verwijst naar deze voorbeelden. De voorbeelden zijn nadrukkelijk niet bedoeld voor productiedoeleinden, maar dienen ter illustratie van een mogelijke aanpak.

Deze voorbeelden zijn gemaakt door het projectteam Webrichtlijnen en Geo, van Geonovum en ICTU.

Licentie
--------
Tenzij anders aangegeven in de gebruikte bestanden, zoals bij enkele gebruikte JavaScript bibliotheken van derden, is de licentie [BSD](LICENSE). Raadpleeg voor de licentie dus ook de geïmporteerde broncode bestanden.

Carnavalsoptocht
----------------
Het voorbeeld 'carnavalsoptocht' toont hoe de route van een optocht met een HTML lijst van de straatnamen van de optocht en een statische kaart (via een API) ter illustratie te publiceren is.

Dit voorbeeld is werkend te zien via Raw Git:  
[https://rawgit.com/Geonovum/Webrichtlijnen-Geo/master/carnavalsoptocht/index.html](https://rawgit.com/Geonovum/Webrichtlijnen-Geo/master/carnavalsoptocht/index.html)

Nederland areamap
-----------------
Het voorbeeld 'nederland-areamap' toont hoe met HTML en een standaard HTML areamap op een afbeelding de provinciegrenzen (van enkele provincies, zoals Noord-Holland, Utrecht, Zuid-Holland en Zeeland in dit geval) te gebruiken zijn. Bijvoorbeeld voor links naar meer informatie van een provincie of een titel.

Dit voorbeeld is werkend te zien via Raw Git:  
[https://rawgit.com/Geonovum/Webrichtlijnen-Geo/master/nederland-areamap/index.html](https://rawgit.com/Geonovum/Webrichtlijnen-Geo/master/nederland-areamap/index.html)

Openbare toiletten
------------------
Het voorbeeld 'openbaretoiletten' toont hoe met JavaScript en een JavaScript bilbiotheek een lijst en een kaart gemaakt kunnen worden van een bestand met locaties van openbare toiletten in Nijmegen.

Dit voorbeeld is werkend te zien via Raw Git:  
[https://rawgit.com/Geonovum/Webrichtlijnen-Geo/master/openbaretoiletten/toiletten.html](https://rawgit.com/Geonovum/Webrichtlijnen-Geo/master/openbaretoiletten/toiletten.html)

De pagina index.html dient lokaal of op een andere server gedraaid te worden. Dit voorbeeld gebruikt namelijk een externe webservice, die niet via RawGit werkend te zien is.

Overzicht ministeries CSS
-------------------------
Het voorbeeld 'overzichtministeries-CSS' toont hoe een HTML lijst op een statische kaart (afbeelding) getoond kan worden. Het voorbeeld gebruikt alleen HTML en CSS.

Dit voorbeeld is werkend te zien via Raw Git:  
[https://rawgit.com/Geonovum/Webrichtlijnen-Geo/master/overzichtministeries-CSS/index.html](https://rawgit.com/Geonovum/Webrichtlijnen-Geo/master/overzichtministeries-CSS/index.html)

Overzicht ministeries (met HTMAPL)
----------------------------------
Het voorbeeld 'overzichtministeries-HTMAPL' toont hoe een HTML lijst op een interactieve kaart afgebeeld kan worden. Het voorbeeld gebruikt data-attributen in HTML en de JavaScript bibliotheek HTMAPL.

Dit voorbeeld is werkend te zien via Raw Git:  
[https://rawgit.com/Geonovum/Webrichtlijnen-Geo/master/overzichtministeries-HTMAPL/index.html](https://rawgit.com/Geonovum/Webrichtlijnen-Geo/master/overzichtministeries-HTMAPL/index.html)


Natura 2000: gebiedsinformatie bevragen
---------------------------------------
Het voorbeeld 'natura2000' laat zien hoe je de vraag "Ligt mijn huis in een Natura 2000 gebied?" tekstueel kan beantwoorden (ja/nee), gebruik makend van geo-informatie. Dit is een voorbeeld van een toegankelijke aanpak van gebruik van gebieds-informatie (vlakken). 

Er zijn gegevens van Natura2000 gebieden beschikbaar via een zogenaamde Web Feature Service van [Natura 2000](http://geodata.nationaalgeoregister.nl/natura2000/wfs?request=GetCapabilities&service=WFS). Deze gegevens bevatten onder andere de geografische kenmerken van een gebied. Deze geo-informatie kan je tonen op een kaart. Maar je kan deze informatie ook gebruiken om te bepalen of een bepaald adres in een gebied ligt of niet. Dit voorbeeld geeft eenvoudigweg een Ja/Nee antwoord op de vraag of een adres in een Natura 2000 gebied ligt. Het zoekt eerst naar de locatie van het opgegeven adres en vervolgens bepaalt het of deze locatie in de buurt van een Natura 2000 gebied valt. Het antwoord is simpelweg 'ja' of 'nee'.

Dit voorbeeld is geschreven in PHP. Een online demonstratie hiervan is op dit moment niet voorhanden. Op de meeste webservers die PHP ondersteunen zou dit voorbeeld direct moeten kunnen draaien.

