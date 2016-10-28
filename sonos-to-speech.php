<?php

 /** 
* aktueller Sonos Titel und Interpret per TTS ansagen
* @param $text
*/ 

function s2s($text)
{ 		
	global $debug, $sonos, $sonoszone, $master;
	
	$thissong = "Der laufende Song lautet "; 
 	$by = " von "; 
	
	# pr�ft ob gerade etwas gespielt wird, falls nicht dann keine Ansage
	$gettransportinfo = $sonos->GetTransportInfo();
	if($gettransportinfo <> 1) {
		exit;
	} else {
	# Pr�ft ob Playliste oder Radio l�uft
		$master = $_GET['zone'];
		$sonos = new PHPSonos($sonoszone[$master][0]);
		$temp = $sonos->GetPositionInfo();
		if(!empty($temp["duration"])) {
			# Generiert Titelinfo wenn MP3 l�uft
			$artist = substr($temp["artist"], 0, 30);
			$titel = substr($temp["title"], 0, 70);
		} elseif(empty($temp["duration"])) {
			# Generiert Titelinfo wenn Radio l�uft
			$value = substr($temp["streamContent"], 0, 70); // Titel und Interpret der Radio Playliste
			# Teilt den Stream beim Bindestrich in 2 Werte
			$titelartist = explode("-",$value, 2);
			$artist = $titelartist[0];
			$titel = substr($titelartist[1], 1, 50); // erstes Leerzeichen nach Trennung abschneiden;
			# Falls keine Titel / Artist Info verf�gbar abbrechen
			if($titelartist[1] == '') {
				$text = 'keine Info';
			}
		}
		# Erstellen des Strings zur �bergabe an TTS
		$text = $thissong . $titel . $by . $artist ; 
		$text = utf8_encode($text);
		
		if ($debug == 1) 
		{
			echo ($text); 
			echo '<br />';
		}
		return ($text);
	} 
}
?>