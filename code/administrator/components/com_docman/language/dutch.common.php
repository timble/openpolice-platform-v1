<?php
/**
 * @version		$Id: dutch.common.php 11 2009-10-22 12:58:14Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

/**
 * Default Dutch language file
 *
 * Creator:  Joomla! Nederlands
 * Website:  http://www.joomla.taalbestand.nl/
 * Email:    sander@taalbestand.nl
 * Revision: 1
 * Date:     September 2007
 **/

define ('_DM_DATEFORMAT_LONG', "%A %d %B %Y %H:%M:%S"); // use PHP strftime Format, more info at http://php.net
define ('_DM_DATEFORMAT_SHORT', "%d %B %Y");         // use PHP strftime Format, more info at http://php.net
define ('_DM_ISO', 'utf-8');
define ('_DM_LANG', 'nl');

// -- General
define('_DML_NAME', "Naam");
define('_DML_DATE', "Datum");
define('_DML_DATE_MODIFIED', "Aanpassingsdatum");
define('_DML_HITS', "Hits");
define('_DML_SIZE', "Grootte");
define('_DML_EXT', "Extensie");
define('_DML_MIME', "Mime type");
define('_DML_THUMBNAIL', "Thumbnail");
define('_DML_DESCRIPTION', "Omschrijving");
define('_DML_VERSION', "Versie");
define('_DML_DEFAULT', "Standaard");
define('_DML_FOLDER', "map");
define('_DML_FOLDERS', "mappen");
define('_DML_FILE', "Bestand");
define('_DML_FILES', "Bestanden");
define('_DML_URL', "URL");
define('_DML_PARAMS', "Parameters");
define('_DML_PARAMETERS', "Parameters");
define('_DML_TOP', "Top");
define('_DML_PROPERTY', "Eigenschap");
define('_DML_VALUE', "Waarde");
define('_DML_PATH', "Pad");

define('_DML_DOC', "Document");
define('_DML_DOCS', "Documenten");
define('_DML_DOCUMENT', "Document");
define('_DML_CAT', "Categorie");
define('_DML_CATS', "Categorie&euml;n");
define('_DML_CATEGORY', "Categorie");

define('_DML_UPLOAD', "Upload");
define('_DML_SECURITY', "Veiligheid");
define('_DML_CPANEL', "Home");
define('_DML_CONFIG', "Configuratie");
define('_DML_LICENSE', "Licentie");
define('_DML_LICENSES', "Licenties");
define('_DML_UPDATES', "Updates");
define('_DML_DOWNLOADS', "Downloads");

define('_DML_HOMEPAGE', "Homepage");

define('_DML_NO', "Nee");
define('_DML_YES', "Ja");
define('_DML_OK', "OK");
define('_DML_CANCEL', "Annuleer");
define('_DML_ADD', "Toevoegen");
define('_DML_EDIT', "Wijzig");
define('_DML_CONTINUE', "Doorgaan");
define('_DML_SAVE', "Opslaan");

define('_DML_APPROVED', "Goedgekeurd");
define('_DML_DELETED', "Verwijdert");

define('_DML_INSTALL', "Installeer");
define('_DML_PUBLISHED', "Gepubliceerd");
define('_DML_UNPUBLISH', "Gedepubliceerd");
define('_DML_CHECKED_OUT', "Uitgechecked");

define('_DML_TOOLTIP', "Tooltip");
define('_DML_FILTER_NAME', "Filter op naam");

define('_DML_TITLE', "Titel");
define('_DML_MULTIPLE_SELECTS', "Druk op de <b>Ctrl</b> toets (voor Windows/Unix/Linux) of <b>Command</b> toets (voor Mac) bij het selecteren.");

define('_DML_USER', "Gebruiker");
define('_DML_OWNER', "Eigenaar");
define('_DML_CREATOR', "Auteur");
define('_DML_EDITOR', "Onderhouder");
define('_DML_MAINTAINER', "Onderhouder");
define('_DML_UNKNOWN', "Onbekend");

define('_DML_FILEICON_ALT', "Bestandsicoon");

define('_DML_NOT_AUTHORIZED', "Niet bevoegd");
define('_DML_ERROR', "Fout");
define('_DML_OPERATION_FAILED', "Handeling mislukt");

define('_DML_EDIT_THIS_MODULE', "Wijzig deze module");
define('_DML_UNPUBLISH_THIS_MODULE', "Depubliceer deze module");
define('_DML_ORDER_THIS_MODULE', "rangschik deze module");

define('_DML_WRITABLE', "Beschrijfbaar");
define('_DML_UNWRITABLE', "Onbeschrijfbaar");

define('_DML_SAVED_CHANGES', "Wijzigingen opgeslagen");
define('_DML_ARE_YOU_SURE', "Bent u zeker?");


// -- HTML Class
define('_DML_SELECT_CAT', "Selecteer categorie");
define('_DML_SELECT_DOC', "Selecteer document");
define('_DML_SELECT_FILE', "Selecteer bestand");
define('_DML_ALL_CATS', "- Alle Categorie&euml;");
define('_DML_SELECT_USER', "Selecteer gebruiker");
define('_DML_GENERAL', "Algemeen");
define('_DML_GROUPS', "Groepen");
define('_DML_DOCMAN_GROUPS', "DOCman groepen");
define('_DML_MAMBO_GROUPS', "Joomla! groepen");
define('_DML_JOOMLA_GROUPS', "Joomla! groepen"); // alias
define('_DML_USERS', "Gebruikers");
define('_DML_EVERYBODY', "Iedereen");
define('_DML_ALL_REGISTERED', "Alle geregistreerde gebruikers");
define('_DML_NO_USER_ACCESS', "Geen gebruikerstoegang");
define('_DML_AUTO_APPROVE', "Automatisch goedkeuren");
define('_DML_AUTO_PUBLISH', "Automatisch publiceren");
define('_DML_GROUP', "Groep");
define('_DML_GROUP_PUBLISHER', "Hoofdredacteur");
define('_DML_GROUP_EDITOR', "Redacteur");
define('_DML_GROUP_AUTHOR', "Auteur");

// -- File Class
define('_DML_OPTION_HTTP', "Upload een bestand vanaf uw computer");
define('_DML_OPTION_XFER', "Transfereer een bestand van een andere server naar deze server");
define('_DML_OPTION_LINK', "Link een bestand van een andere server naar deze server");
define('_DML_SIZEEXCEEDS', "Bestandsgrootte overschrijd maximale toegestane grootte.");
define('_DML_ONLYPARTIAL', "Enkel een deel van het bestand werd ontvangen. Probeer opnieuw.");
define('_DML_NOUPLOADED', "Geen document geupload.");
define('_DML_TRANSFERERROR', "Er deed zich een transferfout voor");
define('_DML_DIRPROBLEM', "Mapprobleem. Kan bestand niet verplaatsen.");
define('_DML_DIRPROBLEM2', "Mapprobleem");
define('_DML_COULDNOTCONNECT', "Kon niet verbinen met host");
define('_DML_COULDNOTOPEN', "Kon doelmap niet openen. Controleer bestandsrechten.");
define('_DML_FILETYPE', "Bestandstype");
define('_DML_NOTPERMITED', "Niet toegestaan");
define('_DML_EMPTY', "Leeg");

define('_DML_ALREADYEXISTS', "Bestaat reeds.");
define('_DML_PROTOCOL', "Protocol");
define('_DML_NOTSUPPORTED', "Niet ondersteund.");
define('_DML_NOFILENAME', "Geen bestandsnaam opgegeven.");
define('_DML_FILENAME', "Bestandsnaam");
define('_DML_CONTAINBLANKS', "bevat spaties.");
define('_DML_ISNOTVALID', "is geen geldige bestandsnaam");
define('_DML_SELECTIMAGE', "Selecteer afbeelding");
define('_DML_FAILEDTOCREATEDIR', "Kon map niet aanmaken");
define('_DML_DIRNOTEXISTS', "Map bestaat niet, kan de bestanden niet verwijderen");
define('_DML_TEMPLATEEMPTY', "Template id is leeg; kan bestanden niet verwijderen");
define('_DML_INTERRORMAMBOT', "Interne fout: geen plugin ingesteld");
define('_DML_INTERRORMABOT', _DML_INTERRORMAMBOT); // alias
define('_DML_NOTARGGIVEN', "niet voldoende argumenten opgegeven");
define('_DML_ARG', "argument");
define('_DML_ISNOTARRAY', "is geen array");

define('_DML_NEW', "nieuw!");
define('_DML_HOT', "hot!");

define('_DML_BYTES', "Bytes");
define('_DML_KB', "kB");
define('_DML_MB', "MB");
define('_DML_GB', "GB");
define('_DML_TB', "TB");


// -- Form Validation
define('_DML_ENTRY_ERRORS', "DOCman Systeembericht : Corrigeer de volgende fout(en):");
define('_DML_ENTRY_TITLE', "Invoeging dient een titel te hebben.");
define('_DML_ENTRY_NAME', "Invoeging moet een naam bevatten.");
define('_DML_ENTRY_DATE', "Invoeging moet een datum hebben.");
define('_DML_ENTRY_OWNER', "Invoeging moet een eigenaar hebben.");
define('_DML_ENTRY_CAT', "Invoeging moet een categorie hebben.");
define('_DML_ENTRY_DOC', "Invoeging moet een document geselecteerd hebben.");
define('_DML_ENTRY_MAINT', "Invoeging moet een onderhouder opgegeven hebben.");

define('_DML_ENTRY_DOCLINK_LINK', "Document dient LINK geselecteerd te hebben. (Gelinkte documenten op de details tab.)");
define('_DML_ENTRY_DOCLINK', "Document heeft een bestandsnaam en een document link op de details tab.");
define('_DML_ENTRY_DOCLINK_PROTOCOL', "Onbekend protocol voor documentlink op details tab");
define('_DML_ENTRY_DOCLINK_NAME', "Volledige documentlink is nodig op de details tab");
define('_DML_ENTRY_DOCLINK_HOST', "Een volledige URL is vereist");
define('_DML_ENTRY_DOCLINK_INVALID', "Bestand niet gevonden");
define('_DML_FILENAME_REQUIRED', "Een bestandsnaam is vereist");

// Missing  constants from J!1.0.x
define('_DML_FILTER', "Filter");
define('_DML_UPDATE', "Update");
define('_DML_SEARCH_ANYWORDS', "Elk woord");
define('_DML_SEARCH_ALLWORDS', "Alle woorden");
define('_DML_SEARCH_PHRASE', "Exacte zin");
define('_DML_SEARCH_NEWEST', "Nieuwste eerst");
define('_DML_SEARCH_OLDEST', "Oudste eerst");
define('_DML_SEARCH_POPULAR', "Populair");
define('_DML_SEARCH_ALPHABETICAL', "Alfabetisch");
define('_DML_SEARCH_CATEGORY', "Categorie");
define('_DML_SEARCH_MESSAGE', "Zoekwoord dient minstens 3 karakters te bevatten en een maximum van 20 karakters");
define('_DML_SEARCH_TITLE', "Zoek");
define('_DML_PROMPT_KEYWORD', "Zoekwoord");
define('_DML_SEARCH_MATCHES', "gaf %d resultaten");
define('_DML_NOKEYWORD', "Er werden geen resultaten gevonden");
define('_DML_IGNOREKEYWORD', "&Eacute;&eacute;n of meer zoekwoorden werden weggelaten in de zoekopdracht");
define('_DML_CMN_ORDERING', "Rangschikking");

// Added DOCman 1.4 RC3
define('_DML_HELP', "Help");

// Added DOCman 1.4.0.stable
define('_DML_DONATE', "Donate");