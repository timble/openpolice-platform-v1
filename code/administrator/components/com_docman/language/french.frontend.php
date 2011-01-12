<?php
/**
 * @version		$Id: french.frontend.php 11 2009-10-22 12:58:14Z mathias $
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

// -- General
define('_DML_NOLOG', "Vous devez vous logger pour accéder à cette section documentaire.");
define('_DML_NOLOG_UPLOAD', "Vous devez vous logger et avoir les droits suffisants pour importer les documents.");
define('_DML_NOLOG_DOWNLOAD', "Vous devez vous logger et avoir les droits suffisants pour accéder à ce document.");
define('_DML_NOAPPROVED_DOWNLOAD', "Le document doit être aprouvé avant téléchargement.");
define('_DML_NOPUBLISHED_DOWNLOAD', "Le document doit être publié avant téléchargement.");
define('_DML_ISDOWN', "Désolé, cette section est temprairement inaccessible pour raison de maintenance. Veuillez ré-essayer plus tard.");
define('_DML_SECTION_TITLE', "Téléchargements");

// -- Files
define('_DML_DOCLINKTO', "Document lié à");
define('_DML_DOCLINKON', "Lien créé le");
define('_DML_ERROR_LINKING', "Erreur lors de la connexion à l'hôte.");
define('_DML_LINKTO', "Lien à");
define('_DML_DONE', "Terminé.");
define('_DML_FILE_UNAVAILABLE', "Ce fichier n'est pas accessible sur le serveur");

// -- Documents
define('_DML_TAB_BASIC', "Basique");
define('_DML_TAB_PERMISSIONS', "Permissions");
define('_DML_TAB_LICENSE', "Licence");
define('_DML_TAB_DETAILS', "Propriétés");
define('_DML_TAB_PARAMS', "Paramètres");
define('_DML_OP_CANCELED', "Opération annulée");
define('_DML_CREATED_BY', "Crée par");
define('_DML_UPDATED_BY', "Dernière modification par");
define('_DML_DOCMOVED', "Le document a été déplacé");
define('_DML_MOVETO', "Déplacer vers");
define('_DML_MOVETHEFILES', "Déplacer les fichiers");
define('_DML_SELECTFILE', "Sélectionner un fichier");
define('_DML_THANKSDOCMAN', "Merci pour cette contribution.");
define('_DML_NO_LICENSE', "Licence manquante");
define('_DML_DISPLAY_LIC', "Afficher le texte de la Licence");
define('_DML_LICENSE_TYPE', "Type de Licence");
define('_DML_MANT_TOOLTIP', "Cette fonction permet de déterminer qui peut modifier, ou mettre à jour le document."
     . "Quand un utilisateur membre d'un groupe correspond à " . _DML_MAINTAINER . " d'un document, cela signifie qu'il peut utiliser les principales options de la gestion documentaire. Ces options sont : modifier, mettre à jour, déplacer, extraire/importer et supprimer.");
define('_DML_ON', "de");
define('_DML_CURRENT', "Actuel");
define('_DML_YOU_MUST_UPLOAD', "Vous devez d'abord importer un document dans cette section.");
define('_DML_THE_MODULE', "Le module");
define('_DML_IS_BEING', "est actuellement modifié par un autre administrateur");
define('_DML_LINKED', "->DOCUMENT LIE<-");
define('_DML_FILETITLE', "Titre du fichier");
define('_DML_OWNER_TOOLTIP', "Cette fonction va permettre de déterminer qui est autorisé à télécharger et visualiser le document. Sélectionner : "
     . "*Everybody* (Tout le monde) si vous souhaitez que tout le monde ait accès au document. "
     . "*All Registered Users* (Tous les membres enregistrés) permet aux seuls utilisateurs enregistrés et donc titulaire d'un compte d'accéder au document. "
     . "Vous pouvez assigner les droits sur un document à un seul membre enregistré en sélectionnant un nom sous " . _DML_USERS . "; "
     . "Seul ce membre aura accès au document en question. "
     . "Vous pouvez assigner les droits sur un document à un groupe d'utilisateurs enregistrés en sélectionnant un groupe sous  " . _DML_GROUPS . "; "
     . "Seul ce groupe d'utilisateurs aura accès au document en question...");
define('_DML_MAKE_SURE', "Veuillez saisir l'URL<br />sous la forme http://'");
define('_DML_DOCURL', "URL du document:");
define('_DML_DOCDELETED', "Document supprimé.");
define('_DML_DOCURL_TOOLTIP', "Lorsque qu'il y a des documents liés, vous devez saisir l'URL (adresse) du site en entier pour le document. Préciser systématiquement le protocole (http:// or ftp://) au début de l'adresse.");
define('_DML_HOMEPAGE_TOOLTIP', "You may optionally enter a web site address (URL) for information that is related to this document. Always include http:// at the beginning of the URL or it will not work.");
define('_DML_LICENSE_TOOLTIP', "Un document peut être assorti d'une Licence d'Utilisation que les utilisateurs devront approuver pour accéder au document. Ici vous pourrez définir le type de Licence.");
define('_DML_DISPLAY_LICENSE', "Afficher le type de Licence d'utilisation lors de l'utilisation");
define('_DML_DISPLAY_LIC_TOOLTIP', "Choose *Yes* if you want the License displayed to the User before access is granted.");
define('_DML_APPROVED_TOOLTIP', " Un document doit être approuvé pour être visible et disponible dans la base documentaire. Sélectionner *Oui* le cas échéant et n'oubliez pas de le publier ! Les deux options devront être sélectionnées pour être visualisées à partir du frontal utilisateur");
define('_DML_RESET_COUNTER', "Remettre à Zéro le compteur");
define('_DML_PROBLEM_SAVING_DOCUMENT', "Erreur survenue lors de la sauvegarde du document");

// -- Téléchargement
define('_DML_PROCEED', "Cliquer ici pour commencer");
define('_DML_YOU_MUST', "Vous devez approuver le texte de la Licence pour voir le document.");
define('_DML_NOTDOWN', "Ce document est indisponible actuellement car il est en cours de modification/mise à jour par un utilisateur.");
define('_DML_ANTILEECH_ACTIVE', "Vous tentez d'accéder à un domaine non autorisé.");
define('_DML_DONT_AGREE', "Je ne suis pas d'accord.");
define('_DML_AGREE', "Je suis d'accord.");

// -- Import
define('_DML_UPLOADED', "Importé");
define('_DML_SUBMIT', "Valider");
define('_DML_NEXT', "Suivant >>>");
define('_DML_BACK', "<<< Précédent");
define('_DML_LINK', "Lien");
define('_DML_EDITDOC', "Modifier ce document");
define('_DML_UPLOADWIZARD', "Assistant import");
define('_DML_UPLOADMETHOD', "Sélectionner la méthode d'import");
define('_DML_ISUPLOADING', "Veuillez patienter pendant que DOCman traite l'import");
define('_DML_PLEASEWAIT', "Veuillez patienter");
define('_DML_DOCMANISLINKING', "DOCman vérifie <br />le lien");
define('_DML_DOCMANISTRANSF', "DOCman est en train de transférer<br />le fichier");
define('_DML_TRANSFER', "Transférer");
define('_DML_REMOTEURL', "URL distante");
define('_DML_LINKURLTT', "Saisir l'URL du fichier auquel vous souhaitez accéder. L'URL doit inclure le chemin complet du fichier précédé de (http:// ou ftp://). Exemple: http://joomlacode.org/gf/download/frsrelease/292/1001/docman_1.3RC2.zip.");
define('_DML_REMOTEURLTT', _DML_LINKURLTT . "<br />Vous pouvez nommer le fichier comme vous le souhaitez à condition que vous utilisiez la syntaxe : 'Local Nom' champ.");
define('_DML_LOCALNAME', "Nom Local");
define('_DML_LOCALNAMETT', "Saisir le nom du fichier local tel qu'il doit être enregistré dans l'application."
     . "Ce champ est obligatoire car l'URL ne donne pas suffisamment d'information sur l'emplacement du fichier.");
define('_DML_ERROR_UPLOADING', "Erreur lors de l'import");

// -- Rechercher
define('_DML_SELECCAT', "Catégories");
define('_DML_ALLCATS', "Toutes les catégories");
define('_DML_SEARCH_WHERE', "Rechercher dans");
define('_DML_SEARCH_MODE', "Rechercher par");
define('_DML_SEARCH', "Rechercher");
define('_DML_SEARCH_REVRS', "Inverse");
define('_DML_SEARCH_REGEX', "Expression régulière");
define('_DML_NOT', "Non"); // Used for Inversion

// -- E-mail
define('_DML_EMAIL_GROUP', "Envoyer un E-mail à un groupe");
define('_DML_SUBJECT', "Objet");
define('_DML_EMAIL_LEADIN', "Titre");
define('_DML_MESSAGE', "Corps du Message");
define('_DML_SEND_EMAIL', "Envoyer");

//T�ches du document
define('_DML_BUTTON_DOWNLOAD', "Télécharger");
define('_DML_BUTTON_VIEW', "Voir");
define('_DML_BUTTON_DETAILS', "Propriétes");
define('_DML_BUTTON_EDIT', "Modifier");
define('_DML_BUTTON_MOVE', "Déplacer");
define('_DML_BUTTON_DELETE', "Supprimer");
define('_DML_BUTTON_UPDATE', "Mettre à jour");
define('_DML_BUTTON_CHECKOUT', "Extraire");
define('_DML_BUTTON_CHECKIN', "Importer");
define('_DML_BUTTON_UNPUBLISH', "Ne pas publier");
define('_DML_BUTTON_PUBLISH', "Publier");
define('_DML_BUTTON_RESET', "Annuler");
define('_DML_BUTTON_APPROVE', "Approuver");

// -- Added v1.4.0 RC1
define('_DML_CHECKED_IN', "Checked in"); //  TRANSLATE