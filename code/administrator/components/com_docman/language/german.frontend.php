<?php
/**
 * @version		$Id: german.frontend.php 11 2009-10-22 12:58:14Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

/**
 * Default German (formal) language file
 *
 * Creator:  Jan Erik Zassenhaus
 * Website:  http://www.joomlaportal.ch
 * E-mail:   jan.zassenhaus@joomlaportal.ch
 * Revision: 1.4 (translation version)
 * Date:     February 2008
 **/

// -- General
define('_DML_NOLOG', "Sie müssen sich anmelden, damit Sie die verfügbaren Dokumente anzeigen können!");
define('_DML_NOLOG_UPLOAD', "Sie müssen angemeldet und für das Hochladen von Dokumenten freigeschalten sein!");
define('_DML_NOLOG_DOWNLOAD', "Sie müssen angemeldet und Rechte zum Anzeigen dieses Dokumentes haben!");
define('_DML_NOAPPROVED_DOWNLOAD', "Das Dokument muss vorher freigegeben werden, bevor es heruntergladen werden kann!");
define('_DML_NOPUBLISHED_DOWNLOAD', "Das Dokument muss erst veröffentlicht werden, bevor es heruntergladen werden kann!");
define('_DML_ISDOWN', "Entschuldigung, aber dieser Bereich ist wegen Wartungsarbeiten gesperrt. Bitte kommen Sie später wieder!");
define('_DML_SECTION_TITLE', "Downloads");

// -- Files
define('_DML_DOCLINKTO', "Dokument verlinkt zu ");
define('_DML_DOCLINKON', "Link erstellt am ");
define('_DML_ERROR_LINKING', "Fehler beim Verbinden mit dem Server!");
define('_DML_LINKTO', "Link zu ");
define('_DML_DONE', "Fertig.");
define('_DML_FILE_UNAVAILABLE', "Diese Datei ist auf dem Server nicht verfügbar!");

// -- Documents
define('_DML_TAB_BASIC', "Grundlagen");
define('_DML_TAB_PERMISSIONS', "Zugriffsrechte");
define('_DML_TAB_LICENSE', "Lizenz");
define('_DML_TAB_DETAILS', "Details");
define('_DML_TAB_PARAMS', "Parameter");
define('_DML_OP_CANCELED', "Operation abgebrochen!");
define('_DML_CREATED_BY', "Erstellt von");
define('_DML_UPDATED_BY', "Zuletzt geändert von");
define('_DML_DOCMOVED', "Das Dokument wurde verschoben!");
define('_DML_MOVETO', "Verschieben nach");
define('_DML_MOVETHEFILES', "Dateien verschieben");
define('_DML_SELECTFILE', "Bitte eine Datei auswählen!");
define('_DML_THANKSDOCMAN', "Danke für Ihre Übermittlung!");
define('_DML_NO_LICENSE', "Keine Lizenz");
define('_DML_DISPLAY_LIC', "Lizenz anzeigen");
define('_DML_LICENSE_TYPE', "Lizenztyp");
define('_DML_MANT_TOOLTIP', "Diese Einstellung regelt, wer das Dokument bearbeiten oder verwalten darf. "
     . "Wenn ein Benutzer oder ein Mitglied einer Gruppe der " . _DML_MAINTAINER . " ist, so kann er die speziellen Verwaltungsoptionen nutzten: bearbeiten, update, verschieben, ein-/auschecken und löschen.");
define('_DML_ON', "am");
define('_DML_CURRENT', "Aktuell");
define('_DML_YOU_MUST_UPLOAD', "Sie müssen erst ein Dokument in dieser Kategorie anlegen!");
define('_DML_THE_MODULE', "Das Modul");
define('_DML_IS_BEING', "wird momentan von einem anderen Administrator bearbeitet");
define('_DML_LINKED', "->VERLINKTES DOKUMENT<-");
define('_DML_FILETITLE', "Dateititel");
define('_DML_OWNER_TOOLTIP', "Diese Einstellunge regelt, wer das Dokument herunterladen bzw. angucken darf. Auswahl: "
     . "*Jeder*, damit jeder die Möglichkeit hat das Dokument zu sehen. "
     . "*Alle registrierten Benutzer*, damit nur Benutzer, die ein Benutzerkonto bei Ihnen haben, das Dokument sehen können. "
     . "Sie können das Dokument auch nur für einen bestimmten Benutzer zugäglich machen, indem Sie unter " . _DML_USERS . " ihn auswählen; "
     . "nur dieser Benutzer wird einen Zugang bekommen. "
     . "Sie können das Dokument auch nur einer bestimmten Gruppe zugäglich machen, indem Sie unter " . _DML_GROUPS . " den Gruppennamen auwählen; "
     . "nur die Mitglieder dieser Gruppe werden einen Zugang bekommen.");
define('_DML_MAKE_SURE', "Stellen Sie sicher, dass der Link mit 'http://' beginnt.");
define('_DML_DOCURL', "URL des Dokuments:");
define('_DML_DOCDELETED', "Dokument gelöscht.");
define('_DML_DOCURL_TOOLTIP', "Wenn Sie verlinkte Dokumente haben, dann müssen Sie die vollständige Adresse für das Dokument eingeben. Denken Sie an das Protokoll (http:// oder ftp://) am Anfang!");
define('_DML_HOMEPAGE_TOOLTIP', "Vielleicht wollen Sie eine Webseitenadresse (URL) für weitere Informationen zum Dokument angeben. Geben Sie immer &quot;http://&quot; am Anfang an oder es wird nicht funktionieren.");
define('_DML_LICENSE_TOOLTIP', "Ein Dokument kann eine Lizenz haben, die die Benutzer akzeptieren sollen, bevor sie die Datei herunterladen können. Hier können Sie den Lizenztyp angeben.");
define('_DML_DISPLAY_LICENSE', "Lizenz anzeigen bei einem Download.");
define('_DML_DISPLAY_LIC_TOOLTIP', "Wählen Sie &quot;Ja&quot;, wenn Sie wollen, dass die Lizenz dem Benutzer vor dem Zugriff auf den Download angezeigt wird.");
define('_DML_APPROVED_TOOLTIP', "Ein Dokument muss freigegeben sein, damit es als Download verfügbar ist. Wählen Sie &quot;Ja&quot; hier und vergessen Sie nicht das Dokument zu veröffentlichen! Beide Optionen müssen auf &quot;Ja&quot;* stehen, damit es im Frontend angezeigt wird.");
define('_DML_RESET_COUNTER', "Zähler zurückgesetzt!");
define('_DML_PROBLEM_SAVING_DOCUMENT', "Ein Problem ist beim Speichern des Dokuments aufgetreten!");

// -- Download
define('_DML_PROCEED', "Klicken Sie hier, um fortzufahren");
define('_DML_YOU_MUST', "Sie müssen der Lizenz zustimmen, bevor Sie dieses Dokument ansehen können!");
define('_DML_NOTDOWN', "Das Dokument wird gerade bearbeitet bzw. aktualisiert und ist deshalb momentan nicht zu erreichen!");
define('_DML_ANTILEECH_ACTIVE', "Sie versuchen über eine nicht autorisierte Adresse dieses Dokument einzusehen!");
define('_DML_DONT_AGREE', "Ich akzeptiere nicht");
define('_DML_AGREE', "Ich akzeptiere");

// -- Upload
define('_DML_UPLOADED', "Hochgeladen");
define('_DML_SUBMIT', "Senden");
define('_DML_NEXT', "Weiter >>>");
define('_DML_BACK', "<<< Zurück");
define('_DML_LINK', "Link");
define('_DML_EDITDOC', "Dieses Dokument bearbeiten");
define('_DML_UPLOADWIZARD', "Upload-Assistent");
define('_DML_UPLOADMETHOD', "Bitte die Methode zum Hochladen auswählen!");
define('_DML_ISUPLOADING', "Bitte warten! Die Datei wird hochgeladen...");
define('_DML_PLEASEWAIT', "Bitte warten");
define('_DML_DOCMANISLINKING', "DOCman überprüft<br />den Link...");
define('_DML_DOCMANISTRANSF', "DOCman überträgt<br />die Datei...");
define('_DML_TRANSFER', "Transfer");
define('_DML_REMOTEURL', "Externe URL");
define('_DML_LINKURLTT', "Geben Sie eine externen Link zu Ihrer Datei ein. Der Link muss ein Protokoll beinhalten (http:// oder ftp://), den Dateinamen und dessen Dateityp. Zum Beispiel: http://joomlacode.org/gf/download/frsrelease/292/1001/docman_1.3RC2.zip.");
define('_DML_REMOTEURLTT', _DML_LINKURLTT . "<br />Sie können die Datei beliebig auf diesem Server bennen, benutzen Sie hierfür das Feld &quot;Lokaler Name&quot;.");
define('_DML_LOCALNAME', "Lokaler Name");
define('_DML_LOCALNAMETT', "Geben Sie den lokalen Namen für die externe Datei ein."
     . "Dieses Feld müssen Sie ausfüllen, da nur der Link nicht genügend Informationen über die Datei gibt.");
define('_DML_ERROR_UPLOADING', "Fehler beim Hochladen!");

// -- Search
define('_DML_SELECCAT', "Kategorie auswählen");
define('_DML_ALLCATS', "Alle Kategorien");
define('_DML_SEARCH_WHERE', "Suche in");
define('_DML_SEARCH_MODE', "Suchmodus");
define('_DML_SEARCH', "Suche");
define('_DML_SEARCH_REVRS', "Umgekehrt");
define('_DML_SEARCH_REGEX', "Regulärer Ausdruck");
define('_DML_NOT', "Nicht"); // Used for Inversion

// -- E-mail
define('_DML_EMAIL_GROUP', "E-Mail an die Gruppe senden");
define('_DML_SUBJECT', "Betreff");
define('_DML_EMAIL_LEADIN', "Einleitungstext");
define('_DML_MESSAGE', "Nachricht");
define('_DML_SEND_EMAIL', "Senden");

//Document tasks
define('_DML_BUTTON_DOWNLOAD', "Download");
define('_DML_BUTTON_VIEW', "Anzeigen");
define('_DML_BUTTON_DETAILS', "Details");
define('_DML_BUTTON_EDIT', "Ändern");
define('_DML_BUTTON_MOVE', "Verschieben");
define('_DML_BUTTON_DELETE', "Löschen");
define('_DML_BUTTON_UPDATE', "Updaten");
define('_DML_BUTTON_CHECKOUT', "Auschecken");
define('_DML_BUTTON_CHECKIN', "Einchecken");
define('_DML_BUTTON_UNPUBLISH', "Zurückziehen");
define('_DML_BUTTON_PUBLISH', "Veröffentlichen");
define('_DML_BUTTON_RESET', "Zurücksetzen");
define('_DML_BUTTON_APPROVE', "Bestätigen");

// -- Added v1.4.0 RC1
define('_DML_CHECKED_IN', "Eingescheckt");
