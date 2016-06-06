<?php

##############################################################################################################################
#
# Version: 	1.4.9
# Datum: 	03.06.2016
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
#						Desweiteren neue Parameter in der config.php:
#						stdvolume // Standardlautsäärke wenn nichts anderes mit angegeben wurde
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
#	
#
# bekannte Probleme:	derzeit keine
# 						
# geplante Funktionen: 	- Erstellen von Gruppen basierend auf Auswahl der Zonen
#						- mit anschließendem abspielen einer T2S und wiederherstellen des Ursprungszustandes
#
#
######## Script Code (ab hier bitte nichts ändern) ###################################

ini_set('max_execution_time', 90); // Max. Skriptlaufzeit auf 90 Sekunden

include("PHPSonos.inc.php");
include "config.php";

set_error_handler("customError");

$debug = $config['debuggen'];
if($debug == 1) { 
	echo "<pre><br>"; 
	# include ("mp3info.php"); 
	}
	
 #-- Prüfen ob das Verzeichnis 'log' vorhanden ist, falls nicht mit Rechte 0777 erstellen ---------------
 $path = "log";
 if (is_dir($path)) { 
 } else { 
 mkdir ($path, 0777); 
 } 
 
 #--  Übernahme von Variablen aus config.php  ------------------------------------------
$sonoszone = $config['sonoszone'];
$loxip = $config['LoxIP'];
$loxuser = $config['LoxUser'];
$loxpassword = $config['LoxPassword'];
$log = $config['logging'];


 #-- Error handling (erstellt error log datei)	
 function customError($errno, $errstr, $errfile, $errline, $errcontext){
 	global $path, $loxuser, $loxpassword, $loxip, $zonen;
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
 #-------------------------------------
 
if(isset($_GET['volume']) && is_numeric($_GET['volume']) && $_GET['volume'] >= 0 && $_GET['volume'] <= 100) {
	$volume = $_GET['volume'];
	} else {
	$volume = $config['stdvolume'];
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
	$zonen = $_GET['zone'];
	$sonos = new PHPSonos($sonoszone[$zonen]); //Sonos IPAdresse

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
			$sonos->SetQueue("x-rincon-queue:" . getRINCON($sonoszone[$zonen]) . "#0");
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
				$sonos->SetQueue("x-rincon-queue:" . getRINCON($sonoszone[$zonen]) . "#0");
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
		
		case 'creategroup':
			creategroup();
		break;
		
		case 'setbass':
			$Bass = $_GET['bass'];
			$sonos->SetBass($Bass);
		break;			

		
		case 'addmember':
			if ($debug == 1) {
				echo debug();
				echo "<pre>";
				echo "Member IP: " . $sonoszone[$_GET['member']] . "<br>";
				echo "Member RINCON: " . getRINCON($sonoszone[$_GET['member']]). "<br>";
				echo "</pre>";
			}
			if(isset($_GET['member'])) {
				$AddMember = $sonos->AddMember(getRINCON($sonoszone[$_GET['member']])); # Member Rincon
				$sonos = new PHPSonos($sonoszone[$_GET['member']]); //Slave Sonos ZP IPAddress
				$ret = $sonos->SetAVTransportURI("x-rincon:" . getRINCON($sonoszone[$zonen])); // Master Sonos ZP IPAddress
				logging();
			} else {
				die('Die angegebene Zone konnte nicht gefunden werden.');
			}
			if($debug==1) {			
				echo zonenmaster($_GET['member']);
			}
		  break;

		# Hinzugefügt (nicht getestet)
		case 'removemembernew':
		
			if(isset($_GET['member'])) {
				$sonos = new PHPSonos($sonoszone[$_GET['member']]);
				$MemberID = getRINCON($sonoszone[$_GET['member']]);
				echo "RinconID: " . $MemberID;
				$sonos->RemoveMember($MemberID);
			} else {
				die('Die Member-Zone konnte nicht gefunden werden.');
			}
		break;		

		case 'removemember':
			if(isset($_GET['member'])) {
				if($debug ==1) {
					echo "zonen: " . $zonen . "<br>";
					echo "member: " . $_GET['member'] . "<br>";
				}
				# wenn Member gleich Zone ist 
				if ($zonen == $_GET['member']) {
					die("Der Master kann sich nicht selber entfernen.");
				}
				# nachschauen ob die Zone überhaupt verbunden ist
				$master = zonenmaster($_GET['member']);
				
				if (isset($master)) {
				#	$RemoveMember = $sonos->RemoveMember(getRINCON($sonoszone[$_GET['member']])); # Member Rincon
					$sonos = new PHPSonos($sonoszone[$_GET['member']]); //Slave Sonos ZP IPAddress
					$sonos->SetAVTransportURI("");
					logging();
				} else {
					die("Der Player ist nicht mit dem Master verbunden.");
				}
			} else  {
				die('Die Zone konnte nicht gefunden werden.');
			}
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
			if($debug == 1) {
				echo $sonoszone[$zonen] . "<br>";
				echo getRINCON($sonoszone[$zonen]) . "<br>";	
			}
			if(isset($_GET['playlist'])) {
				$sonos->SetQueue("x-rincon-queue:" . getRINCON($sonoszone[$zonen]) . "#0"); 
				$playlist = $_GET['playlist'];
			} else {
			  die ("Keine Playliste mit dem angegebenen Namen gefunden.");
			}
		
		# Sonos Playlist ermitteln und mit übergebene vergleichen	
		$sonoslists=$sonos->GetSONOSPlaylists();
		$pleinzeln = 0;
		while ( $pleinzeln < count($sonoslists) ) {
			if ($debug == 1) {
					echo "Playlist " . $pleinzeln . "<br>\n\n";
					echo "ID: " . $sonoslists[$pleinzeln]["id"] . "<br>\n";
					echo "Titel: " . $sonoslists[$pleinzeln]["title"] . "<br>\n";
					echo "Typ: " . $sonoslists[$pleinzeln]["typ"] . "<br>\n";
					echo "File: " . $sonoslists[$pleinzeln]["file"] . "<br>\n";
					echo urldecode($sonoslists[$pleinzeln]["file"]) . "<br>\n";
					# echo "ausgewählte Liste: " . $liste . "<br>\n";
					echo "<br>\n";
				}
				if($playlist == $sonoslists[$pleinzeln]["title"]) {
					$plfile = urldecode($sonoslists[$pleinzeln]["file"]);
					$sonos->ClearQueue();
					$sonos->AddToQueue($plfile); //Datei hinzufügen
					$sonos->SetQueue("x-rincon-queue:". getRINCON($sonoszone[$zonen]) ."#0"); 
					if($sonos->GetVolume() <= $config['volrampto'])
				{
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
		  break;

		case 'radioplaylist':
			logging();
			if(isset($_GET['playlist'])) {
				$playlist = $_GET['playlist'];
			} else {
				die ("Playlist (Radioname) wude vergessen mit anzugeben.");
			}
			$GetCurrentPlaylist = $sonos->GetCurrentPlaylist();
			# Debug Info
			if ($debug == 1) {
				echo "Anzahl:  " . count($GetCurrentPlaylist) . "<br>";
				echo "Transport: " . $sonos->GetTransportInfo() . "<br>";
			}
			$radiolists = $sonos->Browse("R:0/0","c");
			$rleinzeln = 0;
			while ( $rleinzeln < count($radiolists) ) {
			if ($debug == 1) {
				echo "Radioliste " . $rleinzeln . "<br>\n\n";
				echo "ID: " . $radiolists[$rleinzeln]["id"] . "<br>\n";
				echo "Titel: " . $radiolists[$rleinzeln]["title"] . "<br>\n";
				echo "Typ: " . $radiolists[$rleinzeln]["typ"] . "<br>\n";
				echo "File: " . $radiolists[$rleinzeln]["res"] . "<br>\n";
				echo urldecode($radiolists[$rleinzeln]["res"]) . "<br>\n";
				echo "ausgewählter Radiosender: >" .  urldecode($playlist) . "<<br>\n";
				echo "<br>\n";
			}
			$gefunden = false;
			$radio = urldecode($playlist);
			$sender = $radiolists[$rleinzeln]["title"];
			if ($radio == $sender) {
				$sonos->SetRadio(urldecode($radiolists[$rleinzeln]["res"]));
					if($sonos->GetVolume() <= $config['volrampto'])	{
						$sonos->RampToVolume($config['rampto'], $volume);
						$sonos->Play();
					} else {
						$sonos->Play();
					}
				$gefunden = true;
				}
				$rleinzeln++;
			}
			if($gefunden == false) {
				die("Der Sender wurde nicht in den Sonos-Favoriten gefunden.");
			}
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
						<a href="'.$_SERVER['SCRIPT_NAME'].'?zonen='.$zonen.'&action=previous" target="_blank">Zurück</a>
						<a href="'.$_SERVER['SCRIPT_NAME'].'?zonen='.$zonen.'&action=play" target="_blank">Abspielen</a>
						<a href="'.$_SERVER['SCRIPT_NAME'].'?zonen='.$zonen.'&action=pause" target="_blank">Pause</a>
						<a href="'.$_SERVER['SCRIPT_NAME'].'?zonen='.$zonen.'&action=stop" target="_blank">Stop</a>
						<a href="'.$_SERVER['SCRIPT_NAME'].'?zonen='.$zonen.'&action=next" target="_blank">Nächster</a>
					</table>
				';
			break;
		
		case 'sendmessagenew':
			# create_tts();
			global $text, $zonen, $messageid, $logging, $words, $voice, $accesskey, $secretkey, $rampsleep, $config, $save_status;
			if(isset($_GET['volume']) && is_numeric($_GET['volume']) && $_GET['volume'] >= 0 && $_GET['volume'] <= 100) {
				$volume = $_GET['volume'];
			} else 	{
			$volume = $config['messagevolume'];	
			}
					
			# erlaubt das Abspielen einer Nachricht ohne messageid
			$messageid = !empty($_GET['messageid']) ? $_GET['messageid'] : '0';
			$messageid = _assertNumeric($messageid);
			$rampsleep = $config['rampsto'];
			# logging();
						
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
								
			if (($messageid == '0') && ($fileo != '')) {
				if ($config['t2s_engine'] === 1001) {
					include_once("t2sv.php");
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
				print_r ($messageid);
				}
			
			save_current_status();
			play_tts($messageid);
			restore_org_settings($save_status);
			
		break;
		
		case 'sendmessage':
			global $text, $zonen, $messageid, $logging, $words, $voice, $accesskey, $secretkey, $rampsleep, $config;
			$Beginn = microtime(true);  // START 
			
			
			if(isset($_GET['volume']) && is_numeric($_GET['volume']) && $_GET['volume'] >= 0 && $_GET['volume'] <= 100) {
					$volume = $_GET['volume'];
				} else 	{
					$volume = $config['messagevolume'];	
				}
			
			# erlaubt das Abspielen einer Nachricht ohne messageid
			$messageid = !empty($_GET['messageid']) ? $_GET['messageid'] : '0';
			$messageid = _assertNumeric($messageid);
			$rampsleep = $config['rampto'];
			logging();
				
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
						
			if (($messageid == '0') && ($fileo != '')) {
				if ($config['t2s_engine'] === 1001) {
					include_once("t2sv.php");
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
			}
					
					#-- Ab hier Einstellungen speichern  -------------------------------------------------------------------
					$save_MediaInfo = $sonos->GetMediaInfo();
					$save_PositionInfo = $sonos->GetPositionInfo();
					$save_Mute = $sonos->GetMute();
					$save_Vol = $sonos->GetVolume();
					$save_Status = $sonos->GetTransportInfo();
					$save_TransportSettings = $sonos->GetTransportSettings();
					$save_GetCurrentPlaylist = $sonos->GetCurrentPlaylist();
					if(($save_Status == 2) || ($save_Status == 3) || ($messageid == '100') || ($sonos->GetVolume() < 10)) {
						sleep('1');
					} else { 
						if($rampsleep === true) {
							$sonos->RampToVolume("SLEEP_TIMER_RAMP_TYPE", "0");
							sleep('10');
						}
					}
						if (($save_PositionInfo["TrackDuration"] == '') || (substr($save_PositionInfo["TrackURI"], 0, 18) == "x-sonos-htastream:"))  {  
							# zum Wiederherstellen es lief ein Radio Sender oder TV Playbar
							$sonos->SetQueue("x-rincon-queue:" . getRINCON($sonoszone[$zonen]) . "#0"); //Playliste aktivieren
						}
						# Wenn Playliste läuft erst den Playmodus auf Normal setzen
						if (substr($save_PositionInfo["TrackURI"], 0, 5) == "npsdy" || substr($save_PositionInfo["TrackURI"], 0, 11) == "x-file-cifs" || substr($save_PositionInfo["TrackURI"], 0, 12) == "x-sonos-http") { // Es läuft eine Musikliste
							$sonos->SetPlayMode('NORMAL');
						}
					#-- Speichern Ende  ---------------------------------------------------------------------------------
						
					#-- Abspielen eines Jingles vor der Durchsage -------------------------------------------------------
						$mpath = $config['messagespath'];
						$sonos->SetMute(false);
						$sonos->SetVolume($volume);
						if(isset($_GET['playgong'])) {
							if(isset($_GET['playgong']) && ($_GET['playgong'] == "yes")) {
								$sonos->AddToQueue("x-file-cifs:" . $mpath . "/" . $config['file_gong'] . ".mp3");
								}
								if(isset($_GET['playgong']) && ($_GET['playgong'] == is_numeric($_GET['playgong']))) {
									$sonos->AddToQueue("x-file-cifs:" . $mpath . "/" . $_GET['playgong'] . ".mp3");	
								}
					            $message_pos = count($save_GetCurrentPlaylist) + 1;
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
						$sonos->AddToQueue("x-file-cifs:" . $mpath . "/" . $messageid . ".mp3");
						$message_pos = count($save_GetCurrentPlaylist) + 1;
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
					#-- Ende TTS Durchsage -----------------------------------------------------------
						
					#-- alten Zustand wiederherstellen----------------------------------------------
						# Playliste
						if (substr($save_PositionInfo["TrackURI"], 0, 5) == "npsdy" || substr($save_PositionInfo["TrackURI"], 0, 11) == "x-file-cifs" || substr($save_PositionInfo["TrackURI"], 0, 12) == "x-sonos-http") { // Es läuft eine Musikliste
							$sonos->SetTrack($save_PositionInfo["Track"]);
							$sonos->Seek($save_PositionInfo["RelTime"],"NONE");
							if($save_TransportSettings['shuffle'] == 1) {
								$sonos->SetPlayMode('SHUFFLE_NOREPEAT'); // schaltet Zufallswiedergabe wieder ein 
							} else {
								$sonos->SetPlayMode('NORMAL'); // spielt im Normal Modus weiter
							}
						} 
						# TV Playbar
						elseif (substr($save_PositionInfo["TrackURI"], 0, 18) == "x-sonos-htastream:") {
							$sonos->SetAVTransportURI($save_PositionInfo["TrackURI"]); 
				        } 
						# Radio
						elseif (($save_PositionInfo["TrackDuration"] == '') && ($save_PositionInfo["title"] <> '')){
						$sonos->SetRadio($save_PositionInfo["TrackURI"], $save_MediaInfo["title"]);
						}
						# und für alle Volume, Mute und Play
						$sonos->SetVolume($save_Vol);
						$sonos->SetMute($save_Mute);
						if ($save_Status == 1) {
							if ($rampsleep === true) {
								$sonos->RampToVolume("ALARM_RAMP_TYPE", $save_Vol);	# alternativ AUTOPLAY_RAMP_TYPE
							} else {
							$sonos->SetVolume($save_Vol);
							}
							$sonos->Play();	
						}
						
					#-- Ende wiederherstellen ------------------------------------------------------
				#else {
				#	die ("Keine Nachricht, keine Lautstaerke angegeben oder falsche Werte angegeben.");
			#}
		$Dauer = microtime(true) - $Beginn;  // ENDE 
		if($debug == 1) {
			echo "Runtime aus sonos2.php: Zwischen START und ENDE des Skripts sind ".round($Dauer, 2)." Sekunden vergangen"; 
		}
    break;
	
		
	case 'group':
		logging();
		# Zonen zusamenfügen
		$masterrincon = getRINCON($sonoszone[$zonen]);
		#$sonos->SetVolume($volume);
					
		foreach ($sonoszone as $zone => $ip) {
			if($zone != $_GET['zone']) {
				$sonos = new PHPSonos($ip); 
				# Ab hier hinzugefügt (speichert den Status aller Zonen)
				#$save_MediaInfo_[$zone] = $sonos->GetMediaInfo();
				$save_PositionInfo = $sonos->GetPositionInfo();
				#$save_Mute = $sonos->GetMute();
				$save_Vol = $sonos->GetVolume();
				#$save_Status_[$zone] = $sonos->GetTransportInfo();
				#$save_TransportSettings_[$zone] = $sonos->GetTransportSettings();
				#$save_GetCurrentPlaylist_[$zone] = $sonos->GetCurrentPlaylist();
				# Ende
				#$sonos->SetVolume($volume);
				$sonos->SetAVTransportURI("x-rincon:" . $masterrincon); 
			}
		}
	break;
		
	case 'ungroup':
		global $save_Vol, $save_TransportSettings, $save_Mute;
		logging();
		foreach($sonoszone as $zonen => $ip) {
			$sonos = new PHPSonos($sonoszone[$zonen]); //Sonos IPAdresse
			$sonos->SetQueue("x-rincon-queue:" . getRINCON($sonoszone[$zonen]) . "#0");
			$sonos->SetVolume($save_Vol);
			$sonos->SetMute($save_Mute);
			if($save_TransportSettings == 1) {
				$sonos->Play();	
			}
		}
	break;
	


	case 'groupalarm': // Speichert je Zone (IP Adresse) den Mute Status und die Lautstärke

	foreach ($sonoszone as $player => $ip) {
		$sonos = new PHPSonos($ip);
		$save_Mute = $sonos->GetMute($ip);
		$save_Vol = $sonos->GetVolume($ip);
		$save_TransportSettings = $sonos->GetTransportSettings($ip);
	}
		$masterrincon = getRINCON($sonoszone[$zonen]); 
		foreach ($sonoszone as $zone => $ip) {
			if($zone != $_GET['zone']) {
				$sonos = new PHPSonos($ip); 
				$sonos->SetAVTransportURI("x-rincon:" . $masterrincon); 
			}
		}
		foreach ($sonoszone as $player => $ip) {
			$sonos->SetVolume($save_Vol);
			$sonos->SetMute($save_Mute);
			if($save_TransportSettings == 1) {
				$sonos->Play();	
			}
		}
	return $sonoszone;# ($save_Vol, save_Mute);
	break;
	
	case 'groupalarmvol': // Speichert je Zone (IP Adresse) den Mute Status und die Lautstärke
	
	$save_Volt2s = $_GET['volume'];
	foreach ($sonoszone as $player => $ip) {
		$sonos = new PHPSonos($ip);
		$save_Mute = $sonos->GetMute($ip);
		$save_Vol = $sonos->GetVolume($ip);
	}
		$masterrincon = getRINCON($sonoszone[$zonen]); 
		foreach ($sonoszone as $zone => $ip) {
			if($zone != $_GET['zone']) {
				$sonos = new PHPSonos($ip); 
				$sonos->SetAVTransportURI("x-rincon:" . $masterrincon); 
			}
		}
		foreach ($sonoszone as $player => $ip) {
			$sonos->SetVolume($save_Volt2s);
			$sonos->SetMute($save_Mute);
			#$recover = array($ip => $save_Vol);
			#var_dump($recover);
			if($debug ==1 ) {
			echo "Volume fuer Zone ".$player.': '.$save_Volt2s."<br/>";
			"<br/>";
			echo "Volume vorher fuer Zone ".$player.': '.$save_Vol."<br/>";
			}
		}
		#print_r ($save_Volt2s);
	return $sonoszone;# ($save_Vol, save_Mute);
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
			$handle = fopen("http://$loxuser:$loxpassword@$loxip/dev/sps/io/S-Titel$zonen/$valueurl", "r"); // Titel- und Interpretinfo für Loxone
			$handle = fopen("http://$loxuser:$loxpassword@$loxip/dev/sps/io/S-Titelinfo$zonen/$valuesplit[0]", "r"); // Nur Titelinfo für Loxone
			$handle = fopen("http://$loxuser:$loxpassword@$loxip/dev/sps/io/S-Interpretinfo$zonen/$valuesplit[1]", "r"); // Nur Interpreteninfo für Loxone
			echo '<PRE>';
 
		break;	
		
				

		case 'loxgettransportinfo':

		if($config['LoxDaten'] === true) {
     			$GetTransportInfo = $sonos->GetTransportInfo();
	  			echo '<PRE>';
		     	print_r($GetTransportInfo);
				$handle = fopen("http://$loxuser:$loxpassword@$loxip/dev/sps/io/S-TransportInfo$zonen/$GetTransportInfo", "r");
		     	echo '</PRE>';
			} else
			{ echo "Die Datenuebermittlung zu Loxone ist nicht aktiv. Bitte in der config.php aktivieren"; }
      	break; 
		

		case 'loxgetmute':
			
			if($config['LoxDaten'] === true) {
   				$GetMute = $sonos->GetMute();
	  			echo '<PRE>';
	     		print_r($GetMute);
				$handle = fopen("http://$loxuser:$loxpassword@$loxip/dev/sps/io/S-Mute$zonen/$GetMute", "r");
	     		echo '</PRE>';
			} else { 
				echo "Die Datenuebermittlung zu Loxone ist nicht aktiv. Bitte in der config.php aktivieren";}
      	break; 
		

		case 'loxgetvolume':
			
			if($config['LoxDaten'] === true) {
   				$GetVolume = $sonos->GetVolume();
	  			echo '<PRE>';
	     		print_r($GetVolume);
				$handle = fopen("http://$loxuser:$loxpassword@$loxip/dev/sps/io/S-Volume$zonen/$GetVolume", "r");
	     		echo '</PRE>';
			} else { 
				echo "Die Datenuebermittlung zu Loxone ist nicht aktiv. Bitte in der config.php aktivieren"; }
      	break; 
		



					
		
	
	# Debug Bereich ------------------------------------------------------

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
		
			foreach ($sonoszone as $player => $ip) {

				$sonos = new PHPSonos($ip); //Slave Sonos ZP IPAddress
				$temp = $sonos->GetPositionInfo();

				if (substr($temp["TrackURI"], 0, 9) == "x-rincon:" ) {
					$masterrincon = substr($temp["TrackURI"], 9 ,24);
					}
				
				foreach ($sonoszone as $masterplayer => $ip) {
					# hinzugefügt am 18.01 weil Fehler bei Gruppierung auflösen
					$masterrincon = substr($temp["TrackURI"], 9, 24);
					if(getRINCON($ip) == $masterrincon) {
						echo "<br>" . $player . " -> ";
						echo "Master des Players: " . $masterplayer;
					}
				}
				$masterrincon = "";
			}
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
			#echo "Mute Mode fuer die Gruppe ist: " . $GetGroupMute;
		
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
			$GroupVolume = $_GET['volume'];
			$GroupVolume = $sonos->SetGroupVolume($volume);
								
		break;
		
		case 'setrelativegroupvolume':
			SnapshotGroupVolume();
			$RelativeGroupVolume = $_GET['volume'];
			$RelativeGroupVolume = $sonos->SetRelativeGroupVolume($volume);
								
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
			
		case 'getaudioinputattributes':	
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
		
		case 'subscribezpgroupmanagement':
			echo '<PRE>';
					print_r($sonos->SubscribeZPGroupManagement($callback));
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
		
		case 'getinvisible':
			echo '<PRE>';
					print_r($sonos->GetInvisible());
			echo '</PRE>';
		
		break;
				
		
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
			echo "Technische Details der ausgewaehlten Zone: " . $zonen;
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

 function getRINCON($zoneplayerIp) {
  $url = "http://" . $zoneplayerIp . ":1400/status/zp";
  $xml = simpleXML_load_file($url);
  $uid = $xml->ZPInfo->LocalUID;
  return $uid;  
  return $playerIP;
 }


 function zonenmaster($member) {
		global $sonos, $sonoszone;
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
				#	echo "<br>" . $player . " -> ";
				#	echo "Master des Players: " . $masterplayer;
					return  $masterplayer;				
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

 function logging_alt() 
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
 global $zonen, $log, $path;
 if($log == true) {
	$format = "txt"; //Moeglichkeiten: csv und txt
 	$datum_zeit = date("d.m.Y H:i:s");
	$ip = $_SERVER["REMOTE_ADDR"];
	$site = $_SERVER['REQUEST_URI'];
	$browser = $zonen;
 
	$monate = array(1=>"Januar", 2=>"Februar", 3=>"Maerz", 4=>"April", 5=>"Mai", 6=>"Juni", 7=>"Juli", 8=>"August", 9=>"September", 10=>"Oktober", 11=>"November", 12=>"Dezember");
	$monat = date("n");
	$jahr = date("y");
 
	$dateiname=$path."/log_".$monate[$monat]."_$jahr.$format";
 	$header = array("Datum/Uhrzeit", "    Zone  ", "Syntax");
	$infos = array($datum_zeit, $zonen, $site);
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
	$zufallszahl = mt_rand(90,99); // generiert eine Zufallszahl zwischen 90 und 99
	return $zufallszahl;
 } 
 
 function _assertNumeric($number) {
        if(!is_numeric($number)) {
            echo "Die Eingabe ist nicht numerisch. Bitte wiederholen" ;
        }
        return $number;
}

 function networkstatus() {
	global $sonoszone, $zonen, $config, $debug;
	$Server = $config['sonoszone'];
		foreach($sonoszone as $zonen => $ip) {
		if (!$socket = @fsockopen($ip, 1400, $errno, $errstr, 30)) {
			#if($debug == 1) {
				echo "Zone ".$zonen.": ".$ip." -=> Offline :-( <br/>"; 
			} else { 
				echo "Zone ".$zonen.": ".$ip." -=> Online :-) <br/>";
			#}
			fclose($socket); 
		}
	}
}

 function loxdata() {
 	global $sonos, $loxuser, $loxpassword, $loxip, $zonen, $handle, $config;
	# prüft ob die Verbindung zu Loxone in der config eingeschaltet ist			
	if($config['LoxDaten'] === false) {
		echo "Die Datenuebermittlung zu Loxone ist nicht aktiv. Bitte zuerst in der config.php aktivieren"; 
		exit;
	}	
	$GetVolume = $sonos->GetVolume();
	$GetTransportInfo = $sonos->GetTransportInfo();
	try {
		$handle = @fopen("http://$loxuser:$loxpassword@$loxip/dev/sps/io/S-Volume$zonen/$GetVolume", "r");
		$handle = @fopen("http://$loxuser:$loxpassword@$loxip/dev/sps/io/S-TransportInfo$zonen/$GetTransportInfo", "r");
	} catch (Exception $e) {
		echo "Die Verbindung zu Loxone konnte nicht initiiert werden!";
	}
}
function SnapshotGroupVolume() {
	global $sonos;
		$SnapshotGroupVolume = $sonos->SnapshotGroupVolume();
	return $SnapshotGroupVolume;
}


function creategroup() {
	global $sonoszone, $zonen, $config, $sonos;
	$members = $_GET['members'];
	$members = explode(",", $members); 
    print_r($members);
	#exit;
	$i=0;
	#foreach ($sonoszone as $members) { 
    #    $ResultVal = SearchArray($members, 0, $sonoszone); 
    #    $SonosGroup[$i] = array($SonosGroup[$ResultVal][0],$SonosGroup[$ResultVal][1],$SonosGroup[$ResultVal][2],$SonosGroup[$ResultVal][3]); 
    #    $i++; 
    #} 
	$AnzahlPlayer = count($members);
	for ($i=0; $i < $AnzahlPlayer; $i++) { 
		$AddMember = $sonos->AddMember(getRINCON($sonoszone[$members])); # Member Rincon
		$sonos = new PHPSonos($sonoszone[$members]); //Slave Sonos ZP IPAddress
		$ret = $sonos->SetAVTransportURI("x-rincon:" . getRINCON($sonoszone[$zonen])); // Master Sonos ZP IPAddress
    } 
}

function SearchArray($value, $key, $array) { 
   foreach ($array as $k => $val) { 
       if ($val[$key] == $value) { 
            return $k; 
        } 
   } 
    return NULL; 
} 

function create_tts() {

global $text, $zonen, $messageid, $logging, $words, $voice, $accesskey, $secretkey, $rampsleep, $config;
	if(isset($_GET['volume']) && is_numeric($_GET['volume']) && $_GET['volume'] >= 0 && $_GET['volume'] <= 100) {
		$volume = $_GET['volume'];
	} else 	{
	$volume = $config['messagevolume'];	
	}
			
	# erlaubt das Abspielen einer Nachricht ohne messageid
	$messageid = !empty($_GET['messageid']) ? $_GET['messageid'] : '0';
	$messageid = _assertNumeric($messageid);
	$rampsleep = $config['rampto'];
	# logging();
				
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
						
	if (($messageid == '0') && ($fileo != '')) {
		if ($config['t2s_engine'] === 1001) {
			include_once("t2sv.php");
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
	

function save_current_status() {
	global $zonen, $config, $sonoszone, $sonos, $messageid, $rampsleep, $save_status;
	$save_status[1] = $sonos->GetMediaInfo();
	$save_status[2] = $sonos->GetPositionInfo();
	$save_status[3] = $sonos->GetMute();
	$save_status[4] = $sonos->GetVolume();
	$save_status[5] = $sonos->GetTransportInfo();
	$save_status[6] = $sonos->GetTransportSettings();
	$save_status[7] = $sonos->GetCurrentPlaylist();
	if(($save_status[5] == 2) || ($save_status[5] == 3) || ($messageid == '100') || ($sonos->GetVolume() < 10)) {
		sleep('1');
	} else { 
	if($rampsleep === true) {
		$sonos->RampToVolume("SLEEP_TIMER_RAMP_TYPE", "0");
		sleep('10');
		}
	}
	if (($save_status[2]["TrackDuration"] == '') || (substr($save_status[2]["TrackURI"], 0, 18) == "x-sonos-htastream:"))  {  
		# zum Wiederherstellen es lief ein Radio Sender oder TV Playbar
		$sonos->SetQueue("x-rincon-queue:" . getRINCON($sonoszone[$zonen]) . "#0"); //Playliste aktivieren
	}
	# Wenn Playliste läuft erst den Playmodus auf Normal setzen
	if (substr($save_status[2]["TrackURI"], 0, 5) == "npsdy" || substr($save_status[2]["TrackURI"], 0, 11) == "x-file-cifs" || substr($save_status[2]["TrackURI"], 0, 12) == "x-sonos-http") { // Es läuft eine Musikliste
		$sonos->SetPlayMode('NORMAL');
		}
	# return ($save_MediaInfo, $save_PositionInfo, $save_Mute, $save_Vol, $save_Status, $save_TransportSettings, $save_CurrentPlaylist);
	#$var = array($save_MediaInfo, $save_PositionInfo, $save_Mute, $save_Vol, $save_Status, $save_TransportSettings);
	return ($save_status);
	}
	
function play_tts($messageid) {
	global $volume, $config, $sonos, $messageid, $save_status;
	$mpath = $config['messagespath'];
	$sonos->SetMute(false);
	$sonos->SetVolume($volume);
	if(isset($_GET['playgong'])) {
		if(isset($_GET['playgong']) && ($_GET['playgong'] == "yes")) {
			$sonos->AddToQueue("x-file-cifs:" . $mpath . "/" . $config['file_gong'] . ".mp3");
		}
		if(isset($_GET['playgong']) && ($_GET['playgong'] == is_numeric($_GET['playgong']))) {
			$sonos->AddToQueue("x-file-cifs:" . $mpath . "/" . $_GET['playgong'] . ".mp3");	
		}
		$message_pos = count($save_status[7]) + 1;
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
		$sonos->AddToQueue("x-file-cifs:" . $mpath . "/" . $messageid . ".mp3");
		$message_pos = count($save_status[7]) + 1;
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


function restore_org_settings($save_status) {
	global $save_status, $sonos, $rampsleep;
	# Playliste
	if (substr($save_status[2]["TrackURI"], 0, 5) == "npsdy" || substr($save_status[2]["TrackURI"], 0, 11) == "x-file-cifs" || substr($save_status[2]["TrackURI"], 0, 12) == "x-sonos-http") { // Es läuft eine Musikliste
		$sonos->SetTrack($save_status[2]["Track"]);
		$sonos->Seek($save_status[2]["RelTime"],"NONE");
		if($save_status[6]['shuffle'] == 1) {
			$sonos->SetPlayMode('SHUFFLE_NOREPEAT'); // schaltet Zufallswiedergabe wieder ein 
		} else {
			$sonos->SetPlayMode('NORMAL'); // spielt im Normal Modus weiter
		}
	} 
		# TV Playbar
		elseif (substr($save_status[2]["TrackURI"], 0, 18) == "x-sonos-htastream:") {
			$sonos->SetAVTransportURI($save_status[2]["TrackURI"]); 
			} 
		# Radio
		elseif (($save_status[2]["TrackDuration"] == '') && ($save_status[2]["title"] <> '')){
			$sonos->SetRadio($save_status[2]["TrackURI"], $save_status[1]["title"]);
			}
		# und für alle Volume, Mute und Play
		$sonos->SetVolume($save_status[4]);
		$sonos->SetMute($save_status[3]);
		if ($save_status[5] == 1) {
			if ($rampsleep === true) {
				$sonos->RampToVolume("ALARM_RAMP_TYPE", $save_status[4]);	# alternativ AUTOPLAY_RAMP_TYPE
			} else {
				$sonos->SetVolume($save_status[4]);
			}
		$sonos->Play();	
		}
	}

	


?>