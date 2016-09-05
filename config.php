<?php

##############################################################################################################################
#
# Version: 		1.2.0
# Datum: 		05.09.2016
# ver�ffentlicht in forum: https://www.loxforum.com/
# 
# Historie:
# ----------------------------------------------------------------------------------------------------------------------------
# 1.0.0		Ver�ffentlichung des Skripts
# 1.1.0		Neue Parameter hinzugef�gt
# 1.1.2		Minimum Lautst�rke ab wann automatisch rampTo ausgef�hrt wird
# 1.1.3		Neue Parameter f�r weather-to-speech (w2s) und clock-to-speech (c2s)
# 1.1.4		Parameter f�r Mac OS X TTS Engine erg�nzt
# 1.1.5		Neuer Parameter f�r die Wartezeit in Sekunden bei sendgroupmessage bevor der Gruppenmute vor T2S aufgehoben wird. (Z. 121)
#			Default Lautst�rke Parameter f�r T2S und Sonos je Zone hinzugef�gt (siehe sonoszone)
# 1.2.0		Neuer Paramter 'MP3path' als Speicherort f�r MP3 files die �ber 'messageid' abgerufen werden
#
#
# bekannte Probleme: derzeit keine
# 

$config = array(
	# Hier werden die einzelnen Sonos Zonen gepflegt (ACHTUNG: kleingeschreibung)
	# die Aufschl�sselung ist wie folgt: 'Zone' => array('IP Adresse','Standardvolume f�r T2S Ansagen','Standardvolume f�r Sonos')
	'sonoszone' => array(
				'bad'      	=> array('192.168.xx.24','30','30'),
				'paul'   	=> array('192.168.xx.57','25','20'),
				'schlafen' 	=> array('192.168.xx.38','18','20'),
				'terrasse' 	=> array('192.168.xx.75','50','40'),
				'wohnen'   	=> array('192.168.xx.25','100','100'),
				'master'   	=> array('192.168.xx.31','35','25')
				),

	# Hier k�nnen eigene Radio Sender definiert werden, welche bei 'nextradio' oder 'prevradio' angesteuert werden
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
	# Text-to-Speech Parameter f�r VoiceRSS.org 
	#---------------------------------------------------------------------------------------------------
	# Hier deinen VoiceRSS.org API key einpflegen
	'VoiceRSS_key'  => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',

	# Die Sprache f�r die VoiceRSS Engine festlegen
    'messageLangV'   => 'de-de',

	# Den Qualit�t der MP3 Datei festlegen die VoiceRSS.org zur�ckschickt (die vorgegebene funktioniert)
	'audiocodec'    => '48khz_16bit_stereo',
	####################################################################################################
	
	####################################################################################################
	# Text-to-Speech Parameter f�r IVONA.com 
	#---------------------------------------------------------------------------------------------------
	# Hier deinen IVONA Access key einpflegen
	'access_key'  => 'xxxxxxxxxxxxxxxxxxxx',
	# Hier deinen IVONA Secret key einpflegen
	'secret_key'  => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',

	# Die Sprache f�r die IVONA Engine festlegen
    'messageLangI'   => 'de-DE',

	# Standardstimme f�r T2s
	'voice'    => 'Hans', // 'Marlene' oder 'Hans'
	
	####################################################################################################
	# Text-to-Speech Parameter f�r Mac OS X
	#---------------------------------------------------------------------------------------------------
	# Pfad zum LAME MP3 Encoder
	'lamePath'	=>	'/usr/local/bin/',
	####################################################################################################
	
	####################################################################################################
	# Angabe welche TTS Engine benutzt werden soll:
	#-- f�r VoiceRSS.org die '1001'
	#-- f�r IVONA.com die '2001'
	#-- f�r die OS X TTS-Engine die '3001'
	# eingeben.
	't2s_engine'	=> 2001,
	####################################################################################################

	# Pfad zu deinem Speichermedium von dem Sonos die Nachrichen abspielt
    'messagespath'   => '//syn-ds415/music/tts/',	# Windows Backslash \\ und Slash \ in Pfadangaben durch // und / ersetzen ohne Slash am Ende
	# Unterverzeichnis f�r gespeicherte MP3 Dateien 
	# (nur f�r Funktion: messageid). Wird dieser Parameter LEER gelassen wird im Verzeichnis 'messagespath' nach den Dateien gesucht.
	'MP3path' 		=> '',						# das angelegte Verzeichnis ohne Slash oder Backslash eingeben

	# Nur f�r User die ihre Skripte NICHT auf eine NAS( QNAP, Synology, etc.) gehostet haben!!!
	# Der hier angegebene Pfad ist der Speicherort der T2S Engine f�r die gesendete MP3 Datei.
	# Wer einen Pi als Webserver und eine NAS/externe Fesplatte nutzt muss hier sein mount Pfad angeben
	# Wenn die Skripte auf einer NAS gehostet sind ist hier der gleiche Pfad wie bei 'messagepath' einzutragen
    'messageStorePath'   => '//volume1/music/tts/', 

	# WICHIG, NICHT �NDERN: Datei Name der PHPSonos
    'filePhpSonos'  => 'PHPSonos.php',

	# Parameter ob Logging f�r Sonos genutzt werden soll
	'logging'       => true,

	# Vorgabe Werte f�r die Funktion Laust�rkeneinstellung 'volumeup' and 'volumedown' in Prozent
	'volumeup'      => '3',
	'volumedown'    => '3',

	# Wartezeit in Sekunden bis nach Stop Playliste/Radio die Nachricht abgespielt wird
	'sleeptimegong' => '2',
	
	## NEU
	# Wartezeit in Sekunden bei sendgroupmessage bevor der Gruppenmute aufgehoben wird.
	'sleepgroupmessage' => '5',

	# Dateiname der Jingle oder Gong mp3 Datei die vor der eigentlichen Nachricht/Durchsage abgespielt wird
	'file_gong'     => '2_Airport_gong',

	#########################################################
	#    ++ Neue Parameter aufgrund neuer Funktionen ++     #
	#########################################################
	# ab hier in eure config.php kopieren

	# Hier die Daten und User des Loxone Miniserver eintragen
	'LoxIP' 	=> '192.168.xx.105:80',
	'LoxUser' 	=> 'xxxxxxx',
	'LoxPassword'	=> 'xxxxxxxxxxxx',
	
	# Sollen Daten zur Loxone geschickt werden (Titel/Interpret, Lautst�rke, Mute Status, Play Status sind m�glich)
	'LoxDaten' => false,

	# Einstellungen zu Lautst�rke
	# Hier ist es m�glich unterschiedliche Arten des Ansteigen der Lautst�rke zu definieren
	# z.B. sleep - f�r den Wecker / Musik morgens, damit dieser langsamm lauter wird
	#
	# 	"sleep" 	- von aktueller Lautst�rke auf die Ziel Lautst�rke �ndernd, fest eingestellt in 17 Sekunden.
	#	"alarm" 	- von 0 auf die Ziel Lautst�rke ansteigend.
	#	"auto" 	- von 0 auf die Ziel Lautst�rke ansteigend, sehr schnell und gleichm��ig.
	#
	# Standard f�r den Befehl Play wenn der Parameter rampto in der Syntax nicht angegeben wurde.
	'rampto' => 'alarm',
	# Lautst�rke in Prozent ab wann 'rampto' OHNE explizite Angabe genutzt werden soll, ansonsen geht es mit eingestellter Lautst�rke weiter
	# gilt f�r folgende Funktionen: play, nextradio, previousradio, playqueue, sonosplaylist, radioplaylist
	'volrampto' => '35',

	# Parameter f�r Fritzbox Integration --> Noch nicht aktiv
	######################################################################

	'fritzboxip'  	=> '192.168.xx.1',
	'fritzboxpw'  	=> 'xxxxxxxxxxx',
	'rufumleitung1' => '017664067xxx',
	'rufumleitung2'	=> '017664067xxx',
	'rufumleitung3'	=> '016387581yyy',
	######################################################################

	# Parameter f�r Wunderground w2s Integration
	######################################################################
	# Token bei http://deutsch.wunderground.com/weather/api/ anfordern
	# G�ltigen Wunderground API key einf�gen
	'wgkey'		=> 'xxxxxxxxxxxxxxxxx',
	# L�sst sich mittels Funktion geolookup und L�ngen-/Breitengrad ermitteln. Siehe auch Dokumentation der API
	'wgcity' 		=> 'Darmstadt',
	# Wird der Schwellwert �berschritten erfolgt die Sprachausgabe f�r Wind km/h oder Regen (% Regenwahrscheinlichkeit)
	'wgwindschwelle'	=> '20', // km/h
	'wgregenschwelle'	=> '25', // in Prozent
	######################################################################	

	# Zum debuggen mit Hilfe des Browsers kann im folgenden Parameter eine '1' gesetzt werden
	# Bitte unbedingt daran denken vor Produktivnutzung wieder auf '0' zu setzen
	'debuggen'	=> '0'
);
