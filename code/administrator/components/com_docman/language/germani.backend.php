<?php
/**
 * @version		$Id: germani.backend.php 11 2009-10-22 12:58:14Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

/**
 * Default German (informal) language file
 *
 * Creator:  Jan Erik Zassenhaus
 * Website:  http://www.joomlaportal.ch
 * E-mail:   jan.zassenhaus@joomlaportal.ch
 * Revision: 1.4 (translation version)
 * Date:     February 2008
 **/

// -- Toolbar
define('_DML_TOOLBAR_SAVE', "Speichern");
define('_DML_TOOLBAR_CANCEL', "Abbrechen");
define('_DML_TOOLBAR_NEW', "Neu");
define('_DML_TOOLBAR_NEW_DOC', "Neues Dokument");
define('_DML_TOOLBAR_HOME', "Home");
define('_DML_TOOLBAR_UPLOAD', "Upload");
define('_DML_TOOLBAR_MOVE', "Verschieben");
define('_DML_TOOLBAR_COPY', "Kopieren");
define('_DML_TOOLBAR_SEND', "Senden");
define('_DML_TOOLBAR_BACK', "Zurück");
define('_DML_TOOLBAR_PUBLISH', "Öffentlich");
define('_DML_TOOLBAR_UNPUBLISH', "Zurückziehen");
define('_DML_TOOLBAR_DEFAULT', "Standard");
define('_DML_TOOLBAR_DELETE', "Löschen");
define('_DML_TOOLBAR_CLEAR', "Leeren");
define('_DML_TOOLBAR_EDIT', "Bearbeiten");
define('_DML_TOOLBAR_EDIT_CSS', "CSS bearbeiten");
define('_DML_TOOLBAR_APPLY', "Anwenden");


// -- Files
define('_DML_ORPHANS', "Verwaiste");
define('_DML_ORPHANS_LINKED', "Dateien nicht gelöscht, da sie noch mit Dokumenten verbunden sind.");
define('_DML_ORPHANS_PROBLEM', "Dateien nicht gelöscht! Es gibt Probleme mit den Zugriffsrechten auf diese Dateien.");
define('_DML_ORPHANS_DELETED', "Dateien gelöscht!");
define('_DML_LINKS', "Links");
define('_DML_NEXT', "Weiter");
define('_DML_SUCCESS', "Erfolg!");
define('_DML_UPLOADMORE', "Mehr hochladen");
define('_DML_UPLOADWIZARD', "Upload-Assistent");
define('_DML_UPLOADMETHOD', "Wähle die Methode zum Hochladen");
define('_DML_ISUPLOADING', "Die Datei wird hochgeladen...");
define('_DML_PLEASEWAIT', "Bitte warten...");
define('_DML_UPLOADDISK', "Upload-Assistent - Lade eine Datei von einem Datenträger hoch");
define('_DML_FILETOUPLOAD', "Bitte wähle eine Datei zum Hochladen aus");
define('_DML_BATCHMODE', "Batch-Modus");
define('_DML_BATCHMODETT', "Im Batch-Modus kannst Du ein Zip-Archiv hochladen, dass mehrere Dateien enthalten kann. Das Archiv wird nach dem Hochladen automatisch entpackt. Bitte sorge dafür, dass das Archiv keine zusätzlichen Archive oder Unterordner enthält. Bedenke, dass dieser Prozess bereits im DOCman-Verzeichnis enthaltene Dateien ohne jede Warung überschreiben wird, wenn sie den gleichen Dateinamen haben. Dieser Modus ist noch im experimentier Status, also sei vorsichtig mit dieser Funktion.");
define('_DML_DOCMANISTRANSF', "Die Datei wird<br />übertragen");
define('_DML_TRANSFERFROMWEB', _DML_UPLOADWIZARD . " - " . "übertrage eine Datei von einem Server");
define('_DML_REMOTEURL', "Externe URL");
define('_DML_LINKURLTT', "Gebe einen externen Link zu Ihrer Datei ein. Der Link muss ein Protokoll beinhalten (http:// oder ftp://), den Dateinamen und dessen Dateityp. Zum Beispiel: http://www.beispiel.de/datei.zip.");
define('_DML_REMOTEURLTT', _DML_LINKURLTT . "<br />Du kannst die Datei beliebig auf diesem Server bennen, benutze hierfür das Feld &quot;Lokaler Name&quot;.");
define('_DML_LOCALNAME', "Lokaler Name");
define('_DML_LOCALNAMETT', "Gebe den lokalen Namen für die externe Datei ein."
     . "Dieses Feld musst Du ausfüllen, da nur der Link nicht genügend Informationen über die Datei liefert.");
define('_DML_DOCUPDATED', "Dokument wurde aktualisiert!");
define('_DML_FILEUPLOADED', "Datei wurde aktualisiert!");
define('_DML_MAKENEWENTRY', "Ein neues Dokument mit dieser Datei erstellen");
define('_DML_DISPLAYFILES', "Dateien anzeigen");
define('_DML_ALLFILES', "Alle Dateien");
define('_DML_DOCFILES', "Dokument-Datei");
define('_DML_CREATEALINK', "Ein verlinktes Dokument erstellen");
define('_DML_SELECTMETHODFIRST', "Bitte wähle eine Transfermethode aus!");
define('_DML_ERROR_UPLOADING', "Fehler beim Hochladen!");
define('_DML_ZLIB_ERROR', "Die Operation konnte nicht durchgeführt werden, da die Zlib-Bibliothek nicht installiert ist.");
define('_DML_UNZIP_ERROR', "Dateien konnten aus dem Paket nicht extrahiert werden!");
define('_DML_SUBMIT', "Senden");
define('_DML_NEW_FILE', "Neue Datei");
define('_DML_MAKE_SELECTION', "Bitte wähle zuerst einen Eintrag von der Liste!");

// -- Documents
define('_DML_MOVECAT', "Kategorie verschieben");
define('_DML_MOVETOCAT', "Zur Kategorie verschieben");
define('_DML_DOCSMOVED', "Dokumente wurden verschoben");
define('_DML_COPYCAT', "Kategorie kopieren");
define('_DML_COPYTOCAT', "Zur Kategorie kopieren");
define('_DML_COPY_OF', "Kopie von"); // Copy of [document name]
define('_DML_DOCSCOPIED', "Dokumente wurden kopiert");
define('_DML_DOCS_NOT_APPROVED', "Dokumente warten auf Freischaltung!");
define('_DML_DOCS_NOT_PUBLISHED', "Dokumente sind nicht veröffentlicht!");
define('_DML_NO_PENDING_DOCS', "Keine offenen Dokumente!");
define('_DML_FILE_MISSING', "***Datei fehlt***");
define('_DML_YOU_MUST_UPLOAD', "Du musst erst ein Dokument für diese Kategorie hochladen!");
define('_DML_THE_MODULE', "Das Modul");
define('_DML_IS_BEING', "wird gerade von einem anderen Administrator bearbeitet.");
define('_DML_NO_LICENSE', "Keine Lizenz");
define('_DML_LINKED', "->VERLINKTES DOKUMENT<-");
define('_DML_CURRENT', "Aktuell");
define('_DML_LICENSE_TYPE', "Lizenztyp");
define('_DML_FILETITLE', "Dateititel");
define('_DML_OWNER_TOOLTIP', "Diese Einstellunge regelt, wer das Dokument herunterladen bzw. angucken darf. Auswahl: "
     . "&quot;Jeder&quot;, damit jeder die Möglichkeit hat das Dokument zu sehen. "
     . "&quot;Alle registrierten Benutzer&quot;, damit nur Benutzer, die ein Benutzerkonto bei Dir haben, das Dokument sehen können. "
     . "Du kannst das Dokument auch nur für einen bestimmten Benutzer zugäglich machen, indem Du unter " . _DML_USERS . " ihn auswählst; "
     . "nur dieser Benutzer wird einen Zugang bekommen. "
     . "Du kannst das Dokument auch nur einer bestimmten Gruppe zugäglich machen, indem Du unter " . _DML_GROUPS . " den Gruppennamen auwählst; "
     . "nur die Mitglieder dieser Gruppe werden einen Zugang bekommen.");
define('_MANT_TOOLTIP', "Diese Einstellung regelt, wer das Dokument bearbeiten oder verwalten kann. "
     . "Wenn ein Benutzer oder ein Mitglied einer Gruppe der " . _DML_MAINTAINER . " ist, so kann er die speziellen Verwaltungsoptionen nutzten: bearbeiten, update, verschieben, ein-/auschecken und löschen.");
define('_DML_MAKE_SURE', "Stelle sicher, dass die URL mit 'http://' beginnt.");
define('_DML_DOCURL', "URL des Dokuments");
define('_DML_DOCURL_TOOLTIP', "Wenn Du verlinkte Dokumente hast, dann musst Du die vollständige Adresse für das Dokument eingeben. Denke an das Protokoll (&quot;http://&quot; oder &quot;ftp://&quot;) am Anfang der URL!");
define('_DML_HOMEPAGE_TOOLTIP', "Vielleicht willst Du eine Webseitenadresse (URL) für weitere Informationen zum Dokument angeben. Gebe immer &quot;http://&quot; am Anfang an oder es wird nicht funktionieren.");
define('_DML_LICENSE_TOOLTIP', "Ein Dokument kann eine Lizenz haben, die die Benutzer akzeptieren sollen, bevor sie die Datei herunterladen können. Hier kannst Du den Lizenztyp angeben.");
define('_DML_DISPLAY_LICENSE', "Lizenz bei Download anzeigen");
define('_DML_DISPLAY_LIC_TOOLTIP', "Wähle &quot;Ja&quot;, wenn Du willst, dass die Lizenz angezeigt wird, bevor der Benutzer Zugriff bekommt.");
define('_DML_APPROVED_TOOLTIP', "Ein Dokument muss freigegeben sein, damit es als Download verfügbar ist. Wähle &quot;Ja&quot; hier und vergesse nicht das Dokument zu veröffentlichen! Beide Optionen müssen auf &quot;Ja&quot; stehen, damit es im Frontend angezeigt wird!");
define('_DML_PLEASE_SEL_CAT', "Bitte wähle zuerst min. eine Kategorie aus!");
define('_DML_MANT_TOOLTIP', "Diese Einstellung regelt, wer das Dokument bearbeiten kann. "
     . "Wenn ein Benutzer oder ein Mitglied einer Gruppe der " . _DML_MAINTAINER . " ist, so kann er die speziellen Verwaltungsoptionen nutzten: bearbeiten, update, verschieben, ein-/auschecken und löschen.");
define('_DML_DISPLAY_LIC', "Lizenz anzeigen");

define('_DML_TAB_PERMISSIONS', "Zugriff");
define('_DML_TAB_LICENSE', "Lizenz");
define('_DML_TAB_DETAILS', "Details");
define('_DML_TAB_PARAMS', "Parameter");

define('_DML_TITLE_DOCINFORMATION', "Dokumenteninformation");
define('_DML_TITLE_DOCPERMISSIONS', "Dokumentenzugriffsrechte");
define('_DML_TITLE_DOCLICENSES', "Dokumentenlizenz");
define('_DML_TITLE_DOCDETAILS', "Dokumentendetails");
define('_DML_TITLE_DOCPARAMETERS', "Dokumentenparameter");

define('_DML_CREATED_BY', "Erstellt von");
define('_DML_UPDATED_BY', "Zuletzt aktualisiert von");
define('_DML_SELECT_ITEM_DEL', "Wähle etwas zum Löschen aus!"); // No Enties
define('_DML_SELECT_ITEM_MOVE', "Wähle etwas zum Verschieben aus!"); // No Enties
define('_DML_SELECT_ITEM_COPY', "Wähle etwas zum Kopieren aus!"); // No Enties
define('_STATUS_YOU', "Dieses Dokument ist von Ihnen ausgecheckt worden.");
define('_STATUS_NOT_OUT', "Dieses Dokument ist nicht ausgecheckt.");
define('_DML_NEW_DOCUMENT', "Neues Dokument");
define('_DML_DOCUMENTS_MOVED_TO', "Dokument(e) wurden verschoben nach"); // [Number of] Documents moved to [location]
define('_DML_DOCUMENTS_COPIED_TO', "Dokument(e) wurden kopiert nach"); // [Number of] Documents moved to [location]


// -- Categories
define('_DML_CATDETAILS', "Kategoriedetails");
define('_DML_CATTITLE', "Kategorietitel");
define('_DML_CATNAME', "Kategoriename");
define('_DML_LONGNAME', "Ein langer Name, der im oberen Bereich angezeigt wird.");
define('_DML_PARENTITEM', "Aktuelle Kategorie");
define('_DML_IMAGE', "Bild");
define('_DML_PREVIEW', "Vorschau");
define('_DML_IMAGEPOS', "Bildposition");
define('_DML_ORDERING', "Sortierung");
define('_DML_ACCESSLEVEL', "Zugangslevel");
define('_DML_CREATEMENUITEM', "Dieses wird einen neuen Menüeintrag in dem von Dir gewählten Men&uuml erstellen.");
define('_DML_SELECTMENU', "Wähle ein Menü");
define('_DML_SELECTMENUTYPE', "Wähle ein Menütyp");
define('_DML_MENUITEMNAME', "Menüeintragsname");
define('_DML_SELECTCATTO', "Wähle eine Kategorie um");
define('_DML_SELECTCATTODELETE', "Wähle eine Kategorie zum Löschen aus!");
define('_DML_REORDER', "Sortierung");
define('_DML_ACCESS', "Zugang");
define('_DML_CAT_MUST_SELECT_NAME', "Die Kategorie muss einen Namen haben!");
define('_DML_CATS_CANT_BE_REMOVED', "kann nicht gelöscht werden, da in ihr noch Dokumente und/oder Unterkategorien vorhanden sind!");

// -- Groups
define('_DML_TITLE_GROUPS', "Gruppen");
define('_DML_CANNOT_DEL_GROUP', "Kann die Gruppe nicht löschen, da ihr noch ein Dokument zugewiesen ist!");
define('_DML_USERS_AVAILABLE', "Benutzer verfügbar");
define('_DML_MEMBERS_IN_GROUP', "Mitglieder in dieser Gruppe");
define('_DML_ADD_GROUP_TIP', "Klicke doppelt auf einen Namen oder benutze die Pfeile, um Benutzer hinzuzufügen oder zu löschen. "
     . "Um mehr als einen Benutzer zu markieren, " . _DML_MULTIPLE_SELECTS);
define('_DML_ADDING_USERS', "Benutzer zu einer Gruppe hinzufügen");
define('_DML_FILL_FORM', "Bitte fülle das Formular korrekt aus!");
define('_DML_ONLY_ADMIN_EMAIL', "Nur ein Super Administrator kann eine Massen E-Mail versenden!");
define('_DML_NO_TARGET_EMAIL', "Es gibt keinen Benutzer in der Gruppe mit einer korrekten E-Mail-Adresse!");
define('_DML_THIS_IS', "Dieses ist eine E-Mail-Nachricht von");
define('_DML_SENT_BY', "gesendet von DOCman an alle Mitglieder der Dokumentengruppe.");
define('_DML_EMAIL_SENT_TO', "E-Mail gesendet zu");
define('_DML_MEMBERS', "Mitglieder");
define('_DML_EMAIL', "E-Mail");
define('_DML_USER_BLOCKED', "blockiert");

// -- Licenses
define('_DML_LICENSE_TEXT', "Lizenztext");
define('_DML_CANNOT_DEL_LICENSE', "Kann die Lizenz nicht löschen, da sie noch von einem Dokument benutzt wird.");


// -- Config
define('_DML_FRONTEND', "Frontend");
define('_DML_PERMISSIONS', "Zugriff");
define('_DML_RESETDEFAULT', "Auf Standard zurücksetzen");
define('_DML_ASCENDENT', "Aufsteigend");
define('_DML_DESCENDENT', "Absteigend");

define('_DML_CONFIGURATION', "DOCman-Konfiguration");
define('_DML_CONFIG_UPDATED', "Die Konfiguration wurde aktualisiert!");
define('_DML_CONFIG_WARNING', "WARNUNG: Konfiguration aktualisiert, aber die Größe des Upload-Maximums ist größer als das PHP-Maximum: ");
define('_DML_CONFIG_ERROR', "Ein Fehler ist aufgetreten: Die Konfigurationsdatei konnte nicht überschrieben werden!");
define('_DML_CONFIG_ERROR_UPLOAD', "FEHLER: Die Größe des Upload-Maximums kann nicht negativ sein!");

define('_DML_CFG_DOCMANTT', "DOCman-Tooltip...");
define('_DML_CFG_ALLOWBLANKS', "Leerzeichen erlauben");
define('_DML_CFG_REJECT', "Zurückweisen");
define('_DML_CFG_CONVERTUNDER', "Mit Unterstrichen ersetzten");
define('_DML_CFG_CONVERTDASH', "Mit Bindestrichen ersetzten");
define('_DML_CFG_REMOVEBLANKS', "Leerzeichen entfernen");
define('_DML_CFG_PATHFORSTORING', "Pfad um Dateien zu speichern");
define('_DML_CFG_PATHTT', "Hier sollst Du das lokale Verzeichnis angeben, wo alle Dateien gespeichert werden sollen. Gebe einen absoluten Pfad an! Du kannst den Standard-Pfad benutzen oder Du trägst einen eigenen hier ein.<br /><br />"
     . "Zum Beispiel: Auf einem &quot;NIX-System&quot; könnte das so aussehen: &quot;/var/usr/www/dmdocuments&quot;<br /><br />"
     . "Wenn Du einen Windows basierenden Server benutzen, könnte das so aussehen: &quot;c:/inetpub/www/dmdocuments&quot;");
define('_DML_CFG_SECTIONISDOWN', "DOCman gesperrt?");
define('_DML_CFG_SECTIONTT', "Wenn Du normale Benutzer vom Zugang zu den Downloads ausschließen wollen, dann stelle diese Option auf &quot;Ja&quot;. <br />"
     . "Dieses ist sinnvoll, wenn Du testen oder die Downloads aktualisieren willst.<br /><br />"
     . "Administratoren und Benutzer mit dem Status &quot;Special&quot; werden weiterhin Zugriff auf die Downloads haben, als würde diese Option auf &quot;Nein&quot; stehen. <br />"
    );
define('_DML_CFG_NUMBEROFDOCS', "Anzahl der Dokumente pro Seite");
define('_DML_CFG_NUMBERTT', "Anzahl der Dokumente, die auf einer Seite angezeigt werden sollen. Sollten mehr als die eingegebene Zahl vorhanden sein, so werden die Dokumente auf eine zweite Seite ausgedehnt und sind dann über ein Menü erreichbar.");

define('_DML_CFG_GUEST', "Gäste");
define('_DML_CFG_GUEST_NO', "Kein Zugang");
define('_DML_CFG_GUEST_X', "Nur durchsuchen");
define('_DML_CFG_GUEST_RX', "Durchsuchen, downloaden und anzeigen");
define('_DML_CFG_GUEST_TT', "Dieses stellt ein, was Gäste (nicht angemeldete Benutzer) machen können: <br /><b>&quot;"
     . _DML_CFG_GUEST_NO . "&quot;:</b> Keine Dokumente werden angezeigt.<br /><b>&quot;"
     . _DML_CFG_GUEST_X . "&quot;:</b> Erlaubt ihnen vorhandene Dokumente zu sehen, aber sie nicht herunterladen zu können. <br /><b>&quot;"
     . _DML_CFG_GUEST_RX . "&quot;:</b> Erlaubt ihnen Dokumente zu sehen und herunterzuladen."
     . "<br /><br />Diese Berechtigung ist zusätzlich zu der individuellen Dokumenten-Berechtigungen."
     . "</span>");

define('_DML_CFG_AUTHOR_NONE', "Kein Zugang");
define('_DML_CFG_AUTHOR_READ', "Nur downloaden");
define('_DML_CFG_AUTHOR_BOTH', "Downloaden und Bearbeiten");

define('_DML_CFG_ICONSIZE', "Icongröße");
define('_DML_CFG_DAYSFORNEW', "Tage für &quot;Neu&quot;-Anzeige");
define('_DML_CFG_DAYSFORNEWTT', "Anzahl der Tage, die eine Datei als &quot;Neu&quot; angezeigt wird. Wird den Link &quot;" . _DML_NEW . "&quot; neben dem Dokumentennamen anzeigen, wenn eine Liste an Dokumenten angezeigt wird. Wenn diese Einstellung auf &quot;0&quot; steht, so wird der Link nicht angezeigt.");
define('_DML_CFG_HOT', "Downloads für &quot;Beliebt&quot;-Anzeige");
define('_DML_CFG_HOTTT', "Die Anzahl von Zugriffen bevor ein Dokument als beliebt markiert wird. Dabei wird &quot;" . _DML_HOT . "&quot; neben dem Dokumentennamen angezeigt, wenn der angegebene Wert erreicht wird. Wenn dieser Wert auf &quot;0&quot; gesetzt wird, so wird dieser Text nicht angezeigt.");
define('_DML_CFG_DISPLAYLICENSES', "Lizenzen anzeigen?");

define('_DML_CFG_VIEW', "Anzeige");
define('_DML_CFG_VIEWTT', "Hier kannst Du den Standard-Benutzer bzw. die Standard-Gruppe eintragen, die ein Dokument anzeigen darf. Diese Einstellung kann in jedem Dokument überschrieben werden.");
define('_DML_CFG_MAINTAIN', "Verwaltung");
define('_DML_CFG_MAINTAINTT', "Hier kannst Du den Standard-Benutzer bzw. die Standard-Gruppe eintragen, die ein Dokument verwalten darf. Diese Einstellung kann in jedem Dokument überschrieben werden.");
define('_DML_CFG_CREATORS_PERM', "Ersteller können");
define('_DML_CFG_CREATORSPERMTT', "Hier kannst Du allgemein einstellen, was ein Ersteller eines Dokumentes darf.<br /><br />"
     . "Diese Berechtigung ist zusätzlich zu den Feldern &quot;Leser&quot; und &quot;Verwalter&quot; in jedem Dokument.");
define('_DML_CFG_WHOCANAREADER', "Download");
define('_DML_CFG_WHOCANAREADERTT', "Hier kannst Du einstellen, ob ein Ersteller/Verwalter die Anzeigeberechtigung seines Dokuments ändern kann.<br /><br />"
     . "Hinweis: Administratoren können immer die Anzeigeberechtigungen verändern!");
define('_DML_CFG_WHOCANAEDITOR', "Bearbeiten");
define('_DML_CFG_WHOCANAEDITORTT', "Hier kannst Du einstellen, ob der Ersteller/Verwalter die Verwaltungsberechtigung ändern kann.<br /><br />"
     . "Hinweis: Administratoren können immer einen Verwalter ändern!");

define('_DML_CFG_EMAILGROUP', "E-Mail an Gruppenmitglieder");
define('_DML_CFG_EMAILGROUPTT', "Wenn &quot;Ja&quot;, wird ein Link neben jedes Gruppendokument (die Gruppe ist als &quot;Besitzer&quot; eines Dokuments eingetragen) gesetzt, der es ermöglicht der gesamten Gruppe eine E-Mail-Nachricht zu senden.");

define('_DML_CFG_UPLOAD', "Upload");
define('_DML_CFG_UPLOADTT', "Hier kannst Du den Benutzer bzw. die Gruppe wählen, die Dokumente hochladen darf. Diese Funktion beinhaltet alle Hochlademethoden: http, Link und Transfer.");
define('_DML_CFG_APPROVE', "Freigabe");
define('_DML_CFG_APPROVETT', "Hier kannst Du den Benutzer bzw. die Gruppe wählen, die Dokumente freigeben dürfen.<br />Dokumente müssen freigegeben und veröffentlicht werden, bevor sie verfügbar sind.");
define('_DML_CFG_PUBLISH', "Veröffentlichung");
define('_DML_CFG_PUBLISHTT', "Hier kannst Du den Benutzer bzw. die Gruppe wählen, die Dokumente veröffentlichen dürfen.<br />Dokumente müssen freigegeben und veröffentlicht werden, bevor sie verfügbar sind.");
define('_DML_CFG_USER_UPLOAD', "Wer darf hochladen?");
define('_DML_CFG_USER_APPROVE', "Wer darf freigeben?");
define('_DML_CFG_USER_PUBLISH', "Wer darf veröffentlichen?");

define('_DML_CFG_EXTALLOWED', "Erlaubte Dateiendungen");
define('_DML_CFG_EXTALLOWEDTT', "Dateitypen, die hochgeladen werden dürfen. Dateiendungen durch &quot;|&quot; trennen. Backend-Benutzer können jede Datei hochladen!");
define('_DML_CFG_MAXFILESIZE', "Max. Dateigröße beim Upload");
define('_DML_CFG_MAXFILESIZETT', "Die maximale Dateigröße beim Hochladen im Frontend. Du kannst K/M/G (<b>K</b>ilobyte/<b>M</b>egabyte/<b>G</b>igabyte) als Shortcuts für diesen Eintrag benutzen.<br />Dieses Limit betrifft das Hochladen im Backend nicht!<br /><hr />Es gibt auf Deinem Server eine PHP-Variable, upload_max_filesize, sie steht auf ");
define('_DML_CFG_USERCANUPLOAD', "Benutzer dürfen alle Dateitypen hochladen?");
define('_DML_CFG_USERCANUPLOADTT', "Wenn &quot;Ja&quot; und &quot;Benutzer dürfen hochladen&quot;, dann können registrierte Benutzer alle Dateitypen hochladen, egal was Du oben ausgeschlossen hast!");
define('_DML_CFG_OVERWRITEFILES', "Dateien überschreiben?");
define('_DML_CFG_OVERWRITEFILESTT', "Wenn &quot;Ja&quot;, dann werden gleichnamige Dateien auf dem Server überschrieben.");
define('_DML_CFG_LOWERCASE', "Dateinamen in Kleinbuchstaben?");
define('_DML_CFG_LOWERCASETT', "Wenn &quot;Ja&quot;, dann werden alle Dateinamen klein geschrieben, z.B.&nbsp;&quot;IhreDatei.TXT&quot; wird zu &quot;ihredatei.txt&quot;.<br />Wenn &quot;Nein&quot;, dann werden alle Dateinamen so gespeichert, wie sie hochgeladen werden (Groß- und Kleinschreibung wird ignoriert).");
define('_DML_CFG_FILENAMEBLANKS', "Dateinamen mit Leerzeichen");
define('_DML_CFG_FILENAMEBLANKSTT', "Behandlung von Dateinamen mit Leerzeichen:<br />"
     . "&quot;Leerzeichen erlauben&quot; wird die Datei mit Leerzeichen speichern.<br />"
     . "&quot;Zurückweisen&quot; wird den Upload solcher Dateien verhindern.<br /><br />"
     . "Du kannst auch die Dateinamen in Unterstriche (_), Bindestriche (-) konvertieren oder Du lässt sie entfernen.");
define('_DML_CFG_REJECTFILENAMES', "Abgelehnte Dateinamen");
define('_DML_CFG_REJECTFILENAMESTT', "Gebe hier eine Liste von Dateinamen an, durch &quot;|&quot; getrennt, die nicht hochgeladen werden dürfen. Diese Dateinamen haben z.B. spezielle Aufgaben im System. &quot;.htaccess&quot; wird standardmäßig abgelehnt.<br />Du kannst auch andere Namen angeben, die zu Problemen auf Deinem System führen würden, wie z.B. *, ), $, ? oder (");
define('_DML_CFG_UPMETHODS', "Upload-Methoden?");
define('_DML_CFG_UPMETHODSTT', "Wähle hier die Methoden zum Hochladen aus, die dem Benutzer zur Verfügung stehen sollen. Administratoren können allen Methoden nutzen! Mehrere Methoden auswählen mit: " . _DML_MULTIPLE_SELECTS);

define('_DML_CFG_ANTILEECH', "Anti-Leech-System?");
define('_DML_CFG_ANTILEECHTT', "Das Anti-Leech-System schützt Deine Downloads vor dem Verlinken von anderen Seiten auf Deine Dokumente. "
     . "Wenn Du diese Einstellung auf &quot;Ja&quot; stellst, so wird jede Anfrage auf einen Download, "
     . "anhand der Hostadresse (HTTP-Referer) mit der Liste an erlaubten Hosts überprüft. Wenn der Host keinen Zugriff hat, so wird der Zugang verweigert. "
     . "Dieses System schützt Dich davor, dass andere Betreiber Dein Downloadverzeichnis ausnutzen.<br /><br />"
     . "Hinweis: DOCman unterstützt das direkte Verlinken zwischen Systemen. "
     . "Wenn Du Links benutzt, dann stelle vorher sicher, dass der andere Betreiber Dich in der Liste erlaubter Hosts eingetragen hat."
    );
define('_DML_CFG_ALLOWEDHOSTS', "Erlaubte Hosts");
define('_DML_CFG_ALLOWEDHOSTSTT', "Eine Liste von Hosts, die bei aktiviertem Anti-Leech-System auf Deine Dokumente zugreifen dürfen. Bitte trenne mehrere Systeme durch ein &quot;|&quot;.<br />Die Standardeinstellung ist im allgemeinen sicher.");

define('_DML_CFG_LOG', "Anzeige protokollieren?");
define('_DML_CFG_LOGTT', "Hierbei werden folgende Informationen gespeichert: IP-Adresse, Datum/Zeit und welches Dokument heruntergeladen wurde. "
     . "Mit dieser Option werden viele Informationen in die Datenbank geschrieben!<hr />"
     . "Mambots mit weiteren Protokolleigenschaften sind verfügbar.");

define('_DML_CFG_UPDATESERVER', "DOCman Updates");
define('_DML_CFG_UPDATESERVERTT', "DOCman kann sich selber aktualisieren und dabei verfügbare Module, Plugins und Bots installieren. Darüber hinaus können wärend des Upgrades Datenbankänderungen durchgeführt werden! Gebe hier die Adresse zum DOCman-Updateserver ein. Wenn sich die Adresse nicht geändert hat (das hoffen wir!), dann lasse bitte das Feld auf seinem Standardwert.");
define('_DML_CFG_DEFAULTLISTING', "Standardsortierung");
define('_DML_CFG_TRIMWHITESPACE', "Leerzeichen filtern");
define('_DML_CFG_TRIMWHITESPACETT', "Leerzeichen und leere Linien werden vom Theme gefiltert.");

define('_DML_CFG_ERR_DOCPATH', 'Tab [' . _DML_GENERAL . '] \'' . _DML_CFG_PATHFORSTORING . '\' muss ausgefüllt sein!');
define('_DML_CFG_ERR_PERPAGE', 'Tab [' . _DML_FRONTEND . '] \'' . _DML_CFG_NUMBEROFDOCS . '\' muss numerisch und größer als null sein!');
define('_DML_CFG_ERR_NEW', 'Tab [' . _DML_FRONTEND . '] \'' . _DML_CFG_DAYSFORNEW . '\' muss numerisch, null oder größer sein!');
define('_DML_CFG_ERR_HOT', 'Tab [' . _DML_FRONTEND . '] \'' . _DML_CFG_HOT . '\' muss numerisch und null oder größer sein!');
define('_DML_CFG_ERR_UPLOAD', 'Tab [' . _DML_PERMISSIONS . '] \'' . _DML_CFG_UPLOAD . '\': Gebe ein, wer Dokumente hochladen darf.');
define('_DML_CFG_ERR_APPROVE', 'Tab [' . _DML_PERMISSIONS . '] \'' . _DML_CFG_APPROVE . '\': Gebe ein, wer Dokumente freigeben darf.');
define('_DML_CFG_ERR_DOWNLOAD', 'Tab [' . _DML_PERMISSIONS . '] \'' . _DML_CFG_VIEW . '\': Wähle die Standard Benutzer/Gruppe.');
define('_DML_CFG_ERR_EDIT', 'Tab [' . _DML_PERMISSIONS . '] \'' . _DML_CFG_MAINTAIN . '\': Wähle die Standard Benutzer/Gruppe zum Verwalten des Dokuments aus.');
define('_DML_CFG_EXTENSIONSVIEWING', "Dateiendungen zur Anzeige");
define('_DML_CFG_EXTENSIONSVIEWINGTT', "Dateiendungen können angezeigt werden. Leer lassen für keine; &quot;*&quot; für alle. Mehrere Erweiterungen durch (|) trennen (z.B. txt|pdf ).");

define('_DML_CFG_GENERALSET', "Allgemeine Einstellungen");
define('_DML_CFG_THEMES', "Themes");
define('_DML_CFG_EXTRADOCINFO', "Zusätzliche Dokumenteninformationen");
define('_DML_CFG_GUESTPERM', "Gast-Berechtigungen");
define('_DML_CFG_FRONTPERM', "Frontend-Berechtigungen");
define('_DML_CFG_DOCPERM', "Dokument-Berechtigungen");
define('_DML_CFG_OVERRIDEVIEW', "Anzeige überschreiben");
define('_DML_CFG_OVERRIDEMANT', "Verwaltung überschreiben");
define('_DML_CFG_CREATORPERM', "Ersteller-Berechtigungen");
define('_DML_CFG_FILEXTENSIONS', "Dateiendungen");
define('_DML_CFG_FILENAMES', "Dateinamen");

define('_DML_CFG_PROCESS_BOTS', "Inhalt-Mambots benutzen?");
define('_DML_CFG_PROCESS_BOTSTT', "Durch diese Funktion können Mambots auf Dokumenten- und Kategoriebeschreibungen angewand werden. Dieses erlaubt Dir &quot;{Tags}&quot; in Beschreibungen zu nutzen. Warnung: Nicht alle Mambots arbeiten reibungslos mit dieser Funktion!");
define('_DML_CFG_INDIVIDUAL_PERM', "Individuelle Benutzerberechtigungen erlauben?");
define('_DML_CFG_INDIVIDUAL_PERMTT', "Wenn Du diese Einstellung deaktivierst, so wirst Du zwar weiterhin in der Lage sein Berechtigungen einer Gruppe zuzuweisen, aber nicht mehr einem einzelnen Benutzer. Deine bestehenden Dokument-Berechtigungen werden erhalten bleiben, aber wenn ein Dokument bearbeitet wird, dass einem einzelnen Benutzer zugeteilt ist, so muss dann eine Benutzergruppe ausgewählt werden. Schalte diese Funktion aus, wenn Du die Geschwindigkeit und die Speicherkapazität steigern möchtest.");
define('_DML_CFG_HIDE_REMOTE', "Remote Links verbergen");
define('_DML_CFG_HIDE_REMOTETT', "Diese Option versteckt sog. &quot;Remote Links&quot;, also Links auf andere Server. Benutzer mit der Berechtigung Daten zu ändern können aber weiterhin den Link sehen. Hinweis: Diese Funktion bietet keine absolute Sicherheit für &quot;Remote Links&quot;! Die Benutzer können immernoch herausfinden, wie der exakte Link zur Datei ist!");

// -- Statistics
define('_DML_STATS', "Statistik");
define('_DML_DOCSTATS', "DOCman-Statistik - Top 50 Downloads");
define('_DML_RANK', "Rang");

// -- Logs
define('_DML_DOWNLOAD_LOGS', "Download-Protokolle");
define('_DML_IP', "IP");
define('_DML_BROWSER', "Browser");
define('_DML_OS', "Betriebssystem");
define('_DML_ANONYMOUS', "Anonym");

// -- Updates
define('_DML_UPGRADE', "Upgrade");
define('_DML_YOU_HAVE_VERSION', "Du hast die Version");
define('_DML_UPTODATE', "Deine Version ist aktuell!");
define('_DML_NO_UP_AVAIL', "Keine Updates zum jetzigen Zeitpunkt verfügbar!");
define('_DML_COULD_NOT_COPY', "Es konnten nicht alle Dateien zu ihren Verzeichnissen kopiert werden! Überprüfe die Dateiberechtigungen! Gestoppt bei der Datei");
define('_DML_UPDATING_DB', "Datenbank wird aktualisiert...");
define('_DML_DELETING_OLD', "Alte Dateien werden gelöscht...");
define('_DML_ERROR_DELETING_OLD', "Fehler beim Löschen der alten Dateien! Kein kritischer Fehler!");
define('_DML_PACKAGE', "Paket");
define('_DML_INST_CLICK', "installiert. Klick");
define('_DML_HERE', "hier");
define('_DML_TO_CONT', "um fortzufahren");
define('_DML_ERROR_READING', "Fehler beim Lesen");
define('_DML_XML_ERROR', "XML-Datei fehlerhaft");
define('_DML_CHECKING_UP', "Überprüfung auf Updates");
define('_DML_RELEASED_ON', "Veröffentlicht am");

// -- Themes
define('_DML_THEMES', "Themes");
define('_DML_EDIT_DEFAULT_THEME', "Aktuelles Theme bearbeiten");
define('_DML_THEME_INSTALLED', "Theme installiert!");
define('_DML_ADJUST_CONFIG', "Konfiguration anpassen");
define('_DML_NEED_ZLIB', "Die Installation kann erst nach der Installierung von Zlib fortgesetzt werden!");
define('_DML_INSTALLER_ERROR', "Installation - Fehler");
define('_DML_SUCCESFULLY_INSTALLED', "Erfolgreich installiert!");
define('_DML_ENABLE_FILE_UPLOADS', "Datei-Uploads müssen aktiviert sein, um fortzufahren!");
define('_DML_UPLOAD_ERROR', "Upload-Fehler!");
define('_DML_EXTRACT_FAILED', "Extraktion fehlgeschlagen!");
define('_DML_INSTALL_FAILED', "Installation fehlgeschlagen!");
define('_DML_UNINSTALL_FAILED', "Deinstallation fehlgeschlagen!");
define('_DML_INSTALL_FROM_DIRECTORY', "Installation von einem Verzeichnis");
define('_DML_INSTALL_DIRECTORY', "Installationsverzeichnis");
define('_DML_PACKAGE_FILE', "Paketdatei");
define('_DML_UPLOAD_PACKAGE_FILE', "Paketdatei hochladen");
define('_DML_UPLOAD_AND_INSTALL', "Datei hochladen und installieren");
define('_DML_INSTALL_THEME', "Theme installieren");
define('_DML_SELECT_DIRECTORY', "Bitte gebe ein Verzeichnis an!");
define('_DML_SELECT_PACKAGE', "Bitte wähle ein Paket!");
define('_DML_STYLESHEET_EDITOR', "Theme-Stylesheet-Editor");
define('_DML_OPFAILED_NO_TEMPLATE', _DML_OPERATION_FAILED.": Kein Template ausgewählt!");
define('_DML_OPFAILED_CONTENT_EMPTY', _DML_OPERATION_FAILED.": Inhalt leer!");
define('_DML_OPFAILED_UNWRITABLE', _DML_OPERATION_FAILED.": Die Datei ist schreibgeschützt!");
define('_DML_OPFAILED_CANT_OPEN_FILE', _DML_OPERATION_FAILED.": Datei kann zum Ändern nicht geöffnet werden!");
define('_DML_OPFAILED_COULDNT_OPEN', _DML_OPERATION_FAILED.": Kann nicht geöffnet werden ");
define('_DML_AUTHOR_URL', "Autor-URL" );
define('_DML_AUTHOR', "Autor" );
define('_DML_INSTALLED_THEMES', "Installierte Themes");
define('_DML_THEME_DETAILS', "Themedetails");
define('_DML_EDIT_THEME', "Theme bearbeiten");


// -- E-mail
define('_DML_EMAIL_GROUP', "E-Mail an die Gruppe senden");
define('_DML_SUBJECT', "Betreff");
define('_DML_EMAIL_LEADIN', "Einleitungstext");
define('_DML_MESSAGE', "Nachricht");
define('_DML_SEND_EMAIL', "Senden");

// -- Credits
define('_DML_CREDITS', "Credits" );
define('_DML_APPLICATION', "Program");
define('_DML_ICONS', "Icons");
define('_DML_ICONS_PERMISSION', "Icons mit Erlaubnis benutzt von" );
define('_DML_CHANGELOG', "Changelog");

// -- Clear Data
define('_DML_CLEARDATA', "Daten löschen" );
define('_DML_CLEARDATA_CLEARED', "Daten gelöscht " );
define('_DML_CLEARDATA_FAILED', "Löschen fehlgeschlagen: " );
define('_DML_CLEARDATA_ITEM', "Dokument" );
define('_DML_CLEARDATA_CLEAR', "Löschen" );
define('_DML_CLEARDATA_CATS_CONTAIN_DOCS', "Dokumente vor den Kategorien leeren");
define('_DML_CLEARDATA_DELETE_DOCS_FIRST', "Dokumente vor den Dateien leeren");

// -- Sample data
define('_DML_SAMPLE_CATEGORY', "Beispielkategorie" );
define('_DML_SAMPLE_CATEGORY_DESC', "Du kannst die Beispielkategorie löschen." );
define('_DML_SAMPLE_DOC', "Beispieldokument" );
define('_DML_SAMPLE_DOC_DESC', "Du kannst das Beispieldokument und die verlinkte Datei löschen." );
define('_DML_SAMPLE_FILENAME', "beispiel_datei.png" );
define('_DML_SAMPLE_COMPLETED', "Beispieldaten wurden installiert!" );
define('_DML_SAMPLE_GROUP', "Beispielgruppe" );
define('_DML_SAMPLE_GROUP_DESC', "Du kannst Gruppen dazu nutzen, um bestimmten Gruppen von Benutzern Rechte zu geben." );
define('_DML_SAMPLE_LICENSE', "Beispiellizenz" );
define('_DML_SAMPLE_LICENSE_DESC', "Du kannst optional Lizenzen zu einem Dokument anzeigen lassen." );

// -- Added v1.4.0 RC1
define('_DML_CFG_COMPAT', "Kompatibilität" );
define('_DML_CFG_SPECIALCOMPATMODE', "&quot;Special&quot;-Kompatibilitätsmodus" );
define('_DML_CFG_SPECIALCOMPATMODETT', "Im DOCman 1.3 Kompatibilitätsmodus sind &quot;Special&quot;-Benutzer Amanger, Administratoren und Super Administratoren. Im Joomla!-Modus werden zu dieser Gruppen auch noch Benutzer mit Autoren-, Publisher- und Editor-Rechten gezählt.");
define('_DML_CFG_SPECIALCOMPAT_DM13', "DOCman 1.3" );
define('_DML_CFG_SPECIALCOMPAT_J10', "Joomla!" );
