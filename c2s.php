<?php
function c2s($text)

// clock-to-speech: Erstellt basierend auf der aktuellen Uhrzeit eine TTS Nachricht, �bermittelt sie an VoiceRRS und 
// speichert das zur�ckkommende file lokal ab
// @Parameter = $text von sonos2.php
{
	global $debug;
	
	$Stunden = intval(strftime("%H"));
	$Minuten = intval(strftime("%M"));
	switch ($Stunden) 
	{
		# Uhrzeitansage f�r die Zeit zwischen 06:00 und 11:00h
		case $Stunden >=6 && $Stunden <11:
			$Vorspann="Guten Morgen, ich bin es noch einmal.";
			break;
		# Uhrzeitansage f�r die Zeit zwischen 11:00 und 17:00h
		case $Stunden >=11 && $Stunden <17:
			$Vorspann="Guten Tag.";
			break;
		# Uhrzeitansage f�r die Zeit zwischen 17:00 und 22:00h
		case $Stunden >=17 && $Stunden <22:
			$Vorspann="Guten Abend.";
			break;
		# Uhrzeitansage f�r die Zeit nach 22:00h
		case $Stunden >=22 :
			$Vorspann="Gute Nacht.";
			break;
		default:
			$Vorspann="Gute Nacht.";
			break;
	}
	
	switch ($Stunden) 
	{
		# erg�nzender Satz f�r die Zeit zwischen 6:00 und 8:00h an Schultagen
		case $Stunden >=6 && $Stunden <8:
			$Nachsatz=" Es ist Zeit in die Schule zu gehen. Bitte nehmt eure Sachen und zieht euch f�r die Schule an, Z�hneputzen bitte nicht verge�en. Viel Spa� und viel Gl�ck heute, eure Waltraut.";
		break;
		# erg�nzender Satz f�r die Zeit nach 8:00h
		case $Stunden >=8:
			$Nachsatz="";
		break;
		default:
			$Nachsatz="";
		break;
	}
	
	$text = $Vorspann." Es ist jetzt ".$Stunden." Uhr und ".$Minuten. " Minuten." .$Nachsatz;
	$text = $text;
	if ($debug == 1) 
		{
			echo ($text); 
			echo '<br />';
		}
	return ($text);
}	
?>
