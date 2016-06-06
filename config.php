<?php

##############################################################################################################################
#
# Version: 		1.1.5
# Datum: 		23.03.2016
# ver�ffentlicht in forum: https://www.loxforum.com/
# 
# Historie:
# ----------------------------------------------------------------------------------------------------------------------------
# 1.0.0		Ver�ffentlichung des Skripts
# 1.1.0		Neue Parameter hinzugef�gt
# 1.1.2		Minimum Lautst�rke ab wann automatisch rampTo ausgef�hrt wird
# 1.1.3		Neue Parameter f�r weather-to-speech (w2s) und clock-to-speech (c2s)
# 1.1.4		Neuer TTS Anbieter hinzugef�gt
# 1.1.5		Neue Parameter f�r Wartezeit bevor t2s abgespielt wird. (Zeile 147)
#
# bekannte Probleme: derzeit keine
# 


$config = array(
	# Hier kommem die einzelnen Sonos Player rein "name_kleingeschrieben" => "IP Adresse des Players"
	'sonoszone' => array(
                'bad'      => '192.168.50.xxx',
                'master'   => '192.168.50.xxx',
                'schlafen' => '192.168.50.xxx',
                'test'     => '192.168.50.xxx'
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
	'VoiceRSS_key'  => 'xxxxxxxxxxxxxxxxxxxxxxxxxxx',

	# Die Sprache f�r die VoiceRSS Engine festlegen
    'messageLangV'   => 'de-de',

	# Den Qualit�t der MP3 Datei festlegen die VoiceRSS.org zur�ckschickt (die vorgegebene funktioniert)
	'audiocodec'    => '48khz_16bit_stereo',
	####################################################################################################
	
	####################################################################################################
	# Text-to-Speech Parameter f�r IVONA.com 
	#---------------------------------------------------------------------------------------------------
	# Hier deinen IVONA Access key einpflegen
	'access_key'  => 'xxxxxxxxxxxxxxxxxx',
	# Hier deinen IVONA Secret key einpflegen
	'secret_key'  => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',

	# Die Sprache f�r die IVONA Engine festlegen
    'messageLangI'   => 'de-DE',

	# Standardstimme f�r T2s
	'voice'    => 'Marlene', // 'Marlene' oder 'Hans'
	####################################################################################################
	# Angabe welche TTS Engine benutzt werden soll:
	#-- f�r VoiceRSS.org die '1001'
	#-- f�r IVONA.com die '2001'
	# eingeben.
	't2s_engine'	=> 2001,
	####################################################################################################

	# Pfad zu deinem Speichermedium von dem Sonos die Nachrichen abspielt. Dieser muss �ber Netzwerkkennung erreichbar sein.
    'messagespath'   => '//syn-ds415/music/tts/',	# Windows Backslash \\ und Slash \ in Pfadangaben durch // und / ersetzen ohne 											Slash am Ende

	# Pfad zu deinem Speichermedium an dem das Script das erhaltene MP3 file speichert. Dieser entspricht exakt
	# dem 'messagespath', nur muss die Angabe hier nicht mit Netzwerk Kennung erfolgen, sondern den Regeln des localhost
	# Wer einen Pi als Webserver und eine NAS/externe Fesplatte nutzt muss hier sein mount Pfad angeben
	#
	# In dem Beispiel hier liegt das Script auf einer Synology mit dem Namen 'syn-ds415' und speichert die MP3 in den Unterordner tts im Ordner music.
	# Bei messageStorePath muss der interne mount pfad f�r das o.g. Verzeichnis dann so angegeben werden, f�r Zugriff von Sonos aus dann der gleiche Pfad wie in Zeile 83.
	'messageStorePath'   => '//volume1/music/tts/', 

	# WICHIG, NICHT �NDERN: Datei Name der PHPSonos
    'filePhpSonos'  => 'PHPSonos.inc.php',

	# Parameter ob Logging f�r Sonos genutzt werden soll
	'logging'       => true,

	# Falls Logging genutzt wird hier den gew�nschten Dateinamen eintragen
    'logfile'       => 'sonoslog.txt',

	# Vorgabe Werte f�r die Funktion Laust�rkeneinstellung 'volumeup' and 'volumedown' in Prozent
	'volumeup'      => '3',
	'volumedown'    => '3',

	# Wartezeit in Sekunden bis nach Stop Playliste/Radio die Nachricht abgespielt wird
	'sleeptimegong' => '1',

	# Dateiname der Jingle oder Gong mp3 Datei die vor der eigentlichen Nachricht/Durchsage abgespielt wird
	'file_gong'     => '2_Airport_gong',

	#########################################################
	#    ++ Neue Parameter aufgrund neuer Funktionen ++     #
	#########################################################
	# ab hier in eure config.php kopieren

	# Hier die Daten und User des Loxone Miniserver eintragen
	'LoxIP' 	=> '192.168.50.xxx:80',
	'LoxUser' 	=> 'xxxxxxx',
	'LoxPassword'	=> 'xxxxxxxxx',
	
	# Sollen Daten zur Loxone geschickt werden (Titel/Interpret, Lautst�rke, Mute Status, Play Status sind m�glich)
	'LoxDaten' => true,

	# Standardlautst�rke wenn nichts anderes mit angegeben wurde
	'stdvolume' 	=> '40',

	# Standardlautst�rke f�r Durchsagen wenn nichts anderes angegeben wurde
	'messagevolume' => '35',

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
	# Parameter der angibt ob vor dem Abspielen einer t2s langsam (ca. 10 Sekunden) oder abrupt die Lautst�rke runtergeregelt wird
	# Bitte Parameter sleeptimegong beachten bei false.
	'rampsleep' => true,  // false = abruptes stoppen. 

	# Parameter f�r Fritzbox Integration --> Noch nicht aktiv
	######################################################################

	'fritzboxip'  	=> '192.168.50.xx',
	'fritzboxpw'  	=> 'xxxxxxxxxx',
	'rufumleitung1' => '017664067xxx',
	'rufumleitung2'	=> '017664067xxx',
	'rufumleitung3'	=> '016387581yyy',
	######################################################################

	# Parameter f�r Wunderground w2s Integration
	######################################################################
	# Token bei http://deutsch.wunderground.com/weather/api/ anfordern
	# G�ltigen Wunderground API key einf�gen
	'wgkey'		=> 'xxxxxxxxxxxxxx',
	# L�sst sich mittels Funktion geolookup und L�ngen-/Breitengrad ermitteln. Siehe auch Dokumentation der API
	'wgcity' 		=> 'xxxxxxxxxxx',
	# Wird der Schwellwert �berschritten erfolgt die Sprachausgabe f�r Wind km/h oder Regen (% Regenwahrscheinlichkeit)
	'wgwindschwelle'	=> '20', // km/h
	'wgregenschwelle'	=> '25', // in Prozent
	######################################################################	

	# Zum debuggen mit Hilfe des Browsers kann im folgenden Parameter eine '1' gesetzt werden
	# Bitte unbedingt daran denken vor Produktivnutzung wieder auf '0' zu setzen
	'debuggen'	=> '0'
);
