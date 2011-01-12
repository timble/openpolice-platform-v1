<?php
/**
 * @version		$Id: CHANGELOG.php 1384 2010-06-18 09:49:14Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license	    GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');
?>

Note: This changelog only contains the most important changes.

Legend:

* -> Security Fix
# -> Bug Fix
$ -> Language fix or change
+ -> Addition
^ -> Change
- -> Removed
! -> Note


-------------------- 1.5.8 Stable Release [ June 21, 2010] ------------------

# Fixed #233 Details table shows even if every child is hidden
# Fixed #226 PHP Short tag in list_item template
# Fixed #220 update deleted original and does not upload
# Fixed #224 Html issues
* Fixed #216 MEDIUM: Attackers with upload permissions can in some cases expose sensitive data
# Fixed Error when clicking 'New Doc' in files view
# Fixed #217 Unpublishing download button prevented downloads
# Fixed #218 Notices in theme after upgrading

-------------------- 1.5.7 Stable Release [ April 30, 2010] ------------------

# Fixed "Call to undefined function apache_setenv" on IIS

-------------------- 1.5.6 Stable Release [ April 30, 2010] ------------------

# Fixed #194 Background gradient on dark templates can be set in theme config
# Fixed #170 Document table headers not sorting
# Fixed #189 Local Name setting while transfer file is now required in backend
# Fixed #169 Re-added, cleaned up, fixed email group feature
# Fixed #209 Smarter filtering for files in backend
# Fixed #107 Installation with FTP layer
# Fixed #192 Batch upload relative path
# Fixed #182 Couldn't delete filenames with quotes
# Fixed #167 DOCman license not using JRoute class
# Fixed #183 Downloading with IE7/8
# Fixed: Wrong div class in latest down module

-------------------- 1.5.5 Stable Release [March 9 2010] ------------------

# Fixed #149 403 error when author uses DOClink
# Fixed search form html anomality
# Fixed #185 missing icons

-------------------- 1.5.4 Stable Release [March 4 2010] ------------------

# Fixed some IIS regressions
# Fixed #179 Notices in Search
# Fixed #178 Problem uploading on IIS in some cases

-------------------- 1.5.3 Stable Release [February 20 2010] ------------------

# Fixed [#107] Upgrade with FTP Layer
# Fixed issue with theme config not being found in some cases
# [#163] Improved IIS compatibility drastically
# [#146] Description vanishes in IE7, because of Joomla template dependence
^ [#150] Refactored Help button to point to support.joomlatools.eu
# [#152] DOClink takes into account multiple DOCman menu items
# [#87] Unable to select unpublished category when creating document
# [#136] Missing icon in DOClink
# [#131] Searching international characters
# [#85] More helpful info when configuring max upload filesize
# [#122] User can upload all file types not obeyed
! Max documents limit in DOClink upped to 2500
! Performance: Loading users in frontend is now twice as fast
! Performance: Documents view is now 10% faster
# [#135] Performance: Files view is now 60% faster
^ [#66] Search results now point to correct menu items
- [#169] Removed email group
# [#143] Version check during install requires php5

-------------------- 1.5.2 Stable Release [January 20 2010] ------------------

^ [#115] DOClink incorrectly showed template's background
# [#121] Assign multiple categories in modules
# [#102] Auto publish/ auto approve failed when category ID is used
# Small performance gain when loading users
# [#74] Documents owned by deleted users caused errors
# [#127] Plugins didn't show correctly in plugin manager
# [#116] DOClink in some cases exposed document names
# [#134] Greatly improved handling of special characters in file names
# [#99] Various DOClink Fixes
# [#100] DOClink enabled on install
# [#118] Moved uploading animation (dm_progress.gif) to frontend
# [#106] Friendly "config not writeable" message
+ Added 'thumbnails' to Clear Data feature
^ [#91] Smarter versions checking
# [#77] PHP5.3 compat: Fixed call-time pass by reference
# [#77] PHP5.3 compat: Replaced split with preg_split
# [#77] PHP5.3 compat: Replaced ereg_replace with preg_replace
# [#77] PHP5.3 compat: Replaced eregi with preg_match
# [#77] PHP5.3 compat: Assigning the return value of new by reference

-------------------- 1.5.1 Stable Release [December 16 2009] ------------------

# [#86] Override checkboxes in configuration
# [#83] TCPDF error with DOClink pdf icon
^ [#80] Changed 'number of documents per page' setting to list (5-100, 5 step increments)
- [#80] Removed 'all' option from pagination in backend
# [#78] Memory issues in log view
# Fixed Issue with content plugins
# [#76] Added Menu item name and description
# [#72] Missing translation in mod_docman_latestdown
# [#71] Search plugin caused issue with language strings
# [#70] Frontend modules where not visible in module manager
+ [#68] Document title link options [None, Direct download, Details page] to default template
# [#62] Thumbnail preview in frontend edit form with SEF on and mod_rewrite off
# Fixed Category selection in Joomla Menu Manager
# Fixed Process Content Plugins configuration setting

-------------------- 1.5.0 Stable Release [December 09 2009] ------------------

- Removed legacy (Joomla 1.5 Native)
+ DOClink, search plugin and modules are now included in the package and installed automatically
^ Complete new frontend default theme. Optimised to easily blend into any Joomla template.
^ Fully refactored administrator to fully match Joomla 1.5's native look and feel
^ Performance optimizations
! Performed a full security audit
! Many minor improvements based on feedback from community

-------------------- 1.4.0 Stable Release [February 14 2009] ------------------