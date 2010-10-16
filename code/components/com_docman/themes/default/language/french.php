<?php
/**
 * @version		$Id: french.php 11 2009-10-22 12:58:14Z mathias $
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

define('_DML_TPL_DATEFORMAT_LONG', '%d/%m/%Y %H:%M');
define('_DML_TPL_DATEFORMAT_SHORT', '%d/%m/%Y');

// Général
define('_DML_TPL_FILES', "Fichiers");
define('_DML_TPL_CATS', "Catégories");
define('_DML_TPL_DOCS', "Documents");
define('_DML_TPL_CAT_VIEW', "Accueil");
define('_DML_TPL_MUST_LOGIN', "Vous devez vous logger avant de pouvoir soumettre de nouveaux documents");
define('_DML_TPL_SUBMIT', "Soumettre un fichier");
define('_DML_TPL_SEARCH_DOC', "Rechercher");
define('_DML_TPL_LICENSE_DOC', "Document license");

// Titres
define('_DML_TPL_TITLE_BROWSE', "Téléchargements");
define('_DML_TPL_TITLE_EDIT', "Modifier le document");
define('_DML_TPL_TITLE_SEARCH', "Rechercher");
define('_DML_TPL_TITLE_DETAILS', "Propriétés du document");
define('_DML_TPL_TITLE_MOVE', "Déplacer un document");
define('_DML_TPL_TITLE_UPDATE', "Mettre à jour un document");
define('_DML_TPL_TITLE_UPLOAD', "Soumettre un document");

// Documents
define('_DML_TPL_HITS', "Clics");
define('_DML_TPL_DATEADDED', "Date de mise en ligne");
define('_DML_TPL_HOMEPAGE', "Accueil");
define('_DML_TPL_NO_DOCS', "Il n'y a pas de documents dans cette catégorie");

//Rechercher Documents
define('_DML_TPL_ORDER_BY', "Trier par");
define('_DML_TPL_ORDER_NAME', "Titre");
define('_DML_TPL_ORDER_DATE', "Date");
define('_DML_TPL_ORDER_HITS', "Clics");
define('_DML_TPL_ORDER_ASCENT', "Croissant");
define('_DML_TPL_ORDER_DESCENT', "Décroissant");
define('_DML_TPL_NO_ITEMS_FOUND', "Aucun élément trouvé");

//Modifier Document

//D�placement Document
define('_DML_TPL_MOVE_DOC', "Déplacer le document dans une autre catégorie");

//Document update
define('_DML_TPL_UPDATE_DOC', "Mettre à jour le document");
define('_DML_TPL_UPDATE_OVERWRITE', "Cette fonction écrasera SYSTEMATIQUEMENT le fichier si le titre est identique.");

//Import Document
define('_DML_TPL_UPLOAD_STEP', "Etape");
define('_DML_TPL_UPLOAD_OF', "sur");
define('_DML_TPL_UPLOAD_NEXT', "Suivant");
define('_DML_TPL_UPLOAD_DOC', "Assistant Import");
define('_DML_TPL_TRANSFER', "Transférer un fichier à partir d'un serveur Web");
define('_DML_TPL_LINK', "Lier un fichier provennat d'un autre serveur");
define('_DML_TPL_UPLOAD', "Importer un fichier à partir de votre ordinateur");

//T�ches du document
define('_DML_TPL_DOC_DOWNLOAD', "Télécharger");
define('_DML_TPL_DOC_VIEW', "Voir");
define('_DML_TPL_DOC_DETAILS', "Propriétés");
define('_DML_TPL_DOC_EDIT', "Modifier");
define('_DML_TPL_DOC_MOVE', "Déplacer");
define('_DML_TPL_DOC_DELETE', "Supprimer");
define('_DML_TPL_DOC_UPDATE', "Mettre à jour");
define('_DML_TPL_DOC_CHECKOUT', "Extraire");
define('_DML_TPL_DOC_CHECKIN', "Importer");
define('_DML_TPL_DOC_UNPUBLISH', "Ne pas publier");
define('_DML_TPL_DOC_PUBLISH', "Publier");
define('_DML_TPL_DOC_RESET', "Annuler");
define('_DML_TPL_DOC_APPROVE', "Approuver");

define('_DML_TPL_BACK', "Retour");

//Propri�t�s du document
define('_DML_TPL_DETAILSFOR', "Propriétés de");
define('_DML_TPL_NAME', "Titre");
define('_DML_TPL_DESC', "Description");
define('_DML_TPL_FNAME', "Nom du fichier");
define('_DML_TPL_FSIZE', "Taille du fichier");
define('_DML_TPL_FTYPE', "Type de fichier");
define('_DML_TPL_SUBBY', "Créateur");
define('_DML_TPL_SUBDT', "Créé le :");
define('_DML_TPL_OWNER', "Lecteurs");
define('_DML_TPL_MAINT', "Géré par");
define('_DML_TPL_DOWNLOADS', "Téléchargements");
define('_DML_TPL_LASTUP', "Dernière mise à jour le");
define('_DML_TPL_LASTBY', "Dernière modification par");
define('_DML_TPL_HOME', "Accueil" );
define('_DML_TPL_MIME', "Type MIME");
define('_DML_TPL_CHECKED_OUT', "Extrait");
define('_DML_TPL_CHECKED_BY', "Extrait par");
define('_DML_TPL_MD5_CHECKSUM', "MD5 Checksum");
define('_DML_TPL_CRC_CHECKSUM', "CRC Checksum");
