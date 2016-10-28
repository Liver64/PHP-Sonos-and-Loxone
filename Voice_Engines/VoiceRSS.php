<?php
function t2s($messageid)
// text-to-speech: Erstellt basierend auf Input eine TTS Nachricht, �bermittelt sie an VoiceRRS und 
// speichert das zur�ckkommende file lokal ab
// @Parameter = $messageid von sonos2.php

{
	global $words, $config, $messageid, $fileolang, $fileo;

		$ttsengine = $config['t2s_engine'];
		$ttskey = $config['API-key'];
		$ttsaudiocodec = $config['audiocodec'];
		$words = utf8_encode($words);
		
		if($ttsengine = '1001') {
			$ttslanguage = $config['messageLang'].'-'.$config['messageLang'];
		}
						
		#####################################################################################################################
		# zu testen da auf Google Translate basierend (urlencode)
		# ersetzt Umlaute um die Sprachqualit�t zu verbessern
		# search = array('�','�','�','�','�','�','�','�','%20','%C3%84','%C4','%C3%9C','%FC','%C3%96','%F6','%DF','%C3%9F');
		# replace = array('ae','ue','oe','Ae','Ue','Oe','ss','Grad',' ','ae','ae','ue','ue','oe','oe','ss','ss');
		# words = str_replace($search,$replace,$words);
		#####################################################################################################################	

		# Sprache in Gro�buchsaben
		$upper = strtoupper($ttslanguage);
								  
		# Generieren des strings der an VoiceRSS geschickt wird
		$inlay = "key=$ttskey&src=$words&hl=$ttslanguage&f=$ttsaudiocodec";	
									
		# Speicherort der MP3 Datei
		$path = $config['messageStorePath'];
		$file = $path . $fileolang . ".mp3";
					
		# Pr�fung ob die MP3 Datei bereits vorhanden ist
		if (!file_exists($file)) 
		{
			# �bermitteln des strings an VoiceRSS.org
			ini_set('user_agent', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36');
			$mp3 = file_get_contents('http://api.voicerss.org/?' . $inlay);
			file_put_contents($file, $mp3);
		}
	# Ersetze die messageid durch die von TTS gespeicherte Datei
	$messageid = $fileolang;
	return ($messageid);
				  	
}

?>

