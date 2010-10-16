<?php
/**
 * @version		$Id: germani.php 11 2009-10-22 12:58:14Z mathias $
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
 * Email:    jan.zassenhaus@joomlaportal.ch
 * Revision: 1.4 (translation version)
 * Date:     February 2008
 **/

define('_DML_TPL_DATEFORMAT_LONG', '%d.%m.%Y %H:%M'); 
define('_DML_TPL_DATEFORMAT_SHORT', '%d.%m.%Y');

// General
define('_DML_TPL_FILES', "Dateien");
define('_DML_TPL_CATS', "Kategorien");
define('_DML_TPL_DOCS', "Dokumente");
define('_DML_TPL_CAT_VIEW', "Home");
define('_DML_TPL_MUST_LOGIN', "Du musst Dich anmelden, um neue Dateien vorzuschlagen.");
define('_DML_TPL_SUBMIT', "Neues Dokument vorschlagen");
define('_DML_TPL_SEARCH_DOC', "Dokument suchen");
define('_DML_TPL_LICENSE_DOC', "Dokumentenlizenz");

// Titles
define('_DML_TPL_TITLE_BROWSE', "Downloads");
define('_DML_TPL_TITLE_EDIT', "Dokument bearbeiten");
define('_DML_TPL_TITLE_SEARCH', "Ein Dokument suchen");
define('_DML_TPL_TITLE_DETAILS', "Dokumentendetails");
define('_DML_TPL_TITLE_MOVE', "Dokument verschieben");
define('_DML_TPL_TITLE_UPDATE', "Dokument updaten");
define('_DML_TPL_TITLE_UPLOAD', "Dokument vorschlagen");

// Documents
define('_DML_TPL_HITS', "Zugriffe");
define('_DML_TPL_DATEADDED', "Erstellungsdatum");
define('_DML_TPL_HOMEPAGE', "Homepage");
define('_DML_TPL_NO_DOCS', "Es gibt keine Dokumente in dieser Kategorie!");

//Document search
define('_DML_TPL_ORDER_BY', "Sortieren nach");
define('_DML_TPL_ORDER_NAME', "Name");
define('_DML_TPL_ORDER_DATE', "Datum");
define('_DML_TPL_ORDER_HITS', "Zugriffe");
define('_DML_TPL_ORDER_ASCENT', "aufsteigend");
define('_DML_TPL_ORDER_DESCENT', "absteigend");
define('_DML_TPL_NO_ITEMS_FOUND', "Keine Ergebnisse gefunden!");

//Document edit

//Document move
define('_DML_TPL_MOVE_DOC', "Dokument in andere Kategorie verschieben");

//Document update
define('_DML_TPL_UPDATE_DOC', "Dokument updaten");
define('_DML_TPL_UPDATE_OVERWRITE', "Überschreibt das Dokument IMMER wenn der Dateiname gleich ist.");

//Document upload
define('_DML_TPL_UPLOAD_STEP', "Schritt");
define('_DML_TPL_UPLOAD_OF', "von");
define('_DML_TPL_UPLOAD_NEXT', "Nächstes");
define('_DML_TPL_UPLOAD_DOC', "Upload-Assistent");
define('_DML_TPL_TRANSFER', "Von einem anderen Webserver übertragen");
define('_DML_TPL_LINK', "Von einem anderen Server verlinken");
define('_DML_TPL_UPLOAD', "Vom lokalen Rechner hochladen");

//Document tasks
define('_DML_TPL_DOC_DOWNLOAD', "Download");
define('_DML_TPL_DOC_VIEW', "Anzeigen");
define('_DML_TPL_DOC_DETAILS', "Details");
define('_DML_TPL_DOC_EDIT', "Ändern");
define('_DML_TPL_DOC_MOVE', "Verschieben");
define('_DML_TPL_DOC_DELETE', "Löschen");
define('_DML_TPL_DOC_UPDATE', "Updaten");
define('_DML_TPL_DOC_CHECKOUT', "Auschecken");
define('_DML_TPL_DOC_CHECKIN', "Einchecken");
define('_DML_TPL_DOC_UNPUBLISH', "Zurückziehen");
define('_DML_TPL_DOC_PUBLISH', "Veröffentlichen");
define('_DML_TPL_DOC_RESET', "Zurücksetzen");
define('_DML_TPL_DOC_APPROVE', "Bestätigen");

define('_DML_TPL_BACK', "Zurück");

//Document details
define('_DML_TPL_DETAILSFOR', "Details für");
define('_DML_TPL_NAME', "Name");
define('_DML_TPL_DESC', "Beschreibung");
define('_DML_TPL_FNAME', "Dateiname");
define('_DML_TPL_FSIZE', "Dateigröße");
define('_DML_TPL_FTYPE', "Dateityp");
define('_DML_TPL_SUBBY', "Ersteller");
define('_DML_TPL_SUBDT', "Erstellt am");
define('_DML_TPL_OWNER', "Betrachter");
define('_DML_TPL_MAINT', "Verwaltet von");
define('_DML_TPL_DOWNLOADS', "Downloads");
define('_DML_TPL_LASTUP', "Zuletzt geändert");
define('_DML_TPL_LASTBY', "Zuletzt geändert von");
define('_DML_TPL_HOME', "Homepage" );
define('_DML_TPL_MIME', "Dateityp");
define('_DML_TPL_CHECKED_OUT', "Ausgecheckt");
define('_DML_TPL_CHECKED_BY', "Ausgecheckt von");
define('_DML_TPL_MD5_CHECKSUM', "MD5-Prüfsumme");
define('_DML_TPL_CRC_CHECKSUM', "CRC-Prüfsumme");
