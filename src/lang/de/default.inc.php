<?php
	define("ERROR", "Fehler");
	define("WARNING", "Warnung");
	define("LOADING", "Lade");
	define("CLOSE", "Schliessen");
	
	define("ERROR_LANG", "Sprache Fehler");
	define("ERROR_LANG_MSG", "Fehler unbekannte Sprache.");
	
	define("ERROR_PAGE", "Seiten Fehler");
	define("ERROR_PAGE_MSG", "Fehler unbekannte Seite %s.");
	
	define("ERROR_USER_RIGHTS", "Benutzerrechte Fehler");
	define("ERROR_USER_RIGHTS_MSG", "Fehler, der Benutzer hat nicht die n�tigen Rechte um die Seite zu sehen.");
	
	define("ERROR_DATABASE", "Datenbank Fehler");
	define("ERROR_DATABASE_MSG", "Fehler: %s");
	
	define("ERROR_USER_BANNED", "Sicherheitsalarm");
	define("ERROR_USER_BANNED_MSG_1", "Sie werden blockiert von dieser Website.");
	define("ERROR_USER_BANNED_MSG_2", "Bitte geben Sie den folgenden Captcha ein um wieder den Zugriff zu dieser Website zu erhalten.");
	define("ERROR_USER_BUTTON", "Nicht mehr blockieren");
	
	define("ERROR_DEBUG_MAIL_SENT", "Ein technisches Problem ist aufgetreten. Ein Administrator wurde dar�ber informiert und sollte das Problem schnell l�sen.");
	
	define("ERROR_401", "Fehler 401");
	define("ERROR_401_MSG", "Fehler 401 : Authentifikation erforderlich");
	define("ERROR_403", "Fehler 403");
	define("ERROR_403_MSG", "Fehler 403 : Zugriff verweigert");
	define("ERROR_404", "Fehler 404");
	define("ERROR_404_MSG", "Fehler 404 : Seite nicht gefunden");
	define("ERROR_500", "Fehler 500");
	define("ERROR_500_MSG", "Fehler 500 : Interner Server Fehler");
	define("REDIRECT_URL_TO", "Sie werden zu <a href='%s'>%s</a> weitergeleitet (Wenn die Weiterleitung nicht funktioniert, klicken Sie bitte auf den Link).");
	
	define("MAIN_PAGE_GO_BACK", "Zur�ck zur Hauptseite");
	
	define("BOX_LANGUAGE_TITLE", "Sprachen");
	define("CAPTCHA_CODE", "Geben Sie den unten stehenden Code ein");
	define("ERROR_CAPTCHA", "Captcha Code Fehler.");
	
	define("DECRYPT_ERROR", "Nachrichten Entschl�sselungsfehler, bitte versuchen Sie es nochmal");
	define("SUBMIT_ERROR", "<table><tr><td><img src='{#BASE_URL#}wsp/img/warning.png' height='48' width='48' border='0' align='absmidlle'/></td><td><b>{#SIMPLE_QUOTE#} + ucfirst(transport.statusText) + {#SIMPLE_QUOTE#}</b></td></tr></table>{#SIMPLE_QUOTE#} + (transport.responseText!={#SIMPLE_QUOTE#}{#SIMPLE_QUOTE#}?{#SIMPLE_QUOTE#}<br/> {#SIMPLE_QUOTE#} + transport.responseText:{#SIMPLE_QUOTE#}{#SIMPLE_QUOTE#}) + {#SIMPLE_QUOTE#}");
	define("SUBMIT_UNKNOW_ERROR", "<table><tr><td><img src='{#BASE_URL#}wsp/img/warning.png' height='48' width='48' border='0' align='absmidlle'/></td><td><b>Unbekannter Fehler</b></td></tr></table>");
	define("SUBMIT_LOADING", "Bitte warten Sie w�hrend das Formular gepr�ft wird ...");
	define("SUBMIT_LOADING_2", "Bitte warten ...");
	define("DOWNLOAD_FLASH_PLAYER", "<a href=\"http://www.macromedia.com/go/getflashplayer\" rel=\"nofollow\">Laden Sie den Flash Player</a> um es zu sehen.");
	
	define("LIVE_VALIDATION_FORMULAR_ERROR", "Ihr Formular ist nicht korrekt, bitte �berpr�fen Sie alle Felder.");
	define("LIVE_VALIDATION_FORMULAR_FIELD_ERROR", "Ihr Formular ist nicht korrekt, bitte �berpr�fen Sie das Feld {#SIMPLE_QUOTE#} + lv_error_alert_field_name + {#SIMPLE_QUOTE#}.");
	define("LIVE_VALIDATION_FORMULAR_ERROR_DEBUG", "Ihr Formular ist nicht korrekt, bitte �berpr�fen Sie das Feld {#SIMPLE_QUOTE#} + lv_error_alert_id + {#SIMPLE_QUOTE#}.");
	define("LIVE_VALIDATION_FORMULAR_ERROR_MSG", "lv_error_alert_msg");
	define("INCLUDE_OBJECT_TO_MAIN_PAGE", "Bitte f�gen Sie das %s Objekt auf der Hauptseite ein (\$this->includeJsAndCssFromObjectToPage('%s')).");
	
	define('NOT_SUPPORTED_BROWSER_TITLE', 'Nicht unterst�tzter Browser');
	define('NOT_SUPPORTED_BROWSER', '<b>Internet Explorer 6 und �ltere Versionen werden nicht vollst�ndig unterst�tzt.</b><br/>Wir empfehlen einen anderen Browser zu benutzen.<br/><br/>Es muss 50 Wege geben um Ihren Browser zu wechseln - hier sind 5:<br/><br/>');
	
	define("JAVASCRIPT_NOT_ACTIVATE", "JavaScript ist in Ihrem Webbrowser ausgeschaltet. Schalten Sie es ein um den vollen Funktionsumfang dieser Seite nutzen zu k�nnen, dann aktualisieren Sie die Seite.");
?>