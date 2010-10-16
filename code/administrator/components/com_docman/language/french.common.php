<?php
/**
 * @version		$Id: english.common.php 953 2009-10-14 20:38:38Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

/**
 * TRANSLATORS:
 * PLEASE ADD THE INFO BELOW
 */

/**
 * Language:
 * Creator:
 * Website:
 * E-mail:
 * Revision:
 * Date:
 */

define ('_DM_DATEFORMAT_LONG', '%d %m %Y %H:%M'); // use PHP strftime Format, more info at http://php.net
define ('_DM_DATEFORMAT_SHORT', '%d %m %Y');         // use PHP strftime Format, more info at http://php.net
define ('_DM_ISO', 'iso-8859-1');
define ('_DM_LANG', 'fr');

// -- General
define('_DML_NAME', "Titre");
define('_DML_DATE', "Date");
define('_DML_DATE_MODIFIED', "Date de modification");
define('_DML_HITS', "Clics");
define('_DML_SIZE', "Taille");
define('_DML_EXT', "Extension");
define('_DML_MIME', "Type MIME");
define('_DML_THUMBNAIL', "Miniature");
define('_DML_DESCRIPTION', "Description");
define('_DML_VERSION', "Version");
define('_DML_DEFAULT', "D&eacute;faut");
define('_DML_FOLDER', "Dossier");
define('_DML_FOLDERS', "Dossiers");
define('_DML_FILE', "Fichier");
define('_DML_FILES', "Fichiers");
define('_DML_URL', "URL");
define('_DML_PARAMS', "Param&egrave;tres");
define('_DML_PARAMETERS', "Param&egrave;tres");
define('_DML_TOP', "Top");
define('_DML_PROPERTY', "Propri&eacute;t&eacute;");
define('_DML_VALUE', "Valeur");
define('_DML_PATH', "Chemin");

define('_DML_DOC', "Document");
define('_DML_DOCS', "Documents");
define('_DML_DOCUMENT', "Document");
define('_DML_CAT', "Cat&eacute;gorie");
define('_DML_CATS', "Cat&eacute;gories");
define('_DML_CATEGORY', "Cat&eacute;gorie");

define('_DML_UPLOAD', "Import");
define('_DML_SECURITY', "S&eacute;curit&eacute;");
define('_DML_CPANEL', "Accueil");
define('_DML_CONFIG', "Configuration");
define('_DML_LICENSE', "Licence");
define('_DML_LICENSES', "Licences");
define('_DML_UPDATES', "Mises &agrave;; jour");
define('_DML_DOWNLOADS', "T&eacute;l&eacute;chargement");

define('_DML_HOMEPAGE', "Accueil");

define('_DML_NO', "Non");
define('_DML_YES', "Oui");
define('_DML_OK', "OK");
define('_DML_CANCEL', "Annuler");
define('_DML_ADD', "Ajouter");
define('_DML_EDIT', "Modifier");
define('_DML_CONTINUE', "Suite");
define('_DML_SAVE', "Enregistrer");

define('_DML_APPROVED', "Approuv&eacute;");
define('_DML_DELETED', "Supprim&eacute;");

define('_DML_INSTALL', "Installer");
define('_DML_PUBLISHED', "Publi&eacute;");
define('_DML_UNPUBLISH', "D&eacute;publier");
define('_DML_CHECKED_OUT', "Extrait");

define('_DML_TOOLTIP', "Infobulle");
define('_DML_FILTER_NAME', "Filtrer par nom");

define('_DML_TITLE', "Titre");
define('_DML_MULTIPLE_SELECTS', "Garder le doigt enfonc&eacute; sur la touche <b>Ctrl</b> (sur Windows/Unix/Linux) ou la touche clavier <b>Command</b> (sur Mac) lors de la s&eacute;lection.");

define('_DML_USER', "Utilisateur");
define('_DML_OWNER', "Lecteurs");
define('_DML_CREATOR', "Cr&eacute;ateur");
define('_DML_EDITOR', "Gestionnaire");
define('_DML_MAINTAINER', "Gestionnaire");
define('_DML_UNKNOWN', "Inconnu");

define('_DML_FILEICON_ALT', "Fichier Icône");

define('_DML_NOT_AUTHORIZED', "Interdit");
define('_DML_ERROR', "Erreur");
define('_DML_OPERATION_FAILED', "L'op&eacute;ration a &eacute;chou&eacute;");

define('_DML_EDIT_THIS_MODULE', "Modifier ce module");
define('_DML_UNPUBLISH_THIS_MODULE', "D&eacute;publier ce module");
define('_DML_ORDER_THIS_MODULE', "Trier ce module");

define('_DML_WRITABLE', "Inscriptible");
define('_DML_UNWRITABLE', "Non inscriptible");

define('_DML_SAVED_CHANGES', "Enregistrer les modifications");
define('_DML_ARE_YOU_SURE', "Etes-vous certain ?");


// -- HTML Class
define('_DML_SELECT_CAT', "S&eacute;lectionner Cat&eacute;gorie");
define('_DML_SELECT_DOC', "S&eacute;lectionner Document");
define('_DML_SELECT_FILE', "S&eacute;lectionner Fichier");
define('_DML_ALL_CATS', "- Toutes les Cat&eacute;gories");
define('_DML_SELECT_USER', "S&eacute;lectionner Utilisateur");
define('_DML_GENERAL', "G&eacute;n&eacute;ral");
define('_DML_GROUPS', "Groupes");
define('_DML_DOCMAN_GROUPS', "Groupes DOCman ");
define('_DML_MAMBO_GROUPS', "Groupes Joomla!");
define('_DML_JOOMLA_GROUPS', "Groupes Joomla!"); // alias
define('_DML_USERS', "Utilisateurs");
define('_DML_EVERYBODY', "Tout le monde");
define('_DML_ALL_REGISTERED', "Tous les Utilisateurs Enregistr&eacute;s");
define('_DML_NO_USER_ACCESS', "Pas d'Acc s Utilisateur");
define('_DML_AUTO_APPROVE', "Auto Approuver");
define('_DML_AUTO_PUBLISH', "Auto Publier");
define('_DML_GROUP', "Groupe");
define('_DML_GROUP_PUBLISHER', "Contributeur");
define('_DML_GROUP_EDITOR', "Editeur");
define('_DML_GROUP_AUTHOR', "Auteur");

// -- File Class
define('_DML_OPTION_HTTP', "Importer un fichier &agrave;; partir de votre ordinateur");
define('_DML_OPTION_XFER', "Transf&eacute;rer un fichier d'un autre serveur vers ce serveur");
define('_DML_OPTION_LINK', "Lier un fichier d'un autre serveur &agrave;; ce serveur");
define('_DML_SIZEEXCEEDS', "La taille d&eacute;passe le maximum autoris&eacute;.");
define('_DML_ONLYPARTIAL', "Un probl&egrave;me est survenu lors de l'import du fichier. Veuillez r&eacute;essayer.");
define('_DML_NOUPLOADED', "Aucun document n'a &eacute;t&eacute; import&eacute;.");
define('_DML_TRANSFERERROR', "Une erreur ets survenue lors du trannsfert");
define('_DML_DIRPROBLEM', "Le r&eacute;pertoire est endommag&eacute; ou est &agrave;; l'origine du probl&egrave;me. Le fichier n'a pu &ecirctre d&eacute;plac&eacute;..");
define('_DML_DIRPROBLEM2', "Probl&egrave;me sur le r&eacute;pertoire");
define('_DML_COULDNOTCONNECT', "Impossible de se connecter &agrave;; l'hôte.");
define('_DML_COULDNOTOPEN', "Impossible d'&eacute;crire dans le r&eacute;pertoire de destination. Veuillez v&eacute;rifier les droits d'acc&egrave;s.");
define('_DML_FILETYPE', "Type de fichier");
define('_DML_NOTPERMITED', "Interdit");
define('_DML_EMPTY', "Vide");

define('_DML_ALREADYEXISTS', "Existe d&eacute;j&agrave;;.");
define('_DML_PROTOCOL', "Protocole");
define('_DML_NOTSUPPORTED', "Non support&eacute;.");
define('_DML_NOFILENAME', "Aucun nom de fichier n'&eacute; &eacute;t&eacute; sp&eacute;cifi&eacute;.");
define('_DML_FILENAME', "Nom de fichier");
define('_DML_CONTAINBLANKS', "contient des espaces.");
define('_DML_ISNOTVALID', "n'est pas un nom de fichier valide");
define('_DML_SELECTIMAGE', "S&eacute;lectionner une image");
define('_DML_FAILEDTOCREATEDIR', "Impossible de cr&eacute;er le r&eacute;pertoire");
define('_DML_DIRNOTEXISTS', "Le r&eacute;pertoire n'existe pas. Impossible de supprimer les fichiers");
define('_DML_TEMPLATEEMPTY', "L'ID du mod&egrave;le est vide. Impossible de supprimer les fichiers ");
define('_DML_INTERRORMAMBOT', "Erreur interne : aucun mambot n'est pas d&eacute;fini");
define('_DML_INTERRORMABOT', _DML_INTERRORMAMBOT); // alias
define('_DML_NOTARGGIVEN', "arguments insuffisants");
define('_DML_ARG', "argument");
define('_DML_ISNOTARRAY', "n'est pas un tableau");

define('_DML_NEW', "nouveau !");
define('_DML_HOT', "populaire !");

define('_DML_BYTES', "Octets");
define('_DML_KB', "KB");
define('_DML_MB', "MB");
define('_DML_GB', "GB");
define('_DML_TB', "TB");


// -- Form Validation
define('_DML_ENTRY_ERRORS', "Message syst me DOCman : Veuillez corriger la/les erreurs suivantes :");
define('_DML_ENTRY_TITLE', "Renseigner le titre.");
define('_DML_ENTRY_NAME', "Renseigner le nom.");
define('_DML_ENTRY_DATE', "Renseigner la date.");
define('_DML_ENTRY_OWNER', "Renseigner le propri&eacute;taire.");
define('_DML_ENTRY_CAT', "Renseigner la cat&eacute;gorie.");
define('_DML_ENTRY_DOC', "Renseigner le le titre du document.");
define('_DML_ENTRY_MAINT', "Renseigner le gestionnaire.");

define('_DML_ENTRY_DOCLINK_LINK', "S&eacute;lectionnez un lien pour ces documents.");
define('_DML_ENTRY_DOCLINK', "Le document a un nom de fichier et un lien.");
define('_DML_ENTRY_DOCLINK_PROTOCOL', "Protocole inconnu pour le lien du document link.");
define('_DML_ENTRY_DOCLINK_NAME', "Le lien complet est requis pour le document");
define('_DML_ENTRY_DOCLINK_HOST', "L'URL compl&egrave;te est requise");
define('_DML_ENTRY_DOCLINK_INVALID', "Aucun fichier trouv&eacute;");
define('_DML_FILENAME_REQUIRED', "Le nom du fichier est requis");

// Missing  constants from J!1.0.x
define('_DML_FILTER', "Filtre");
define('_DML_UPDATE', "Mis &agrave;; jour");
define('_DML_SEARCH_ANYWORDS', "N'importe quel mot");
define('_DML_SEARCH_ALLWORDS', "Tous les mots");
define('_DML_SEARCH_PHRASE', "Phrase exacte");
define('_DML_SEARCH_NEWEST', "Nouveau en premier");
define('_DML_SEARCH_OLDEST', "Ancien en premier");
define('_DML_SEARCH_POPULAR', "Plus populaire");
define('_DML_SEARCH_ALPHABETICAL', "Alphab&eacute;tique");
define('_DML_SEARCH_CATEGORY', "Cat&eacute;gorie");
define('_DML_SEARCH_MESSAGE', "Le mot recherch&eacute; doit comprendre entre 3 et 20 lettres");
define('_DML_SEARCH_TITLE', "Chercher");
define('_DML_PROMPT_KEYWORD', "Mot-cl&eacute;");
define('_DML_SEARCH_MATCHES', "%d r&eacute;sultat(s)");
define('_DML_NOKEYWORD', "Aucun r&eacute;sultat");
define('_DML_IGNOREKEYWORD', "Un ou plusieurs mots ont &eacute;t&eacute; ignor&eacute;s dans la recherche");
define('_DML_CMN_ORDERING', "Tri");

// Added DOCman 1.4 RC3
define('_DML_HELP', "Help");

