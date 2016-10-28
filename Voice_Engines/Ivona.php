<?php
function t2s($messageid)

// text-to-speech: Erstellt basierend auf Input eine TTS Nachricht, �bermittelt sie an Ivona.com und 
// speichert das zur�ckkommende file lokal ab
// @Parameter = $messageid von sonos2.php
{
	set_include_path(__DIR__ . '/ivona_tts');
	
	global $messageid, $words, $filename, $fileolang, $config, $voice, $accesskey, $secretkey, $fileo;
		include 'ivona_tts/ivona_tts.php';
			
		#-- �bernahme der Variablen aus config.php --
		$engine = $config['t2s_engine'];
		$path = $config['messageStorePath'];
		if($engine = '2001') {
			$language = $config['messageLang'].'-'.strtoupper($config['messageLang']);
		}
		
		#####################################################################################################################
		# zu testen da auf Google Translate basierend (urlencode)
		# ersetzt Umlaute um die Sprachqualit�t zu verbessern
		# $search = array('�','�','�','�','�','�','�','�','%20','%C3%84','%C4','%C3%9C','%FC','%C3%96','%F6','%DF','%C3%9F');
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