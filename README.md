Sonos http Befehle rund um Loxone
=================================

## Einleitung 

*sonos2* ist eine Sammlung von Befehlen welche die php class PHPSonos nutzt um Sonos player via http Befehle von Loxone aus zu steuern. 

## Installation 

Sicherstellen dass das Verzeichnis in dem die Skript Dateien liegen vom php f�higen Webserver ausgef�hrt werden k�nnen (DEIN_VERZEICHNIS)

## Konfiguration 
Die Konfiguration wird in der config.php durchgef�hrt. 
F�ge in der config.php deine Sonos Zonen inkl. IP-Adressen und auch deine gew�nschten Radiostation hinzu.
Der Pfad f�r die Nachrichten bzw. Text-To-Speech (TTS) Dateien muss f�r Sonos erreichbar sein.
F�r TTS ben�tigst du noch einen API-Key von VoicesRSS.org oder ivona.com

Unbedingt sicherstellen das dein Webserver User Schreibrechte f�r DEIN_VEREICHNIS besitzt.

Syntax Beispiele f�r Browser:
=============================
## Setzt den Playmode. Erlaubte M�glichkeiten sind: NORMAL, REPEAT_ALL, SHUFFLE und SHUFFLE_NOREPEAT
http://DEINE_IP/DEIN_VERZEICHNIS/index.php?zone=DEINE_ZONE&action=playmode&playmode=normal

## Entfernt Track Nr. 1 von der laufenden Playliste
http://DEINE_IP/DEIN_VERZEICHNIS/index.php?zone=DEINE_ZONE&action=remove&track=1

## Setzt die Lautst�rke fix auf 30 %
http://DEINE_IP/DEIN_VERZEICHNIS/index.php?zone=DEINE_ZONE&action=volume&volume=30

## Spielt n�chsten Radio Sender aus der Liste in config.php
http://DEINE_IP/DEIN_VERZEICHNIS/index.php?zone=DEINE_ZONE&action=nextradio

## Spielt vorherigen Radio Sender aus der Liste in config.php
http://DEINE_IP/DEIN_VERZEICHNIS/index.php?zone=DEINE_ZONE&action=previousradio

## Startet play mit Lautst�rke 20% und der lautst�rkeanhebung 'alarm'
http://DEINE_IP/DEIN_VERZEICHNIS/index.php?zone=DEINE_ZONE&action=play&Volume=20&rampto=alarm

## Folgende action sind m�glich: toggle, stop, next, pause, previous, rewind, 
http://DEINE_IP/DEIN_VERZEICHNIS/index.php?zone=DEINE_ZONE&action=stop

## Laust�rke wird innerhalb 17 Sekunden linear auf Null gefahren (Art Schlummerfunktion) und Wiedergabe gestoppt
http://DEINE_IP/DEIN_VERZEICHNIS/index.php?zone=DEINE_ZONE&action=softstop

## Setzt angegeben Zone auf mute wenn Wert true, unmute mit Wert false
http://DEINE_IP/DEIN_VERZEICHNIS/index.php?zone=DEINE_ZONE&action=mute&mute=true

## Lautst�rke leiser (die Schritt Vorgabe wird in Prozent in der config.php gepflegt)
http://DEINE_IP/DEIN_VERZEICHNIS/index.php?zone=DEINE_ZONE&action=volumedown

## Lautst�rke lauter (die Schritt Vorgabe wird in Prozent in der config.php gepflegt)
http://DEINE_IP/DEIN_VERZEICHNIS/index.php?zone=DEINE_ZONE&action=volumeup

## L�schen der laufenden Playliste
http://DEINE_IP/DEIN_VERZEICHNIS/index.php?zone=DEINE_ZONE&action=clearqueue

## Spielt MP3 Datei ohne jingle/gong vor der Durchsage
----------------------------------------
## Stoppt gegenw�rtig laufende Playliste/Radiostation, speichert die Lautst�rke und Playliste/Radiostation, 
## setzt die Lautst�rke auf 30%, spielt die Datei 1.mp3 die im Ordner 'messagepath' gespeichert ist,
## nach dem Abspielen wird die vorherige Playliste/Radiostation wieder geladen und mit der vorher gespeicherten 
## Lautst�rke wieder abgespielt.
## Wenn aktuell nichts l�uft, denn noch eine Playliste/Radiostation in der Zone aktiv ist, bleibt die Zone stumm
## und die Playliste/Radiostation wird nur geladen.
http://DEINE_IP/DEIN_VERZEICHNIS/index.php?zone=DEINE_ZONE&volume=30&action=sendmessage&messageid=1

## Spielt MP3 Datei mit jingle/gong vor der Durchsage
---------------------------------------
## Stoppt gegenw�rtig laufende Playliste/Radiostation, speichert die Lautst�rke und Playliste/Radiostation, 
## setzt die Lautst�rke auf 40%, spielt vorher ein Jingle/Gong MP3 ab, spielt dann die Datei 1.mp3 die im Ordner 'messagepath' 
## gespeichert ist, nach dem Abspielen wird die vorherige Playliste/Radiostation wieder geladen und mit der vorher gespeicherten 
## Lautst�rke wieder abgespielt.
## Wenn aktuell nichts l�uft, denn noch eine Playliste/Radiostation in der Zone aktiv ist, bleibt die Zone stumm
## und die Playliste/Radiostation wird nur geladen.
http://DEINE_IP/DEIN_VERZEICHNIS/index.php?zone=DEINE_ZONE&volume=40&playgong=yes&action=sendmessage&messageid=1

## Spielt TTS Text ohne jingle/gong vor der Durchsage
---------------------------------------
## Stoppt gegenw�rtig laufende Playliste/Radiostation, speichert die Lautst�rke und Playliste/Radiostation, 
## setzt die Lautst�rke auf 20%, wandelt dann den text in MP3 mit Hillfe von TTS um und 
## spielt Sie ab, nach dem Abspielen wird die vorherige Playliste/Radiostation wieder geladen und mit der vorher gespeicherten 
## Lautst�rke wieder abgespielt.
## Wenn aktuell nichts l�uft, denn noch eine Playliste/Radiostation in der Zone aktiv ist, bleibt die Zone stumm
## und die Playliste/Radiostation wird nur geladen.
##
## F�r Loxone kann auch beim analagen Ausgangsbefehl der Parameter <v> f�r Durchsagen verwendet werden.
http://DEINE_IP/DEIN_VERZEICHNIS/index.php?zone=DEINE_ZONE&volume=20&action=sendmessage&text=Dies ist ein Test

## F�gt der angegebenen Zone eine weitere hinzu
http://DEINE_IP/DEIN_VERZEICHNIS/index.php?zone=DEINE_ZONE&action=addmember&member=ANDERE_ZONE

## L�scht aus der Gruppe die angegebenen Zone wieder
http://DEINE_IP/DEIN_VERZEICHNIS/index.php?zone=DEINE_ZONE&action=removemember&member=ANDERE_ZONE

## L�dt die angegebene Sonos Playliste und spielt Sie mit Lauts�rke 15% ab
http://DEINE_IP/DEIN_VERZEICHNIS/index.php?zone=DEINE_ZONE&action=sonosplaylist&playlist=NAME_DER_PLAYLISTE&volume=15

## L�dt die angegebene Radioliste unter "Meine Radiosender" aus Sonos 
http://DEINE_IP/DEIN_VERZEICHNIS/index.php?zone=DEINE_ZONE&action=radioplaylist&playlist=NAME_DER_RADIOSTATION&volume=15

## �ndert die Lautst�rkeanhebung bei Play (siehe config.php) sleep, alarm und auto sind erlaubt
http://DEINE_IP/DEIN_VERZEICHNIS/index.php?zone=DEINE_ZONE&action=play&rampto=sleep

## 1 schaltet �berblenden ein, 0 schaltet �berblenden aus
http://DEINE_IP/DEIN_VERZEICHNIS/index.php?zone=DEINE_ZONE&action=crossfade&crossfade=1

## Stopt alle Zonen
http://DEINE_IP/DEIN_VERZEICHNIS/index.php?zone=DEINE_ZONE&action=stop&stopall

## Gruppiert alle Zonen
http://DEINE_IP/DEIN_VERZEICHNIS/index.php?zone=DEINE_ZONE&action=group

## Hebt die Gruppierung wieder auf
http://DEINE_IP/DEIN_VERZEICHNIS/index.php?zone=DEINE_ZONE&action=ungroup

## weather-to-speech (in Verbindung mit wunderground.com [NUR API key ben�tigt])
##
## je nach Tageszeit werden unterschiedliche Wettervorhersagen erstellt und per TTS durchgegeben
## Regenwahrscheinlichkeit und Windwarnung nur ab �berschreiten von Grenzwerten (siehe config.php)
## Ansagetexte k�nnen in der Datei 'w2s.php' individualisiert werden (VORSICHT!!
http://DEINE_IP/DEIN_VERZEICHNIS/index.php?zone=DEINE_ZONE&action=sendmessage&weather&volume=30

## clock-to-speech (Die Uhrzeit + Anrede werden �ber TTS ausgegeben )
## 
## Ansagetexte k�nnen in der Datei 'c2s.php' individualisiert werden (VORSICHT!!
http://DEINE_IP/DEIN_VERZEICHNIS/index.php?zone=DEINE_ZONE&action=sendmessage&clock&volume=20



## Hier die Syntax zur Info oder Fehlersuche (nur in Browser zu nutzen)
folgende actions k�nnengenutzt werden: getmedianfo, getpositioninfo, gettransportsettings, gettransportinfo,
getradiotimegetnowplaying, getvolume, radiourl, titelinfo, getledstate, getzoneattributes
-----------------------------------------------------------------------------------------

http://DEINE_IP/DEIN_VERZEICHNIS/sonos2.php?zone=DEINE_ZONE&action=getmedianfo




## Zur detaillierteren Fehlersuche kann auch folgende Syntax genutzt werden:
-----------------------------------------------------------------------------------------
## In der Syntax 'sonos2.php' durch 'index.php' ersetzen
http://DEINE_IP/DEIN_VERZEICHNIS/index.php?zone=DEINE_ZONE&action=play

Syntax Beispiel wie der Browser Befehl zu teilen ist um in Loxone verwendet zu werden:
-----------------------------------------------------------------------------------------
Ausgangsverbinder erstellen = http://DEINE_IP		## und Haken bei "Verbindung nach senden schlie�en" setzen
Ausgangsbefehl hinzuf�gen = /DEIN_VERZEICHNIS/index.php?zone=DEINE_ZONE&action=play
etc.



## Loxone Integration
Titel und Interpret k�nnen jetzt auch getrennt in Loxone verwendet werden
http://DEINE_IP/DEIN_VERZEICHNIS/index.php?zone=DEINE_ZONE&action=loxgettitel

Der Text Eingangsverbinderf�r die Kombination lautet: S-Titel<ZONE>
Der Text Eingangsverbinderf�r den Titel lautet: S-Titelinfo<ZONE>
Der Text Eingangsverbinderf�r den Interpret lautet: S-Interpretinfo<ZONE>



## weather-to-speech (w2s)
Ansage der Windst�rke und Windrichtung
Wetterdaten (Browser) f�r Fehlersuche wenn debug=1


## NEUE FUNKTIONEN ##
---------------------
## Gibt den gegenw�rtigen Mute Status einer Gruppe zur�ck
http://DEINE_IP/DEIN_VERZEICHNIS/index.php?zone=DEINE_ZONE&action=getgroupmute

## Setzt den Mute Status f�r eine Gruppe (1=Mute, 0=Unmute)
http://DEINE_IP/DEIN_VERZEICHNIS/index.php?zone=DEINE_ZONE&action=setgroupmute&mute=1

## Gibt die gegenw�rtige mittlere Lautst�rke einer Gruppe zur�ck
http://DEINE_IP/DEIN_VERZEICHNIS/index.php?zone=DEINE_ZONE&action=getgroupvolume

## Setzt die angegebene Lautst�rke f�r eine Gruppe auf 40% (Master muss DEINE_ZONE sein)
http://DEINE_IP/DEIN_VERZEICHNIS/index.php?zone=DEINE_ZONE&action=setgroupvolume&volume=40

## Erh�ht die jeweilige Lautst�rke je Zone einer Gruppe um 20% (Master muss DEINE_ZONE sein)
## ACHTUNG! Basierend auf derzeitiger Lautst�rke wird LS um Wert x erh�ht (k�nnte u.U. laut werden)
http://DEINE_IP/DEIN_VERZEICHNIS/index.php?zone=DEINE_ZONE&action=setrelativegroupvolume&volume=20

## Nimmt die angegebene Zone aus einer Gruppe heraus
http://DEINE_IP/DEIN_VERZEICHNIS/index.php?zone=DEINE_ZONE&action=becomegroupcoordinator

## Setzt den Schlummermodus f�r angegebene Zone auf 5 Minuten. Bei kleiner 10 Minuten nur einstellige Eingabe Bsp.:5 f�r 5 Minuten) 
## generell erlaubte Eingabe: 1-59
http://DEINE_IP/DEIN_VERZEICHNIS/index.php?zone=DEINE_ZONE&action=sleeptimer&timer=5




## Fehler

keine bekannten  

## Danke an

thanks to Stefan Nikolaus and Thomas Trautner for there coding

## N�chste Aktionen
##
## Erstellen von Gruppen basierend auf Auswahl der Zonen
## mit anschlie�endem abspielen einer T2S und wiederherstellen des Ursprungszustandes

*intensiveres Testen
