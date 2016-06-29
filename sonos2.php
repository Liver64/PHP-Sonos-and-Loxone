<?php

##############################################################################################################################
#
# Version: 	1.5.1
# Datum: 	23.06.2016
# veröffentlicht in forum: https://www.loxforum.com/
# 
# Historie:
# ----------------------------------------------------------------------------------------------------------------------------
# 1.2.0		Veröffentlichung des Skriptes
# 1.2.2 	Aufgrund von diverser Groﬂ-/kleinschreibung Problematiken jetzt die komplette Syntax in kleinschreibung
# 1.3.0		Neue Funktionen hinzugefügt: 	group/ungroup // Achtung: Playlisten/Radiosender gehen bei ungroup verloren
#						addmember/removemember // zu einer Zone eine weitere hinzufügen 
#						Achtung: Playlisten/Radiosender gehen bei removemember von verlassende Zone 
#						verloren
#						sonosplaylist // lädt Sonos Playliste und spielt Sie dann ab
#						radiourl // Identifizieren der URL des gegenwärtig spielenden Radiosenders um die URL 
#						dann in der config.php zu der Radioliste hinzuzufügen.
#						rampto // Anpassung der Art der Lautstärkeregelung bei Play (3 Varianten möglich)
#
#						messagevolume // Standardlautstärke für Durchsagen wenn nichts anderes angegeben wurde
#						rampto // Standard für den Befehl Play wenn der Parameter rampto in der Syntax nicht 
#						angegeben wurde.
#
#						Details bzgl. Syntax bitte der README.md und der Parameter in config.php entnehmen 
# 1.3.1		Fehler bei Loxone Titelinfo und Volume behoben
# 1.3.2		Fehler in der Funktion 'ungroup' behoben
#			Rampto default bei gewissen Funktionen geändert, Parameter zu config.php hinzugefügt
# 			Fehler in der Funktion 'Logging' in Verbindung mit Loxone Anbindung behoben 
# 1.3.3		Google, Napster und die Sonos TV Bar bei Wiederherstellung nach TTS hinzugefügt
# 1.4.0		Weather-to-speak und Clock-to-speak Funktionen hinzugefügt
#			Ramp-to-sleep (ca. 16 Sekunden) bei Beginn TTS Ansage und laufender Zone hinzugefügt
# 1.4.1		w2s aktualisiert, Windstärkenangaben hinzugefügt, Bugfix für Windrichtung wenn Werte in Kürzel
#			zurückgegegben werden, 
# 1.4.2		Funktion softstop hinzugefügt (reduziert die Lautstärke linear in 17 Sekunden 
#	 		auf Null, dann Stop
# 1.4.3		Bugfix in Loxone Titel/Interpret Information behoben, TV Playbar Parameter geändert
# 1.4.4		Die messageid 100 (File 100.mp3) ist für eine Klingelfunktion reserviert. Wenn Sonos läuft wird somit verhindert
#			das die Ramp-to-sleep Funktion greift und stattdessen das Klingel MP3 file sofort abgespielt wird. (Voraussetzung 
#			man hat ein Klingelsignal an der Loxone)
#			Zusätzlicher Code für Playbar im TV Modus hinzugefügt (muss noch getestet werden)
#			Funktion Telefonmute hinzugefügt
# 1.4.5 	Code Optimierung und Error handling hinzugefügt (Verzeichnis log wird erstellt und die log dateien dort hineingeschrieben)
# 			max. Skript Laufzeit auf 60 Sekunden erhöht (sollte die Fatal Error Probleme mit SonosPHP.inc.php lösen)
# 			Funktion Telefonmute hinzugefügt (reduziert Volume langsam auf Wert 5%)
# 			TV Playbar funktioniert nicht wenn Playbar im TV Modus ist.
# 1.4.6		Fixed Problem bei TTS und eingeschaltetem Shuffle
#			folgende Funktion hinzugefügt:
#			- Neuer Online Text-to-speech Provider Ivona.com implementiert:
# 			alternativer Anbieter bei dem 2 Stimmen (männlich und weiblich) genutzt werden können. Eine default Stimme kann in der config.php
# 			voreingestellt werden, aber in der Syntax individuell angepasst werden. Steuerung welcher Provider genutzt werden soll erfolgt ebenso
# 			über die config.php (mehr Details bitte der Readme.md entnehmen) 
#			- Zonestatus (prüft ob alle Player Online sind)
#			- beim Errorhandling wird eine Info an Loxone Text Eingangsverbinder S-Error geschickt)
#			- clearlox (löscht Fehler in Loxone Benachrichtigung S-Error)
#			- getbass (gibt die Bass Einstellung zurück) + setbass (setzt den Bass auf angegebenen Wert)
#			- gettreble (gibt die Bass Einstellung zurück) + settreble (setzt den Treble auf angegebenen Wert)
#			- getloudness (gibt die Loudness Einstellung zurück [0 oder 1]) + setloudness (setzt den Bass auf angegebenen Wert [0 oder 1])
# 1.4.7		Fixed Problem mit nextradio und prevradio
# 1.4.8		Fixed loxgettitelinfo
#			maximale Skriptlaufzeit auf 90 Sekunden erhöht
#			Zeitspanne (10 Sekunden oder abruptes verringern der Lautstärke) vor dem Abspielen der t2s konfigurierbar (config.php)
#			s2s (sonos-to-speech) sagt den laufenden Titel kurz an (Titel stoppt abrupt, dann Titel/Interpret Ansage, Titel startet abrupt wieder)
# 1.4.9		monatliches Logfile wird erstellt
#			Bugfix in weather-to-speech behoben
# 			bei nextradio und prevradio die Lautstärke Parameter optimiert. Zone spielt = Volume bleibt, Zone spielt nicht = Volume aus Parameter $Volume wird zum Start verwendet
#			Folgende Funktionen wurden hinzugefügt:
#			- getgroupmute = Gibt den gegenwärtigen Mute Status einer Gruppe zurück
#			- setgroupmute = Setzt für eine Gruppe den Mute Status (0=Unmute, 1=Mute)
#			- getgroupvolume = Gibt die gegenwärtige Lautstärke einer Gruppe zurück
#			- setgroupvolume = Setzt für eine Gruppe die angegebene Laustärke gleich
#			- setrelativegroupvolume = Erhöht für eine Gruppe die angegebene Laustärke relativ in Prozent je Zone. ACHTUNG! vorheriges Lautstärkeverhältnis beachten!
#			- becomegroupcoordinator = Nimmt angegebene Zone aus einer Gruppe heraus
#			- Sleeptimer = Ausschaltverzögerung in Minuten (1-59 Minuten möglich)
# 1.5.0		Offline Mac basierende T2S Engine hinzugefügt (danke schön an Patrick (patriwag))
# 1.5.1		Erstellen von Gruppen bzw. auflösen einzelner Zonen basierend auf Auswahl der Zonen. Die jeweiligen Zonen müssen mit einem Komma aufgelistet werden, falls nur eine Zone dann ohne Komma
#			- addmember erstellt basierend auf der Auswahl von Zonen eine Gruppe. 
#			- removemember löscht die angegeben(n) Zone(n) aus einer bestehenden Gruppe. 
#			max. Scriptlaufzeit auf 120 Sekunden erhöht
#			Neue Funktion um eine T2S an eine Gruppe zu schicken. Vorher wird je Zone der Zustand gespeichert, dann die gewünschten Zonen
#			gruppiert, die t2s in gewünschter Lautstärke je Zone (siehe config.php) abgespielt und zum Schluß wieder der Originalzustand jeder Zone hergestellt.
# 			- sendgroupmessage 
#			Zusätzlich gibt es am Ende der Syntax den Parameter "groupvolume", der die Volume default Werte aus der config.php um den angegebenen Prozentwert erhöht.
#			- groupsonosplaylist = spielt eine Sonos Playliste in einer Gruppe von Zonen ab	 (analog zu sonosplaylist für einzelne Zone)
#			- groupradioplaylist = spielt einen ausgewählten Radiosender in einer Gruppe von Zonen ab (analog zu radioplaylist für einzelne Zone)
#			
# bekannte Probleme:	derzeit keine
# 						
# geplante Funktionen: 	
#
#
######## Script Code (ab hier bitte nichts ändern) ###################################

ini_set('max_execution_time', 120); // Max. Skriptlaufzeit auf 120 Sekunden

include("PHPSonos.php");
include "config.php";

set_error_handler("customError");

$debug = $config['debuggen'];
if($debug == 1) { 
	echo "<pre><br>"; 
	# include ("mp3info.php"); 
	}
	
 // Prüfen ob das Verzeichnis 'log' vorhanden ist, falls nicht mit Rechte 0777 erstellen
 $path = "log";
 if (is_dir($path)) { 
 } else { 
 mkdir ($path, 0777); 
 } 
 
 // Übernahme und Deklaration von Variablen aus config.php
$sonoszone = $config['sonoszone'];
$loxip = $config['LoxIP'];
$loxuser = $config['LoxUser'];
$loxpassword = $config['LoxPassword'];
$log = $config['logging'];


// prüft ob Zeitzonen Server/PHP identisch sind und korrigert ggf.
$script_tz = date_default_timezone_get();

if (strcmp($script_tz, ini_get('date.timezone'))){
	date_default_timezone_set('Europe/Berlin');
	echo 'Die Script-Zeitzone unterschied sich von der ini-set Zeitzone und wurde angepasst.'."<br>"."<br>";
} else {
	if($debug == 1) {
		echo 'Die Script-Zeitzone und die ini-set Zeitzone stimmen überein.'."<br>"."<br>";
	}
}


// Error handling (erstellt error log datei)	
 function customError($errno, $errstr, $errfile, $errline, $errcontext){
 	global $path, $loxuser, $loxpassword, $loxip, $master;
	$message = date("Y-m-d H:i:s - ");
	$message .= "Fehler: [" . $errno ."], " . "$errstr in $errfile in line $errline, ";
	$message .= "Variable:" . print_r($errcontext, true) . "\r\n";
	error_log($message, 3, $path."/sonos_error.log");
	#-- Loxone Uebermittlung eines Fehlerhinweises ----------------------------------------------
	$ErrorS = rawurlencode("Sonos Fehler. Bitte log pruefen");
	$handle = @fopen("http://$loxuser:$loxpassword@$loxip/dev/sps/io/S-Error/$ErrorS", "r");
	#--------------------------------------------------------------------------------------------
	die("Ein Fehler trat auf. Bitte Datei /".$path."/sonos_error.log pruefen.");
	}
#------------------------------------------------------------------------------------------------
 
 
# Start des Srcipts
if(isset($_GET['volume']) && is_numeric($_GET['volume']) && $_GET['volume'] >= 0 && $_GET['volume'] <= 100) {
	$volume = $_GET['volume'];
} else {
	$master = $_GET['zone'];
	$sonos = new PHPSonos($sonoszone[$master][0]); //Sonos IP Adresse
	$volume = $config['sonoszone'][$master][2];
}

if(isset($_GET['rampto'])) {
		switch($_GET['rampto'])	{
			case 'sleep';
				$config['rampto'] = "SLEEP_TIMER_RAMP_TYPE";
				break;
			case 'alarm';
				$config['rampto'] = "ALARM_RAMP_TYPE";
				break;
			case 'auto';
				$config['rampto'] = "AUTOPLAY_RAMP_TYPE";
				break;
		}
	} else {
		switch($config['rampto']) {
			case 'sleep';
				$config['rampto'] = "SLEEP_TIMER_RAMP_TYPE";
				break;
			case 'alarm';
				$config['rampto'] = "ALARM_RAMP_TYPE";
				break;
			case 'auto';
				$config['rampto'] = "AUTOPLAY_RAMP_TYPE";
				break;
		}
	}

if(array_key_exists($_GET['zone'], $sonoszone)){ 
	$master = $_GET['zone'];
	$sonos = new PHPSonos($sonoszone[$master][0]); //Sonos IP Adresse
	
	switch($_GET['action'])	{
		case 'play';
			if(count($sonos->GetCurrentPlaylist()) > 0) { 
			if($sonos->GetVolume() <= $config['volrampto']) {
					$sonos->RampToVolume($config['rampto'], $volume);
					$sonos->Play();
				} else {
					$sonos->Play();
				}
			} else {
				die("Keine Titel in der Playliste zum Abspielen.");
			}
			break;
		
		case 'pause';
				$sonos->Pause();
			break;
			
		case 'clearlox': // Loxone Fehlerhinweis zurücksetzen
				$handle = fopen("http://$loxuser:$loxpassword@$loxip/dev/sps/io/S-Error/''", "r");
			break;
		
		case 'next';
			$titelgesammt = $sonos->GetPositionInfo();
			$titelaktuel = $titelgesammt["Track"];
			$playlistgesammt = count($sonos->GetCurrentPlaylist());
						
			if ($titelaktuel < $playlistgesammt) {
			$sonos->Next();
			} else {
				die("Kein weiterer Titel in der Playlist vorhanden");
			}
			break;

		case 'previous';
				$sonos->Previous();
			break;  
			
		case 'zonestatus';
				networkstatus();
			break;  
			
		case 'rewind':
				$sonos->Rewind();
			break; 

		case 'mute';
			if($_GET['mute'] == 'false') {
				$sonos->SetMute(false);
				logging();
			}
			else if($_GET['mute'] == 'true') {
				$sonos->SetMute(true);
				logging();
			} else {
				die('Falscher Mute Parameter');
			}       
			break;
		
		case 'telefonmute';
			if($_GET['mute'] == 'false') {
				 $MuteStat = $sonos->GetMute();
				 if($MuteStat == 'true') {
					$SaveVol = $sonos->GetVolume();
					$sonos->SetVolume(5);
					$sonos->SetMute(false);
					$sonos->RampToVolume("ALARM_RAMP_TYPE", $SaveVol);
				}
			}
			else if($_GET['mute'] == 'true') {
				 $sonos->SetMute(true);
				 $SaveVol = $sonos->GetVolume();
				 $sonos->SetVolume($SaveVol);
			}
			break;

			
		case 'stop';
				$sonos->Stop();
			break;  

		case 'softstop':
				$save_vol_stop = $sonos->GetVolume();
				$sonos->RampToVolume("SLEEP_TIMER_RAMP_TYPE", "0");
				sleep('17');
				$sonos->Stop();
				$sonos->SetVolume($save_vol_stop);
			break;      
		  
		case 'toggle':
			if($sonos->GetTransportInfo() == 1)  {
				$sonos->Pause();
			} else {
				$sonos->Play();
			}
			break;  
					
		case 'playmode';
			// NORMAL
			// REPEAT_ALL
			// REPEAT_ONE
			// SHUFFLE_NOREPEAT
			// SHUFFLE
			// SHUFFLE_REPEAT_ONE
			if( ($_GET['playmode'] == "normal") || ($_GET['playmode'] == "repeat_all") || ($_GET['playmode'] == "shuffle_norepeat") || ($_GET['playmode'] == "shuffle") || ($_GET['playmode'] == "repeat_one") || ($_GET['playmode'] == "shuffle_repeat_one")) {
				$sonos->SetPlayMode(strtoupper($_GET['playmode']));
			} else {
				die('falscher PlayMode');
			}    
			break;           
	  
		case 'crossfade':
			if((is_numeric($_GET['crossfade'])) && ($_GET['crossfade'] == 0) || ($_GET['crossfade'] == 1)) { 
				$crossfade = $_GET['crossfade'];
			} else {
				die ("falscher Crossfade -> 0 = aus / 1 = an");
			}
				$sonos->SetCrossfadeMode($crossfade);
			break; 
		  
		case 'remove':
			if(is_numeric($_GET['remove'])) {
				$sonos->RemoveFromQueue($_GET['remove']);
			} 
			break;   
		
		case 'playqueue':
			$titelgesammt = $sonos->GetPositionInfo();
			$titelaktuel = $titelgesammt["Track"];
			$playlistgesammt = count($sonos->GetCurrentPlaylist());
						
			if ($titelaktuel < $playlistgesammt) {
			$sonos->SetQueue("x-rincon-queue:" . getRINCON($sonoszone[$master][0]) . "#0");
				if($sonos->GetVolume() <= $config['volrampto'])	{
					$sonos->RampToVolume($config['rampto'], $volume);
					$sonos->Play();
				} else{
					$sonos->Play();
				}
			logging();
			} else {
				die("Keine Titel in der Playlist zum Abspielen.");
			}
			break;
		
		case 'clearqueue':
				$sonos->SetQueue("x-rincon-queue:" . getRINCON($sonoszone[$master][0]) . "#0");
				$sonos->ClearQueue();
				logging();
			break;  
		  
		case 'volume':
			if(isset($volume)) {
				$sonos->SetVolume($volume);
				loxdata();
			} else {
				die('falscher Wertebereich für die Lautstärke, 0-100 ist nur erlaubt');
			}
			break;  
		  
		case 'volumeup': 
			$volume = $sonos->GetVolume();
			if($volume < 100) {
				$volume = $volume + $config['volumeup'];
				$sonos->SetVolume($volume);
				loxdata();
			}      
			break;
			
		case 'volumedown':
			$volume = $sonos->GetVolume();
			if($volume > 0) {
				$volume = $volume - $config['volumedown'];
				$sonos->SetVolume($volume);
				loxdata();
			}
			break;   

			
		case 'setloudness':
			if(($_GET['loudness'] == 1) || ($_GET['loudness'] == 0)) {
				$loud = $_GET['loudness'];
				$sonos->SetLoudness($loud);
			} else {
				die('falscher LoudnessMode');
			}    
		break;
		
		
		case 'settreble':
			$Treble = $_GET['treble'];
			$sonos->SetTreble($Treble);
		break;
		
		
		case 'setbass':
			$Bass = $_GET['bass'];
			$sonos->SetBass($Bass);
		break;	
		
		
		case 'setbass':
			$Bass = $_GET['bass'];
			$sonos->SetBass($Bass);
		break;			

		
		case 'addmember':
			$member = $_GET['member'];
			$group = creategroup($member);
		break;

		
		case 'removemember':
			$member = $_GET['member'];
			$group = removegroup($member);
		break;
		  
		
		case 'nextradio':
			$playstatus = $sonos->GetTransportInfo();
			$radiovolume = $sonos->GetVolume();
			$radiosender = $sonos->GetPositionInfo();
			$senderuri = $radiosender["URI"];
			$radioanzahl = $result = count($config['radio_name']);
			$senderaktuell = array_search($senderuri,  $config['radio_adresse']);
			# Wenn nextradio aufgerufen wird ohne eine vorherigen Radiosender
			if( $senderaktuell == "" && $senderuri == "" || substr($senderuri,0,12) == "x-file-cifs:" ) {
				$sonos->SetRadio($config['radio_adresse'][0], $config['radio_name'][0]);
			}

			if ($senderaktuell == $radioanzahl - 1) {
				$sonos->SetRadio($config['radio_adresse'][0], $config['radio_name'][0]);
			} else {
				$sonos->SetRadio($config['radio_adresse'][$senderaktuell + 1], $config['radio_name'][$senderaktuell + 1]);
			}
			if( $debug == 1) {
				echo "Senderuri vorher: " . $senderuri . "<br>";
				echo "Sender aktuell: " . $senderaktuell . "<br>";
				echo "Radioanzahl: " .$radioanzahl . "<br>";
			}
			if($playstatus == 1) {
				$sonos->SetVolume($radiovolume);
				$sonos->Play();
			} else {
				$sonos->RampToVolume($config['rampto'], $volume);
				$sonos->Play();
			}
		  break;

		case 'prevradio':
			$playstatus = $sonos->GetTransportInfo();
			$radiovolume = $sonos->GetVolume();
			$radiosender = $sonos->GetPositionInfo();
			$senderuri = $radiosender["URI"];
			$radioanzahl = $result = count($config['radio_name']);
			$senderaktuell = array_search($senderuri, $config['radio_adresse']);
			# Wenn prevradio aufgerufen wird ohne eine vorherigen Radiosender
			if( $senderaktuell == "" && $senderuri == "" || substr($senderuri,0,12) == "x-file-cifs:") {
					$sonos->SetRadio($config['radio_adresse'][0], $config['radio_name'][0]);
				}
				if ($senderaktuell == 0) {
					$sonos->SetRadio($config['radio_adresse'][$radioanzahl -1], $config['radio_name'][$radioanzahl - 1]);
				} else {
					$sonos->SetRadio($config['radio_adresse'][$senderaktuell - 1], $config['radio_name'][$senderaktuell - 1]);
				}	
				if( $debug == 1) {
					echo "Senderuri vorher: " . $senderuri . "<br>";
					echo "Sender aktuell: " . $senderaktuell . "<br>";
					echo "Radioanzahl: " .$radioanzahl . "<br>";
				}
				if($playstatus == 1) {
					$sonos->SetVolume($radiovolume);
					$sonos->Play();
				} else {
					$sonos->RampToVolume($config['rampto'], $volume);
					$sonos->Play();
				}
		  break;
				  
		case 'sonosplaylist':
			logging();
			groupplaylist();
		break;
		  
		
		case 'groupsonosplaylist':
			global $membermaster, $debug, $sonos;
			logging();
			$master = $_GET['zone'];
			$groupvol = "1";
			groupplaylist();
			creategroup($membermaster, $groupvol);
		break;

		case 'radioplaylist':
			logging();
			groupradioplaylist();
		break;
		
		
		case 'groupradioplaylist': 
			global $member, $debug, $sonos;
			logging();
			$master = $_GET['zone'];
			$groupvol = "1";
			groupradioplaylist();
			creategroup($member, $groupvol);
		break;
		
		
		case 'info':
      		 $PositionInfo = $sonos->GetPositionInfo();
			 $GetMediaInfo = $sonos->GetMediaInfo();
			 $radio = $sonos->RadiotimeGetNowPlaying();

			 $title = $PositionInfo["title"];
			 $album = $PositionInfo["album"];
			 $artist = $PositionInfo["artist"];
			 $albumartist = $PositionInfo["albumArtist"];
			 $reltime = $PositionInfo["RelTime"];
			 $bild = $PositionInfo["albumArtURI"];
			 $streamContent = $PositionInfo["streamContent"];
			 if($sonos->GetTransportInfo() == 1 )  {
				# Play
				$status = 'Play';
			 } else {
				# Pause
				$status = 'Pause';
			 }  
			 if($PositionInfo["albumArtURI"] == '')  {
				# Kein Cover - Dann Radio Cover
				$bild = $radio["logo"];
			 }
			 if($PositionInfo["albumArtURI"] == '')  {
				# Kein Title - Dann Radio Title
				$title = $GetMediaInfo["title"];
			 }   
			 if($PositionInfo["album"] == '')  {
				# Kein Album - Dann Radio Stream Info
				$album = $PositionInfo["streamContent"];
			 }   
			 echo'
				  cover<tab>' . $bild . '<br>   
				  title<tab>' . $title . '<br>
				  album<tab>' . $album . '<br>
				  artist<tab>' . $artist . '<br>
				  time<tab>' . $reltime . '<br>
				  status<tab>' . $status . '<br>
				';
		break;
      
    
		case 'cover':
			$PositionInfo = $sonos->GetPositionInfo();
			$radio = $sonos->RadiotimeGetNowPlaying();
			$bild = $PositionInfo["albumArtURI"];
			if($PositionInfo["albumArtURI"] == '')  {
				# Kein Cover - Dann Radio Cover
				$bild = $radio["logo"];
			}
			echo' ' . $bild . ' ';
		break;   
		
		
		case 'title':
			$PositionInfo = $sonos->GetPositionInfo();
			$GetMediaInfo = $sonos->GetMediaInfo();
			$radio = $sonos->RadiotimeGetNowPlaying();
			$title = $PositionInfo["title"];
			if($PositionInfo["albumArtURI"] == '')  {
				# Kein Title - Dann Radio Title
				$title = $GetMediaInfo["title"];
			}
			echo' ' . $title . ' ';
		break;   
			 
		
		case 'artist':
			$PositionInfo = $sonos->GetPositionInfo();
			$GetMediaInfo = $sonos->GetMediaInfo();
			$title = $PositionInfo["title"];
			$album = $PositionInfo["album"];
			$artist = $PositionInfo["artist"];
			$albumartist = $PositionInfo["albumArtist"];
			$reltime = $PositionInfo["RelTime"];
			$bild = $PositionInfo["albumArtURI"];
			echo' ' . $artist . ' ';      
		break;   
		
			 
		case 'album':
			$PositionInfo = $sonos->GetPositionInfo();
			$GetMediaInfo = $sonos->GetMediaInfo();
			$radio = $sonos->RadiotimeGetNowPlaying();
			$album = $PositionInfo["album"];
			if($PositionInfo["album"] == '')  {
				# Kein Album - Dann Radio Stream Info
				$album = $PositionInfo["streamContent"];
			}
			echo'' . $album . '';
		break;

		
		case 'titelinfo':
		if($debug == 1) {
				echo debug();
			}
			$PositionInfo = $sonos->GetPositionInfo();
			$GetMediaInfo = $sonos->GetMediaInfo();
			$title = $PositionInfo["title"];
			$album = $PositionInfo["album"];
			$artist = $PositionInfo["artist"];
			$albumartist = $PositionInfo["albumArtist"];
			$reltime = $PositionInfo["RelTime"];
			$bild = $PositionInfo["albumArtURI"];
				echo'
					<table>
						<tr>
							<td><img src="' . $bild . '" width="200" height="200" border="0"></td>
							<td>
							Titel: ' . $title . '<br><br>
							Album: ' . $album . '<br><br>
							Artist: ' . $artist . '</td>
						</tr>
						<tr>
						<td>
						<a href="'.$_SERVER['SCRIPT_NAME'].'?zonen='.$master.'&action=previous" target="_blank">Zurück</a>
						<a href="'.$_SERVER['SCRIPT_NAME'].'?zonen='.$master.'&action=play" target="_blank">Abspielen</a>
						<a href="'.$_SERVER['SCRIPT_NAME'].'?zonen='.$master.'&action=pause" target="_blank">Pause</a>
						<a href="'.$_SERVER['SCRIPT_NAME'].'?zonen='.$master.'&action=stop" target="_blank">Stop</a>
						<a href="'.$_SERVER['SCRIPT_NAME'].'?zonen='.$master.'&action=next" target="_blank">Nächster</a>
					</table>
				';
			break;
			
		
		
		case 'sendgroupmessage':
			global $sonos, $text, $member, $master, $zone, $messageid, $logging, $words, $voice, $accesskey, $secretkey, $rampsleep, $config, $save_status, $mute, $membermaster, $groupvol;
			
			if(isset($_GET['volume'])) {
				die("Die Angabe des Parameters Volume ist innerhalb dieser Syntax nicht zulässig!");
				exit;
			}
			// erhöht die Defaultwerte aus der config.php um xx Prozent
			if(isset($_GET['groupvolume']) && is_numeric($_GET['groupvolume']) && $_GET['groupvolume'] >= 0 && $_GET['groupvolume'] <= 100) {
				$groupvolume = $_GET['groupvolume'];
				SetGroupVolume($groupvolume);
			}
			if(isset($_GET['groupvolume']) && $_GET['groupvolume'] > 100) {
				die("Der angegebene Wert für groupvolume ist nicht gültig. Erlaubte Werte sind 0 bis 100, bitte prüfen!");
				exit;
			}
			$master = $_GET['zone'];
			$groupvol = "1";
			// Gruppe erstellen, vorher Zustand der Zonen in JSON Datei speichern
			creategroup($membermaster, $groupvol);
			$sonos->Stop();
			// Alle Zonen auf Mute
			$sonos = new PHPSonos($sonoszone[$master][0]);
			$sonos->SetGroupMute(true);
			// T2S erstellen und abspielen
			create_tts($text, $messageid);
			sleep($config['sleepgroupmessage']); // warten gemäß config.php
			// setzen der T2S Lautstärke je Zone
			foreach ($membermaster as $player => $zone) {
				$sonos = new PHPSonos($sonoszone[$zone][0]); 
				$sonos->SetVolume($config['sonoszone'][$zone][1]);
			}
			//Gruppen Mute aufheben
			$sonos = new PHPSonos($sonoszone[$master][0]);
			$sonos->SetGroupMute(false);
			play_tts($messageid, $groupvol);
			// Gruppe auflösen, JSON Datei einlesen und Ursprungszustand je Zone wiederherstellen
			removegroup($membermaster);
			logging();
		break;
		
		
		case 'sendmessage':
			global $text, $master, $messageid, $logging, $words, $voice, $accesskey, $secretkey, $rampsleep, $config, $save_status, $groupvol;
			
			if(isset($_GET['volume']) && is_numeric($_GET['volume']) && $_GET['volume'] >= 0 && $_GET['volume'] <= 100) {
				$volume = $_GET['volume'];
			} else 	{
				# übernimmt Standard Lautstärke der angegebenen Zone aus config.php
				$volume = $config['sonoszone'][$master][1];
			}
			$groupvol = "0";
			create_tts($text, $messageid);
			save_current_status_single();
			play_tts($messageid, $groupvol);
			restore_org_settings_single($save_status);
			logging();
		break;
		
			
	case 'group':
		logging();
		# Alle Zonen gruppieren
		$masterrincon = getRINCON($sonoszone[$master][0]);
		foreach ($sonoszone as $zone => $ip) {
			if($zone != $_GET['zone']) {
				$sonos = new PHPSonos($sonoszone[$zone][0]); //Sonos IPAdresse
				$sonos->SetAVTransportURI("x-rincon:" . $masterrincon); 
			}
		}
	break;
		
	case 'ungroup':
		logging();
		# Alle Zonen Gruppierungen aufheben
		foreach($sonoszone as $zone => $ip) {
			$sonos = new PHPSonos($sonoszone[$zone][0]); //Sonos IPAdresse
			$sonos->SetQueue("x-rincon-queue:" . getRINCON($sonoszone[$zone][0]) . "#0");
		}
	break;
	

# Loxone Bereich ------------------------------------------------------
		
		case 'loxgettitel':  # Titel und Interpret für Übergabe an Loxone
			$temp = $sonos->GetPositionInfo();
			$tempradio = $sonos->GetMediaInfo();
			
			# prüft ob die Verbindung zu Loxone in der config eingeschaltet ist			
			if($config['LoxDaten'] === false) {
				echo "Die Datenuebermittlung zu Loxone ist nicht aktiv. Bitte in der config.php aktivieren"; 
				$value = "Datenübermittlung ist aus";
				$valuesplit[0]=" ";
				$valuesplit[1]=" ";
				#exit;
			} else {
				$gettransportinfo = $sonos->GetTransportInfo();
			}
			
			# prüft ob gerade überhaupt etwas gespielt wird
			if($config['LoxDaten'] === true) {
				if ($gettransportinfo == 1) {
					if(empty($temp["duration"])) {							# nur wenn Radio läuft
						$value =  substr($tempradio["title"], 0, 40); 		// Radiosender
						$valuesplit[0] = $value; 							
						$valuesplit[1] = $value;							
						# Alte Version mit Split von Interpret und Titel
						#$valuesplit = explode("-",$value, 2); 				// Teilt den Stream beim Bindestrich in 2 Werte
						#$valuesplit[1] = substr($valuesplit[1], 1, 54); 	// erstes Leerzeichen nach Trennung abschneiden
					} elseif(!empty($temp["duration"]) && ($gettransportinfo == 1)) {
						$artist = substr($temp["artist"], 0, 30); 	// restrektiert Interpretinfo auf die ersten 30 Zeichen
						$title = substr($temp["title"], 0, 50); 	// restrektiert Titelinfo auf die ersten 50 Zeichen
						$value = $artist." - ".$title; 	// kombiniert Titel- und Interpretinfo
						$valuesplit[0] = $title; 		// Nur Titelinfo
						$valuesplit[1] = $artist;		// Nur Interpreteninfo
					}
				# Wenn Pause oder Stop dann folgenden Text übergeben
				} else {
					$value = "Es wird gerade nichts gespielt!";
					$valuesplit[0]="Zur Zeit nichts!";
					$valuesplit[1]="Zur Zeit nichts!";
				}
			}
			# Übergabe der Titelinformation an Loxone
			$valueurl = rawurlencode($value);
			$valuesplit[0] = rawurlencode($valuesplit[0]);
			$valuesplit[1] = rawurlencode($valuesplit[1]);
			sleep(3); // wartet 3 Sekunden (Latenzzeit Sonos)
			$handle = fopen("http://$loxuser:$loxpassword@$loxip/dev/sps/io/S-Titel$master/$valueurl", "r"); // Titel- und Interpretinfo für Loxone
			$handle = fopen("http://$loxuser:$loxpassword@$loxip/dev/sps/io/S-Titelinfo$master/$valuesplit[0]", "r"); // Nur Titelinfo für Loxone
			$handle = fopen("http://$loxuser:$loxpassword@$loxip/dev/sps/io/S-Interpretinfo$master/$valuesplit[1]", "r"); // Nur Interpreteninfo für Loxone
			echo '<PRE>';
 
		break;	
		
				

		case 'loxgettransportinfo':

		if($config['LoxDaten'] === true) {
     			$GetTransportInfo = $sonos->GetTransportInfo();
	  			echo '<PRE>';
		     	print_r($GetTransportInfo);
				$handle = fopen("http://$loxuser:$loxpassword@$loxip/dev/sps/io/S-TransportInfo$master/$GetTransportInfo", "r");
		     	echo '</PRE>';
			} else
			{ echo "Die Datenuebermittlung zu Loxone ist nicht aktiv. Bitte in der config.php aktivieren"; }
      	break; 
		

		case 'loxgetmute':
			
			if($config['LoxDaten'] === true) {
   				$GetMute = $sonos->GetMute();
	  			echo '<PRE>';
	     		print_r($GetMute);
				$handle = fopen("http://$loxuser:$loxpassword@$loxip/dev/sps/io/S-Mute$master/$GetMute", "r");
	     		echo '</PRE>';
			} else { 
				echo "Die Datenuebermittlung zu Loxone ist nicht aktiv. Bitte in der config.php aktivieren";}
      	break; 
		

		case 'loxgetvolume':
			
			if($config['LoxDaten'] === true) {
   				$GetVolume = $sonos->GetVolume();
	  			echo '<PRE>';
	     		print_r($GetVolume);
				$handle = fopen("http://$loxuser:$loxpassword@$loxip/dev/sps/io/S-Volume$master/$GetVolume", "r");
	     		echo '</PRE>';
			} else { 
				echo "Die Datenuebermittlung zu Loxone ist nicht aktiv. Bitte in der config.php aktivieren"; }
      	break; 
		



					
		
	
	# Debug Bereich ------------------------------------------------------

	
		case "test1":
				
			break;
			
		case "test2":
				
			break;
	
		case 'getmediainfo':
				echo '<PRE>';
				print_r($sonos->GetMediaInfo());
				echo '</PRE>';
			break;
		
		case 'getmute':
				echo '<PRE>';
				print_r($sonos->GetMute());
				echo '<PRE>';
			break;

		case 'getpositioninfo':
				echo '<PRE>';
				print_r($sonos->GetPositionInfo());
				echo '</PRE>';
			break;      

		case 'gettransportsettings':
				echo '<PRE>';
				print_r($sonos->GetTransportSettings());
				echo '</PRE>';
			break;   
		  
		case 'gettransportinfo':
			# 1 = PLAYING
			# 2 = PAUSED_PLAYBACK
			# 3 = STOPPED

				echo '<PRE>';
					print_r($sonos->GetTransportInfo());
				echo '</PRE>';
			break;        
		
		case 'getradiotimegetnowplaying':
				$radio = $sonos->RadiotimeGetNowPlaying();
				print_r($radio);
			break;

		  
		case 'getvolume':
				echo '<PRE>';
					print_r($sonos->GetVolume());
				echo '</PRE>';
			break;
			
		
		case 'getuser':
				echo '<PRE>';
					echo get_current_user();
				echo '</PRE>';
			break;	
		  
		case 'masterplayer':
			Global $zone, $master;		
			foreach ($sonoszone as $player => $ip) {

				$sonos = new PHPSonos($ip[0]); //Slave Sonos ZP IPAddress
				$temp = $sonos->GetPositionInfo($ip);

				if (substr($temp["TrackURI"], 0, 9) == "x-rincon:" ) {
					$masterrincon = substr($temp["TrackURI"], 9 ,24);
					}
				
				foreach ($sonoszone as $masterplayer => $ip) {
					# hinzugefügt am 18.01 weil Fehler bei Gruppierung auflösen
					$masterrincon = substr($temp["TrackURI"], 9, 24);
					if(getRINCON($ip[0]) == $masterrincon) {
						echo "<br>" . $player . " -> ";
						echo "Master des Players: " . $masterplayer;
					}
				}
				$masterrincon = "";
			}
			return $masterplayer;
		break;
			
		case 'radiourl':
		
			$GetPositionInfo = $sonos->GetPositionInfo();
			echo "Die Radio URL lautet: " . $GetPositionInfo["URI"];
		
		break;
		
		case 'becomegroupcoordinator':
			echo '<PRE>';
					$sonos->BecomeCoordinatorOfStandaloneGroup();
			echo '</PRE>';
		break;
		
		case 'getgroupmute':
			$GetGroupMute = $sonos->GetGroupMute();
		break;
		
		case 'setgroupmute':
			if(($_GET['mute'] == 1) || ($_GET['mute'] == 0)) {
				$mute = $_GET['mute'];
				$sonos->SetGroupMute($mute);
			} else {
				echo "Der Mute Mode ist unbekannt";
			}
		break;


		case 'getgroupvolume':
			$GetGroupVolume = $sonos->GetGroupVolume() ;
		break;
		
		case 'setgroupvolume':
			$GroupVolume = $_GET['groupvolume'];
			$GroupVolume = $sonos->SetGroupVolume($GroupVolume);
								
		break;
		
		case 'setrelativegroupvolume':
			SnapshotGroupVolume();
			$RelativeGroupVolume = $_GET['groupvolume'];
			$RelativeGroupVolume = $sonos->SetRelativeGroupVolume($RelativeGroupVolume);
								
		break;
		
		case 'snapshotgroupvolume':
			$SnapshotGroupVolume = $sonos->SnapshotGroupVolume();
		break;
		
		case 'sleeptimer':
		
		if(isset($_GET['timer']) && is_numeric($_GET['timer']) && $_GET['timer'] > 0 && $_GET['timer'] < 60) {
			$timer = $_GET['timer'];
			if($_GET['timer'] < 10) {
				$timer = '00:0'.$_GET['timer'].':00';
			} else {
				$timer = '00:'.$_GET['timer'].':00';
				$timer = $sonos->Sleeptimer($timer);
			}
		} else {
		echo "Die eingegebene Zeitspanne ist nicht korrekt, bitte korrigieren";
		}
		break;

		case 'getsonosplaylists':
			echo '<PRE>';
					print_r($sonos->GetSonosPlaylists());
			echo '</PRE>';
		
		break;		
			
		case 'getaudioinputattributes':	// funktioniert nicht
			echo '<PRE>';
					print_r($sonos->GetAudioInputAttributes());
			echo '</PRE>';
		
		break;		
		
		case 'getzoneattributes':
			echo '<PRE>';
					print_r($sonos->GetZoneAttributes());
			echo '</PRE>';
		
		break;
		
		case 'zonentabelle':
			echo '<PRE>';
					sonosgruppentabelle();
			echo '<PRE>';
		break;

		case 'getcurrenttransportactions':
			echo '<PRE>';
					print_r($sonos->GetCurrentTransportActions());
			echo '</PRE>';
		
		break;
		
		case 'getcurrentplaylist':
			echo '<PRE>';
					print_r($sonos->GetCurrentPlaylist());
			echo '</PRE>';
		
		break;
		
		case 'getimportedplaylists':
			echo '<PRE>';
					print_r($sonos->GetImportedPlaylists());
			echo '</PRE>';
		
		break;
		
				
		case 'listalarms':
			echo '<PRE>';
					print_r($sonos->ListAlarms());
			echo '</PRE>';
		
		break;
		
		case 'getledstate':
			echo '<PRE>';
					die ($sonos->GetLEDState());
			echo '</PRE>';
		
		break;
		
		case 'setledstate':
			echo '<PRE>';
					if(($_GET['state'] == "On") || ($_GET['state'] == "Off")) {
					$state = $_GET['state'];
					$sonos->SetLEDState($state);
					} else {
						die ('Bitte Eingabe korrigieren. On oder Off ist nur erlaubt');
					}
			echo '</PRE>';
		
		break;
		
		#case 'getinvisible':
			#echo '<PRE>';
			#		print_r($sonos->GetInvisible());
			#echo '</PRE>';
		#break;
				
		
		case 'getcurrentplaylist':
			
			echo '<PRE>';
					print_r($sonos->GetCurrentPlaylist());
			echo '</PRE>';
		break;
		
		case 'getloudness':
			
			echo '<PRE>';
					print_r($sonos->GetLoudness());
			echo '</PRE>';
		break;
		
		case 'gettreble':
			
			echo '<PRE>';
					print_r($sonos->GetTreble());
			echo '</PRE>';
		break;
		
		case 'getbass':
			
			echo '<PRE>';
					print_r($sonos->GetBass());
			echo '</PRE>';
		break;

		case 'getzoneinfo':
		
			$GetZoneInfo = $sonos->GetzoneInfo();
			echo '<PRE>';
			echo "Technische Details der ausgewaehlten Zone: " . $master;
			echo '<PRE>';
			echo '<PRE>';
			echo "IP Adresse: " . substr($GetZoneInfo['IPAddress'], 0, 30);
			echo '<PRE>';
			echo "Serial Number: " . substr($GetZoneInfo['SerialNumber'], 0, 50);
			echo '<PRE>';
			echo "Software Version: " . substr($GetZoneInfo['SoftwareVersion'], 0, 30);
			echo '<PRE>';
			echo "Hardware Version: " . substr($GetZoneInfo['HardwareVersion'], 0, 30);
			echo '<PRE>';
			echo "MAC Adresse: " . substr($GetZoneInfo['MACAddress'], 0, 30);
			echo '<PRE>';
			$zoneplayerip = getRINCON(substr($GetZoneInfo['IPAddress'], 0 , 13));
			echo '<PRE>';
			echo "RinconID: " . $zoneplayerip;
		break;
		  
	default:
       die("Dieser Befehl ist nicht bekannt. <br>sonos2.php?zone=SONOSPLAYER&action=BEFEHL&BEFEHL=Option");

	} 
	
	
	}
	else 
	{
	echo "Der Zone ist nicht im angegebenen Bereich vorhanden. (siehe config.php)";
}




# Funktionen Bereich ------------------------------------------------------

# Hilfs Funktionen für Skripte ------------------------------------------------------

 function getArrayValue($array, $key, $default = null) { // Durchsucht eine Array und gibt die values zurück
        if (isset($array[$key])) return $array[$key];
        return $default;
 }

 
 function getRINCON($zoneplayerIp) {
  $url = "http://" . $zoneplayerIp . ":1400/status/zp";
  $xml = simpleXML_load_file($url);
  $uid = $xml->ZPInfo->LocalUID;
  return $uid;  
  return $playerIP;
 }


 function zonenmaster($member) {
		global $sonos, $sonoszone, $master, $member;
		foreach ($sonoszone as $player => $ip) {
			#echo "<br>" . $player;
			$sonos = new PHPSonos($ip); //Slave Sonos ZP IPAddress
			$temp = $sonos->GetPositionInfo();
			if (substr($temp["TrackURI"], 0, 9) == "x-rincon:" ) {
				$masterrincon = substr($temp["TrackURI"], 9 ,24);
				}
			foreach ($sonoszone as $masterplayer => $ip) {
				# Hinzugefügt weil Fehler bei Gruppierung aufheben
				$masterrincon = substr($temp["TrackURI"], 9 ,24);
				if(getRINCON($ip) == $masterrincon) {
					if ($member == $player) {
					echo "<br>" . $player . " -> ";
					echo "Master des Players: " . $masterplayer;
					return $masterplayer;
					return $player;
					}
				}
			}
			unset($masterrincon);
			unset($sonos);
		}
 }
 
 function debug() {
 	global $sonos, $sonoszone;
	$GetPositionInfo = $sonos->GetPositionInfo();
	$GetMediaInfo = $sonos->GetMediaInfo();
	$GetTransportInfo = $sonos->GetTransportInfo();
	$GetTransportSettings = $sonos->GetTransportSettings();
	$GetCurrentPlaylist = $sonos->GetCurrentPlaylist();
	
	echo '<PRE>';
	echo '<br />GetPositionInfo:';
	print_r($GetPositionInfo);

	echo '<br />GetMediaInfo:';
	print_r ($GetMediaInfo); // Radio

	echo '<br />GetTransportInfo:';
	print_r ($GetTransportInfo);
	
	echo '<br />GetTransportSettings:';
	print_r ($GetTransportSettings);  
	
	echo '<br />GetCurrentPlaylist:';
	print_r ($GetCurrentPlaylist);
	echo '</PRE>';
}

 function logging_alt() // Nicht mehr in Nutzung
 { 
 	global $log, $config, $path;
	if($log == true) {
		$content = date("d.m.Y - H:i:s") . ' ' . $_SERVER['REQUEST_URI'] . "\r\n";
		$handle = fopen ($path."/".$config['logfile'], 'a');
		fwrite ($handle, $content);
		fclose ($handle);
		return;
	}
		echo "Logging ist derzeit ausgeschaltet. Bitte in der config.php aktivieren";
 }
 
 
 function logging()
 {
 global $master, $log, $path;
 if($log == true) {
	$format = "txt"; //Moeglichkeiten: csv und txt
 	$datum_zeit = date("d.m.Y H:i:s");
	$ip = $_SERVER["REMOTE_ADDR"];
	$site = $_SERVER['REQUEST_URI'];
	$browser = $master;
 
	$monate = array(1=>"Januar", 2=>"Februar", 3=>"Maerz", 4=>"April", 5=>"Mai", 6=>"Juni", 7=>"Juli", 8=>"August", 9=>"September", 10=>"Oktober", 11=>"November", 12=>"Dezember");
	$monat = date("n");
	$jahr = date("y");
 
	$dateiname=$path."/log_".$monate[$monat]."_$jahr.$format";
 	$header = array("Datum/Uhrzeit", "    Zone  ", "Syntax");
	$infos = array($datum_zeit, $master, $site);
 	if($format == "csv") {
		$eintrag= '"'.implode('", "', $infos).'"';
	} else { 
		$eintrag = implode("\t", $infos);
		}
 	$write_header = file_exists($dateiname);
 	$datei=fopen($dateiname,"a");
 	if(!$write_header) {
		if($format == "csv") {
			$header_line = '"'.implode('", "', $header).'"';
		} else {
			$header_line = implode("\t", $header);
		}
	fputs($datei, $header_line."\n");
	}
	fputs($datei,$eintrag."\n");
	fclose($datei);
	} else
		echo "Logging ist derzeit ausgeschaltet. Bitte in der config.php aktivieren";
 }
 

 function random() {
	// generiert eine Zufallszahl zwischen 90 und 99
	$zufallszahl = mt_rand(90,99); 
	return $zufallszahl;
 } 
 
 function _assertNumeric($number) {
	// prüft ob eine Eingabe numerisch ist
    if(!is_numeric($number)) {
        echo "Die Eingabe ist nicht numerisch. Bitte wiederholen" ;
    }
    return $number;
 }
 

function ping($host, $port) {
   $timeout = 20;
   $handle = @fsockopen($host = "udp://".$host, $port, $errno, $errstr, $timeout);
	if (!$handle) {
        return false;
        exit();
    } else {
        return true;
        fclose($handle);
	}
}


function File_Put_Array_As_JSON($FileName, $ar, $zip=false) {
	// erstellt eine JSON Datei aus einer Array
    if (! $zip) {
		return file_put_contents($FileName, json_encode($ar));
    } else {
		return file_put_contents($FileName, gzcompress(json_encode($ar)));
    }
}

function File_Get_Array_From_JSON($FileName, $zip=false) {
	// liest eine JSON Datei und erstellt eine Array
    if (! is_file($FileName)) 	{ die ("Fatal: Die Datei $FileName gibt es nicht."); }
	    if (! is_readable($FileName))	{ die ("Fatal: Die Datei $FileName ist nicht lesbar."); }
            if (! $zip) {
				return json_decode(file_get_contents($FileName), true);
            } else {
				return json_decode(gzuncompress(file_get_contents($FileName)), true);
	    }
}

 function loxdata() {
 	global $sonos, $loxuser, $loxpassword, $loxip, $master, $handle, $config;
	// prüft ob die Verbindung zu Loxone in der config eingeschaltet ist			
	if($config['LoxDaten'] === false) {
		die("Die Datenuebermittlung zu Loxone ist nicht aktiv. Bitte zuerst in der config.php aktivieren");
		exit;
	}	
	$GetVolume = $sonos->GetVolume();
	$GetTransportInfo = $sonos->GetTransportInfo();
	try {
		$handle = @fopen("http://$loxuser:$loxpassword@$loxip/dev/sps/io/S-Volume$master/$GetVolume", "r");
		$handle = @fopen("http://$loxuser:$loxpassword@$loxip/dev/sps/io/S-TransportInfo$master/$GetTransportInfo", "r");
	} catch (Exception $e) {
		echo "Die Verbindung zu Loxone konnte nicht initiiert werden!";
	}
}

 function SetGroupVolume($groupvolume) {
	global $sonos;
	$GroupVolume = $_GET['groupvolume'];
	$GroupVolume = $sonos->SetGroupVolume($GroupVolume);
 }

function SetRelativeGroupVolume($volume) {
	global $sonos;
	SnapshotGroupVolume();
	$RelativeGroupVolume = $_GET['groupvolume'];
	$RelativeGroupVolume = $sonos->SetRelativeGroupVolume($RelativeGroupVolume);
}

function SnapshotGroupVolume() {
	global $sonos;
	$SnapshotGroupVolume = $sonos->SnapshotGroupVolume();
	return $SnapshotGroupVolume;
}

 function SetGroupMute($mute) {
	global $sonos;
		$sonos->SetGroupMute($mute);
 }

#-- ab hier T2S Funktionen ------------------------------------------------------------------------------------------
	
function create_tts($text, $messageid) {
	global $sonos, $text, $member, $master, $zone, $messageid, $logging, $words, $voice, $accesskey, $secretkey, $rampsleep, $config, $save_status, $mute;
	global $fileolang, $fileo, $volume;
				
	# erlaubt das Abspielen einer Nachricht ohne messageid
	$messageid = !empty($_GET['messageid']) ? $_GET['messageid'] : '0';
	$messageid = _assertNumeric($messageid);
	$rampsleep = $config['rampto'];
					
	if(isset($_GET['weather'])) {
		# ruft die weather-to-speech Funktion auf
		include_once("w2s.php");
		$fileo = w2s($text);
		$words = substr($fileo, 0, 500); // Begrenzung des Textes auf 500 Zeichen
		$words = urlencode($fileo);
		} 
	elseif (isset($_GET['clock'])) {
		# ruft die clock-to-speech Funktion auf
		include_once("c2s.php");
		$fileo = c2s($text);
		$words = urlencode($fileo);
		}
	elseif (isset($_GET['sonos'])) {
		# ruft die sonos-to-speech Funktion auf
		include_once("s2s.php");
		$fileo = s2s($text);
		$words = urlencode($fileo);
		$rampsleep = false;
		}
	elseif (isset($_GET['garbage'])) {
		# ruft die garbage-to-speech Funktion auf
		include_once("g2s.php");
		$fileo = g2s($text);
		$words = urlencode($fileo);
		}
	elseif (($messageid == 0) && ($_GET['text'] == '')) {
		echo 'Die Eingabe ist ungueltig. Bitte den Text eingeben';
		exit();
		}
	elseif (is_numeric($messageid > 0)) { # && ($fileo != '')) {
		# spielt die angegebene Nachricht ab
		$fileo = $_GET['messageid'];
		}
	elseif (($messageid == 0) && ($text == '')) {
		# vorbereiten der TTS Nachricht an t2s
		$fileo = !empty($_GET['text']) ? $_GET['text'] : ''; 
		$words = substr($_GET['text'], 0, 500); // Begrenzung des Textes auf 500 Zeichen
		$words = urlencode($_GET['text']);				
		}	
	# Name der MP3 als MD5 Hash zum Speichern
	$fileo  = md5($words);
	$fileolang = "$fileo";
	# ruft die zur Verfügung stehenden T2S Engines auf (je nach config)					
	if (($messageid == '0') && ($fileo != '')) {
		if ($config['t2s_engine'] === 1001) {
			include_once("t2sv.php");
			}
		if ($config['t2s_engine'] === 3001) {
			include_once("t2sx.php");
			}
		if ($config['t2s_engine'] === 2001) {
			include_once("t2si.php");
			if(!isset($_GET['voice'])) {
				$voice = $config['voice'];	
			} elseif (($_GET['voice'] == 'Marlene') or ($_GET['voice'] == 'Hans')) {
				$voice = $_GET['voice'];
			}
		}
		t2s($messageid);
		return $messageid;
		}
	}
	


function creategroup($member,$groupvol = "0") {
	global $sonoszone, $master, $sonos, $config, $zonevolume, $save_status, $membermaster, $fvolume;
	
	$file = 'tmp_sz.json'; 
	$masterrincon = getRINCON($sonoszone[$master][0]); 
	$member = $_GET['member'];
	$member = explode(',', $member);
	// fügt den Master der existierenden Array hinzu
	array_push($member, $master);
	// erstellt Datei und fügt die Zonendaten hinzu
	foreach ($member as $player => $sz) {
		foreach ($member as $szone => $zone) {
			$sonos = new PHPSonos($sonoszone[$sz][0]); //Sonos IP Adresse
			$save_status[$sz]['Mute'] = $sonos->GetMute($zone);
			// falls Volume < 10 wird vor dem Gruppieren die Standardlautstärke aus der config.php geholt
			if($groupvol <> "1") {
				if($sonos->GetVolume($zone) < 10) {
					foreach ($member as $szone => $zone) {
						$sonos = new PHPSonos($sonoszone[$zone][0]); //Sonos IP Adresse
						$save_status[$sz]['Volume'] = $config['sonoszone'][$zone][2];
						$sonos->SetVolume($save_status[$sz]['Volume']);
					}
				}
			}
			$save_status[$sz]['Volume'] = $sonos->GetVolume($zone);
			$save_status[$sz]['MediaInfo'] = $sonos->GetMediaInfo($zone);
			$save_status[$sz]['PositionInfo'] = $sonos->GetPositionInfo($zone);
			$save_status[$sz]['TransportInfo'] = $sonos->GetTransportInfo($zone);
			$save_status[$sz]['TransportSettings'] = $sonos->GetTransportSettings($zone);
		}
	}
	// konvertiert Daten in JSON und speichert
	File_Put_Array_As_JSON($file, $save_status);
	$membermaster = $member;
	// löscht den Master aus der Array
	$members = array_pop($member);
	// Gruppieren der angegebenen Zonen
	foreach ($member as $zone) {
		$sonos = new PHPSonos($sonoszone[$zone][0]);
		$sonos->SetAVTransportURI("x-rincon:" . $masterrincon); 
	}
	return array($membermaster); // gibt member und master zurück
}
	
	
function removegroup($membermaster) {
	global $sonoszone, $path, $master, $sonos, $config, $zonevolume, $save_status, $results, $membermaster, $member;
	
	$file = 'tmp_sz.json'; 
	// Auflösen der Gruppe
	$member = $_GET['member'];
	$member = explode(',', $member);
	# prüft ob angegebene Zone Teil der Gruppe ist oder nicht
	foreach ($member as $splayer => $ip) {
		$sonos = new PHPSonos($sonoszone[$ip][0]); //Slave Sonos ZP IPAddress
		$temp = $sonos->GetPositionInfo($ip);
		if (substr($temp["TrackURI"], 0, 9) != "x-rincon:" ) {
			die("Die angegebene Zone ".($ip). " ist nicht Teil der Gruppe oder sie ist der Master der Gruppe und kann von daher nicht entfernt werden!");
			exit;
		}
	}
	// nimmt angegebene Zone(n) aus der Gruppe heraus
	foreach ($member as $zone) {
		$sonos = new PHPSonos($sonoszone[$zone][0]);
		$sonos->BecomeCoordinatorOfStandaloneGroup();
	}
	// Importiert die Daten mit den gespeicherten Einstellungen in eine Array
	$import = array();
	$import = File_Get_Array_From_JSON($file, $zip=false);
	if(empty($membermaster)) {
		$membermaster = $member;
	} else {
		$membermaster = $membermaster;
	}
	// Allgemeines Wiederherstellen der Ursprungszustände
	foreach($membermaster as $player => $zone) {
		$sonos = new PHPSonos($sonoszone[$zone][0]); //Sonos IP Adresse
		# zum Wiederherstellen es lief:
		# Playliste
		if (substr($import[$zone]['PositionInfo']["TrackURI"], 0, 5) == "npsdy" || substr($import[$zone]['PositionInfo']["TrackURI"], 0, 11) == "x-file-cifs" || substr($import[$zone]['PositionInfo']["TrackURI"], 0, 12) == "x-sonos-http") { // Es läuft eine Musikliste
			$sonos->SetTrack($import[$zone]['PositionInfo']['Track']);
			$sonos->Seek($import[$zone]['PositionInfo']['RelTime'],"NONE");
				if($import[$zone]['TransportSettings']['shuffle'] == 1) {
					$sonos->SetPlayMode('SHUFFLE_NOREPEAT'); // schaltet Zufallswiedergabe wieder ein 
				} else {
					$sonos->SetPlayMode('NORMAL'); // spielt im Normal Modus weiter
				}
			} 
			# TV Playbar
			elseif (substr($import[$zone]['PositionInfo']["TrackURI"], 0, 18) == "x-sonos-htastream:") {
				$sonos = new PHPSonos($sonoszone[$zone][0]); //Sonos IPAdresse
				$sonos->SetAVTransportURI($import[$zone]['PositionInfo']["TrackURI"]); 
			} 
			# Radio
			elseif (($import[$zone]['PositionInfo']["TrackDuration"] == '') && ($import[$zone]['PositionInfo']["title"] <> '')){
				$sonos = new PHPSonos($sonoszone[$zone][0]); //Sonos IPAdresse
				$sonos->SetRadio($import[$zone]['PositionInfo']["TrackURI"], $import[$zone]['MediaInfo']["title"]);
			}
		$sonos->SetVolume($import[$zone]['Volume']);
		$sonos->SetMute($import[$zone]['Mute']);
		if($import[$zone]['TransportInfo'] == 1) {
			$sonos->Play();
		}
	}
	#unlink($file); 
}	

	
function play_tts($messageid, $groupvol) {
	global $volume, $config, $sonos, $messageid, $save_status, $sonoszone, $master, $groupvol;
	// wenn Single T2S dann Volume und Mute setzten
	if($groupvol == "0") {
		$sonos->SetMute(false);
		$sonos->SetVolume($volume);
	}
	$mpath = $config['messagespath'];
	$sonos = new PHPSonos($sonoszone[$master][0]); //Sonos IP Adresse
	if(isset($_GET['playgong'])) {
		if(isset($_GET['playgong']) && ($_GET['playgong'] == "yes")) {
			$sonos->AddToQueue("x-file-cifs:" . $mpath . "/" . $config['file_gong'] . ".mp3");
		}
		if(isset($_GET['playgong']) && ($_GET['playgong'] == is_numeric($_GET['playgong']))) {
			$sonos->AddToQueue("x-file-cifs:" . $mpath . "/" . $_GET['playgong'] . ".mp3");	
		}
		if($groupvol == "1") {
			$save_status = $sonos->GetCurrentPlaylist();
			$message_pos = count($save_status);
		} else {
			$message_pos = count($save_status['CurrentPlaylist']) + 1;
		}
		$sonos->SetQueue("x-rincon-queue:" . getRINCON($sonoszone[$master][0]) . "#0"); //Playliste aktivieren
		$sonos->SetTrack($message_pos);
		$sonos->Play();   // Abspielen
		$abort = false;

		# Prüfen ob Meldung zu Ende gespielt ist
		sleep($config['sleeptimegong']); // warten gemäß config.php
		while ($sonos->GetTransportInfo()==1) {
		usleep(200000); // Alle 200ms wird abgefragt
		}
		# Message wieder aus Queue entfernen
		$sonos->RemoveFromQueue($message_pos); 
		}
		#-- Ende Jingle  ------------------------------------------------------------------------------------------
									
		#-- TTS Durchsage abspielen	--------------------------------------------------------------------------------
		$sonos = new PHPSonos($sonoszone[$master][0]); //Sonos IP Adresse
		$sonos->AddToQueue("x-file-cifs:" . $mpath . "/" . $messageid . ".mp3");
		
		if($groupvol == "1") {
			$save_status = $sonos->GetCurrentPlaylist();
			$message_pos = count($save_status);
		} else {
			$message_pos = count($save_status['CurrentPlaylist']) + 1;#['CurrentPlaylist']
		}
		$sonos->SetQueue("x-rincon-queue:" . getRINCON($sonoszone[$master][0]) . "#0"); //Playliste aktivieren
		$sonos->SetTrack($message_pos);
		$sonos->Play();   // Abspielen
		$abort = false;

		# Prüfen ob Meldung zu Ende gespielt ist
		sleep($config['sleeptimegong']); // warten gemäﬂ config.php
		while ($sonos->GetTransportInfo()==1) {
		usleep(200000); // Alle 200ms wird abgefragt
		}
		# Message wieder aus Queue entfernen
		$sonos->RemoveFromQueue($message_pos); 
		sleep($config['sleeptimegong']);   // Wartezeit bis alter Zustand wieder hergestellt wird
		
}


function save_current_status_single() {
	global $master, $config, $sonoszone, $sonos, $messageid, $rampsleep, $save_status;
	$save_status['MediaInfo'] = $sonos->GetMediaInfo();
	$save_status['PositionInfo'] = $sonos->GetPositionInfo();
	$save_status['Mute'] = $sonos->GetMute();
	$save_status['Volume'] = $sonos->GetVolume();
	$save_status['TransportInfo'] = $sonos->GetTransportInfo();
	$save_status['TransportSettings'] = $sonos->GetTransportSettings();
	$save_status['CurrentPlaylist'] = $sonos->GetCurrentPlaylist();
	if(($save_status['TransportInfo'] == 2) || ($save_status['TransportInfo'] == 3) || ($messageid == '100') || ($sonos->GetVolume() < 10)) {
		sleep('1');
	} else { 
	if($rampsleep === true) {
		$sonos->RampToVolume("SLEEP_TIMER_RAMP_TYPE", "0");
		sleep('10');
		}
	}
	if (($save_status['PositionInfo']["TrackDuration"] == '') || (substr($save_status['PositionInfo']["TrackURI"], 0, 18) == "x-sonos-htastream:"))  {  
		# zum Wiederherstellen es lief ein Radio Sender oder TV Playbar
		$sonos = new PHPSonos($sonoszone[$master][0]); //Sonos IP Adresse
		$sonos->SetQueue("x-rincon-queue:" . getRINCON($sonoszone[$master][0]) . "#0"); //Playliste aktivieren
	}
	# Wenn Playliste läuft erst den Playmodus auf Normal setzen
	if (substr($save_status['PositionInfo']["TrackURI"], 0, 5) == "npsdy" || substr($save_status['PositionInfo']["TrackURI"], 0, 11) == "x-file-cifs" || substr($save_status['PositionInfo']["TrackURI"], 0, 12) == "x-sonos-http") { // Es läuft eine Musikliste
		$sonos->SetPlayMode('NORMAL');
		}
	return ($save_status);
}


function restore_org_settings_single($save_status) {
	global $save_status, $sonos, $rampsleep;
	# Playliste
	if (substr($save_status['PositionInfo']["TrackURI"], 0, 5) == "npsdy" || substr($save_status['PositionInfo']["TrackURI"], 0, 11) == "x-file-cifs" || substr($save_status['PositionInfo']["TrackURI"], 0, 12) == "x-sonos-http") { // Es läuft eine Musikliste
		$sonos->SetTrack($save_status['PositionInfo']["Track"]);
		$sonos->Seek($save_status['PositionInfo']["RelTime"],"NONE");
		if($save_status['TransportSettings']['shuffle'] == 1) {
			$sonos->SetPlayMode('SHUFFLE_NOREPEAT'); // schaltet Zufallswiedergabe wieder ein 
		} else {
			$sonos->SetPlayMode('NORMAL'); // spielt im Normal Modus weiter
		}
	} 
		# TV Playbar
		elseif (substr($save_status['PositionInfo']["TrackURI"], 0, 18) == "x-sonos-htastream:") {
			$sonos->SetAVTransportURI($save_status['PositionInfo']["TrackURI"]); 
			} 
		# Radio
		elseif (($save_status['PositionInfo']["TrackDuration"] == '') && ($save_status['PositionInfo']["title"] <> '')){
			$sonos->SetRadio($save_status['PositionInfo']["TrackURI"], $save_status['MediaInfo']["title"]);
			}
		# und für alle Volume, Mute und Play
		$sonos->SetVolume($save_status['Volume']);
		$sonos->SetMute($save_status['Mute']);
		if ($save_status['TransportInfo'] == 1) {
			if ($rampsleep === true) {
				$sonos->RampToVolume("ALARM_RAMP_TYPE", $save_status['Volume']);	# alternativ AUTOPLAY_RAMP_TYPE
			} else {
				$sonos->SetVolume($save_status['Volume']);
			}
		$sonos->Play();	
	}
}


function groupplaylist() {
	Global $debug, $sonos, $master, $sonoszone, $config, $volume;
	if($debug == 1) {
		echo $sonoszone[$master][0] . "<br>";
		echo getRINCON($sonoszone[$master][0]) . "<br>";	
	}
	if(isset($_GET['playlist'])) {
		$sonos->SetQueue("x-rincon-queue:" . getRINCON($sonoszone[$master][0]) . "#0"); 
		$playlist = $_GET['playlist'];
	} else {
		die ("Keine Playliste mit dem angegebenen Namen gefunden.");
	}
	
	# Sonos Playlist ermitteln und mit übergebene vergleichen	
	$sonoslists=$sonos->GetSONOSPlaylists();
	$pleinzeln = 0;
	while ( $pleinzeln < count($sonoslists) ) {
		if($playlist == $sonoslists[$pleinzeln]["title"]) {
			$plfile = urldecode($sonoslists[$pleinzeln]["file"]);
			$sonos->ClearQueue();
			$sonos->AddToQueue($plfile); //Datei hinzufügen
			$sonos->SetQueue("x-rincon-queue:". getRINCON($sonoszone[$master][0]) ."#0"); 
			if($sonos->GetVolume() <= $config['volrampto'])	{
				$sonos->RampToVolume($config['rampto'], $volume);
				$sonos->Play();
			} else {
				$sonos->Play();
			}
				$gefunden = 1;
		}
		$pleinzeln++;
			if (($pleinzeln == count($sonoslists) ) && ($gefunden != 1)) {
				die("Keine Playliste mit dem angegebenen Namen gefunden.");
			}
		}			
}

function groupradioplaylist(){
	Global $debug, $sonos, $master, $sonoszone, $config, $volume;
			
	if(isset($_GET['playlist'])) {
        $playlist = $_GET['playlist'];
    } else {
		die ("Keine Radio Playlist gefunden.");
    }
    # Sonos Radio Playlist ermitteln und mit übergebene vergleichen   
    $radiolists = $sonos->Browse("R:0/0","c");
	$radioplaylist = urldecode($playlist);
	$rleinzeln = 0;
    while ($rleinzeln < count($radiolists)) {
	if ($radioplaylist == $radiolists[$rleinzeln]["title"]) {
			$sonos->SetRadio(urldecode($radiolists[$rleinzeln]["res"]));
            $sonos->SetVolume($volume);
            $sonos->Play();
    }
    $rleinzeln++;
	}   
}

		

?>