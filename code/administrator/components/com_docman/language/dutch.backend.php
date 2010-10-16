<?php
/**
 * @version		$Id: dutch.backend.php 11 2009-10-22 12:58:14Z mathias $
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

// -- Toolbar
define('_DML_TOOLBAR_SAVE', "Opslaan");
define('_DML_TOOLBAR_CANCEL', "Annuleren");
define('_DML_TOOLBAR_NEW', "Nieuw");
define('_DML_TOOLBAR_NEW_DOC', "Nieuw Doc.");
define('_DML_TOOLBAR_HOME', "Home");
define('_DML_TOOLBAR_UPLOAD', "Upload");
define('_DML_TOOLBAR_MOVE', "Verplaats");
define('_DML_TOOLBAR_COPY', "Kopieer");
define('_DML_TOOLBAR_SEND', "Verzenden");
define('_DML_TOOLBAR_BACK', "Terug");
define('_DML_TOOLBAR_PUBLISH', "Publiceren");
define('_DML_TOOLBAR_UNPUBLISH', "Depubliceren");
define('_DML_TOOLBAR_DEFAULT', "Standaard");
define('_DML_TOOLBAR_DELETE', "Verwijder");
define('_DML_TOOLBAR_CLEAR', "Wissen");
define('_DML_TOOLBAR_EDIT', "Wijzig");
define('_DML_TOOLBAR_EDIT_CSS', "Wijzig CSS");
define('_DML_TOOLBAR_APPLY', "Toepassen");


// -- Files
define('_DML_ORPHANS', "Wezen");
define('_DML_ORPHANS_LINKED', "Bestand(en) niet verwijderd. Er kunnen geen bestanden verwijdert worden die gelinkt zijn aan documenten.");
define('_DML_ORPHANS_PROBLEM', "Bestand(en) niet verwijderd. Er is een probleem met bestandsrechten.");
define('_DML_ORPHANS_DELETED', "Bestand(en) verwijderd.");
define('_DML_LINKS', "Links");
define('_DML_NEXT', "Volgende");
define('_DML_SUCCESS', "Succesvol!");
define('_DML_UPLOADMORE', "Upload meer bestanden");
define('_DML_UPLOADWIZARD', "Upload wizard");
define('_DML_UPLOADMETHOD', "Kies de gewenste uploadmethode");
define('_DML_ISUPLOADING', "DOCman is bezig aan het uploaden");
define('_DML_PLEASEWAIT', "Een ogenblik geduld");
define('_DML_UPLOADDISK', "Upload wizard - Upload een bestand vanaf de harde schijf");
define('_DML_FILETOUPLOAD', "Kies het bestand om te uploaden");
define('_DML_BATCHMODE', "Batch Modus");
define('_DML_BATCHMODETT', "Batch modus zal een zip bestand uploaden die meerdere bestanden bevat. Het pakket wordt uitgepakt na upload. U mag hierbij geen mappen en/of submappen in het pakket toevoegen. Wees wel indachtig dat dit proces reeds bestaande DOCman bestanden in de DOCman documentenmap kan overschrijven wanneer deze dezelfde bestandsnaam hebben; er is geen overschrijfbeveiliging bij het gebruik van archiefbestanden.");
define('_DML_DOCMANISTRANSF', "DOCman transfereert<br />het bestand");
define('_DML_TRANSFERFROMWEB', _DML_UPLOADWIZARD . " - " . "transfereer een bestand van een webserver");
define('_DML_REMOTEURL', "Remote URL");
define('_DML_LINKURLTT', "Vul de remote URL in waartoe u toegang wenst. De URL dient te starten met http:// of ftp:// en elke andere toegangsinformatie is vereist. Bijvoorbeeld: http://joomlacode.org/gf/download/frsrelease/292/1001/docman_1.3RC2.zip.");
define('_DML_REMOTEURLTT', _DML_LINKURLTT . "<br />U kunt het bestand eender welke naam geven door gebruik te maken van het veld &quot;Lokale naam&quot;.");
define('_DML_LOCALNAME', "Lokale Naam");
define('_DML_LOCALNAMETT', "Vul de lokale naam in van het bestandzoals u het wil noemen op dit systeem."
     . "Dit is een vereist veld aangezien de URL niet voldoende informatie kan verstrekken voor het document.");
define('_DML_DOCUPDATED', "Document werd geupdate.");
define('_DML_FILEUPLOADED', "Het bestand werd geupload.");
define('_DML_MAKENEWENTRY', "Maak een nieuw document aan voor dit bestand.");
define('_DML_DISPLAYFILES', "Toon bestanden.");
define('_DML_ALLFILES', "Alle bestanden");
define('_DML_DOCFILES', "Documentbestanden");
define('_DML_CREATEALINK', "Maak een gelinkt document");
define('_DML_SELECTMETHODFIRST', "Selecteer een document trasfermethode");
define('_DML_ERROR_UPLOADING', "Fout bij het uploaden.");
define('_DML_ZLIB_ERROR', "De bewerking kon niet verdergezet worden aangezien de zlib library niet aanwezig is in PHP.");
define('_DML_UNZIP_ERROR', "Kon het archief niet uitpakken.");
define('_DML_SUBMIT', "Verzenden");
define('_DML_NEW_FILE', "Nieuw bestand");
define('_DML_MAKE_SELECTION', "Maak een selectie uit de lijst.");

// -- Documents
define('_DML_MOVECAT', "Verplaats categorie");
define('_DML_MOVETOCAT', "Verplaats naar categorie");
define('_DML_DOCSMOVED', "Documenten die verplaatst worden");
define('_DML_COPYCAT', "Kopieer categorie");
define('_DML_COPYTOCAT', "Kopieer naar categorie");
define('_DML_COPY_OF', "Kopie van"); // Copy of [document name]
define('_DML_DOCSCOPIED', "Documenten die gekopieerd worden");
define('_DML_DOCS_NOT_APPROVED', "Niet goedgekeurde documenten");
define('_DML_DOCS_NOT_PUBLISHED', "Niet gepubliceerde documenten");
define('_DML_NO_PENDING_DOCS', "Geen documenten in de wachtrij.");
define('_DML_FILE_MISSING', "***Bestand ontbreekt***");
define('_DML_YOU_MUST_UPLOAD', "U dient eerst een document te uploaden voor deze sectie.");
define('_DML_THE_MODULE', "De module");
define('_DML_IS_BEING', "wordt momenteel gewijzigd door een andere administrator");
define('_DML_NO_LICENSE', "Geen licentie");
define('_DML_LINKED', "->GELINKT DOCUMENT<-");
define('_DML_CURRENT', "Huidig");
define('_DML_LICENSE_TYPE', "Licentie type");
define('_DML_FILETITLE', "Bestandstitel");
define('_DML_OWNER_TOOLTIP', "Dit bepaald wie het document kan downloaden en bekijken. Kies: "
     . "*Iedereen* wanneer iedereen toegang mag krijgen tot het document. "
     . "*Alle geregistreerde gebruikers* enkel bezoekers die geregistreerd zijn op uw website hebben toegang tot het document. "
     . "U kunt een document toewijzen aan een enkele geregistreerde gebruiker door het selecteren van zijn/haar naam onder " . _DML_USERS . "; "
     . "enkel die gebruiker zal toegang hebben. "
     . "u kunt het document toewijzen aan een groep van geregistreerde gebruikers door het selecteren van de groepsnaam onder " . _DML_GROUPS . "; "
     . "enkel de groepleden zullen toegang hebben tot het document.");
define('_MANT_TOOLTIP', "Dit bepaalt wie het document kan wijzigen of beheren. "
     . "Wanneer een gebruiker, of lid van een groep, de " . _DML_MAINTAINER . " is van een document betekend dit dat ze specifieke documentbeheeropties hebben: wijzigen, updaten, verplaatsen, verwijderen, inchecken en uitchecken.");
define('_DML_MAKE_SURE', "Zorg ervoor dat de URL start<br />met 'http://'");
define('_DML_DOCURL', "URL van het document:");
define('_DML_DOCURL_TOOLTIP', "Waneer je een gelinkt document hebt dient u het websiteadres (URL) voor het document hier opgeven. Voeg altijd aan het begin http:// of ftp:// toe.");
define('_DML_HOMEPAGE_TOOLTIP', "U kunt optioneel een URL invullen voor informatie dat gerelateerd is aan het document. Voeg altijd aan het begin http:// toe of het zal niet werken.");
define('_DML_LICENSE_TOOLTIP', "Een document kan een overeenkomst/licentie hebben dat de bezoekers dienen te accepteren voordat ze toegang hebben tot het document. U kunt hier het licentietype defini&euml;ren.");
define('_DML_DISPLAY_LICENSE', "Toon overeenkomst/licentie bij het bekijken");
define('_DML_DISPLAY_LIC_TOOLTIP', "Kies`*Ja* indien u wenst dat de licentie getoond wordt aan de gebruiker voordat toegang verkregen wordt.");
define('_DML_APPROVED_TOOLTIP', "Een document dient goedgekeurd, zichtbaar en beschikbaar te zijn op de repository. Selecteer *Ja* hier en vergeet niet om het document ook te publiceren! Beide opties dienen ingesteld te zijn voordat het zichtbaar is op de frontend");
define('_DML_PLEASE_SEL_CAT', "Definieer minstens een categorie");
define('_DML_MANT_TOOLTIP', "Dit bepaalt wie het document kan wijzigen, beheren. "
     . "Wanneer een gebruiker of lid van een groep de " . _DML_MAINTAINER . " is van een, betekend dit dat ze specifieke documentbeheeropties hebben: wijzig, update, verplaats, verwijder, inchecken en uitchecken.");
define('_DML_DISPLAY_LIC', "Display overeenkomst");

define('_DML_TAB_PERMISSIONS', "Rechten");
define('_DML_TAB_LICENSE', "Licentie");
define('_DML_TAB_DETAILS', "Details");
define('_DML_TAB_PARAMS', "Parameters");

define('_DML_TITLE_DOCINFORMATION', "Document informatie");
define('_DML_TITLE_DOCPERMISSIONS', "Documentrechten");
define('_DML_TITLE_DOCLICENSES', "Document licenties");
define('_DML_TITLE_DOCDETAILS', "Document details");
define('_DML_TITLE_DOCPARAMETERS', "Document parameters");

define('_DML_CREATED_BY', "Gemaakt door");
define('_DML_UPDATED_BY', "Laatst geupdate door");
define('_DML_SELECT_ITEM_DEL', "Selecteer een item om te verwijderen");
define('_DML_SELECT_ITEM_MOVE', "Selecteer een item om te verplaatsen");
define('_DML_SELECT_ITEM_COPY', "Selecteer een item om kopi&euml;ren");
define('_STATUS_YOU', "Dit document is door u uitgechecked.");
define('_STATUS_NOT_OUT', "Dit document is niet uitgechecked.");
define('_DML_NEW_DOCUMENT', "Nieuw document");
define('_DML_DOCUMENTS_MOVED_TO', "documenten verplaatst naar"); // [Number of] Documents moved to [location]
define('_DML_DOCUMENTS_COPIED_TO', "documenten gekopieerd naar"); // [Number of] Documents moved to [location]


// -- Categories
define('_DML_CATDETAILS', "Categorie details");
define('_DML_CATTITLE', "Titel categorie");
define('_DML_CATNAME', "Naam categorie");
define('_DML_LONGNAME', "Een lange naam om weer te geven in de hoofding");
define('_DML_PARENTITEM', "Ouder item");
define('_DML_IMAGE', "Afbeelding");
define('_DML_PREVIEW', "Voorbeeld");
define('_DML_IMAGEPOS', "Positie afbeelding");
define('_DML_ORDERING', "Rangschikking");
define('_DML_ACCESSLEVEL', "Toegangsniveau");
define('_DML_CREATEMENUITEM', "Dit zal een nieuw menuitem aanmaken in het menu dat u selecteerd");
define('_DML_SELECTMENU', "Selecteer een menu");
define('_DML_SELECTMENUTYPE', "Selecteer menutype");
define('_DML_MENUITEMNAME', "Naam menuitem");
define('_DML_SELECTCATTO', "Selecteer de categorie om te");
define('_DML_SELECTCATTODELETE', "Selecteer de categorie om te verwijderen");
define('_DML_REORDER', "Rangschik");
define('_DML_ACCESS', "Toegang");
define('_DML_CAT_MUST_SELECT_NAME', "De categorie moet een naam hebben");
define('_DML_CATS_CANT_BE_REMOVED', "kan niet verwijderd worden. Het bevat nog documenten en/of subcategorie&euml;n.");

// -- Groups
define('_DML_TITLE_GROUPS', "Groepen");
define('_DML_CANNOT_DEL_GROUP', "Kan geen groep verwijderen op dit ogenblik aangezien er documenten er eigenaar van zijn.");
define('_DML_USERS_AVAILABLE', "Beschikbare gebruikers");
define('_DML_MEMBERS_IN_GROUP', "Leden in deze groep");
define('_DML_ADD_GROUP_TIP', "Dubbelklik op een naam of selecteer deze en gebruik de pijl om leden toe te voegen of te verwijderen. "
     . "Om meer dan &eacute;&eacute;n lid te selecteren, " . _DML_MULTIPLE_SELECTS);
define('_DML_ADDING_USERS', "Toevoegen van leden aan groepen");
define('_DML_FILL_FORM', "Vul het formulier correct in");
define('_DML_ONLY_ADMIN_EMAIL', "Enkel een Super Administrator kan massamail verzenden!");
define('_DML_NO_TARGET_EMAIL', "Er zijn geen gebruikers met een geldig e-mailadres in de groep");
define('_DML_THIS_IS', "Dit is een emailbericht van");
define('_DML_SENT_BY', "verzonden door DOCman aan leden van de documentengroep");
define('_DML_EMAIL_SENT_TO', "E-mail verzonden naar");
define('_DML_MEMBERS', "leden");
define('_DML_EMAIL', "E-mail");
define('_DML_USER_BLOCKED', "geblokkeerd");

// -- Licenses
define('_DML_LICENSE_TEXT', "Licentie tekst");
define('_DML_CANNOT_DEL_LICENSE', "Kan de licentie niet verwijderen aangezien een document deze gebruikt.");


// -- Config
define('_DML_FRONTEND', "Front-end");
define('_DML_PERMISSIONS', "Rechten");
define('_DML_RESETDEFAULT', "Herstel standaard");
define('_DML_ASCENDENT', "Oplopend");
define('_DML_DESCENDENT', "Aflopend");

define('_DML_CONFIGURATION', "DOCman Configuratie");
define('_DML_CONFIG_UPDATED', "De configuratie werd succesvol opgeslagen.");
define('_DML_CONFIG_WARNING', "WAARSCHUWING: Configuratie is opgeslagen maar de maximaal toegestande upload bestandsgrootte is groter dan het PHP maximum: ");
define('_DML_CONFIG_ERROR', "Er deed zich een fout voor: Niet mogelijk om het configuratiebestand te openen voor de wijzigingen op te kunnen slaan!");
define('_DML_CONFIG_ERROR_UPLOAD', "FOUT: De maximale upload bestandsgrootte kan niet negatief zijn.");

define('_DML_CFG_DOCMANTT', "DOCman tooltip...");
define('_DML_CFG_ALLOWBLANKS', "Spaties toestaan");
define('_DML_CFG_REJECT', "Weigeren");
define('_DML_CFG_CONVERTUNDER', "Converteren naar een underscore");
define('_DML_CFG_CONVERTDASH', "Converteer naar liggend streepje");
define('_DML_CFG_REMOVEBLANKS', "Verwijder spaties");
define('_DML_CFG_PATHFORSTORING', "Pad voor het opslaan van bestanden");
define('_DML_CFG_PATHTT', "Hier definieert u de lokale map waar alle bestanden in worden opgeslagen. Dit dient het absolute pad te zijn. U kunt de standaardwaarde accepteren of, indien u dit verkiest een andere locatie, het volledige pad hier invullen.<br /><br />"
     . "Bijvoorbeeld, op een *NIX systeem is dit iets als /var/usr/www/dmdocuments<br /><br />"
     . "Indien u een windows gebaseerd systeem gebruikt is dit iets als c:/inetpub/www/dmdocuments");
define('_DML_CFG_SECTIONISDOWN', "Sectie is offline?");
define('_DML_CFG_SECTIONTT', "Indien u wenst dat gebruikers geen toegang hebben tot de documenten repository kunt u dit instellen op *Ja*. <br />"
     . "Dit is handig bij het testen of bij het upgraden van de repository.<br /><br />"
     . "Administrators en speciale gebruikers zullen altijd toegang hebben, zelfs wanneer deze is ingesteld op *Nee*. <br />"
    );
define('_DML_CFG_NUMBEROFDOCS', "Aantal documenten per pagina");
define('_DML_CFG_NUMBERTT', "Aantal documenten om weer te geven op een pagina. Indien het totaal aantal documenten groter is dan de ingevulde waarde  zal een paginanavigatiebalk getoond worden voor eenvoudige navigatie.");

define('_DML_CFG_GUEST', "Gasten");
define('_DML_CFG_GUEST_NO', "Geen toegang");
define('_DML_CFG_GUEST_X', "Enkel bladeren");
define('_DML_CFG_GUEST_RX', "Bladeren, downloaden en bekijken");
define('_DML_CFG_GUEST_TT', "Dit bepaalt wat gasten (niet geregistreerde gebruikers) kunnen doen: <br />*"
     . _DML_CFG_GUEST_NO . "* Geen documenten zijn niet zichtbaar<br />*"
     . _DML_CFG_GUEST_X . "* Staat hen toe om de documenten te zien maar geeft hen geen toegang tot de bestanden zelf. <br />*"
     . _DML_CFG_GUEST_RX . "* Staat hen toe om de documenten te bekijken en te downloaden."
     . "<br /><br />Dit recht is in toevoeging tot een individuele document toegangsrecht."
     . "</span>");

define('_DML_CFG_AUTHOR_NONE', "Geen toegang");
define('_DML_CFG_AUTHOR_READ', "Enkel download");
define('_DML_CFG_AUTHOR_BOTH', "Download en wijzigen");

define('_DML_CFG_ICONSIZE', "Icoongrootte");
define('_DML_CFG_DAYSFORNEW', "Aantal dagen voor nieuw");
define('_DML_CFG_DAYSFORNEWTT', "Aantal dagen dat een bestand als nieuw wordt aanzien. Dit toont het label *" . _DML_NEW . "* naast de documentnaam wanneer een lijst van documenten wordt getoond. Indien de waarde is ingesteld op nul zal er geen label getoond worden.");
define('_DML_CFG_HOT', "Downloads die hot zijn");
define('_DML_CFG_HOTTT', "Aantal downloads vooraleer een document aanzien wordt als populair. Dit toont het label *" . _DML_HOT . "* nabij de documentnaam wanneer het totaal aantal downloads deze waarde berijkt. Indien de waarde is ingesteld op nul zal er geen label getoond worden.");
define('_DML_CFG_DISPLAYLICENSES', "Toon licenties?");

define('_DML_CFG_VIEW', "Bekijk");
define('_DML_CFG_VIEWTT', "Dit staat u toe de standaard gebruiker/groep in te stellen die documenten kan downloaden en bekijken. Dit kan overschreven worden op documentniveau.");
define('_DML_CFG_MAINTAIN', "Beheren");
define('_DML_CFG_MAINTAINTT', "Dit staat u toe de standaard gebruiker/groep in te stellen die documenten kan beheren. Dit kan overschreven worden op documentniveau.");
define('_DML_CFG_CREATORS_PERM', "Auteurs kunnen");
define('_DML_CFG_CREATORSPERMTT', "Dit staat u toe, globaal, in te stellen wat een de auteur van een document kan doen.<br /><br />"
     . "Dit is een toevoeging aan de rechten die de bekijker- of beheerdervelden in elk document.");
define('_DML_CFG_WHOCANAREADER', "Download");
define('_DML_CFG_WHOCANAREADERTT', "Dit staat u toe te beslissen of een auteur/beheerder kan wijzigen wie een document kan bekijken.<br /><br />"
     . "N.B.: Administrators kunnen altijd bekijkrechten toewijzen.");
define('_DML_CFG_WHOCANAEDITOR', "Wijzig");
define('_DML_CFG_WHOCANAEDITORTT', "Dit staat u toe te beslissen of een auteur/beheerder kan wijzigen wie de beheerders zijn.<br /><br />"
     . "N.B.: Administrators kunnen altijd een beheerder selecteren.");

define('_DML_CFG_EMAILGROUP', "E-mail gebruikers van de groep?");
define('_DML_CFG_EMAILGROUPTT', "Indien *Ja* en de eerste optie is *Ja*, zal dit een link tonen in elk document dat eigenaar is van een groep om toe te staan dat een e-mail verzonden wordt naar alle andere leden van deze groep voor discussies.");

define('_DML_CFG_UPLOAD', "Upload");
define('_DML_CFG_UPLOADTT', "Dit staat u toe om de gebruiker/groep in te stellen die documenten kan uploaden. Dit controleert alle uploadmethoden: http, link en transfer");
define('_DML_CFG_APPROVE', "Goedkeuren");
define('_DML_CFG_APPROVETT', "Dit staat u toe om de gebruiker/groep in te stellen die documenten kan goedkeuren.<br />Documenten moeten goedgekeurd en gepubliceerd worden alvorens ze beschikbaar zijn.");
define('_DML_CFG_PUBLISH', "Publiceren");
define('_DML_CFG_PUBLISHTT', "Dit staat u toe om de gebruiker/groep in te stellen die documenten kan publiceren.<br />Documenten moeten goedgekeurd en gepubliceerd worden alvorens ze beschikbaar zijn.");
define('_DML_CFG_USER_UPLOAD', "Selecteer wie kan uploaden");
define('_DML_CFG_USER_APPROVE', "Selecteer wie kan goedkeuren");
define('_DML_CFG_USER_PUBLISH', "Selecteer wie kan publiceren");

define('_DML_CFG_EXTALLOWED', "Toegestande extensies");
define('_DML_CFG_EXTALLOWEDTT', "Toegestande bestandsextensies, gescheiden door een |. Backend gebruikers kunnen elk bestandstype uploaden.");
define('_DML_CFG_MAXFILESIZE', "Max. bestandsgrootte voor uploads");
define('_DML_CFG_MAXFILESIZETT', "Maximaal toegestane bestandsgrootte voor frontend uploads. U mag K/M/G als afkortingen gebruiken voor deze instelling.<br />Deze limiet is niet van toepassing op Backend (admin) uploads. <br /><hr />Er is ook een PHP configuratiewaarde, upload_max_filesize, welke is ingesteld op ");
define('_DML_CFG_USERCANUPLOAD', "Gebruikers kunnen alle bestandstypes uploaden?");
define('_DML_CFG_USERCANUPLOADTT', "Indien *Ja* en vorige *Gebruikers upload* is ingesteld op *Ja*, kunnen geregistreerde gebruikers alle bestandstypes uploaden en vorige restricties negeert.");
define('_DML_CFG_OVERWRITEFILES', "Overschrijf bestanden?");
define('_DML_CFG_OVERWRITEFILESTT', "Indien *Ja*, zullen bestanden overschreven worden bij upload wanneer de bestandsnaam gelijk is.");
define('_DML_CFG_LOWERCASE', "Namen zonder hoofdletters?");
define('_DML_CFG_LOWERCASETT', "Indien *Ja*, zullen geuploade bestandsnamen geconverteerd worden naar kleine letters, vb.&nbsp;UwBestand.TXT wordt uwbestand.txt.<br />Indien *nee*, bestandsnamen zullen worden opgeslagen in hoofdletters en kleine letters.");
define('_DML_CFG_FILENAMEBLANKS', "Bestandsnamen met spaties");
define('_DML_CFG_FILENAMEBLANKSTT', "Behandelen van bestandsnamen die spaties bevatten:<br />"
     . "*Spaties toestaan* zal deze opslaan met spaties.<br />"
     . "*Weigeren* zal niet toestaan dat het bestand wordt geupload.<br /><br />"
     . "U kunt ook de spaties converteren naar underscores (_), liggend streepje (-) of dat de spaties verwijdert worden uit de bestandsnaam.");
define('_DML_CFG_REJECTFILENAMES', "Weiger bestandsnamen");
define('_DML_CFG_REJECTFILENAMESTT', "Vul een lijst in van bestandsnamen die niet mogen geupload worden, gescheiden door een verticaal streepje (|). Deze bestandsnamen hebben een speciale betekenis op het systeem. \'.htaccess\' wordt standaard geweigerd.<br />U mag ook algemene expressies tussen het | symbool plaatsen om bestandsnamen met problemen tegen te houden, bijvoorbeeld: (* $ ?)");
define('_DML_CFG_UPMETHODS', "Upload methode?");
define('_DML_CFG_UPMETHODSTT', "Selecteer alle methodes die een gebruiker mag gebruiken. Administrators hebben recht op alle methoden. Voor meerdere methodes, " . _DML_MULTIPLE_SELECTS);

define('_DML_CFG_ANTILEECH', "Anti-leech systeem?");
define('_DML_CFG_ANTILEECHTT', "Het anti-leech systeem voorkomt niet geautoriseerd linken naar uw documenten. "
     . "Wanneer ingesteld op *Ja* zal elk verzoek gecontroleerd worden of elk download/bekijk verzoek "
     . "(de HTTP referer) afkomstig is van een systeem van de \'Toegestane Hosts\' lijst. Indien dit niet zo is zal de toegang geweigerd worden. "
     . "Dit is een beveiliging tegen andere systemen die kunnen profiteren van uw bandbreedte.<br /><br />"
     . "N.B. DOCman ondersteunt directe linken tussen systemen. "
     . "Indien u links gebruikt, wees er dan zeker van dat het bronsysteem in de toegestane hosts lijst staat."
    );
define('_DML_CFG_ALLOWEDHOSTS', "Toegestane hosts");
define('_DML_CFG_ALLOWEDHOSTSTT', "Een lijst van hosts die bestanden kan opvragen wanneer het anti-leech systeem geactiveerd is. Indien u meerdere hosts wenst die naar deze bestanden refereert vult u de namen in gescheiden door een verticaal streepje (|).<br />De standaardwaarde is meestal veilig.");

define('_DML_CFG_LOG', "Log weergaves?");
define('_DML_CFG_LOGTT', "Dit logt het IP adres, datum en tijd en bestandsnaam van het document dat werd bekeken. "
     . "Er kan veel informatie opgeslagen worden in de database wanneer deze optie is ingeschakeld.<hr />"
     . "Plugins zijn beschikbaar voor bijkomende logging mogelijkheden.");

define('_DML_CFG_UPDATESERVER', "Update server");
define('_DML_CFG_UPDATESERVERTT', "DOCman kan zichzelf updaten via het web en ook nieuwe DOCman gerelateerde modules, plugins en bots installeren. Het kan zelfs databaseveranderingen toepassen bij het upgraden! Hier dient u de URL van de DOCman update web server invullen. Indien de server niet verandert is (we hopen van niet!) laat u dit staan op de standaard waarde.");
define('_DML_CFG_DEFAULTLISTING', "Standaard rangschikking");
define('_DML_CFG_TRIMWHITESPACE', "Witruimte inkorten");
define('_DML_CFG_TRIMWHITESPACETT', "Witruimte inkorten en lege lijnen verwijderen uit de themaweergave, code opschoning en bandbreedte besparen");

define('_DML_CFG_ERR_DOCPATH', 'Tab [' . _DML_GENERAL . '] \'' . _DML_CFG_PATHFORSTORING . '\' dient opgegeven te worden.');
define('_DML_CFG_ERR_PERPAGE', 'Tab [' . _DML_FRONTEND . '] \'' . _DML_CFG_NUMBEROFDOCS . '\' moet numeriek zijn en groter dan nul');
define('_DML_CFG_ERR_NEW', 'Tab [' . _DML_FRONTEND . '] \'' . _DML_CFG_DAYSFORNEW . '\' Moet numeriek zijn en een waarde van nul of groter');
define('_DML_CFG_ERR_HOT', 'Tab [' . _DML_FRONTEND . '] \'' . _DML_CFG_HOT . '\' moet een waarde van num of groter zijn');
define('_DML_CFG_ERR_UPLOAD', 'Tab [' . _DML_PERMISSIONS . '] \'' . _DML_CFG_UPLOAD . '\': Selecteer wie documenten kan uploaden.');
define('_DML_CFG_ERR_APPROVE', 'Tab [' . _DML_PERMISSIONS . '] \'' . _DML_CFG_APPROVE . '\': Selecteer wie documenten kan goedkeuren.');
define('_DML_CFG_ERR_DOWNLOAD', 'Tab [' . _DML_PERMISSIONS . '] \'' . _DML_CFG_VIEW . '\': Selecteer een standaard gebruiker/groep.');
define('_DML_CFG_ERR_EDIT', 'Tab [' . _DML_PERMISSIONS . '] \'' . _DML_CFG_MAINTAIN . '\': Selecteer een standaard gebruiker/groep voor documentonderhoud');
define('_DML_CFG_EXTENSIONSVIEWING', "Extensies voor bekijken");
define('_DML_CFG_EXTENSIONSVIEWINGTT', "Bestandsextensies die kunnen bekeken worden. Gebruik een spatie voor geen, * voor alles. Gebruik een | tussen types (txt|pdf).");

define('_DML_CFG_GENERALSET', "Algemene instellingen");
define('_DML_CFG_THEMES', "Thema\'s");
define('_DML_CFG_EXTRADOCINFO', "Extra Document Informatie");
define('_DML_CFG_GUESTPERM', "Gast rechten");
define('_DML_CFG_FRONTPERM', "Frontend rechten");
define('_DML_CFG_DOCPERM', "Documentrechten");
define('_DML_CFG_OVERRIDEVIEW', "Bekijken overschrijven");
define('_DML_CFG_OVERRIDEMANT', "Beheer overschrijven");
define('_DML_CFG_CREATORPERM', "Auteur rechten");
define('_DML_CFG_FILEXTENSIONS', "Bestandsextensies");
define('_DML_CFG_FILENAMES', "Bestandsnamen");

define('_DML_CFG_PROCESS_BOTS', "Artikelplugins verwerken?");
define('_DML_CFG_PROCESS_BOTSTT', "Past artikelplugins toe op de document of categorieomschrijvingen. Dit staat u toe om {tags} in uw omschrijvingen te gebruiken. *Waarschuwing* Niet alle plugins werken met deze instelling.");
define('_DML_CFG_INDIVIDUAL_PERM', "Individuele gebruikersrechten inschakelen");
define('_DML_CFG_INDIVIDUAL_PERMTT', "Wanneer u dit uitschakelt zult u rechten kunnen toewijzen aan een groep, maar niet langer aan een individuele gebruiker. Uw bestaande documentrechten zullen behouden worden maar bij het wijzigen van een document dat is toegewezen aan een enkele gebruiker dient u een gebruikersgroep op te geven in de plaats. Schakel dit uit om de snelheid en geheugengebruik te verbeteren voor grote sites met veel gebruikers. ");
define('_DML_CFG_HIDE_REMOTE', "Verberg remote links");
define('_DML_CFG_HIDE_REMOTETT', "Deze optie verbergt links naar remote bestanden in de document detailoverzicht. Gebruikers met aanpassingsrechten zullen de links zien. *OPMERKING* Dit geeft absoluut _NIET_ volledige bescherming van remote links. Gebruikers zullen nog steeds uitvinden waar de locatie is van het bestand.");

// -- Statistics
define('_DML_STATS', "Statistieken");
define('_DML_DOCSTATS', "DOCman statistieken - Top 50 Downloads");
define('_DML_RANK', "Rang");

// -- Logs
define('_DML_DOWNLOAD_LOGS', "Download Logs");
define('_DML_IP', "IP");
define('_DML_BROWSER', "Browser");
define('_DML_OS', "Besturingssysteem");
define('_DML_ANONYMOUS', "Anoniem");

// -- Updates
define('_DML_UPGRADE', "Upgrade");
define('_DML_YOU_HAVE_VERSION', "U heeft versie");
define('_DML_UPTODATE', "Uw versie is up-to-date.");
define('_DML_NO_UP_AVAIL', "Geen updates beschikbaar op dit ogenblik.");
define('_DML_COULD_NOT_COPY', "Kon niet alle bestanden naar de mappen kopi&euml;ren. Controleer bestandsrechten. Gestopt bij bestand");
define('_DML_UPDATING_DB', "Updating database...");
define('_DML_DELETING_OLD', "Oude bestanden verwijderen...");
define('_DML_ERROR_DELETING_OLD', "Fout bij verwijderen van oude bestanden. Geen kritieke fout.");
define('_DML_PACKAGE', "Pakket");
define('_DML_INST_CLICK', "Ge&iuml;nstalleerd. Klik");
define('_DML_HERE', "hier");
define('_DML_TO_CONT', "om verder te gaan");
define('_DML_ERROR_READING', "fout bij het lezen");
define('_DML_XML_ERROR', "XML bestand ongeldig");
define('_DML_CHECKING_UP', "Controle op upgrades");
define('_DML_RELEASED_ON', "Vrijgegeven op");

// -- Themes
define('_DML_THEMES', "Thema\'s");
define('_DML_EDIT_DEFAULT_THEME', "Wijzig huidige thema");
define('_DML_THEME_INSTALLED', "Theme ge&iuml;nstalleerd");
define('_DML_ADJUST_CONFIG', "Configuratie aanpassen");
define('_DML_NEED_ZLIB', "De installatie kan niet verdergaan vooraleer zlib ge&iuml;nstalleerd is");
define('_DML_INSTALLER_ERROR', "Installatie - Fout");
define('_DML_SUCCESFULLY_INSTALLED', "Succesvol ge&iuml;nstalleerd");
define('_DML_ENABLE_FILE_UPLOADS', "Bestandsuploads moeten ingeschakeld zijn om door te kunnen gaan");
define('_DML_UPLOAD_ERROR', "Upload fout");
define('_DML_EXTRACT_FAILED', "Uitpakken mislukt");
define('_DML_INSTALL_FAILED', "Installatie mislukt");
define('_DML_UNINSTALL_FAILED', "De&iuml;nstallatie mislukt");
define('_DML_INSTALL_FROM_DIRECTORY', "Installatie vanuit map");
define('_DML_INSTALL_DIRECTORY', "Installeer map");
define('_DML_PACKAGE_FILE', "Pakketbestand");
define('_DML_UPLOAD_PACKAGE_FILE', "Upload pakketbestand");
define('_DML_UPLOAD_AND_INSTALL', "Upload bestand en installeer");
define('_DML_INSTALL_THEME', "Installeer thema");
define('_DML_SELECT_DIRECTORY', "Selecteer een map");
define('_DML_SELECT_PACKAGE', "Selecteer een pakket");
define('_DML_STYLESHEET_EDITOR', "Thema Stylesheet Editor");
define('_DML_OPFAILED_NO_TEMPLATE', _DML_OPERATION_FAILED.": Geen template opgegeven");
define('_DML_OPFAILED_CONTENT_EMPTY', _DML_OPERATION_FAILED.": Inhoud leeg");
define('_DML_OPFAILED_UNWRITABLE', _DML_OPERATION_FAILED.": Het bestand is niet schrijfbaar");
define('_DML_OPFAILED_CANT_OPEN_FILE', _DML_OPERATION_FAILED.": Gefaald om bestand te openen voor schrijven");
define('_DML_OPFAILED_COULDNT_OPEN', _DML_OPERATION_FAILED.": Kon niet openen ");
define('_DML_AUTHOR_URL', "Auteur URL" );
define('_DML_AUTHOR', "Auteur" );
define('_DML_INSTALLED_THEMES', "Ge&iuml;nstalleerde thema\'s'");
define('_DML_THEME_DETAILS', "Thema details");
define('_DML_EDIT_THEME', "Wijzig theme");


// -- E-mail
define('_DML_EMAIL_GROUP', "Verzend E-mail naar groep");
define('_DML_SUBJECT', "Onderwerp");
define('_DML_EMAIL_LEADIN', "Inleidende tekst");
define('_DML_MESSAGE', "Hoofdtekst");
define('_DML_SEND_EMAIL', "Verzenden");

// -- Credits
define('_DML_CREDITS', "Credits" );
define('_DML_APPLICATION', "Applicatie");
define('_DML_ICONS', "Iconen");
define('_DML_ICONS_PERMISSION', "Iconen gebruikt met toelating van" );
define('_DML_CHANGELOG', "Changelog");

// -- Clear Data
define('_DML_CLEARDATA', "Wis gegevens" );
define('_DML_CLEARDATA_CLEARED', "Data verwijderd " );
define('_DML_CLEARDATA_FAILED', "Verwijderen mislukt: " );
define('_DML_CLEARDATA_ITEM', "Item" );
define('_DML_CLEARDATA_CLEAR', "Verwijder" );
define('_DML_CLEARDATA_CATS_CONTAIN_DOCS', "Documenten verwijderen alvorens categorie&euml;n verwijdert worden");
define('_DML_CLEARDATA_DELETE_DOCS_FIRST', "Documenten verwijderen voordat bestanden verwijdert worden");

// -- Sample data
define('_DML_SAMPLE_CATEGORY', "Voorbeeldcategorie" );
define('_DML_SAMPLE_CATEGORY_DESC', "U kunt deze voorbeeldcategorie verwijderen." );
define('_DML_SAMPLE_DOC', "Voorbeelddocument" );
define('_DML_SAMPLE_DOC_DESC', "U kunt dit voorbeelddocumengt en gelinkt bestand verwijderen." );
define('_DML_SAMPLE_FILENAME', "sample_file.png" );
define('_DML_SAMPLE_COMPLETED', "Voorbeelddata toegevoegd." );
define('_DML_SAMPLE_GROUP', "Voorbeeld groep" );
define('_DML_SAMPLE_GROUP_DESC', "U kunt groepen gebruiken om rechten toe te wijzen aan een groep van gebruikers." );
define('_DML_SAMPLE_LICENSE', "Voorbeeldlicentie" );
define('_DML_SAMPLE_LICENSE_DESC', "U kunt optioneel licenties toevoegen aan uw documenten." );

// -- Added v1.4.0 RC1
define('_DML_CFG_COMPAT', "Compatibiliteit" );
define('_DML_CFG_SPECIALCOMPATMODE', "&quot;Special&quot; compatibiliteitsmodus" );
define('_DML_CFG_SPECIALCOMPATMODETT', "In de DOCman 1.3 compatibiliteitsmodus zijn &quot;Special&quot; gebruikers Managers, Administrators en Super Administrators. In Joomla! modus is dit ook Authors, Publishers en Editors");
define('_DML_CFG_SPECIALCOMPAT_DM13', "DOCman 1.3" );
define('_DML_CFG_SPECIALCOMPAT_J10', "Joomla!" );