<?php
/**
 * @version		$Id: README.php 1362 2010-05-01 13:37:29Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license	    This file can not be redistributed without the written consent of the
 *				original copyright holder. This file is not licensed under the GPL.
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');
?>

DOCman v1.5.8 README
--------------------

*** IMPORTANT ***

PLEASE READ THE UPGRADE INSTRUCTIONS BELOW WHEN UPGRADING FROM AN OLDER VERSION!

ALWAYS BACK UP YOUR SYSTEM'S FILES AND DATABASE BEFORE (UN)INSTALLING ANYTHING!

TO MAKE SURE THE FILES HAVEN'T BEEN TAMPERED WITH, DOWNLOAD DOCMAN, ADDONS AND
TRANSLATIONS FROM THE OFFICIAL LOCATION AT http://www.joomladocman.com/


Table of Contents
-----------------
* About DOCman

* System Requirements
* Installation in Joomla! 1.5.x
* Installing translations
* Upgrading from 1.5.x to 1.5.8
* Upgrading from older versions of v1.4.x or 1.5.x
* Upgrading from v1.3 RC1 or RC2
* Migrating DOCman from a Joomla! 1.0.x site to a Joomla! 1.5 site

* Official Addons
* Useful Links


About DOCman
------------
DOCman is an open source document management and download system for Joomla! v1.5. With this component you can manage documents across categories and make them available for download.

These are the main features of DOCman:

* Infinite categories and subcategories. The documents can be organized across custom categories and subcategories;
* Files can be hosted locally or on a remote server
* Access control: Documents can be assigned to specific user or to custom groups of users
* Download counter and log. You can display a download counter per document and all the downloads can be logged (by user, IP, browser, date and hour);
* Own search system. Documents can be searched by name and/or description. The search system integrates with Joomla! using an optional mambot;
* Anti-leech system. The built-in anti-leech system avoids direct linking to documents;
* Path protection. Real paths to documents are never displayed to users;
* Themes: The layout can be changed using custom themes;
* ... and much more!

System Requirements
-------------------
1. Joomla 1.5.x (recommended 1.5.15 or later).
2. PHP 5.2.x or higher
3. Database: MySQL 4.1 or higher


Installation in Joomla! 1.5.x
-----------------------------
1. Check the system requirements. [Help -> System Info -> System Info]
2. Check your writing permissions. [Help -> System Info -> Directory Permissions]
3. Install DOCman using Joomla's installer. [Extensions -> Install/Uninstall]
4. If you're new to DOCman, we highly recommend you click the 'Add sample data'-button.
5. Review the configuration settings and save.

Installing translations
-----------------------
Unzip the translation file of your choice in the root of your Joomla installation.

Upgrading from 1.5.x to 1.5.8
-----------------------------
1. Backup your Joomla installation and database
2. Install upgrade_docman_v1.5.x_to_v1.5.8.tar.gz, just like you would install any other extension

Upgrading from older versions of v1.4.x or 1.5.x
------------------------------------------------
If you have any version of 1.4.x, you can always upgrade to the latest version without loosing your data, EXCEPT the config settings and the theme.
1. Make a backup copy of /administrator/components/com_docman/docman.config.php to a different location
   OR
   Make screenshots of the configuration pages, or note down the settings
2. [Optional] If you have custom themes, make sure you backup these separately They're in /components/com_docman/themes
3. Uninstall DOCman. Your files, documents, categories, licenses, logs and groups will be preserved.
4. Uninstall the DOCman search plugin, DOClink and the official modules.
4. Install the latest version of DOCman
5. Restore docman.config.php or use the settings from the screenshots
6. Review the configuration settings and save. Make sure that 'Path for storing files' (in the config) is correct.

Upgrading from v1.3 RC1 or RC2
------------------------------
You cannot upgrade directly from 1.3.x to 1.5. First upgrade to 1.4, then upgrade to 1.5.
Follow the instructions in the 1.4.x readme file.

Migrating DOCman from a Joomla! 1.0.x site to a Joomla! 1.5 site
----------------------------------------------------------------
Download the file docman_migrator_plugins_[version].zip. Inside, there is a README file with instructions.


Useful Links
------------
* Site:
  http://www.joomladocman.com/

* Blog:
  http://blog.joomlatools.eu/

* FAQ:
  http://support.joomlatools.eu/

* Downloads & translations:
  http://www.joomlatools.eu/products/docman/downloads/

* Forum Support:
  http://forum.joomlatools.eu/
