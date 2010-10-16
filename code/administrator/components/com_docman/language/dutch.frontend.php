<?php
/**
 * @version		$Id: dutch.frontend.php 11 2009-10-22 12:58:14Z mathias $
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

// -- General
define('_DML_NOLOG', "U moet ingelogd te zijn om toegang te krijgen tot het documentgedeelte.");
define('_DML_NOLOG_UPLOAD', "U dient ingelogd en geautoriseerd te zijn om bestanden te uploaden.");
define('_DML_NOLOG_DOWNLOAD', "U dient ingelogd en geautoriseerd te zijn om bestanden te downloaden.");
define('_DML_NOAPPROVED_DOWNLOAD', "Het document moet goedgekeurd zijn alvorens downloaden.");
define('_DML_NOPUBLISHED_DOWNLOAD', "Het document moet gepubliceerd zijn alvorens downloaden.");
define('_DML_ISDOWN', "Sorry, deze sectie is tijdelijk offline voor onderhoudswerkzaamheden. Probeer later opnieuw.");
define('_DML_SECTION_TITLE', "Downloads");

// -- Files
define('_DML_DOCLINKTO', "Document gelinkt naar ");
define('_DML_DOCLINKON', "Link aangemaakr op ");
define('_DML_ERROR_LINKING', "Fout bij verbinden met host.");
define('_DML_LINKTO', "Link naar ");
define('_DML_DONE', "Voltooid.");
define('_DML_FILE_UNAVAILABLE', "Het bestand is niet beschikbaar op de server");

// -- Documents
define('_DML_TAB_BASIC', "Basis");
define('_DML_TAB_PERMISSIONS', "Rechten");
define('_DML_TAB_LICENSE', "Licentie");
define('_DML_TAB_DETAILS', "Details");
define('_DML_TAB_PARAMS', "Parameters");
define('_DML_OP_CANCELED', "Handeling geannuleert");
define('_DML_CREATED_BY', "Aangemaakt door");
define('_DML_UPDATED_BY', "Laatst geupdate door");
define('_DML_DOCMOVED', "Document werd verplaatst");
define('_DML_MOVETO', "Verplaats naar");
define('_DML_MOVETHEFILES', "Verplaats de bestanden");
define('_DML_SELECTFILE', "Selecteer een bestand");
define('_DML_THANKSDOCMAN', "We danken u voor uw toevoeging.");
define('_DML_NO_LICENSE', "Geen Licentie");
define('_DML_DISPLAY_LIC', "Toon overeenkomst");
define('_DML_LICENSE_TYPE', "Licentie type");
define('_DML_MANT_TOOLTIP', "Dit bepaalt wie het document kan aanpassen of beheren. "
     . "Wanneer een gebruiker, of lid van een groep, de " . _DML_MAINTAINER . " is van een document betekend dit dat ze specifieke documentbeheer opties hebben: wijzigen, update, verplaatsen, verwijderen, inchecken en uitchecken.");
define('_DML_ON', "op");
define('_DML_CURRENT', "Huifig");
define('_DML_YOU_MUST_UPLOAD', "U dient eerst een document voor deze sectie uploaden.");
define('_DML_THE_MODULE', "De module");
define('_DML_IS_BEING', "wordt momenteel aangepast door een andere administrator");
define('_DML_LINKED', "->GELINKT DOCUMENT<-");
define('_DML_FILETITLE', "Bestandstitel");
define('_DML_OWNER_TOOLTIP', "Dit bepaald wie het document kan downloaden en bekijken. Kies: "
     . "*Iedereen* wanneer iedereen toegang mag krijgen tot het document. "
     . "*Alle geregistreerde gebruikers* enkel bezoekers die geregistreerd zijn op uw website hebben toegang tot het document. "
     . "U kunt een document toewijzen aan een enkele geregistreerde gebruiker door het selecteren van zijn/haar naam onder " . _DML_USERS . "; "
     . "enkel die gebruiker zal toegang hebben. "
     . "u kunt het document toewijzen aan een groep van geregistreerde gebruikers door het selecteren van de groepsnaam onder " . _DML_GROUPS . "; "
     . "enkel de groepleden zullen toegang hebben tot het document.");
define('_DML_MAKE_SURE', "Zorg ervoor dat de URL start<br />met 'http://'");
define('_DML_DOCURL', "URL van het document:");
define('_DML_DOCDELETED', "Document verwijdert.");
define('_DML_DOCURL_TOOLTIP', "Waneer je een gelinkt document hebt dient u het websiteadres (URL) voor het document hier opgeven. Voeg altijd aan het begin http:// of ftp:// toe.");
define('_DML_HOMEPAGE_TOOLTIP', "U kunt optioneel een URL invullen voor informatie dat gerelateerd is aan het document. Voeg altijd aan het begin http:// toe of het zal niet werken.");
define('_DML_LICENSE_TOOLTIP', "Een document kan een overeenkomst/licentie hebben dat de bezoekers dienen te accepteren voordat ze toegang hebben tot het document. U kunt hier het licentietype defini&euml;ren.");
define('_DML_DISPLAY_LICENSE', "Toon overeenkomst/licentie bij het bekijken");
define('_DML_DISPLAY_LIC_TOOLTIP', "Kies`*Ja* indien u wenst dat de licentie getoond wordt aan de gebruiker voordat toegang verkregen wordt.");
define('_DML_APPROVED_TOOLTIP', "Een document dient goedgekeurd, zichtbaar en beschikbaar te zijn op de repository. Selecteer *Ja* hier en vergeet niet om het document ook te publiceren! Beide opties dienen ingesteld te zijn voordat het zichtbaar is op de frontend");
define('_DML_RESET_COUNTER', "Teller resetten");
define('_DML_PROBLEM_SAVING_DOCUMENT', "Probleem bij het opslaan van het document");

// -- Download
define('_DML_PROCEED', "Klik hier om verder te gaan");
define('_DML_YOU_MUST', "U dient de overeenkomst te accepteren om het document te kunnen bekijken.");
define('_DML_NOTDOWN', "Het document wordt geupdate/aangepast door een gebruiker en is onbeschikbaar op dit ogenblik.");
define('_DML_ANTILEECH_ACTIVE', "U probeert toegang te krijgen tot een niet geauthoriseerd domein.");
define('_DML_DONT_AGREE', "Ik ga niet akkoord.");
define('_DML_AGREE', "Ik ga akkoord.");

// -- Upload
define('_DML_UPLOADED', "Geupload");
define('_DML_SUBMIT', "Toevoegen");
define('_DML_NEXT', "Volgende >>>");
define('_DML_BACK', "<<< Terug");
define('_DML_LINK', "Link");
define('_DML_EDITDOC', "Wijzig dit document");
define('_DML_UPLOADWIZARD', "Upload Wizard");
define('_DML_UPLOADMETHOD', "Kies de upload methode");
define('_DML_ISUPLOADING', "DOCman is bezig aan het uploaden");
define('_DML_PLEASEWAIT', "Een ogenblik geduld");
define('_DML_DOCMANISLINKING', "DOCman controleert <br />de link");
define('_DML_DOCMANISTRANSF', "DOCman transferreert<br />het bestand");
define('_DML_TRANSFER', "Transfer");
define('_DML_REMOTEURL', "Remote URL");
define('_DML_LINKURLTT', "Vul de remote URL in waartoe u toegang wenst. De URL dient te starten met http:// of ftp:// en elke andere toegangsinformatie is vereist. Bijvoorbeeld: http://joomlacode.org/gf/download/frsrelease/292/1001/docman_1.3RC2.zip.");
define('_DML_REMOTEURLTT', _DML_LINKURLTT . "<br />U kunt het bestand eender welke naam geven door gebruik te maken van het veld &quot;Lokale naam&quot;.");
define('_DML_LOCALNAME', "Lokale naam");
define('_DML_LOCALNAMETT', "Vul de lokale naam in van het bestand zoals u wil dat het wordt opgeslaan op de server."
     . "Dit is een vereist veld aangezien de URL niet voldoende informatie verstrekt over het document.");
define('_DML_ERROR_UPLOADING', "Error bij uploadeng");

// -- Search
define('_DML_SELECCAT', "Selecteer categorie");
define('_DML_ALLCATS', "Alle categorie&euml;n");
define('_DML_SEARCH_WHERE', "Zoek waar");
define('_DML_SEARCH_MODE', "Zoek op");
define('_DML_SEARCH', "Zoeken");
define('_DML_SEARCH_REVRS', "Omgekeerd");
define('_DML_SEARCH_REGEX', "Algemene expressie");
define('_DML_NOT', "Niet"); // Used for Inversion

// -- E-mail
define('_DML_EMAIL_GROUP', "Verzend E-mail naar Group");
define('_DML_SUBJECT', "Onderwerp");
define('_DML_EMAIL_LEADIN', "Begintekst");
define('_DML_MESSAGE', "Hoofdtekst");
define('_DML_SEND_EMAIL', "Verzenden");

//Document tasks
define('_DML_BUTTON_DOWNLOAD', "Download");
define('_DML_BUTTON_VIEW', "Bekijk");
define('_DML_BUTTON_DETAILS', "Details");
define('_DML_BUTTON_EDIT', "Wijzig");
define('_DML_BUTTON_MOVE', "Verplaats");
define('_DML_BUTTON_DELETE', "Verwijder");
define('_DML_BUTTON_UPDATE', "Update");
define('_DML_BUTTON_CHECKOUT', "Uitchecken");
define('_DML_BUTTON_CHECKIN', "Inchecken");
define('_DML_BUTTON_UNPUBLISH', "Depubliceren");
define('_DML_BUTTON_PUBLISH', "Publiceren");
define('_DML_BUTTON_RESET', "Reset");
define('_DML_BUTTON_APPROVE', "Goedkeuren");

// -- Added v1.4.0 RC1
define('_DML_CHECKED_IN', "Ingechecked");