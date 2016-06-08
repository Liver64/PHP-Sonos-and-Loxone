<?php

##############################################################################################################################
#
# Version: 		1.1.5
# Datum: 		23.03.2016
# veröffentlicht in forum: https://www.loxforum.com/
# 
# Historie:
# ----------------------------------------------------------------------------------------------------------------------------
# 1.0.0		Veröffentlichung des Skripts
# 1.1.0		Neue Parameter hinzugefügt
# 1.1.2		Minimum Lautstärke ab wann automatisch rampTo ausgeführt wird
# 1.1.3		Neue Parameter für weather-to-speech (w2s) und clock-to-speech (c2s)
# 1.1.4		Neuer TTS Anbieter hinzugefügt
# 1.1.5		Neue Parameter für Wartezeit bevor t2s abgespielt wird. (Zeile 147)
#
# bekannte Probleme: derzeit keine
# 


$config = array(
	# Hier kommem die einzelnen Sonos Player rein "name_kleingeschrieben" => "IP Adresse des Players"
	'sonoszone' => array(
                'bad'      => '192.168.15.107',
                'buero'    => '192.168.15.112',
                'schlafen' => '192.168.15.108',
                'kueche'   => '192.168.15.118'
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
	# Text-to-Speech Parameter für VoiceRSS.org 
	#---------------------------------------------------------------------------------------------------
	# Hier deinen VoiceRSS.org API key einpflegen
	'VoiceRSS_key'  => 'xxxxxxxxxxxxxxxxxx',

	# Die Sprache für die VoiceRSS Engine festlegen
    'messageLangV'   => 'de-de',

	# Den Qualität der MP3 Datei festlegen die VoiceRSS.org zurückschickt (die vorgegebene funktioniert)
	'audiocodec'    => '48khz_16bit_stereo',
	####################################################################################################
	
	####################################################################################################
	# Text-to-Speech Parameter für IVONA.com 
	#---------------------------------------------------------------------------------------------------
	# Hier deinen IVONA Access key einpflegen
	'access_key'  => 'xxxxxxxxxxxxxxxxxx',
	# Hier deinen IVONA Secret key einpflegen
	'secret_key'  => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',

	# Die Sprache für die IVONA Engine festlegen
    'messageLangI'   => 'de-DE',

	# Standardstimme für T2s
	'voice'    => 'Marlene', // 'Marlene' oder 'Hans'

	####################################################################################################
	# Text-to-Speech Parameter für Mac OS X
	#---------------------------------------------------------------------------------------------------
	# Pfad zum LAME MP3 Encoder
	'lamePath'	=>	'/usr/local/bin/',
	####################################################################################################

	####################################################################################################
	# Angabe welche TTS Engine benutzt werden soll:
	#-- für VoiceRSS.org die '1001'
	#-- für IVONA.com die '2001'
	#-- für die OS X TTS-Engine die '3001'
	# eingeben.
	't2s_engine'	=> 3001,
	####################################################################################################

	# Pfad zu deinem Speichermedium von dem Sonos die Nachrichen abspielt. Dieser UNC Pfad muss über die Netzwerkkennung erreichbar sein.
    'messagespath'   => '//tts.wagner.local/sound',	
    # Backslashes wie sie Windows verwendet (\\ und \) sind in den Pfadangaben durch Slashes (// und /) zu ersetzen. Am Ende des UNC Pfades darf sich kein Slash befinden.

	# Pfad zu deinem Speichermedium an dem das Script das erhaltene MP3 file speichert. Dieser entspricht exakt
	# dem 'messagespath', nur muss die Angabe hier nicht mit Netzwerkkennung, sondern den Regeln des localhost
	# Wer einen Pi als Webserver und eine NAS/externe Fesplatte nutzt muss hier sein mount Pfad angeben
	#
	# In dem Beispiel hier liegt das Script auf einer Synology mit dem Namen 'syn-ds415' und speichert die MP3 in den Unterordner tts im Ordner music.
	# Bei messageStorePath muss der interne mount pfad für das o.g. Verzeichnis dann so angegeben werden, für Zugriff von Sonos aus dann der gleiche Pfad wie in Zeile 83.
	'messageStorePath'   => '/sound/', 

	# WICHIG, NICHT ÄNDERN: Datei Name der PHPSonos
    'filePhpSonos'  => 'PHPSonos.inc.php',

	# Parameter ob Logging für Sonos genutzt werden soll
	'logging'       => true,

	# Falls Logging genutzt wird hier den gewünschten Dateinamen eintragen
    'logfile'       => 'sonoslog.txt',

	# Vorgabe Werte für die Funktion Laustärkeneinstellung 'volumeup' and 'volumedown' in Prozent
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
	
	# Sollen Daten zur Loxone geschickt werden (Titel/Interpret, Lautstärke, Mute Status, Play Status sind möglich)
	'LoxDaten' => true,

	# Standardlautstärke wenn nichts anderes mit angegeben wurde
	'stdvolume' 	=> '40',

	# Standardlautstärke für Durchsagen wenn nichts anderes angegeben wurde
	'messagevolume' => '35',

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
	'volrampto' => '35',
	# Parameter der angibt ob vor dem Abspielen einer t2s langsam (ca. 10 Sekunden) oder abrupt die Lautstärke runtergeregelt wird
	# Bitte Parameter sleeptimegong beachten bei false.
	'rampsleep' => true,  // false = abruptes stoppen. 

	# Parameter für Fritzbox Integration --> Noch nicht aktiv
	######################################################################

	'fritzboxip'  	=> '192.168.50.xx',
	'fritzboxpw'  	=> 'xxxxxxxxxx',
	'rufumleitung1' => '017664067xxx',
	'rufumleitung2'	=> '017664067xxx',
	'rufumleitung3'	=> '016387581yyy',
	######################################################################

	# Parameter für Wunderground w2s Integration
	######################################################################
	# Token bei http://deutsch.wunderground.com/weather/api/ anfordern
	# Gültigen Wunderground API key einfügen
	'wgkey'		=> 'xxxxxxxxxxxxxx',
	# Lässt sich mittels Funktion geolookup und Längen-/Breitengrad ermitteln. Siehe auch Dokumentation der API
	'wgcity' 		=> 'xxxxxxxxxxx',
	# Wird der Schwellwert überschritten erfolgt die Sprachausgabe für Wind km/h oder Regen (% Regenwahrscheinlichkeit)
	'wgwindschwelle'	=> '20', // km/h
	'wgregenschwelle'	=> '25', // in Prozent
	######################################################################	

	# Zum debuggen mit Hilfe des Browsers kann im folgenden Parameter eine '1' gesetzt werden
	# Bitte unbedingt daran denken vor Produktivnutzung wieder auf '0' zu setzen
	'debuggen'	=> '0'
);
