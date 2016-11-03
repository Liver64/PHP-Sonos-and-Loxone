<?php

##############################################################################################################################
#
# Version: 		1.2.2
# Datum: 		10.10.2016
# veröffentlicht in forum: https://www.loxforum.com/
# 
# Historie:
# ----------------------------------------------------------------------------------------------------------------------------
# 1.0.0		Veröffentlichung des Skripts
# 1.1.0		Neue Parameter hinzugefügt
# 1.1.2		Minimum Lautstärke ab wann automatisch rampTo ausgeführt wird
# 1.1.3		Neue Parameter für weather-to-speech (w2s) und clock-to-speech (c2s)
# 1.1.4		Parameter für Mac OS X TTS Engine ergänzt
# 1.1.5		Neuer Parameter für die Wartezeit in Sekunden bei sendgroupmessage bevor der Gruppenmute vor T2S aufgehoben wird.
#			Default Lautstärke Parameter für T2S und Sonos je Zone hinzugefügt (siehe sonoszone)
# 1.2.0		Neuer Paramter 'MP3path' als Speicherort für MP3 files die über 'messageid' abgerufen werden
# 1.2.1		Parameter mit Aufbewahrungszeitraum der vom T2S Provider gespeicherten MP3 Dateien zur automatischen Löschung (Zeile 112) 
# 1.2.2		Parameter für T2S Engines zusammengefasst und optimiert
#
#
# bekannte Probleme: derzeit keine
# 

$config = array(
	# Hier werden die einzelnen Sonos Zonen gepflegt (ACHTUNG: kleingeschreibung)
	# die Aufschlüsselung ist wie folgt: 'Zone' => array('IP Adresse','Standardvolume für T2S Ansagen','Standardvolume für Sonos')
	'sonoszonen' => array(
				'bad'      	=> array('192.168.50.24','30','30'),
				'master'   	=> array('192.168.50.57','25','20'), // Küche
				'buero'   	=> array('192.168.50.31','35','25')
				),

	# Hier können eigene Radio Sender definiert werden, welche bei 'nextradio' oder 'prevradio' angesteuert werden
	# 
	# An der Stelle kommt nur der Stationsname rein.
	'radio_name' => array ( "Radio FFH",
				"SWR3",
				"You FM",
				"P4 Norge",
				"FM Jammin 181",
				"1 Live"
				),
					  
	# und hier die URL zum Stationsnamen.
	'radio_adresse' => array ("x-rincon-mp3radio://ndr-ndr1-han-mp3.akacast.akamaistream.net/7/807/273766/v1/gnl.akacast.akamaistream.net/ndr_ndr1_han_mp3",
				"x-rincon-mp3radio://swr-mp3-m-swr3.akacast.akamaistream.net/7/720/137136/v1/gnl.akacast.akamaistream.net/swr-mp3-m-swr3",
				"x-rincon-mp3radio://hr-mp3-m-youfm.akacast.akamaistream.net/7/246/142136/v1/gnl.akacast.akamaistream.net/hr-mp3-m-youfm",
				"aac://mms-live.online.no/p4_norge",
				"x-rincon-mp3radio://relay3.181.fm:14042",
				"x-rincon-mp3radio://1live-diggi.akacast.akamaistream.net/7/965/119435/v1/gnl.akacast.akamaistream.net/1live-diggi"
				),
	
	####################################################################################################
	# Angabe welche TTS Engine benutzt werden soll:
	#----------------------------------------------
	#-- für VoiceRSS.org die '1001'
	#-- für IVONA.com die '2001'
	#-- für die OS X TTS-Engine die '3001'
	#   eingeben.
	't2s_engine'	=> 2001,
	####################################################################################################			
	
	####################################################################################################
	# Text-to-Speech Parameter (Ivona oder VoiceRSS)
	#---------------------------------------------------------------------------------------------------
	#'API-key'  => 'xxxxx', 		// VoiceRSS
	'API-key' => 'xxx', 					// Ivona
	# Secret Key eingeben (nur Ivona)
	'secret-key'  => 'xxxx',
	# Sprache für die Ausgabe (in kleinbuchstaben)
    'messageLang'    => 'de',
	# Standardstimme für T2s (nur Ivona)
	'voice'    => 'Hans', // 'Marlene' oder 'Hans'
	# Qualitätsstufe der MP3 Datei festlegen (nur VoiceRSS)
	'audiocodec'    => '48khz_16bit_stereo', # <-- default der funktioniert
	####################################################################################################
	
	####################################################################################################
	# Text-to-Speech Parameter für Mac OS X
	#---------------------------------------------------------------------------------------------------
	# Pfad zum LAME MP3 Encoder
	'lamePath'	=>	'/usr/local/bin/',
	####################################################################################################
	
	# Pfad zu deinem Speichermedium in deinem NETZWERK von dem Sonos die Nachrichen abruft und abspielt
	# beide Pfade MÜSSEN mir einem / enden
    'messagespath'	=> '//syn-ds415/music/tts/',	# Windows Backslash \\ und Slash \ in Pfadangaben durch // und / 
			
	# Pfad zu dem Speichermedium deines Webservers auf dem die erhaltenen MP3 Files gespeichert werden sollen
    'messageStorePath'   => '//volume1/music/tts/', 
		
	# Unterverzeichnis für gespeicherte MP3 Dateien 
	# (nur für Funktion: messageid). Wird dieser Parameter LEER gelassen wird im Verzeichnis 'messagespath' nach den Dateien gesucht.
	'MP3path' 		=> 'MP3',						# das Verzeichnis ohne Slash oder Backslash eingeben. Bitte vorher das Verzeichnis
													# als Unterverzeichnis des 'messagepath' erstellen und dann hier angeben!!!
	
	# Angabe in Tagen oder Wochen ab welchen Datum die MP3 aus dem Verzeichnis 'messageStorePath' automatisch gelöscht werden sollen.
	# Bsp.: '-4 days' --> löscht alle MP3 Dateien mit Dateinamenlänge 36 die älter als 4 Tage von heute an gespeichert wurden.
	'MP3store'      => '-5 days',					# bei Wochen: -2 weeks
	
	# WICHIG, NICHT ÄNDERN: Datei Name der PHPSonos
    'filePhpSonos'  => 'PHPSonos.php',

	# Parameter ob Logging für Sonos genutzt werden soll
	'logging'       => true,

	# Vorgabe Werte für die Funktion Laustärkeneinstellung 'volumeup' and 'volumedown' in Prozent
	'volumeup'      => '3',
	'volumedown'    => '3',

	# Wartezeit in Sekunden bis nach Stop Playliste/Radio die Nachricht abgespielt wird
	'sleeptimegong' => '2',
	
	## NEU
	# Wartezeit in Sekunden bei sendgroupmessage bevor der Gruppenmute aufgehoben wird.
	'sleepgroupmessage' => '2',

	# Dateiname der Jingle oder Gong mp3 Datei die vor der eigentlichen Nachricht/Durchsage abgespielt wird
	'file_gong'     => '2_Airport_gong',

	# Hier die Daten und User des Loxone Miniserver eintragen
	'LoxIP' 	=> 'xx',
	'LoxUser' 	=> 'xxx',
	'LoxPassword'	=> 'xxxx',
	
	# Sollen Daten zur Loxone geschickt werden (Titel/Interpret, Lautstärke, Mute Status, Play Status sind möglich)
	'LoxDaten' => true,

	# Einstellungen zu Lautstärke
	# Hier ist es möglich unterschiedliche Arten des Ansteigen der Lautstärke zu definieren
	# z.B. sleep - für den Wecker / Musik morgens, damit dieser langsamm lauter wird
	#
	# 	"sleep" 	- von aktueller Lautstärke auf die Ziel Lautstärke ändernd, fest eingestellt in 17 Sekunden.
	#	"alarm" 	- von 0 auf die Ziel Lautstärke ansteigend.
	#	"auto" 	- von 0 auf die Ziel Lautstärke ansteigend, sehr schnell und gleichmäßig.
	#
	# Standard für den Befehl Play wenn der Parameter rampto in der Syntax nicht angegeben wurde.
	'rampto' => 'alarm',
	# Lautstärke in Prozent ab wann 'rampto' OHNE explizite Angabe genutzt werden soll, ansonsen geht es mit eingestellter Lautstärke weiter
	# gilt für folgende Funktionen: play, nextradio, previousradio, playqueue, sonosplaylist, radioplaylist
	'volrampto' => '25',

	

	# Parameter für Wunderground w2s Integration
	######################################################################
	# Token bei http://deutsch.wunderground.com/weather/api/ anfordern
	# Gültigen Wunderground API key einfügen
	'wgkey'		=> 'xxxxxx',
	# Lässt sich mittels Funktion geolookup und Längen-/Breitengrad ermitteln. Siehe auch Dokumentation der API
	'wgcity' 		=> 'Darmstadt',
	# Wird der Schwellwert überschritten erfolgt die Sprachausgabe für Wind km/h oder Regen (% Regenwahrscheinlichkeit)
	'wgwindschwelle'	=> '20', // km/h
	'wgregenschwelle'	=> '25', // in Prozent
	######################################################################	

	# Debuggen im Browser = '1' <-- Empfehlung zum Entwickeln
	# Einfaches Error Handling = '0' <-- Empfehlung für Nutzung in Produktivumgebung
	# Erweitertes Error Handling = '2'
	'debuggen'	=> '0'
);
