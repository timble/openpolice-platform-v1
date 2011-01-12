<?php
/**
 * @version		$Id: english.frontend.php 953 2009-10-14 20:38:38Z mathias $
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

// -- General
define('_DML_NOLOG', "You must login to access the document section.");
define('_DML_NOLOG_UPLOAD', "You must login and be authorized to upload documents.");
define('_DML_NOLOG_DOWNLOAD', "You must login and be authorized to access this document.");
define('_DML_NOAPPROVED_DOWNLOAD', "The document must be approved before downloading.");
define('_DML_NOPUBLISHED_DOWNLOAD', "The document must be published before downloading.");
define('_DML_ISDOWN', "Sorry, this section is temporarily down for maintenance. Try again later.");
define('_DML_SECTION_TITLE', "Downloads");

// -- Files
define('_DML_DOCLINKTO', "Document linked to ");
define('_DML_DOCLINKON', "Link created on ");
define('_DML_ERROR_LINKING', "Error connecting to host.");
define('_DML_LINKTO', "Link to ");
define('_DML_DONE', "Done.");
define('_DML_FILE_UNAVAILABLE', "The file is not available on the server");

// -- Documents
define('_DML_TAB_BASIC', "Basic");
define('_DML_TAB_PERMISSIONS', "Permissions");
define('_DML_TAB_LICENSE', "License");
define('_DML_TAB_DETAILS', "Details");
define('_DML_TAB_PARAMS', "Parameters");
define('_DML_OP_CANCELED', "Operation Cancelled");
define('_DML_CREATED_BY', "Created by");
define('_DML_UPDATED_BY', "Last updated by");
define('_DML_DOCMOVED', "Document has been moved");
define('_DML_MOVETO', "Move to");
define('_DML_MOVETHEFILES', "Move the files");
define('_DML_SELECTFILE', "Select a file");
define('_DML_THANKSDOCMAN', "Thank you for your submission.");
define('_DML_NO_LICENSE', "No License");
define('_DML_DISPLAY_LIC', "Display Agreement");
define('_DML_LICENSE_TYPE', "License Type");
define('_DML_MANT_TOOLTIP', "This determines who can edit, or maintain, the document. "
     . "When a User, or member of a Group, is the " . _DML_MAINTAINER . " of a document it means that they can use the specific document management options: edit, update, move, check in/out and delete.");
define('_DML_ON', "on");
define('_DML_CURRENT', "Current");
define('_DML_YOU_MUST_UPLOAD', "You must upload a document for this section first.");
define('_DML_THE_MODULE', "The module");
define('_DML_IS_BEING', "is currently being edited by another administrator");
define('_DML_LINKED', "->LINKED DOCUMENT<-");
define('_DML_FILETITLE', "File Title");
define('_DML_OWNER_TOOLTIP', "This determines who can download and view the document. Choose: "
     . "*Everybody* if you want anyone to be able to access the document. "
     . "*All Registered Users* only allows Users that have an account at your site access to the document. "
     . "You can assign the document to a single registered User by selecting a name under " . _DML_USERS . "; "
     . "only that User will be granted access. "
     . "You can assign the document to a Group of Registered Users by selecting the Group name under " . _DML_GROUPS . "; "
     . "only the Group members will be granted access to the document.");
define('_DML_MAKE_SURE', "Make sure to start the URL<br />with 'http://'");
define('_DML_DOCURL', "URL of Document:");
define('_DML_DOCDELETED', "Document deleted.");
define('_DML_DOCURL_TOOLTIP', "When you have LINKED documents you must enter the web site address (URL) for the document here. Always include the protocol (http:// or ftp://) at the beginning.");
define('_DML_HOMEPAGE_TOOLTIP', "You may optionally enter a web site address (URL) for information that is related to this document. Always include http:// at the beginning of the URL or it will not work.");
define('_DML_LICENSE_TOOLTIP', "A document can have an Agreement/License that the viewers should accept to access it. You can define the License type here.");
define('_DML_DISPLAY_LICENSE', "Display Agreement/License when viewing");
define('_DML_DISPLAY_LIC_TOOLTIP', "Choose *Yes* if you want the License displayed to the User before access is granted.");
define('_DML_APPROVED_TOOLTIP', "A document should be approved to be visible and available on the repository. Select *Yes* here and don\'t forget to publish it too! Both options should be set so the document can be listed on the Front-end");
define('_DML_RESET_COUNTER', "Reset Counter");
define('_DML_PROBLEM_SAVING_DOCUMENT', "Problem saving document");

// -- Download
define('_DML_PROCEED', "Click here to proceed");
define('_DML_YOU_MUST', "You must accept the Agreement to view the document.");
define('_DML_NOTDOWN', "The document is being edited/updated by a User and is unavailable at this moment.");
define('_DML_ANTILEECH_ACTIVE', "You are trying to access from a non-authorized domain.");
define('_DML_DONT_AGREE', "I don't agree.");
define('_DML_AGREE', "I agree.");

// -- Upload
define('_DML_UPLOADED', "Uploaded");
define('_DML_SUBMIT', "Submit");
define('_DML_NEXT', "Next >>>");
define('_DML_BACK', "<<< Back");
define('_DML_LINK', "Link");
define('_DML_EDITDOC', "Edit this document");
define('_DML_UPLOADWIZARD', "Upload Wizard");
define('_DML_UPLOADMETHOD', "Choose the upload method");
define('_DML_ISUPLOADING', "Please wait while DOCman is uploading");
define('_DML_PLEASEWAIT', "Please wait");
define('_DML_DOCMANISLINKING', "DOCman is checking <br />the link");
define('_DML_DOCMANISTRANSF', "DOCman is transferring<br />the file");
define('_DML_TRANSFER', "Transfer");
define('_DML_REMOTEURL', "Remote URL");
define('_DML_LINKURLTT', "Enter the remote URL that you want to access. The URL must include a scheme (http:// or ftp://) and any other access information required. For example: http://joomlacode.org/gf/download/frsrelease/292/1001/docman_1.3RC2.zip.");
define('_DML_REMOTEURLTT'   , _DML_LINKURLTT . "<br />You may call the file anything you wish on this system by using the &quot;Local Name&quot; field.");
define('_DML_LOCALNAME', "Local Name");
define('_DML_LOCALNAMETT', "Enter the local name of the file as you wish it stored on this system."
     . "This is a required field as the URL does not give sufficient information for the document.");
define('_DML_ERROR_UPLOADING', "Error uploading");

// -- Search
define('_DML_SELECCAT', "Select Category");
define('_DML_ALLCATS', "All Categories");
define('_DML_SEARCH_WHERE', "Search where");
define('_DML_SEARCH_MODE', "Search by");
define('_DML_SEARCH', "Search");
define('_DML_SEARCH_REVRS', "Reverse");
define('_DML_SEARCH_REGEX', "Regular Expression");
define('_DML_NOT', "Not"); // Used for Inversion

// -- E-mail
define('_DML_EMAIL_GROUP', "Send E-mail to Group");
define('_DML_SUBJECT', "Subject");
define('_DML_EMAIL_LEADIN', "Leading Text");
define('_DML_MESSAGE', "Main Message");
define('_DML_SEND_EMAIL', "Send");

// -- Task buttons
// NOTE: these strings were originally _DML_TPL_DOC_... in the theme language
define('_DML_BUTTON_DOWNLOAD', "Download");
define('_DML_BUTTON_VIEW', "View");
define('_DML_BUTTON_DETAILS', "Details");
define('_DML_BUTTON_EDIT', "Edit");
define('_DML_BUTTON_MOVE', "Move");
define('_DML_BUTTON_DELETE', "Delete");
define('_DML_BUTTON_UPDATE', "Update");
define('_DML_BUTTON_CHECKOUT', "Checkout");
define('_DML_BUTTON_CHECKIN', "Checkin");
define('_DML_BUTTON_UNPUBLISH', "Unpublish");
define('_DML_BUTTON_PUBLISH', "Publish");
define('_DML_BUTTON_RESET', "Reset");
define('_DML_BUTTON_APPROVE', "Approve");

// -- Added v1.4.0 RC1
define('_DML_CHECKED_IN', "Checked in");