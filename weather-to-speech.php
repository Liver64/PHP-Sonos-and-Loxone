<?php
function w2s($text) 
// weather-to-speech: Erstellt basierend auf Wunderground eine Wettervorhersage zur Generierung einer
// TTS Nachricht, �bermittelt sie an VoiceRRS und speichert das zur�ckkommende file lokal ab
// @Parameter = $text von sonos2.php
 	{
		global $config, $debug;
		
		$Stunden = intval(strftime("%H"));
		$Minuten = intval(strftime("%M"));
		$key = $config['wgkey'];
		$city = $config['wgcity']; 
		$regenschwelle = intval($config['wgregenschwelle']);
		$windschwelle = intval($config['wgwindschwelle']);
		$sprache = "DL"; // DL = deutsch
		$land = "Germany"; // Land
	
		# aktuelle Wetterdaten aufbereiten
		$json_string = file_get_contents("http://api.wunderground.com/api/".$key."/geolookup/conditions/lang:".$sprache."/q/".$land."/".$city.".json");
		$current_parsed_json = json_decode($json_string);
		// Vorhersage: Tag 0 = heute, 1 = morgen, 2 = �bermorgen *
		$json_fc_string = file_get_contents("http://api.wunderground.com/api/".$key."/forecast/lang:".$sprache."/q/".$land."/".$city.".json");
		$parsed_fc_json = json_decode($json_fc_string);
		// Vorhersage: st�ndlich ist 0 = jetzt, 1 = + 1 Stunde, 2 = + 2 Stunden usw.
		$json_hc_string = file_get_contents("http://api.wunderground.com/api/".$key."/hourly10day/lang:".$sprache."/q/".$land."/".$city.".json");
		# Kopiervorlage f�r wunderground.com
		# http://api.wunderground.com/api/9ad952ba578239ff/hourly10day/lang:DL/q/Germany/Frankfurt.json
		$parsed_hc_json = json_decode($json_hc_string);
		## hinzugef�gt zur Fehleranalyse (speichern einer aktuellen Wetterdatei im JSON Format)
		if($debug == 1) {
			$path = $config['messageStorePath']; // Pfad aus config.php
			$file = $path . "weather_raw_data.txt"; // Dateiname
			file_put_contents($file, $json_fc_string); // je nach Typ �ndern: json_fc_string = Vorschau; $json_hc_string = 10 Tage Vorschau; $json_string = aktuelles Wetter
			## Ende Fehleranalyse
		}
		
		## Beginn abholen und aufbereiten der Wetterdaten
		##------------------------------------------------------------------------------------------------------------
		$prognose = $parsed_fc_json->{'forecast'}->{'simpleforecast'}->{'forecastday'};
		$temp_c = $current_parsed_json->{'current_observation'}->{'temp_c'}; 
		$high0 = $prognose[0]->high->celsius; // H�chsttemperatur heute
		$high1 = $prognose[1]->high->celsius; // H�chsttemperatur morgen
		$min_temp = $current_parsed_json->{'current_observation'}->{'dewpoint_c'}; 
		$low0 = $prognose[0]->low->celsius; // Tiefsttemperatur heute
		$low1 = $prognose[1]->low->celsius; // Tiefsttemperatur morgen
		$wind = $parsed_fc_json->{'forecast'}->{'simpleforecast'}->{'forecastday'};
		$wetter_hc = $wind[0]->conditions; // Wetterkonditionen
		$windspeed = $wind[0]->maxwind->kph; // maximale Windgeschwindigkeit n�chste Stunde
		$windtxt = $windspeed;
		$wind_dir = $wind[0]->maxwind->dir; // Windrichtung f�r die n�chste Stunde
		$wetter = $current_parsed_json->{'current_observation'}->{'weather'};
		$conditions0 = $prognose[0]->conditions; // allgemeine Wetterdaten heute
		$conditions1 = $prognose[1]->conditions; // allgemeine Wetterdaten morgen
		$forecast0 = $parsed_fc_json -> {'forecast'}-> {'txt_forecast'}-> forecastday[0] -> {'fcttext_metric'}; // Wetterlage heute
		$forecast1 = $parsed_fc_json -> {'forecast'}-> {'txt_forecast'}-> forecastday[1] -> {'fcttext_metric'}; // Wetterlage morgen
		$regenwahrscheinlichkeit0 = intval($prognose[0]->pop); // Regenwahrscheinlichkeit heute
		$regenwahrscheinlichkeit1 = intval($prognose[1]->pop);// Regenwahrscheinlichkeit morgen
		# Pr�fen ob Wetterk�rzel vorhanden, wenn ja durch W�rter ersetzen
		if(ctype_upper($wind_dir)) 
		{
			# Ersetzen der Windrichtungsk�rzel f�r Windrichtung
			$search = array('W','S','N','O');
			$replace = array('west','sued','nord','ost');
			$wind_dir = str_replace($search,$replace,$wind_dir);
		}
		# Erstellen der Windtexte basierend auf der Windgeschwindigkeit
		## Quelle der Daten: http://www.brennstoffzellen-heiztechnik.de/windenergie-daten-infos/windtabelle-windrichtungen.html
		switch ($windtxt) 
		{
			case $windspeed >=1 && $windspeed <=5:
				$WindText= "ein leiser Zug";
				break;
			case $windspeed >5 && $windspeed <=11:
				$WindText= "eine leichte Briese";
				break;
			case $windspeed >11 && $windspeed <=19:
				$WindText= "eine schwache Briese";
				break;
			case $windspeed >19 && $windspeed <=28:
				$WindText= "ein m��iger Wind";
				break;
			case $windspeed >28 && $windspeed <=38:
				$WindText= "ein frischer Wind";
				break;
			case $windspeed >38 && $windspeed <=49:
				$WindText= "ein starker Wind";
				break;
			case $windspeed >49 && $windspeed <=61:
				$WindText= "ein steifer Wind";
				break;
			case $windspeed >61 && $windspeed <=74:
				$WindText= "ein st�rmischer Wind";
				break;
			case $windspeed >74 && $windspeed <=88:
				$WindText= "ein Sturm";
				break;
			case $windspeed >88 && $windspeed <=102:
				$WindText= "ein schwerer Sturm";
				break;
			case $windspeed >102:
				$WindText= "ein orkanartiger Sturm";
				break;
			default:
				$WindText= "";
				break;
			break;
		}
		# Windinformationen werden nur ausgeben wenn Windgeschwindigkeit gr��er dem Wert aus der config.php ist
			switch ($windspeed) 
			{
				case $windspeed <$windschwelle:
					$WindAnsage="";
					break;
				case $windspeed >=$windschwelle:
					$WindAnsage=". Es weht ".$WindText. " aus Richtung ". utf8_decode($wind_dir). " mit Geschwindigkeiten bis zu ".$windspeed." km/h";
					break;
				default:
					$WindAnsage="";
					break;
			
			break;
			}
		
		# wird nur bei Regen ausgeben wenn Wert gr��er dem Schwellwert aus der config.php ist
		switch ($regenwahrscheinlichkeit0) {
			case $regenwahrscheinlichkeit0 =0 || $regenwahrscheinlichkeit0 <$regenschwelle:
				$RegenAnsage="";
				break;
			case $regenwahrscheinlichkeit0 >=$regenschwelle:
				$RegenAnsage="Die Regenwahrscheinlichkeit betr�gt " .$regenwahrscheinlichkeit0." Prozent.";
				break;
			default:
				$RegenAnsage="";
				break;
		}
		
		# Aufbereitung der TTS Ansage
		# 
		# Aufpassen das bei Text�nderungen die Werte nicht �berschrieben werden
		###############################################################################################
		switch ($Stunden) {
			# Wettervorhersage f�r die Zeit zwischen 06:00 und 11:00h
			case $Stunden >=6 && $Stunden <8:
				$text="Guten morgen liebe Familie. Ich m�chte euch eine kurze Wettervorhersage f�r den heutigen Taach geben. Vormittags wird das Wetter ". utf8_decode($wetter). ", die H�chsttemperatur betr�gt voraussichtlich ". round($high0)." Grad, die aktuelle Temperatur betr�gt ". round($temp_c)." Grad. ". $RegenAnsage.". ".$WindAnsage.". Ich w�nsche euch einen wundervollen Taach.";
				break;
			# Wettervorhersage f�r die Zeit zwischen 11:00 und 17:00h
			case $Stunden >=8 && $Stunden <17:
				$text="Hallo zusammen. Heute Mittag, beziehungsweise heute Nachmittag, wird das Wetter ". utf8_decode($wetter_hc). ". Die momentane Au�entemperatur betr�gt ". round($temp_c)." Grad. " .$RegenAnsage.". ".$WindAnsage.". Ich w�nsche euch noch einen sch�nen Nachmitag.";
				break;
			# Wettervorhersage f�r die Zeit zwischen 17:00 und 22:00h
			case $Stunden >=17 && $Stunden <22:
				$text="Guten Abend. Hier noch mal eine kurze Aktualisierung. In den Abendstunden wird es ". utf8_decode($wetter). ". Die aktuelle Au�entemperatur ist ". round($temp_c)." Grad, die zu erwartende Tiefsttemperatur heute abend betr�gt ". round($low0). " Grad. ". $RegenAnsage.". ".$WindAnsage.". Einen sch�nen Abend noch.";
				break;
			# Wettervorhersage f�r den morgigen Tag nach 22:00h
			case $Stunden >=22:
				$text="Hallo Ratz und Fatz. Das Arheilger Wetter wird morgen voraussichtlich ".utf8_decode($conditions1). ", die H�chsttemperatur betr�gt ". round($high1) ." Grad, die Tiefsttemperatur betr�gt " . round($low1). " Grad und die Regenwahrscheinlichkeit liegt bei ".$regenwahrscheinlichkeit1." Prozent. Gute Nacht ihr zwei und schlaft gut.";
				break;
			default:
				$text="";
				break;
		}
		$text = utf8_encode($text);
		if ($debug == 1) {
			echo '<br />Gesamter Text zur Uebergabe an T2S:';
			echo '<br />';
			print_r ($text); 
			echo '<br />';
			echo '<br />Hoechsttemperatur heute:';
			print_r ($high0). ' Grad';
			echo '<br />Tiefsttemperatur heute:';
			print_r ($low0). ' Grad';
			echo '<br />Hoechsttemperatur morgen:';
			print_r ($high1). ' Grad';
			echo '<br />Tiefsttemperatur morgen:';
			print_r ($low1). ' Grad';
			echo '<br />Wetterkonditionen fuer die naechste Stunde:';
			print_r ($wetter_hc);
			echo '<br />aktuelle Wetterkonditionen:';
			print_r ($wetter);
			echo '<br />max. Windgeschwindigkeit fuer die naechste Stunde:';
			print_r ($windspeed). ' km/h' ;
			echo '<br />allgemeine Wetterdaten heute:';
			print_r ($conditions0);
			echo '<br />allgemeine Wetterdaten morgen:';
			print_r ($conditions1);
			echo '<br />Wetterlage heute:';
			print_r ($forecast0);
			echo '<br />Wetterlage morgen:';
			print_r ($forecast1);
			echo '<br />Regenwahrscheinlichkeit heute:';
			print_r ($regenwahrscheinlichkeit0). ' %';
			echo '<br />Regenwahrscheinlichkeit morgen:';
			print_r ($regenwahrscheinlichkeit1). ' %';
			echo '<br />';
			echo '<br />';
		}
		return $text;
	}
?>
