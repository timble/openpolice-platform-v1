<?php
/**
 * @version		$Id: german.common.php 11 2009-10-22 12:58:14Z mathias $
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


define ('_DM_DATEFORMAT_LONG', '%d.%m.%Y %H:%M'); // use PHP strftime Format, more info at http://php.net
define ('_DM_DATEFORMAT_SHORT', '%d.%m.%Y');         // use PHP strftime Format, more info at http://php.net
define ('_DM_ISO', 'utf-8');
define ('_DM_LANG', 'de');

// -- General
define('_DML_NAME', "Name");
define('_DML_DATE', "Datum");
define('_DML_DATE_MODIFIED', "Änderungsdatum");
define('_DML_HITS', "Zugriffe");
define('_DML_SIZE', "Größe");
define('_DML_EXT', "Dateiendung");
define('_DML_MIME', "Dateityp");
define('_DML_THUMBNAIL', "Thumbnail");
define('_DML_DESCRIPTION', "Beschreibung");
define('_DML_VERSION', "Version");
define('_DML_DEFAULT', "Standard");
define('_DML_FOLDER', "Ordner");
define('_DML_FOLDERS', "Ordner");
define('_DML_FILE', "Datei");
define('_DML_FILES', "Dateien");
define('_DML_URL', "URL");
define('_DML_PARAMS', "Parameter");
define('_DML_PARAMETERS', "Parameter");
define('_DML_TOP', "Oben");
define('_DML_PROPERTY', "Objekt");
define('_DML_VALUE', "Wert");
define('_DML_PATH', "Pfad");

define('_DML_DOC', "Dokument");
define('_DML_DOCS', "Dokumente");
define('_DML_DOCUMENT', "Dokument");
define('_DML_CAT', "Kategorie");
define('_DML_CATS', "Kategorien");
define('_DML_CATEGORY', "Kategorie");

define('_DML_UPLOAD', "Upload");
define('_DML_SECURITY', "Sicherheit");
define('_DML_CPANEL', "Home");
define('_DML_CONFIG', "Konfiguration");
define('_DML_LICENSE', "Lizenz");
define('_DML_LICENSES', "Lizenzen");
define('_DML_UPDATES', "Updates");
define('_DML_DOWNLOADS', "Downloads");

define('_DML_HOMEPAGE', "Homepage");

define('_DML_NO', "Nein");
define('_DML_YES', "Ja");
define('_DML_OK', "OK");
define('_DML_CANCEL', "Abbrechen");
define('_DML_ADD', "Hinzufügen");
define('_DML_EDIT', "Bearbeiten");
define('_DML_CONTINUE', "Weiter");
define('_DML_SAVE', "Speichern");

define('_DML_APPROVED', "Freigegeben");
define('_DML_DELETED', "Gelöscht");

define('_DML_INSTALL', "Installieren");
define('_DML_PUBLISHED', "Veröffentlicht");
define('_DML_UNPUBLISH', "Nicht veröffentlicht");
define('_DML_CHECKED_OUT', "Ausgechecked");

define('_DML_TOOLTIP', "Tooltip");
define('_DML_FILTER_NAME', "Nach Name filtern");

define('_DML_TITLE', "Titel");
define('_DML_MULTIPLE_SELECTS', "Halten Sie den <b>Strg</b>-Knopf (für Windows/Unix/Linux) oder den <b>Command</b>-Knopf (für Mac) gedrückt, währen Sie markieren.");

define('_DML_USER', "Benutzer");
define('_DML_OWNER', "Leser");
define('_DML_CREATOR', "Ersteller");
define('_DML_EDITOR', "Verwalter");
define('_DML_MAINTAINER', "Verwalter");
define('_DML_UNKNOWN', "Unbekannt");

define('_DML_FILEICON_ALT', "Datei-Icon");

define('_DML_NOT_AUTHORIZED', "Nicht authorisiert");
define('_DML_ERROR', "Fehler");
define('_DML_OPERATION_FAILED', "Operation fehlgeschlagen!");

define('_DML_EDIT_THIS_MODULE', "Dieses Modul bearbeiten");
define('_DML_UNPUBLISH_THIS_MODULE', "Dieses Modul nicht mehr veröffentlichen");
define('_DML_ORDER_THIS_MODULE', "Dieses Modul sortieren");

define('_DML_WRITABLE', "nicht schreibgeschützt");
define('_DML_UNWRITABLE', "schreibgeschützt");

define('_DML_SAVED_CHANGES', "Änderungen gespeichert!");
define('_DML_ARE_YOU_SURE', "Sind Sie wirklich sicher?");


// -- HTML Class
define('_DML_SELECT_CAT', "Kategorie auswählen");
define('_DML_SELECT_DOC', "Dokument auswählen");
define('_DML_SELECT_FILE', "Datei wählen");
define('_DML_ALL_CATS', "- Alle Kategorien");
define('_DML_SELECT_USER', "Benutzer wählen"); // No Enties
define('_DML_GENERAL', "Allgemein");
define('_DML_GROUPS', "Gruppen");
define('_DML_DOCMAN_GROUPS', "DOCman-Gruppen");
define('_DML_MAMBO_GROUPS', "Joomla!-Gruppe");
define('_DML_JOOMLA_GROUPS', "Joomla!-Gruppen"); // alias
define('_DML_USERS', "Benutzer");
define('_DML_EVERYBODY', "Jeder");
define('_DML_ALL_REGISTERED', "Alle registrierten Benutzer");
define('_DML_NO_USER_ACCESS', "Kein Benutzerzugang");
define('_DML_AUTO_APPROVE', "Auto. Freigabe");
define('_DML_AUTO_PUBLISH', "Auto. Veröffentlichen"); // No Enties
define('_DML_GROUP', "Gruppe");
define('_DML_GROUP_PUBLISHER', "Publisher");
define('_DML_GROUP_EDITOR', "Editor");
define('_DML_GROUP_AUTHOR', "Author");

// -- File Class
define('_DML_OPTION_HTTP', "Datei von lokalem Rechner hochladen");
define('_DML_OPTION_XFER', "Datei von einem anderen Server übertragen");
define('_DML_OPTION_LINK', "Dateilink auf einen anderen Server");
define('_DML_SIZEEXCEEDS', "Die Größe überschreitet Maximum!");
define('_DML_ONLYPARTIAL', "Nur ein Teil der Datei erhalten. Bitte Vorgang wiederholen.");
define('_DML_NOUPLOADED', "Kein Dokument hochgeladen.");
define('_DML_TRANSFERERROR', "Transferfehler aufgetreten");
define('_DML_DIRPROBLEM', "Verzeichnisproblem. Datei kann nicht verschoben werden!");
define('_DML_DIRPROBLEM2', "Verzeichnisproblem");
define('_DML_COULDNOTCONNECT', "Verbindung zum Server nicht möglich");
define('_DML_COULDNOTOPEN', "Das Zielverzeichnis konnte nicht geöffnet werden! Überprüfen Sie die Berechtigungen!");
define('_DML_FILETYPE', "Dateityp");
define('_DML_NOTPERMITED', "nicht erlaubt");
define('_DML_EMPTY', "Leer");

define('_DML_ALREADYEXISTS', "existiert bereits!");
define('_DML_PROTOCOL', "Protokoll");
define('_DML_NOTSUPPORTED', "Nicht unterstützt!");
define('_DML_NOFILENAME', "Kein Dateiname eingegeben!");
define('_DML_FILENAME', "Dateiname");
define('_DML_CONTAINBLANKS', "enthält Leerzeichen!");
define('_DML_ISNOTVALID', "ist kein gültiger Dateiname!");
define('_DML_SELECTIMAGE', "Bild auswählen");
define('_DML_FAILEDTOCREATEDIR', "Verzeichnis kann nicht erstellt werden!");
define('_DML_DIRNOTEXISTS', "Verzeichnis existiert nicht! Datei kann nicht gelöscht werden!");
define('_DML_TEMPLATEEMPTY', "Template-ID ist leer, kann nicht gelöscht werden!");
define('_DML_INTERRORMAMBOT', "Interner Fehler: Kein Mambot gesetzt!");
define('_DML_INTERRORMABOT', _DML_INTERRORMAMBOT); // alias
define('_DML_NOTARGGIVEN', "nicht genügend Argumente angegeben!");
define('_DML_ARG', "Argument");
define('_DML_ISNOTARRAY', "ist kein Array");

define('_DML_NEW', "Neu!");
define('_DML_HOT', "Beliebt!");

define('_DML_BYTES', "Bytes");
define('_DML_KB', "kB");
define('_DML_MB', "MB");
define('_DML_GB', "GB");
define('_DML_TB', "TB");


// -- Form Validation
define('_DML_ENTRY_ERRORS', "DOCman-System-Nachricht : Bitte folgende(n) Fehler beheben:");
define('_DML_ENTRY_TITLE', "Dokument muss einen Titel haben!");
define('_DML_ENTRY_NAME', "Dokument muss einen Namen haben!");
define('_DML_ENTRY_DATE', "Dokument muss ein Datum haben!");
define('_DML_ENTRY_OWNER', "Dokument muss einen Besitzer haben!");
define('_DML_ENTRY_CAT', "Dokument muss einer Kategorie zugeordnet sein!");
define('_DML_ENTRY_DOC', "Dokument muss mit einer Datei verbunden sein!");
define('_DML_ENTRY_MAINT', "Dokument muss einen Verwalter haben!");

define('_DML_ENTRY_DOCLINK_LINK', "Bei diesem Dokument muss *LINK* ausgewählt werden.");
define('_DML_ENTRY_DOCLINK', "Dieses Dokument hat sowohl eine Datei als auch einen Link auf eine Datei!");
define('_DML_ENTRY_DOCLINK_PROTOCOL', "Unbekanntes Protokoll für den Link!");
define('_DML_ENTRY_DOCLINK_NAME', "Bitte geben Sie den gesamten Link für das Dokument an!");
define('_DML_ENTRY_DOCLINK_HOST', "Eine komplette URL wird benötigt!");
define('_DML_ENTRY_DOCLINK_INVALID', "Datei nicht gefunden!");
define('_DML_FILENAME_REQUIRED', "Ein Dateiname wird benötigt!");

// Missing  constants from J!1.0.x
define('_DML_FILTER', "Filter");
define('_DML_UPDATE', "Aktualisieren");
define('_DML_SEARCH_ANYWORDS', "Jedes Wort");
define('_DML_SEARCH_ALLWORDS', "Alle Wörter");
define('_DML_SEARCH_PHRASE', "Exakter Ausdruck");
define('_DML_SEARCH_NEWEST', "Neueste zuerst");
define('_DML_SEARCH_OLDEST', "Älteste zuerst");
define('_DML_SEARCH_POPULAR', "Am beliebtesten");
define('_DML_SEARCH_ALPHABETICAL', "Alphabetisch");
define('_DML_SEARCH_CATEGORY', "Kategorie");
define('_DML_SEARCH_MESSAGE', "Der Suchbegriff muss min. aus drei Zeichen und max. aus 20 Zeichen bestehen!");
define('_DML_SEARCH_TITLE', "Suche");
define('_DML_PROMPT_KEYWORD', "Suchbegriff");
define('_DML_SEARCH_MATCHES', "gefunden wurden %d Ergebnisse");
define('_DML_NOKEYWORD', "Keine Ergebnisse gefunden!");
define('_DML_IGNOREKEYWORD', "Ein oder mehrere Wörter wurden in der Suche ignoriert");
define('_DML_CMN_ORDERING', "Sortierung");

// Added DOCman 1.4 RC3
define('_DML_HELP', "Help");

// Added DOCman 1.4.0.stable
define('_DML_DONATE', "Donate");