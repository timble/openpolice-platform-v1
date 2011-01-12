<?php
/**
 * @version		$Id: english.backend.php 1160 2010-02-01 17:25:23Z mathias $
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

// -- Toolbar
define('_DML_TOOLBAR_SAVE', "Save");
define('_DML_TOOLBAR_CANCEL', "Cancel");
define('_DML_TOOLBAR_NEW', "New");
define('_DML_TOOLBAR_NEW_DOC', "New Doc");
define('_DML_TOOLBAR_HOME', "Home");
define('_DML_TOOLBAR_UPLOAD', "Upload");
define('_DML_TOOLBAR_MOVE', "Move");
define('_DML_TOOLBAR_COPY', "Copy");
define('_DML_TOOLBAR_SEND', "Send");
define('_DML_TOOLBAR_BACK', "Back");
define('_DML_TOOLBAR_PUBLISH', "Publish");
define('_DML_TOOLBAR_UNPUBLISH', "Unpublish");
define('_DML_TOOLBAR_DEFAULT', "Default");
define('_DML_TOOLBAR_DELETE', "Delete");
define('_DML_TOOLBAR_CLEAR', "Clear");
define('_DML_TOOLBAR_EDIT', "Edit");
define('_DML_TOOLBAR_EDIT_CSS', "Edit CSS");
define('_DML_TOOLBAR_APPLY', "Apply");


// -- Files
define('_DML_ORPHANS', "Orphans");
define('_DML_ORPHANS_LINKED', "File(s) not deleted. Cannot delete file(s) linked to documents.");
define('_DML_ORPHANS_PROBLEM', "File(s) not deleted. There is a problem with the file permissions.");
define('_DML_ORPHANS_DELETED', "File(s) deleted.");
define('_DML_LINKS', "Links");
define('_DML_NEXT', "Next");
define('_DML_SUCCESS', "Success!");
define('_DML_UPLOADMORE', "Upload more");
define('_DML_UPLOADWIZARD', "Upload wizard");
define('_DML_UPLOADMETHOD', "Choose the upload method");
define('_DML_ISUPLOADING', "DOCman is Uploading");
define('_DML_PLEASEWAIT', "Please Wait");
define('_DML_UPLOADDISK', "Upload wizard - Upload a file from your hard disk");
define('_DML_FILETOUPLOAD', "Choose the file to upload");
define('_DML_BATCHMODE', "Batch Mode");
define('_DML_BATCHMODETT', "Batch mode uploads a zipped package containing multiple files. The package will be unzipped on the fly after uploading. You should not include zipped directories and/or subdirectories in the package. Have in mind that the process could overwrite DOCman files present in the DOCman documents directory that have the same filename; there is no overwrite protection using zipped files. This is experimental and you should use it with caution.");
define('_DML_DOCMANISTRANSF', "DOCman is transferring<br />the file");
define('_DML_TRANSFERFROMWEB', _DML_UPLOADWIZARD . " - " . "transfer a file from a web server");
define('_DML_REMOTEURL', "Remote URL");
define('_DML_LINKURLTT', "Enter the remote URL that you want to access. The URL must include a scheme (http:// or ftp://) and any other access information required. For example: http://www.example.com/file.zip.");
define('_DML_REMOTEURLTT', _DML_LINKURLTT . "<br />You may call the file anything you wish on this system by using the &quot;Local Name&quot; field.");
define('_DML_LOCALNAME', "Local Name");
define('_DML_LOCALNAMETT', "Enter the local name of the file as you wish it stored on this system."
     . "This is a required field as the URL does not give sufficient information for the document.");
define('_DML_DOCUPDATED', "Document has been updated.");
define('_DML_FILEUPLOADED', "File has been uploaded.");
define('_DML_MAKENEWENTRY', "Make a new document entry using this file.");
define('_DML_DISPLAYFILES', "Display Files.");
define('_DML_ALLFILES', "All Files");
define('_DML_DOCFILES', "Document Files");
define('_DML_CREATEALINK', "Create a Linked Document");
define('_DML_SELECTMETHODFIRST', "Please Select a Document Transfer Method");
define('_DML_ERROR_UPLOADING', "Error Uploading.");
define('_DML_ZLIB_ERROR', "The operation could not proceed because the zlib library is not present in PHP.");
define('_DML_UNZIP_ERROR', "Could not unzip the files.");
define('_DML_SUBMIT', "Submit");
define('_DML_NEW_FILE', "New File");
define('_DML_MAKE_SELECTION', "Please make a selection from the list.");

// -- Documents
define('_DML_MOVECAT', "Move Category");
define('_DML_MOVETOCAT', "Move to Category");
define('_DML_DOCSMOVED', "Documents being moved");
define('_DML_COPYCAT', "Copy Category");
define('_DML_COPYTOCAT', "Copy to Category");
define('_DML_COPY_OF', "Copy of"); // Copy of [document name]
define('_DML_DOCSCOPIED', "Documents being copied");
define('_DML_DOCS_NOT_APPROVED', "Documents not approved");
define('_DML_DOCS_NOT_PUBLISHED', "Documents not published");
define('_DML_NO_PENDING_DOCS', "No pending documents.");
define('_DML_FILE_MISSING', "***File Missing***");
define('_DML_YOU_MUST_UPLOAD', "You must upload a document for this section first.");
define('_DML_THE_MODULE', "The Module");
define('_DML_IS_BEING', "is currently being edited by another administrator");
define('_DML_NO_LICENSE', "No License");
define('_DML_LINKED', "->LINKED DOCUMENT<-");
define('_DML_CURRENT', "Current");
define('_DML_LICENSE_TYPE', "License Type");
define('_DML_FILETITLE', "File Title");
define('_DML_OWNER_TOOLTIP', "This determines who can download and view the document. Choose: "
     . "*Everybody* if you want anyone to be able to access the document. "
     . "*All Registered Users* only allows Users that have an account at your site access to the document. "
     . "You can assign the document to a single registered User by selecting a name under " . _DML_USERS . "; "
     . "only that User will be granted access. "
     . "You can assign the document to a Group of Registered Users by selecting the Group name under " . _DML_GROUPS . "; "
     . "only the Group members will be granted access to the document.");
define('_MANT_TOOLTIP', "This determines who can edit, or maintain, the document. "
     . "When a User, or member of a Group, is the " . _DML_MAINTAINER . " of a document it means that they can use the specific document management options: edit, update, move, check in/out and delete.");
define('_DML_MAKE_SURE', "Make sure to start the URL<br />with 'http://'");
define('_DML_DOCURL', "URL of Document:");
define('_DML_DOCURL_TOOLTIP', "When you have LINKED documents you must enter the web site address (URL) for the document here. Always include the protocol (http:// or ftp://) at the beginning.");
define('_DML_HOMEPAGE_TOOLTIP', "You may optionally enter a web site address (URL) for information that is related to this document. Always include http:// at the beginning of the URL or it will not work.");
define('_DML_LICENSE_TOOLTIP', "A document can have an Agreement/License that the viewers should accept to access it. Here you can define the License type.");
define('_DML_DISPLAY_LICENSE', "Display Agreement/License when viewing");
define('_DML_DISPLAY_LIC_TOOLTIP', "Choose`*Yes* if you want the License displayed to the User before access is granted.");
define('_DML_APPROVED_TOOLTIP', "A document should be approved to be visible and available on the repository. Select *Yes* here and don\'t forget to publish it too! Both options should be set so the document can be listed on the Front-end");
define('_DML_PLEASE_SEL_CAT', "Please define at least one Category first");
define('_DML_MANT_TOOLTIP', "This determines who can edit, or maintain, the document. "
     . "When a User, or member of a Group, is the " . _DML_MAINTAINER . " of a document it means that they can use the specific document management options: edit, update, move, check in/out and delete.");
define('_DML_DISPLAY_LIC', "Display Agreement");

define('_DML_TAB_PERMISSIONS', "Permissions");
define('_DML_TAB_LICENSE', "License");
define('_DML_TAB_DETAILS', "Details");
define('_DML_TAB_PARAMS', "Parameters");

define('_DML_TITLE_DOCINFORMATION', "Document Information");
define('_DML_TITLE_DOCPERMISSIONS', "Document Permissions");
define('_DML_TITLE_DOCLICENSES', "Document Licenses");
define('_DML_TITLE_DOCDETAILS', "Document Details");
define('_DML_TITLE_DOCPARAMETERS', "Document Parameters");

define('_DML_CREATED_BY', "Created by");
define('_DML_UPDATED_BY', "Last updated by");
define('_DML_SELECT_ITEM_DEL', "Select an item to delete");
define('_DML_SELECT_ITEM_MOVE', "Select an item to move");
define('_DML_SELECT_ITEM_COPY', "Select an item to copy");
define('_STATUS_YOU', "This document is checked-out by you.");
define('_STATUS_NOT_OUT', "This document is not checked-out.");
define('_DML_NEW_DOCUMENT', "New Document");
define('_DML_DOCUMENTS_MOVED_TO', "Documents moved to"); // [Number of] Documents moved to [location]
define('_DML_DOCUMENTS_COPIED_TO', "Documents copied to"); // [Number of] Documents moved to [location]


// -- Categories
define('_DML_CATDETAILS', "Category Details");
define('_DML_CATTITLE', "Category Title");
define('_DML_CATNAME', "Category Name");
define('_DML_LONGNAME', "A long name to be displayed in headings");
define('_DML_PARENTITEM', "Parent Item");
define('_DML_IMAGE', "Image");
define('_DML_PREVIEW', "Preview");
define('_DML_IMAGEPOS', "Image Position");
define('_DML_ORDERING', "Ordering");
define('_DML_ACCESSLEVEL', "Access Level");
define('_DML_CREATEMENUITEM', "This will create a new Menu Item in the Menu you select");
define('_DML_SELECTMENU', "Select a Menu");
define('_DML_SELECTMENUTYPE', "Select Menu Type");
define('_DML_MENUITEMNAME', "Menu Item Name");
define('_DML_SELECTCATTO', "Select the Category to");
define('_DML_SELECTCATTODELETE', "Select the Category to delete");
define('_DML_REORDER', "Order");
define('_DML_ACCESS', "Access");
define('_DML_CAT_MUST_SELECT_NAME', "The Category must have a name");
define('_DML_CATS_CANT_BE_REMOVED', "cannot be removed. There are associated records and/or sub-Categories");

// -- Groups
define('_DML_TITLE_GROUPS', "Groups");
define('_DML_CANNOT_DEL_GROUP', "Cannot delete a Group at this moment because a document is owned by it.");
define('_DML_USERS_AVAILABLE', "Users available");
define('_DML_MEMBERS_IN_GROUP', "Members in this Group");
define('_DML_ADD_GROUP_TIP', "Double click over a name or select it and use the arrow to add/delete a User member. "
     . "To select more than one member at a time, " . _DML_MULTIPLE_SELECTS);
define('_DML_ADDING_USERS', "Adding User members to Groups");
define('_DML_FILL_FORM', "Please fill in the form correctly");
define('_DML_ONLY_ADMIN_EMAIL', "Only a Super Administrator can send mass e-mail!");
define('_DML_NO_TARGET_EMAIL', "There are no Users with valid e-mail addresses in Group");
define('_DML_THIS_IS', "This is an e-mail message from");
define('_DML_SENT_BY', "sent by DOCman to the members of the documents Group");
define('_DML_EMAIL_SENT_TO', "E-mail sent to");
define('_DML_MEMBERS', "Members");
define('_DML_EMAIL', "E-mail");
define('_DML_USER_BLOCKED', "blocked");

// -- Licenses
define('_DML_LICENSE_TEXT', "License Text");
define('_DML_CANNOT_DEL_LICENSE', "Cannot delete the License because a document is using it.");


// -- Config
define('_DML_FRONTEND', "Front-end");
define('_DML_PERMISSIONS', "Permissions");
define('_DML_RESETDEFAULT', "Reset default");
define('_DML_ASCENDENT', "Ascending");
define('_DML_DESCENDENT', "Descending");

define('_DML_CONFIGURATION', "DOCman Configuration");
define('_DML_CONFIG_UPDATED', "The configuration details have been updated.");
define('_DML_CONFIG_WARNING', "WARNING: Configuration updated but Upload-Max Filesize is larger than PHP maximum: ");
define('_DML_CONFIG_ERROR', "An Error Has Occurred: Unable to open config file to write!");
define('_DML_CONFIG_ERROR_UPLOAD', "ERROR: The Upload-Max Filesize cannot be negative.");

define('_DML_CFG_DOCMANTT', "DOCman tooltip...");
define('_DML_CFG_ALLOWBLANKS', "Allow blanks");
define('_DML_CFG_REJECT', "Reject");
define('_DML_CFG_CONVERTUNDER', "Convert to underscores");
define('_DML_CFG_CONVERTDASH', "Convert to dash");
define('_DML_CFG_REMOVEBLANKS', "Remove Blanks");
define('_DML_CFG_PATHFORSTORING', "Path for storing files");
define('_DML_CFG_PATHTT', "Here you should define the local directory where all the files will be stored. This should be an absolute path. You can accept the default value or, if you prefer a different document directory, enter the full directory path here.<br /><br />"
     . "For example, on a *NIX system this could be something like /var/usr/www/dmdocuments<br /><br />"
     . "If you are using a windows based server, you can use, for example, c:/inetpub/www/dmdocuments");
define('_DML_CFG_SECTIONISDOWN', "Section is down?");
define('_DML_CFG_SECTIONTT', "If you want to stop regular Users from having access to the documents repository, set this option to *Yes*. <br />"
     . "This is useful for testing or when upgrading the repository.<br /><br />"
     . "Administrators and special Users will always have access even when the option is set to *No*. <br />"
    );
define('_DML_CFG_NUMBEROFDOCS', "Number of documents per page");
define('_DML_CFG_NUMBERTT', "Number of documents to display in one page. If the total number of documents is greater than this number, a pagination bar is displayed for easy navigation.");

define('_DML_CFG_GUEST', "Guests");
define('_DML_CFG_GUEST_NO', "No Access");
define('_DML_CFG_GUEST_X', "Browse only");
define('_DML_CFG_GUEST_RX', "Browse, Download, and View");
define('_DML_CFG_GUEST_TT', "This decides what guests (non-Registered Users) can do: <br />*"
     . _DML_CFG_GUEST_NO . "* No documents are not visible<br />*"
     . _DML_CFG_GUEST_X . "* Allows them to see documents exist but not to access them. <br />*"
     . _DML_CFG_GUEST_RX . "* Allows them to see and access document."
     . "<br /><br />This permission is in addition to an individual document\'s access permission."
     . "</span>");

define('_DML_CFG_AUTHOR_NONE', "No Access");
define('_DML_CFG_AUTHOR_READ', "Download Only");
define('_DML_CFG_AUTHOR_BOTH', "Download and Edit");

define('_DML_CFG_ICONSIZE', "Icon size");
define('_DML_CFG_DAYSFORNEW', "Days for new");
define('_DML_CFG_DAYSFORNEWTT', "Number of days that a file is still considered new. Will display the label *" . _DML_NEW . "* next to the document\'s name when a list of documents is displayed. If the value is set to zero, no label will be added.");
define('_DML_CFG_HOT', "Downloads to be hot");
define('_DML_CFG_HOTTT', "Number of accesses before a document is considered popular. Will display the label *" . _DML_HOT . "* near the document\'s name when the total number of accesses reaches this value. If the value is set to zero, no label will be added.");
define('_DML_CFG_DISPLAYLICENSES', "Display Licenses?");

define('_DML_CFG_VIEW', "View");
define('_DML_CFG_VIEWTT', "This lets you set the default User/Group that can download and view documents. This may be overridden at a document level.");
define('_DML_CFG_MAINTAIN', "Maintain");
define('_DML_CFG_MAINTAINTT', "This lets you set the default User/Group that will maintain the document. This may be overridden at a document level.");
define('_DML_CFG_CREATORS_PERM', "Creators can");
define('_DML_CFG_CREATORSPERMTT', "This lets you set, globally, what a document\'s Creator can do.<br /><br />"
     . "This is in addition to the permissions granted by the Viewer or Maintainer fields in each document.");
define('_DML_CFG_WHOCANAREADER', "Download");
define('_DML_CFG_WHOCANAREADERTT', "This lets you decide if Creator/Maintainers can change who can view a document.<br /><br />"
     . "N.B.: Administrators can always assign viewing permission.");
define('_DML_CFG_WHOCANAEDITOR', "Edit");
define('_DML_CFG_WHOCANAEDITORTT', "This lets you decide if Creator/Maintainers can change who the Maintainers are.<br /><br />"
     . "N.B.: Administrators can always select an Maintainer.");

define('_DML_CFG_EMAILGROUP', "E-mail Group Users?");
define('_DML_CFG_EMAILGROUPTT', "If *Yes* and first option is *Yes*, will be displayed a link in each document owned by a Group to allow a User to send an e-mail to all the other members of that Group for discussing.");

define('_DML_CFG_UPLOAD', "Upload");
define('_DML_CFG_UPLOADTT', "This lets you set the User/Group that can upload documents. This controls all upload methods: http, link and transfer");
define('_DML_CFG_APPROVE', "Approve");
define('_DML_CFG_APPROVETT', "This lets you set the User/Group that can approve documents.<br />Documents must be approved and published before being available.");
define('_DML_CFG_PUBLISH', "Publish");
define('_DML_CFG_PUBLISHTT', "This lets you set the User/Group that can publish documents.<br />Documents must be approved and published before being available.");
define('_DML_CFG_USER_UPLOAD', "Select Who Can Upload");
define('_DML_CFG_USER_APPROVE', "Select Who Can Approve");
define('_DML_CFG_USER_PUBLISH', "Select Who Can Publish");

define('_DML_CFG_EXTALLOWED', "Extensions allowed");
define('_DML_CFG_EXTALLOWEDTT', "File type extensions allowed, separated by |. Back-end Users can upload any file type.");
define('_DML_CFG_MAXFILESIZE', "Max. filesize allowed when uploading");
define('_DML_CFG_MAXFILESIZETT', "Maximum allowable filesize for Front-end uploads. You may use K/M/G as shortcuts for the entry.<br />This limit does not apply to Back-end (admin) uploads. <br /><hr />The maximum, determined by the upload_max_filesize and post_max_size php.ini settings, is currently at: ");
define('_DML_CFG_USERCANUPLOAD', "User can upload all file types?");
define('_DML_CFG_USERCANUPLOADTT', "If *Yes* and previous *User upload* is *Yes*, Registered Users can upload all files types, ignoring previous restriction.");
define('_DML_CFG_OVERWRITEFILES', "Overwrite files?");
define('_DML_CFG_OVERWRITEFILESTT', "If *Yes*, files will be overwritten on upload when the filename is the same.");
define('_DML_CFG_LOWERCASE', "Lowercase names?");
define('_DML_CFG_LOWERCASETT', "If *Yes*, uploaded filenames are converted to lowercase, e.g.&nbsp;YourFile.TXT becomes yourfile.txt.<br />If *no*, filenames will be saved with upper and lower case characters.");
define('_DML_CFG_FILENAMEBLANKS', "Filenames with blanks");
define('_DML_CFG_FILENAMEBLANKSTT', "Handling filenames that contain blanks:<br />"
     . "*Allow blanks* will save them with blanks.<br />"
     . "*Reject* will not allow the file to be uploaded.<br /><br />"
     . "You may also convert blanks to underscores (_), dashes (-) or to remove blanks from the filename.");
define('_DML_CFG_REJECTFILENAMES', "Reject filenames");
define('_DML_CFG_REJECTFILENAMESTT', "Enter a list of filenames that are not allowed to be uploaded, separated by a vertical bar (|). These filenames have special meanings to the system. \'.htaccess\' is rejected by default.<br />You may also use regular expressions between the | symbol to stop filenames that contain troublesome characters, for example: (* $ ?)");
define('_DML_CFG_UPMETHODS', "Upload methods?");
define('_DML_CFG_UPMETHODSTT', "Select all of the methods the User can use. Administrators always have access to all methods. For multiple methods, " . _DML_MULTIPLE_SELECTS);

define('_DML_CFG_ANTILEECH', "Anti-leech system?");
define('_DML_CFG_ANTILEECHTT', "The anti-leech system prevents unauthorized linking to your documents. "
     . "When set to *Yes* every request is checked to see if the download/view request "
     . "(the HTTP referer) originated from a system on the \'Allowed Hosts\' list. If it didn\'t, access will be denied. "
     . "This guards against other systems using your repository for their benefit.<br /><br />"
     . "N.B. DOCman supports direct linking between systems. "
     . "If you use links, make sure the source system includes this host in it\'s \'Allowed Hosts\' list."
    );
define('_DML_CFG_ALLOWEDHOSTS', "Allowed hosts");
define('_DML_CFG_ALLOWEDHOSTSTT', "A list of hosts that can request files when the anti-leech system in activated. If you want multiple hosts to be able to refer to these files, enter their names separated by a vertical bar (|).<br />The default value is usually safe.");

define('_DML_CFG_LOG', "Log views?");
define('_DML_CFG_LOGTT', "This logs the remote ip, date and time and filename of document viewed. "
     . "A lot of information may be inserted in the database with this option enabled.<hr />"
     . "Plugins are available for additional logging capability.");

define('_DML_CFG_UPDATESERVER', "Update server");
define('_DML_CFG_UPDATESERVERTT', "DOCman can update itself from the web and also install new DOCman related Modules, Plugins, and Bots. It even can do database changes on the fly while upgrading! Here, you should enter the URL of the DOCman update web server. If the server has not changed (we hope not!) leave this with the default value.");
define('_DML_CFG_DEFAULTLISTING', "Default listing order");
define('_DML_CFG_TRIMWHITESPACE', "Trim Whitespace");
define('_DML_CFG_TRIMWHITESPACETT', "Trim leading whitespace and blank lines from theme output, cleaning up code and saving bandwidth");

define('_DML_CFG_ERR_DOCPATH', 'Tab [' . _DML_GENERAL . '] \'' . _DML_CFG_PATHFORSTORING . '\' must be provided.');
define('_DML_CFG_ERR_PERPAGE', 'Tab [' . _DML_FRONTEND . '] \'' . _DML_CFG_NUMBEROFDOCS . '\' must be numeric and greater than zero');
define('_DML_CFG_ERR_NEW', 'Tab [' . _DML_FRONTEND . '] \'' . _DML_CFG_DAYSFORNEW . '\' must be numeric and zero or greater');
define('_DML_CFG_ERR_HOT', 'Tab [' . _DML_FRONTEND . '] \'' . _DML_CFG_HOT . '\' must be numeric and zero or greater');
define('_DML_CFG_ERR_UPLOAD', 'Tab [' . _DML_PERMISSIONS . '] \'' . _DML_CFG_UPLOAD . '\': Select who can upload documents.');
define('_DML_CFG_ERR_APPROVE', 'Tab [' . _DML_PERMISSIONS . '] \'' . _DML_CFG_APPROVE . '\': Select who can approve documents.');
define('_DML_CFG_ERR_DOWNLOAD', 'Tab [' . _DML_PERMISSIONS . '] \'' . _DML_CFG_VIEW . '\': Select a default User/Group.');
define('_DML_CFG_ERR_EDIT', 'Tab [' . _DML_PERMISSIONS . '] \'' . _DML_CFG_MAINTAIN . '\': Select a default User/Group for document maintenance');
define('_DML_CFG_EXTENSIONSVIEWING', "Extensions for viewing");
define('_DML_CFG_EXTENSIONSVIEWINGTT', "File type extensions that can be viewed. Use blank for none, * for all. Use a | between types (txt|pdf).");

define('_DML_CFG_GENERALSET', "General Settings");
define('_DML_CFG_THEMES', "Themes");
define('_DML_CFG_EXTRADOCINFO', "Extra Document Information");
define('_DML_CFG_GUESTPERM', "Guest Permissions");
define('_DML_CFG_FRONTPERM', "Front-end Permissions");
define('_DML_CFG_DOCPERM', "Document Permissions");
define('_DML_CFG_OVERRIDEVIEW', "Override View");
define('_DML_CFG_OVERRIDEMANT', "Override Maintain");
define('_DML_CFG_CREATORPERM', "Creator Permissions");
define('_DML_CFG_FILEXTENSIONS', "File Extensions");
define('_DML_CFG_FILENAMES', "File Names");

define('_DML_CFG_PROCESS_BOTS', "Process Content Plugins?");
define('_DML_CFG_PROCESS_BOTSTT', "Applies content Plugins on the document or Category descriptions. This allows you to use {tags} in your descriptions. *Warning* Not all Plugins will work with this feature.");
define('_DML_CFG_INDIVIDUAL_PERM', "Allow individual user permissions");
define('_DML_CFG_INDIVIDUAL_PERMTT', "When you turn this off, you will still be able to assign permissions to a group, but no longer to an individual user. Your existing document permissions will be preserved, but when editing a document that is assigned to a single user, you will have to choose a usergroup instead. Turn this off to improve performance and memory usage for large userbases. ");
define('_DML_CFG_HIDE_REMOTE', "Hide remote links");
define('_DML_CFG_HIDE_REMOTETT', "This option hides links to remote files in the document details view. Users with editing permissions will still see the link. *NOTE* This absolutely does _NOT_ offer complete protection for remote links. Users will still be able to find out the remote location of the file.");

// -- Statistics
define('_DML_STATS', "Statistics");
define('_DML_DOCSTATS', "DOCman statistics - Top 50 Downloads");
define('_DML_RANK', "Rank");

// -- Logs
define('_DML_DOWNLOAD_LOGS', "Download Logs");
define('_DML_IP', "IP");
define('_DML_BROWSER', "Browser");
define('_DML_OS', "Operating System");
define('_DML_ANONYMOUS', "Anonymous");

// -- Updates
define('_DML_UPGRADE', "Upgrade");
define('_DML_YOU_HAVE_VERSION', "You have version");
define('_DML_UPTODATE', "Your version is up-to-date.");
define('_DML_NO_UP_AVAIL', "No updates available at this time.");
define('_DML_COULD_NOT_COPY', "Could not copy all the files to their directories. Check permissions. Stopped at file");
define('_DML_UPDATING_DB', "Updating database...");
define('_DML_DELETING_OLD', "Deleting old files...");
define('_DML_ERROR_DELETING_OLD', "Error deleting old files. Not a critical error.");
define('_DML_PACKAGE', "Package");
define('_DML_INST_CLICK', "installed. Click");
define('_DML_HERE', "here");
define('_DML_TO_CONT', "to continue");
define('_DML_ERROR_READING', "error reading");
define('_DML_XML_ERROR', "XML file invalid");
define('_DML_CHECKING_UP', "Checking for updates");
define('_DML_RELEASED_ON', "Released on");

// -- Themes
define('_DML_THEMES', "Themes");
define('_DML_EDIT_DEFAULT_THEME', "Edit Current Theme");
define('_DML_THEME_INSTALLED', "Theme Installed");
define('_DML_ADJUST_CONFIG', "Adjust Configuration");
define('_DML_NEED_ZLIB', "The installer can't continue before zlib is installed");
define('_DML_INSTALLER_ERROR', "Installer - Error");
define('_DML_SUCCESFULLY_INSTALLED', "Successfully Installed");
define('_DML_ENABLE_FILE_UPLOADS', "File uploads must be enabled to continue");
define('_DML_UPLOAD_ERROR', "Upload Error");
define('_DML_EXTRACT_FAILED', "Extract Failed");
define('_DML_INSTALL_FAILED', "Install Failed");
define('_DML_UNINSTALL_FAILED', "Uninstall Failed");
define('_DML_INSTALL_FROM_DIRECTORY', "Install From Directory");
define('_DML_INSTALL_DIRECTORY', "Install Directory");
define('_DML_PACKAGE_FILE', "Package File");
define('_DML_UPLOAD_PACKAGE_FILE', "Upload Package File");
define('_DML_UPLOAD_AND_INSTALL', "Upload File and Install");
define('_DML_INSTALL_THEME', "Install Theme");
define('_DML_SELECT_DIRECTORY', "Please select a directory");
define('_DML_SELECT_PACKAGE', "Please select a package");
define('_DML_STYLESHEET_EDITOR', "Theme Stylesheet Editor");
define('_DML_OPFAILED_NO_TEMPLATE', _DML_OPERATION_FAILED.": No template specified");
define('_DML_OPFAILED_CONTENT_EMPTY', _DML_OPERATION_FAILED.": Content empty");
define('_DML_OPFAILED_UNWRITABLE', _DML_OPERATION_FAILED.": The file is not writable");
define('_DML_OPFAILED_CANT_OPEN_FILE', _DML_OPERATION_FAILED.": Failed to open file for writing");
define('_DML_OPFAILED_COULDNT_OPEN', _DML_OPERATION_FAILED.": Couldn't open ");
define('_DML_AUTHOR_URL', "Author URL" );
define('_DML_AUTHOR', "Author" );
define('_DML_INSTALLED_THEMES', "Installed Themes");
define('_DML_THEME_DETAILS', "Theme Details");
define('_DML_EDIT_THEME', "Edit Theme");


// -- E-mail
define('_DML_EMAIL_GROUP', "Send E-mail to Group");
define('_DML_SUBJECT', "Subject");
define('_DML_EMAIL_LEADIN', "Leading Text");
define('_DML_MESSAGE', "Main Message");
define('_DML_SEND_EMAIL', "Send");

// -- Credits
define('_DML_CREDITS', "Credits" );
define('_DML_APPLICATION', "Application");
define('_DML_ICONS', "Icons");
define('_DML_ICONS_PERMISSION', "Icons used with permission from" );
define('_DML_CHANGELOG', "Changelog");

// -- Clear Data
define('_DML_CLEARDATA', "Clear Data" );
define('_DML_CLEARDATA_CLEARED', "Data Cleared " );
define('_DML_CLEARDATA_FAILED', "Failed clearing: " );
define('_DML_CLEARDATA_ITEM', "Item" );
define('_DML_CLEARDATA_CLEAR', "Clear" );
define('_DML_CLEARDATA_CATS_CONTAIN_DOCS', "Clear documents before clearing Categories");
define('_DML_CLEARDATA_DELETE_DOCS_FIRST', "Clear documents before clearing files");

// -- Sample data
define('_DML_SAMPLE_CATEGORY', "Sample Category" );
define('_DML_SAMPLE_CATEGORY_DESC', "You can delete this sample category." );
define('_DML_SAMPLE_DOC', "Sample Document" );
define('_DML_SAMPLE_DOC_DESC', "You can delete this sample document and the file it is linked to." );
define('_DML_SAMPLE_FILENAME', "sample_file.png" );
define('_DML_SAMPLE_COMPLETED', "Completed adding sample data." );
define('_DML_SAMPLE_GROUP', "Sample Group" );
define('_DML_SAMPLE_GROUP_DESC', "You can use groups to assign permissions to a group of users." );
define('_DML_SAMPLE_LICENSE', "Sample License" );
define('_DML_SAMPLE_LICENSE_DESC', "You can optionally assign licenses to documents." );

// -- Added v1.4.0 RC1
define('_DML_CFG_COMPAT', "Compatibility" );
define('_DML_CFG_SPECIALCOMPATMODE', "&quot;Special&quot; compatibility mode" );
define('_DML_CFG_SPECIALCOMPATMODETT', "In DOCman 1.3 compatibility mode, &quot;Special&quot; users are Managers, Administrators and Super Administrators. In Joomla! mode, this also includes Authors, Publishers and Editors");
define('_DML_CFG_SPECIALCOMPAT_DM13', "DOCman 1.3" );
define('_DML_CFG_SPECIALCOMPAT_J10', "Joomla!" );