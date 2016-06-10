<?php
function t2s($messageid)
// text-to-speech: Erstellt mit dem OS X Command "say" eine AIFF Datei und speichert diese in einem Verzeichnis 
// @Parameter = $messageid von sonos2.php
{
	#echo "bin in der t2sx.php angekommen\n";
	global $words, $config, $messageid, $fileolang;

		$ttskey = $config['VoiceRSS_key'];
		$ttslanguage = $config['messageLangV'];
		$ttsaudiocodec = $config['audiocodec'];
		$messageStorePath = $config['messageStorePath'];
		$lamePath = $config['lamePath'];
		$words = urldecode($words);
		
		
	shell_exec("say $words -o $messageStorePath$fileolang.aiff; ".$lamePath."lame $messageStorePath$fileolang.aiff 2>&1");
	$messageid = $fileolang;
	return ($messageid);
				  	
}

?>

