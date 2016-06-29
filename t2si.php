<?php
function t2s($messageid)

// text-to-speech: Erstellt basierend auf Input eine TTS Nachricht, übermittelt sie an Ivona.com und 
// speichert das zurückkommende file lokal ab
// @Parameter = $messageid von sonos2.php
{
	set_include_path(__DIR__ . '/ivona_tts');
	
	global $messageid, $words, $filename, $fileolang, $voice, $accesskey, $secretkey, $fileo;
		include 'ivona_tts.php';
		include 'config.php';
		
		#-- Übernahme der Variablen aus config.php --
		$language = $config['messageLangI'];
		$path = $config['messageStorePath'];
		
		#####################################################################################################################
		# zu testen da auf Google Translate basierend (urlencode)
		# ersetzt Umlaute um die Sprachqualität zu verbessern
		# $search = array('ä','ü','ö','Ä','Ü','Ö','ß','°','%20','%C3%84','%C4','%C3%9C','%FC','%C3%96','%F6','%DF','%C3%9F');
		# $replace = array('ae','ue','oe','Ae','Ue','Oe','ss','Grad',' ','ae','ae','ue','ue','oe','oe','ss','ss');
		# $words = str_replace($search,$replace,$words);
		#####################################################################################################################
		
		#-- Aufruf der IVONA Class zum generieren der t2s --
		$a = new IVONA_TTS(); 
		#print_r($words);
		$a->save_mp3($words, $path."/".$fileolang.".mp3", $language, $voice);
		$messageid = $fileolang;
	
	return ($messageid);
}


?> 