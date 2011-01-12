<?php
/**
 * @version		$Id: french.backend.php 11 2009-10-22 12:58:14Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

/**
 * Fichier de traduction pour la langue française au format UTF-8
 *
 * Creator:  Thierry Vanneste 
 * Website:  http://www.tvdev.info/
 * E-mail:   thierry.vanneste@tvdev.info 
 * Revision: 1.5
 * Date:     27/2/2009
 **/

// -- Barres d'outils
define('_DML_TOOLBAR_SAVE', "Enregistrer");
define('_DML_TOOLBAR_CANCEL', "Annuler");
define('_DML_TOOLBAR_NEW', "Nouveau");
define('_DML_TOOLBAR_NEW_DOC', "Nouveau Document");
define('_DML_TOOLBAR_HOME', "Accueil");
define('_DML_TOOLBAR_UPLOAD', "Importer");
define('_DML_TOOLBAR_MOVE', "Déplacer");
define('_DML_TOOLBAR_COPY', "Copier");
define('_DML_TOOLBAR_SEND', "Envoyer");
define('_DML_TOOLBAR_BACK', "Retour");
define('_DML_TOOLBAR_PUBLISH', "Publier");
define('_DML_TOOLBAR_UNPUBLISH', "Ne pas publier");
define('_DML_TOOLBAR_DEFAULT', "Défaut");
define('_DML_TOOLBAR_DELETE', "Supprimer");
define('_DML_TOOLBAR_CLEAR', "Effacer");
define('_DML_TOOLBAR_EDIT', "Modifier");
define('_DML_TOOLBAR_EDIT_CSS', "Modifier CSS");
define('_DML_TOOLBAR_APPLY', "Appliquer");


// -- Fichiers
define('_DML_ORPHANS', "Orphelins");
define('_DML_ORPHANS_LINKED', "Fichier(s) non supprimé(s). Impossible de supprimer le(s) fichier(s) liés à des documents.");
define('_DML_ORPHANS_PROBLEM', "Fichier(s) non supprimé(s). Il y a un problème avec les permissions du fichier.");
define('_DML_ORPHANS_DELETED', "Fichier(s) supprimé(s).");
define('_DML_LINKS', "Liens");
define('_DML_NEXT', "Suivant");
define('_DML_SUCCESS', "Félicitations !");
define('_DML_UPLOADMORE', "Importer d'autres fichiers");
define('_DML_UPLOADWIZARD', "Assistant import de fichier");
define('_DML_UPLOADMETHOD', "Sélectionner la méthode d'import du fichier");
define('_DML_ISUPLOADING', "Import fichier DOCman en cours...");
define('_DML_PLEASEWAIT', "Veuillez patienter ...");
define('_DML_UPLOADDISK', "Assistant import de fichier - Transférer un fichier à partir de votre disque dur");
define('_DML_FILETOUPLOAD', "Sélectionner le fichier à importer");
define('_DML_BATCHMODE', "Mode Batch");
define('_DML_BATCHMODETT', "Le mode batch permet d'importer en une seule fois un groupe de fichiers préalablement compressés ou zippés. Le groupe de fichiers sera dézippé lors du transfert. Le dossier zippé ne doit pas contenir de répertoires ou de sous-répertoires. Faites attention car cette opération risque d'écraser des fichiers déjà existant dans le répertoire des documents DOCman portant le même nom. Il n'y a aucun controle prévu lors de cette action. Cette méthode est expérimentale et doit être utilisée en connaissance de cause.");
define('_DML_DOCMANISTRANSF', "Fichier en cours de transfert<br />dans DOCman");
define('_DML_TRANSFERFROMWEB', _DML_UPLOADWIZARD . " - " . "transférer un fichier sur un serveur Web");
define('_DML_REMOTEURL', "URL du fichier");
define('_DML_LINKURLTT', "Saisir l'URL du fichier auquel vous souhaitez accéder. L'URL doit inclure le chemin complet du fichier précédé de (http:// ou ftp://). Exemple: http://joomlacode.org/gf/download/frsrelease/292/1001/docman_1.3RC2.zip.");
define('_DML_REMOTEURLTT', _DML_LINKURLTT . "<br />Vous pouvez nommer le fichier comme vous le souhaitez à condition que vous utilisiez la syntaxe : 'Local Nom'; champ.");
define('_DML_LOCALNAME', "Nom Local");
define('_DML_LOCALNAMETT', "Saisir le nom du fichier local tel qu'il doit être enregistré dans l'application."
     . "Ce champ est obligatoire car l'URL ne donne pas suffisamment d'information sur l'emplacement du fichier.");
define('_DML_DOCUPDATED', "Le document a été mis à jour.");
define('_DML_FILEUPLOADED', "Le fichier a été téléchargé.");
define('_DML_MAKENEWENTRY', "Créer un nouveau document à partir de ce fichier.");
define('_DML_DISPLAYFILES', "Afficher les fichiers.");
define('_DML_ALLFILES', "Tous les fichiers");
define('_DML_DOCFILES', "Fichiers Documents");
define('_DML_CREATEALINK', "Créer un document lié");
define('_DML_SELECTMETHODFIRST', "Veuillez sélectionner une méthode de téléchargement !");
define('_DML_ERROR_UPLOADING', "Erreur lors du téléchargement.");
define('_DML_ZLIB_ERROR', "L'opération a échoué, car la bibliothèque PHP zlib n'existe pas.");
define('_DML_UNZIP_ERROR', "Impossible de dézipper les fichiers.");
define('_DML_SUBMIT', "Valider");
define('_DML_NEW_FILE', "Nouveau Fichier");
define('_DML_MAKE_SELECTION', "Sélectionnez dans la liste.");

// -- Documents
define('_DML_MOVECAT', "Déplacer Catégorie");
define('_DML_MOVETOCAT', "Déplacer dans la catégorie");
define('_DML_DOCSMOVED', "Les documents ont été déplacés ");
define('_DML_COPYCAT', "Copier Catégorie");
define('_DML_COPYTOCAT', "Copier dans la catégorie");
define('_DML_COPY_OF', "Copie de"); // Copie de [document name]
define('_DML_DOCSCOPIED', "Les documents ont été copiés");
define('_DML_DOCS_NOT_APPROVED', "Les documents ne sont pas approuvés");
define('_DML_DOCS_NOT_PUBLISHED', "Les documents ne sont pas publiés");
define('_DML_NO_PENDING_DOCS', "Aucun document en attente d'approbation.");
define('_DML_FILE_MISSING', "***Fichier Manquant***");
define('_DML_YOU_MUST_UPLOAD', "Vous devez d'abord importer un document dans cette section.");
define('_DML_THE_MODULE', "Le module");
define('_DML_IS_BEING', "est actuellement en cours de modification par un autre administrateur");
define('_DML_NO_LICENSE', "Licence non définie");
define('_DML_LINKED', "->DOCUMENT LIE<-");
define('_DML_CURRENT', "Actuel");
define('_DML_LICENSE_TYPE', "Type de Licence");
define('_DML_FILETITLE', "Titre du fichier");
define('_DML_OWNER_TOOLTIP', "Cette fonction va permettre de déterminer qui est autorisé à télécharger et visualiser le document. Sélectionner : "
     . "*Everybody* (Tout le monde) si vous souhaitez que tout le monde ait accès au document. "
     . "*All Registered Users* (Tous les membres enregistrés) permet aux seuls utilisateurs enregistrés et donc titulaire d'un compte d'accéder au document. "
     . "Vous pouvez assigner les droits sur un document à un seul membre enregistré en sélectionnant un nom sous " . _DML_USERS . "; "
     . "Seul ce membre aura accès au document en question. "
     . "Vous pouvez assigner les droits sur un document à un groupe d'utilisateurs enregistrés en sélectionnant un groupe sous  " . _DML_GROUPS . "; "
     . "Seul ce groupe d'utilisateurs aura accès au document en question..");
define('_MANT_TOOLTIP', "Cette fonction va permettre de déterminer qui peut modifier et/ou mettre à jour le document. "
     . " Quand un utilisateur membre d'un groupe correspond à " . _DML_MAINTAINER . " d'un document, cela signifie qu'il peut utiliser les principales options de la gestion documentaire. Ces options sont : modifier, mettre à jour, déplacer, extraire/importer et supprimer.");
define('_DML_MAKE_SURE', "Veuillez saisir l'URL<br />sous la forme http://'");
define('_DML_DOCURL', "URL du document:");
define('_DML_DOCURL_TOOLTIP', "Lorsque qu'il y a des documents liés, vous devez saisir l'URL (adresse) du site en entier pour le document. Préciser systématiquement le protocole (http:// or ftp://) au début de l'adresse.");
define('_DML_HOMEPAGE_TOOLTIP', "Vous pouvez éventuellement saisir l'URL (adresse) absolue d'un document en particulier. Préciser systématiquement le protocole (http:// or ftp://) au début de l'adresse sinon cela ne fonctionnera pas.");
define('_DML_LICENSE_TOOLTIP', "Un document peut être assorti d'une Licence d'Utilisation que les utilisateurs devront approuver pour accéder au document. Ici vous pourrez définir le type de Licence.");
define('_DML_DISPLAY_LICENSE', "Afficher le type de Licence d'utilisation lors de l'utilisation");
define('_DML_DISPLAY_LIC_TOOLTIP', "Sélectionner *Oui* si vous souhaitez proposer la lecture du texte de la licence à l'utilisateur avant qu'il ait accès au document.");
define('_DML_APPROVED_TOOLTIP', " Un document doit être approuvé pour être visible et disponible dans la base documentaire. Sélectionner *Oui* le cas échéant et n'oubliez pas de le publier ! Les deux options devront être sélectionnées pour être visualisées à partir du frontal utilisateur");
define('_DML_PLEASE_SEL_CAT', "Veuillez définir au moins une catégorie");
define('_DML_MANT_TOOLTIP', "Cette fonction permet de déterminer qui peut modifier, ou mettre à jour le document."
     . "Quand un utilisateur membre d'un groupe correspond à " . _DML_MAINTAINER . " d'un document, cela signifie qu'il peut utiliser les principales options de la gestion documentaire. Ces options sont : modifier, mettre à jour, déplacer, extraire/importer et supprimer.");
define('_DML_DISPLAY_LIC', "Lecture de la Licence");

define('_DML_TAB_PERMISSIONS', "Permissions");
define('_DML_TAB_LICENSE', "Licence");
define('_DML_TAB_DETAILS', "Propriétés");
define('_DML_TAB_PARAMS', "Paramètres");

define('_DML_TITLE_DOCINFORMATION', "Fiche description du document");
define('_DML_TITLE_DOCPERMISSIONS', "Permissions sur le document");
define('_DML_TITLE_DOCLICENSES', "Licences du document");
define('_DML_TITLE_DOCDETAILS', "Propriétés du document");
define('_DML_TITLE_DOCPARAMETERS', "Paramètres du document");

define('_DML_CREATED_BY', "Crée par");
define('_DML_UPDATED_BY', "Dernière modification par");
define('_DML_SELECT_ITEM_DEL', "Sélectionner un élément à supprimer");
define('_DML_SELECT_ITEM_MOVE', "Sélectionner un élément à déplacer");
define('_DML_SELECT_ITEM_COPY', "Sélectionner un élément à copier");
define('_STATUS_YOU', "Ce document est extrait par vous.");
define('_STATUS_NOT_OUT', "Ce document n'est pas extrait.");
define('_DML_NEW_DOCUMENT', "Nouveau Document");
define('_DML_DOCUMENTS_MOVED_TO', "Documents déplacés vers"); // [Number of] Documents déplacés vers [location]
define('_DML_DOCUMENTS_COPIED_TO', "Documents copiés vers"); // [Number of] Documents déplacés vers [location]


// -- Catégories
define('_DML_CATDETAILS', "Propriétés de la catégorie");
define('_DML_CATTITLE', "Titre de la catégorie");
define('_DML_CATNAME', "Nom de la catégorie");
define('_DML_LONGNAME', "Un nom long sera affiché dans la ligne de titre");
define('_DML_PARENTITEM', "Elément parent");
define('_DML_IMAGE', "Image");
define('_DML_PREVIEW', "Aperçu");
define('_DML_IMAGEPOS', "Position de l'image");
define('_DML_ORDERING', "Tri");
define('_DML_ACCESSLEVEL', "Niveau d'accès");
define('_DML_CREATEMENUITEM', "Cette fonction va créer une entrée de menu dans le menu que vous avez sélectionné");
define('_DML_SELECTMENU', "Sélectionner un menu");
define('_DML_SELECTMENUTYPE', "Sélectionner le type de menu");
define('_DML_MENUITEMNAME', "Titre de l'entrée du menu");
define('_DML_SELECTCATTO', "Sélectionner la catégorie à");
define('_DML_SELECTCATTODELETE', "Sélectionner la catégorie à supprimer");
define('_DML_REORDER', "Trier");
define('_DML_ACCESS', "Accès");
define('_DML_CAT_MUST_SELECT_NAME', "Renseigner le titre de la catégorie");
define('_DML_CATS_CANT_BE_REMOVED', "ne peut être supprimé. Il existe encore des enregistrements ou des sous catégories liées");

// -- Groupes
define('_DML_TITLE_GROUPS', "Groupes");
define('_DML_CANNOT_DEL_GROUP', "Il n'est pas possible de supprimer ce groupe car un document y est toujours attaché.");
define('_DML_USERS_AVAILABLE', "Liste des utilisateurs");
define('_DML_MEMBERS_IN_GROUP', "Membres de ce groupe");
define('_DML_ADD_GROUP_TIP', "Double cliquer sur un nom ou le sélectionner puis utiliser les flèches pour ajouter/supprimer un membre utilisateur."
     . "pour sélectionner plus d'un utilisateur simultanément, " . _DML_MULTIPLE_SELECTS);
define('_DML_ADDING_USERS', "Ajouter des utilisateurs membres à des groupes");
define('_DML_FILL_FORM', "Veuillez compléter entièrement le formulaire");
define('_DML_ONLY_ADMIN_EMAIL', "Seul un administrateur peut adresser des emails en nombre !");
define('_DML_NO_TARGET_EMAIL', "Certains utilisateurs de ce groupe n'ont pas une adresse email correcte");
define('_DML_THIS_IS', "Cet email provient de");
define('_DML_SENT_BY', "adressé par DOCman aux ayants droits de ce groupe");
define('_DML_EMAIL_SENT_TO', "E-mail adressé à");
define('_DML_MEMBERS', "Membres");
define('_DML_EMAIL', "E-mail");
define('_DML_USER_BLOCKED', "bloqué");

// -- Licences
define('_DML_LICENSE_TEXT', "Texte de la licence");
define('_DML_CANNOT_DEL_LICENSE', "Il n'est pas possible de supprimer cette licence car");


// -- Configuration
define('_DML_FRONTEND', "Interface");
define('_DML_PERMISSIONS', "Permissions");
define('_DML_RESETDEFAULT', "Réinitialiser");
define('_DML_ASCENDENT', "Croissant");
define('_DML_DESCENDENT', "Décroissant");

define('_DML_CONFIGURATION', "Configuration DOCman");
define('_DML_CONFIG_UPDATED', "Les paramètres de configuration ont été mis à jour.");
define('_DML_CONFIG_WARNING', "Attention : la configuration a bien été mise à jour mais la taille maximum des fichiers pour le téléchargement est supérieure au maximum autorisé par la configuration PHP : ");
define('_DML_CONFIG_ERROR', "Une erreur est survenue : impossible d'ouvrir le fichier de configuration en écriture !");
define('_DML_CONFIG_ERROR_UPLOAD', "Erreur : la taille maximum pour le téléchargement des fichiers ne peut pas être négative.");

define('_DML_CFG_DOCMANTT', "Infobulle d'aide DOCman...");
define('_DML_CFG_ALLOWBLANKS', "Autoriser les espaces");
define('_DML_CFG_REJECT', "Refuser");
define('_DML_CFG_CONVERTUNDER', "Compléter les espaces avec des soulignés");
define('_DML_CFG_CONVERTDASH', "Compléter les espaces avec des tirets");
define('_DML_CFG_REMOVEBLANKS', "Supprimer les espaces");
define('_DML_CFG_PATHFORSTORING', "Chemin de l'emplacement des fichiers");
define('_DML_CFG_PATHTT', "Ici vous devrez définir le répertoire local o� les fichiers sont stockés. Ce chemin doit être défini de manière absolue. Vous pouvez laisser les valeurs par défaut mais si vous préférez définir un chemin différent pour les documents, alors il faudra saisir le chemin absolu.<br /><br />"
     . "Par exemple, sur un système de type *NIX celui-ci devra être défini, par exemple, sous la forme : /var/usr/www/dmdocuments<br /><br />"
     . "Si vous utilisez un serveur (local) sous Windows, celui-ci devra être défini, par exemple, sous la forme : c:/inetpub/www/dmdocuments");
define('_DML_CFG_SECTIONISDOWN', "La section est-elle inutilisée ?");
define('_DML_CFG_SECTIONTT', "Si vous souhaitez empêcher les utilisateurs habituels d'accéder au répertoire de stockage des documents, passez cette option à *Oui*. <br />"
     . "Cette fonction est utile lors des tests ou lorsque vous mettez à jour le répertoire de stockage des documents.<br /><br />"
     . "Les Administrateurs et les 'Utilisateurs Spéciaux' y auront toujours accès si l'option est définie à *Non*. <br />"
  );
define('_DML_CFG_NUMBEROFDOCS', "Nombre de documents par page");
define('_DML_CFG_NUMBERTT', "Nombre de documents par page à afficher par page. Si le nombre total des docuemnts est supérieur à ce nombre, un bouton permettant la pagination sera automatiquement affiché.");

define('_DML_CFG_GUEST', "Invités");
define('_DML_CFG_GUEST_NO', "Accès interdit");
define('_DML_CFG_GUEST_X', "Parcourir seulement");
define('_DML_CFG_GUEST_RX', "Parcourir, Télécharger, et Voir");
define('_DML_CFG_GUEST_TT', "Cette fonction permet de déterminer ce à quoi les invités - utilisateurs non enregistrés - (Non Registered Users) auront droit : <br />*"
     . _DML_CFG_GUEST_NO . "* Aucun document n'est invisible<br />*"
     . _DML_CFG_GUEST_X . "* Permet de voir les documents mais pas d'y accéder.<br />*"
     . _DML_CFG_GUEST_RX . "* Permet de voir les documents et d'y accéder..."
     . "<br /><br />Cette autorisation est cumulable avec l'accès à un document individuel."
     . "</span>");

define('_DML_CFG_AUTHOR_NONE', "Accès interdit");
define('_DML_CFG_AUTHOR_READ', "Télécharger seulement");
define('_DML_CFG_AUTHOR_BOTH', "Télécharger et modifier");

define('_DML_CFG_ICONSIZE', "Taille de l'icone");
define('_DML_CFG_DAYSFORNEW', "Nb. de jours pour un nouveau document");
define('_DML_CFG_DAYSFORNEWTT', "Déterminer le nombre de jours pour indiquer le statut de nouveauté d'un fichier. Cette fonction affichera le libellé *" . _DML_NEW . "* à coté du nom du document. Si la valeur est définie à zéro, aucun libellé ne sera ajouté.");
define('_DML_CFG_HOT', "Téléchargements populaires");
define('_DML_CFG_HOTTT', "Indiquer le nombre d'accès au document à partir duquel le document peut-être considéré comme populaire. Cette fonction affichera le libellé *" . _DML_HOT . "* à coté du nom du document lorsque le seuil indiqué sera atteint. Si la valeur est définie à zéro, aucun libellé ne sera ajouté.");
define('_DML_CFG_DISPLAYLICENSES', "Afficher les licences ?");

define('_DML_CFG_VIEW', "Voir");
define('_DML_CFG_VIEWTT', "Cette fonction vous permet de définir l'utilisateur/groupe par défaut qui pourra télécharger et voir les documents. Ces droits peuvent être modifiés au niveau du document.");
define('_DML_CFG_MAINTAIN', "Gérer");
define('_DML_CFG_MAINTAINTT', "Cette fonction vous permet de définir l'utilisateur/groupe par défaut qui pourra gérer le document. Ces droits peuvent être modifiés au niveau du document.");
define('_DML_CFG_CREATORS_PERM', "Les auteurs du document peuvent");
define('_DML_CFG_CREATORSPERMTT', "Cette fonction vous permet de définir globalement ce que l'auteur peut faire sur un document.<br /><br />"
     . "Ceete fonction s'ajoute aux permissions accordées par les champs 'Lecteur' ou 'Gestionnaire' de chaque document.");
define('_DML_CFG_WHOCANAREADER', "Télécharger");
define('_DML_CFG_WHOCANAREADERTT', "Cette fonction vous permet de décider si les Auteurs/Gestionnaires peuvent modifier qui sera autorisé à voir les documents.<br /><br />"
     . "N.B.: Les Administrateurs peuvent toujours assigner les droits de lecture sur un document.");
define('_DML_CFG_WHOCANAEDITOR', "Modifier");
define('_DML_CFG_WHOCANAEDITORTT', "Cette fonction permet de déterminer si les Auteurs/Gestionnaires pourront à leur tour sélectionner des Gestionnaires.<br /><br />"
     . "N.B.: Les Administrateurs peuvent toujours sélectionner un Gestionnaire.");

define('_DML_CFG_EMAILGROUP', "Groupe Utilisateur E-mail ?");
define('_DML_CFG_EMAILGROUPTT', "Si vous cliquez *Oui* et que la première option est *Oui*, un lien sur chaque document partagé par un groupe sera affiché afin de permettre un utilisateur d'envoyer un mail à tous les autres membres du groupe pour discussion.");

define('_DML_CFG_UPLOAD', "Importer");
define('_DML_CFG_UPLOADTT', "Cette fonction permet d'autoriser un Utilisateur/Groupe à importer des documents dans la base. Toutes les méthodes d'import sont controlées : http, lien et transfert");
define('_DML_CFG_APPROVE', "Approuver");
define('_DML_CFG_APPROVETT', "Cette fonction permet d'autoriser un Utilisateur/Groupe à approuver des documents.<br />Les documents doivent être approuvés et publiés préalablement.");
define('_DML_CFG_PUBLISH', "Publier");
define('_DML_CFG_PUBLISHTT', "Cette fonction permet d'autoriser un Utilisateur/Groupe à publier des documents.<br />Les documents doivent être approuvés et publiés préalablement.");
define('_DML_CFG_USER_UPLOAD', "Sélectionner Qui peut Importer");
define('_DML_CFG_USER_APPROVE', "Sélectionner Qui peut Approuver");
define('_DML_CFG_USER_PUBLISH', "Sélectionner Qui peut Publier");

define('_DML_CFG_EXTALLOWED', "Extensions autorisées");
define('_DML_CFG_EXTALLOWEDTT', "Les types d'extension autorisées doivent être séparées par des |. Les utilisateurs finaux peuvent télécharger n'importe quel type de fichier.");
define('_DML_CFG_MAXFILESIZE', "Taille maxi. de fichier autorisée lors de l'import");
define('_DML_CFG_MAXFILESIZETT', "Taille maxi. de fichier autorisée lors du téléchargement à parti de l'interface utilisateur. Vous pouvez utiliser K/M/G comme raccourcis clavier.<br /> Cette limite ne s'applique pas aux imports de fichiers depuis l'interface administrateur (Back-End). <br /><hr /> Il y aussi une valeur de configuration de PHP : upload_max_filesize qui est définie à ");
define('_DML_CFG_USERCANUPLOAD', "Est-ce que l'utilisateur final peut télécharger tous types de fichiers ?");
define('_DML_CFG_USERCANUPLOADTT', "Si *Oui* et si *Utilisateur Import* est égal à *Oui*, alors les membres enregistrés (Registered Users) peuvent importer tous types de fichier. Le précédent paramètre est ignoré.");
define('_DML_CFG_OVERWRITEFILES', "Remplacer les fichiers ?");
define('_DML_CFG_OVERWRITEFILESTT', "Si *Oui*, les fichiers seront remplacés lors de l'import à condition que le nom du fichier trouvé soit identique.");
define('_DML_CFG_LOWERCASE', "Noms des fichiers en minuscules ?");
define('_DML_CFG_LOWERCASETT', "Si *Oui*, les noms des fichiers importés seront transformés en majuscules, ex. VotreFichier.TXT devient votrefichier.txt.<br />Si *Non*, les noms des fichiers seront maintenus à l'identique (caractères minuscules et majuscules inclus");
define('_DML_CFG_FILENAMEBLANKS', "Noms des fichiers avec des espaces");
define('_DML_CFG_FILENAMEBLANKSTT', "Gérer les noms de fichiers qui contiennent des espaces :<br />"
     . "*Autoriser les *espaces* permet d'importer un fichier en incluant les espaces.<br />"
     . "*Refuser* empêchera un fichier d'être importé s'il contient des *espaces*.<br /><br />"
     . "Vous pouvez aussi transformer les espaces existant en soulignés (_), tirets (-), ou encore supprimer les espaces inclus dans le nom du fichier.");
define('_DML_CFG_REJECTFILENAMES', "Refuser les noms de fichier");
define('_DML_CFG_REJECTFILENAMESTT', "Entrer la liste des fichiers qui sont interdits au téléchargement, séparés par une barre verticale (|). Ces noms de fichiers ont un sens précis pour l'application. \'.htaccess\' est refusé par défaut.<br />Vous pouvez aussi utiliser des expressions régulières entre les barres verticales (|) afin de filtrer les fichiers qui contiennent des caractères spéciaux dans le nom du fichier, exemple : (* $ ?)");
define('_DML_CFG_UPMETHODS', "Méthodes d'import ?");
define('_DML_CFG_UPMETHODSTT', "Sélectionner toutes les méthodes qu'un utilisateur peut employer. Les Administrateurs ont par défaut toujours accès à toutes les méthodes. Pour sélectionner plusieurs méthodes, " . _DML_MULTIPLE_SELECTS);

define('_DML_CFG_ANTILEECH', "Système Anti-Piratage ?");
define('_DML_CFG_ANTILEECHTT', "The système Anti-Spam empêche les liens non autorisés sur vos documents. "
     . "Lorsque vous cliquez *Oui* chaque requête est controlée afin de vérifier que le téléchargement/vue de la requête "
     . "(Le HTTP référent) émis par un serveur correspond à la liste des Hotes Autorisés. Sinon l'accès sera refusé. "
     . "Cette fonction permet de préserver votre base documentaire d'être détournée au profit d'autres systèmes.<br /><br />"
     . "N.B. DOCman supporte les liens directs entre les systèmes."
     . "Si vous utilisez les liens, assurez vous que le système source inclut cet hote (Hotes Autorisés) dans la liste."
  );
define('_DML_CFG_ALLOWEDHOSTS', "Hotes Autorisés");
define('_DML_CFG_ALLOWEDHOSTSTT', "Une liste d'Hotes quand le système anti-piratage est activé. Si vous souhaitez permettre à plusieurs hotes de référencer ces fichiers, entrez la liste des noms d'hotes séparés par des barres verticales (|).<br />La valeur par défaut est généralement sécuritaire.");

define('_DML_CFG_LOG', "Voir les journaux (Logs) ?");
define('_DML_CFG_LOGTT', "Ce journal trace l'adresse IP distante, la date et l'heure du fichier accédé. "
     . "N.B. Un grand nombre d'information va être stockée dans la base si cette option est retenue.<hr />"
     . "Des plugins (Mambots) sont disponibles pour tracer plus finement les journaux de connexion.");

define('_DML_CFG_UPDATESERVER', "Mise à jour du serveur");
define('_DML_CFG_UPDATESERVERTT', "DOCman est capable de se mettre à jour automatiquement à partir du Web, mais aussi installer les nouveaux modules, plugins, et bots. Il peut également effectuer des modifications en base à chaud simultanément avec les mises à jour ! Vous trouverez ici l'URL correspondante du serveur DOCman. Si le serveur n'a pas changé (nous espérons que non), laissez la valeur par défaut.");
define('_DML_CFG_DEFAULTLISTING', "Ordre de Tri par défaut");
define('_DML_CFG_TRIMWHITESPACE', "Supprimer les espaces (blancs)");
define('_DML_CFG_TRIMWHITESPACETT', "Trim leading whitespace and blank lines from theme output, cleaning up code and saving bandwidth");

define('_DML_CFG_ERR_DOCPATH', "L'onglet [" . _DML_GENERAL . "] '" . _DML_CFG_PATHFORSTORING . "' doit être renseigné.");
define('_DML_CFG_ERR_PERPAGE', "L'onglet [" . _DML_FRONTEND . "] '" . _DML_CFG_NUMBEROFDOCS . "' doit être numérique et supérieur à zero");
define('_DML_CFG_ERR_NEW', "L'onglet [" . _DML_FRONTEND . "] '" . _DML_CFG_DAYSFORNEW . "' doit être numérique et supérieur à zero");
define('_DML_CFG_ERR_HOT', "L'onglet [" . _DML_FRONTEND . "] '" . _DML_CFG_HOT . "' doit être numérique et supérieur à zero");
define('_DML_CFG_ERR_UPLOAD', "L'onglet [" . _DML_PERMISSIONS . "] '" . _DML_CFG_UPLOAD . "': Sélectionner qui peut importer des documents.");
define('_DML_CFG_ERR_APPROVE', "L'onglet [" . _DML_PERMISSIONS . "] '" . _DML_CFG_APPROVE . "': Sélectionner qui peut approuver des documents.");
define('_DML_CFG_ERR_DOWNLOAD', "L'onglet [" . _DML_PERMISSIONS . "] '" . _DML_CFG_VIEW . "': Sélectionner un Utilisateur/Groupe par défaut.");
define('_DML_CFG_ERR_EDIT', "L'onglet [" . _DML_PERMISSIONS . "] '" . _DML_CFG_MAINTAIN . "': Sélectionner un Utilisateur/Groupe par défaut pour le role de Gestionnaire.");
define('_DML_CFG_EXTENSIONSVIEWING', "Extensions pour la lecture");
define('_DML_CFG_EXTENSIONSVIEWINGTT', "Types d'extensions autorisées pour la lecture. Laissez le champ à blanc si aucun, * pour tous. Utilisez une barre verticale (|) comme sépararateur de valeurs exemple : (txt|pdf).");

define('_DML_CFG_GENERALSET', "Paramètres Généraux");
define('_DML_CFG_THEMES', "Thèmes");
define('_DML_CFG_EXTRADOCINFO', "Information Supplémentaire");
define('_DML_CFG_GUESTPERM', "Permissions Invités");
define('_DML_CFG_FRONTPERM', "Permissions Utilisateurs Finaux");
define('_DML_CFG_DOCPERM', "Permissions des Documents");
define('_DML_CFG_OVERRIDEVIEW', "Modifier Lecture");
define('_DML_CFG_OVERRIDEMANT', "Modifier Gestionnaire");
define('_DML_CFG_CREATORPERM', "Permissions du Créateur");
define('_DML_CFG_FILEXTENSIONS', "Extensions de Fichiers");
define('_DML_CFG_FILENAMES', "Noms des Fichiers");

define('_DML_CFG_PROCESS_BOTS', "Traiter le contenu des Mambots ?");
define('_DML_CFG_PROCESS_BOTSTT', "Appliquer le contenu des Mambots sur le document ou les descriptions de catégories. Vous pouvez autoriser les balises {tags} dans vos descriptions. *Attention* Tous les Mambots ne savent pas interpréter ces balises.");
define('_DML_CFG_INDIVIDUAL_PERM', "Autoriser les permissions individuelles");
define('_DML_CFG_INDIVIDUAL_PERMTT', "Après avoir désactivé la fonction, vous pourrez toujours assigner des permissions à un groupe, mais pas à un utilisateur individuel. Les permissions existantes sur un document seront préservées, mais lorsque vous assignez un document à un utilisateur individuel, vous devrez sélectionner un groupe. Un conseil ! désactivez la fonction si vous souhaitez optimiser les performances et la mémoire ou utiliser des bases de données plus importantes.");
define('_DML_CFG_HIDE_REMOTE', "Cacher les liens distants");
define('_DML_CFG_HIDE_REMOTETT', "Cette option cahce les liens vers les fichiers distants dans la vue en détail du document. Les utilisateurs avec les permissions d'édition verront néanmoins ce lien. *Attention* Ceci n'offre AUCUNE protection pour vos liens distants. Les utilisateurs pourront toujours découvrir la localisation distante du fichier.");

// -- Statistiques
define('_DML_STATS', "Statistiques");
define('_DML_DOCSTATS', "Statistiques DOCman - Le Top 50 des téléchargements");
define('_DML_RANK', "Rang");

// -- Logs
define('_DML_DOWNLOAD_LOGS', "Journaux de téléchargement");
define('_DML_IP', "IP");
define('_DML_BROWSER', "Navigateur");
define('_DML_OS', "Système d'exploitation");
define('_DML_ANONYMOUS', "Anonyme");

// -- Mises à jour
define('_DML_UPGRADE', "Mettre à jour");
define('_DML_YOU_HAVE_VERSION', "Vous avez une version");
define('_DML_UPTODATE', "Votre version est à jour.");
define('_DML_NO_UP_AVAIL', "Aucune mise à jour n'est disponible actuellement.");
define('_DML_COULD_NOT_COPY', "Impossible de copier les tous les fichiers dans les répertoires. Veuillez vérifier les permissions. Fichier interrompu.");
define('_DML_UPDATING_DB', "Mise à jour de la base de données en cours...");
define('_DML_DELETING_OLD', "Supprimer les anciens fichiers...");
define('_DML_ERROR_DELETING_OLD', "Erreur lors de la suppression des anciens fichiers. Erreur non critique.");
define('_DML_PACKAGE', "Lot de fichiers");
define('_DML_INST_CLICK', "installé. Cliquer");
define('_DML_HERE', "ici");
define('_DML_TO_CONT', "afin de poursuivre");
define('_DML_ERROR_READING', "Erreur lors de la lecture");
define('_DML_XML_ERROR', "Fichier XML incorrect");
define('_DML_CHECKING_UP', "Vérifier les mises à jour");
define('_DML_RELEASED_ON', "Mise à jour le");

// -- Thèmes
define('_DML_THEMES', "Thèmes");
define('_DML_EDIT_DEFAULT_THEME', "Modifier le thème actif");
define('_DML_THEME_INSTALLED', "Thème installé");
define('_DML_ADJUST_CONFIG', "Modifier la configuration");
define('_DML_NEED_ZLIB', "Le processus d'installation ne peut aboutir tant que la bibliothèque zlib n'est pas installée");
define('_DML_INSTALLER_ERROR', "Erreur de l'installeur");
define('_DML_SUCCESFULLY_INSTALLED', "Installation réussie");
define('_DML_ENABLE_Fichier_UPLOADS', "L'import du fichier doit être autorisé avant de poursuivre");
define('_DML_UPLOAD_ERROR', "Erreur lors de l'import");
define('_DML_EXTRACT_FAILED', "Erreur lors de l'extraction");
define('_DML_INSTALL_FAILED', "Erreur lors de l'installation");
define('_DML_UNINSTALL_FAILED', "Erreur lors de la désinstallation");
define('_DML_INSTALL_FROM_DIRECTORY', "Installer à partir du répertoire");
define('_DML_INSTALL_DIRECTORY', "Installer le répertoire");
define('_DML_PACKAGE_FILE', "Lot de fichiers");
define('_DML_UPLOAD_PACKAGE_FILE', "Importer un lot de fichiers");
define('_DML_UPLOAD_AND_INSTALL', "Importer un fichier et installer");
define('_DML_INSTALL_THEME', "Installer un thème");
define('_DML_SELECT_DIRECTORY', "Veuillez sélectionner un répertoire");
define('_DML_SELECT_PACKAGE', "Veuillez sélectionner un lot de fichiers");
define('_DML_STYLESHEET_EDITOR', "Editeur de la feuille de style du thème");
define('_DML_OPFAILED_NO_TEMPLATE', _DML_OPERATION_FAILED." : Aucun modèle spécifié");
define('_DML_OPFAILED_CONTENT_EMPTY', _DML_OPERATION_FAILED." : Contenu vide");
define('_DML_OPFAILED_UNWRITABLE', _DML_OPERATION_FAILED.": le fichier n'est pas modifiable");
define('_DML_OPFAILED_CANT_OPEN_Fichier', _DML_OPERATION_FAILED." : le fichier n'est pas modifiable en écriture");
define('_DML_OPFAILED_COULDNT_OPEN', _DML_OPERATION_FAILED." : Ne peut ouvrir ");
define('_DML_AUTHOR_URL', "URL de l'Auteur" );
define('_DML_AUTHOR', "Auteur" );
define('_DML_INSTALLED_THEMES', "Thèmes installés");
define('_DML_THEME_DETAILS', "Propriétés du thème");
define('_DML_EDIT_THEME', "Modifier thème");


// -- E-mail
define('_DML_EMAIL_GROUP', "Envoyer un email à un groupe");
define('_DML_SUBJECT', "Objet");
define('_DML_EMAIL_LEADIN', "Titre principal");
define('_DML_MESSAGE', "Corps du Message");
define('_DML_SEND_EMAIL', "Envoyer");

// -- Crédits
define('_DML_CREDITS', "Crédits" );
define('_DML_APPLICATION', "Application");
define('_DML_ICONS', "Icones");
define('_DML_ICONS_PERMISSION', "Les icones utilisées ici sont autorisées par");
define('_DML_CHANGELOG', "Journal des modifications");

// -- Efffacer les données
define('_DML_CLEARDATA', "Données effacées");
define('_DML_CLEARDATA_CLEARED', "Les données sont effacées");
define('_DML_CLEARDATA_FAILED', "Erreur lors de la suppression : ");
define('_DML_CLEARDATA_ITEM', "Elément");
define('_DML_CLEARDATA_CLEAR', "Supprimer");
define('_DML_CLEARDATA_CATS_CONTAIN_DOCS', "Supprimer les documents avant de supprimer les catégories");
define('_DML_CLEARDATA_DELETE_DOCS_FIRST', "Supprimer les documents avant de supprimer les fichiers");

// -- Données d'exemple
define('_DML_SAMPLE_CATEGORY', "Exemple de Catégorie");
define('_DML_SAMPLE_CATEGORY_DESC', "Vous pouvez supprimer cet exemple de Catégorie.");
define('_DML_SAMPLE_DOC', "Exemple de document");
define('_DML_SAMPLE_DOC_DESC', "Vous pouvez supprimer cet exemplede document et le fichier qui lui est attaché.");
define('_DML_SAMPLE_FILENAME', "sample_file.png" );
define('_DML_SAMPLE_COMPLETED', "Les données d'exemples sont à jour.");
define('_DML_SAMPLE_GROUP', "Exemple de Groupe");
define('_DML_SAMPLE_GROUP_DESC', "Vous pouvez utiliser les groupes afin d'assigner des permissions à des groupes d'utilisateurs.");
define('_DML_SAMPLE_LICENSE', "Exemple de Licence");
define('_DML_SAMPLE_LICENSE_DESC', "Vous pouvez assigner des Licences à des documents.");

// -- Added v1.4.0 RC1
define('_DML_CFG_COMPAT', "Compatibilité" );
define('_DML_CFG_SPECIALCOMPATMODE', "Compatibilité en mode 'Spécial';" );
define('_DML_CFG_SPECIALCOMPATMODETT', "En mode 'spécial' compatible DOCman 1.3 , les utlisateurs sont des Gestionnaires, Administrateurs et Super Administrateurs. En mode Joomla!, ceci inclu également les Auteurs, Publieurs et Editeurs");
define('_DML_CFG_SPECIALCOMPAT_DM13', "DOCman 1.3" );
define('_DML_CFG_SPECIALCOMPAT_J10', "Joomla!" );