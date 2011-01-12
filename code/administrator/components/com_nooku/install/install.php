<?php
/**
 * @version     $Id: install.php 1121 2010-05-26 16:53:49Z johan $
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Install
 * @copyright   Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license     GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link        http://www.nooku.org
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Require the library loader

//$nPaths = $this->_paths;
$status = new JObject();

/***********************************************************************************************
 * ---------------------------------------------------------------------------------------------
 * ADMINISTRATOR LANGUAGE SELECT MODULE
 * ---------------------------------------------------------------------------------------------
 * **********************************************************************************************/

// Set the installation path
$element =& $this->manifest->getElementByPath('mod_language_select_admin/files');
if (is_a($element, 'JSimpleXMLElement') && count($element->children())) {
	$files =& $element->children();
	foreach ($files as $file) {
		if ($file->attributes('module')) {
			$mname = $file->attributes('module');
			break;
		}
	}
}
if (!empty ($mname)) {
	$this->parent->setPath('extension_root', JPATH_ADMINISTRATOR.DS.'modules'.DS.$mname);
} else {
	$this->parent->abort(JText::_('Module').' '.JText::_('Install').': '.JText::_('No module file specified'));
	return false;
}

/**
 * ---------------------------------------------------------------------------------------------
 * Filesystem Processing Section
 * ---------------------------------------------------------------------------------------------
 */

/*
 * If the module directory already exists, then we will assume that the
 * module is already installed or another module is using that
 * directory.
 */
if (file_exists($this->parent->getPath('extension_root'))&&!$this->parent->getOverwrite()) {
	$this->parent->abort(JText::_('Module').' '.JText::_('Install').': '.JText::_('Another module is already using directory').': "'.$this->parent->getPath('extension_root').'"');
	return false;
}

// If the module directory does not exist, lets create it
$created = false;
if (!file_exists($this->parent->getPath('extension_root'))) {
	if (!$created = JFolder::create($this->parent->getPath('extension_root'))) {
		$this->parent->abort(JText::_('Module').' '.JText::_('Install').': '.JText::_('Failed to create directory').': "'.$this->parent->getPath('extension_root').'"');
		return false;
	}
}

/*
 * Since we created the module directory and will want to remove it if
 * we have to roll back the installation, lets add it to the
 * installation step stack
 */
if ($created) {
	$this->parent->pushStep(array ('type' => 'folder', 'path' => $this->parent->getPath('extension_root')));
}

// Copy all necessary files
if ($this->parent->parseFiles($element, -1) === false) {
	// Install failed, roll back changes
	$this->parent->abort();
	return false;
}

$clientId = 1;
$row = & JTable::getInstance('module');
$row->title = $this->get('name');
$row->ordering = $row->getNextOrder( "position='status'" );
$row->position = 'status';
$row->showtitle = 0;
$row->iscore = 0;
$row->access = $clientId == 1 ? 2 : 0;
$row->client_id = $clientId;
$row->module = $mname;
$row->published = 1;
$row->params = '';

if (!$row->store()) {
	// Install failed, roll back changes
	$this->parent->abort(JText::_('Module').' '.JText::_('Install').': '.$db->stderr(true));
	return false;
}

$status->set('mod_language_select_admin', true);



/***********************************************************************************************
 * ---------------------------------------------------------------------------------------------
 * SITE LANGUAGE SELECT MODULE
 * ---------------------------------------------------------------------------------------------
 * **********************************************************************************************/

// Set the installation path
$element =& $this->manifest->getElementByPath('mod_language_select_site/files');
if (is_a($element, 'JSimpleXMLElement') && count($element->children())) {
	$files =& $element->children();
	foreach ($files as $file) {
		if ($file->attributes('module')) {
			$mname = $file->attributes('module');
			break;
		}
	}
}
if (!empty ($mname)) {
	$this->parent->setPath('extension_root', JPATH_SITE.DS.'modules'.DS.$mname);
} else {
	$this->parent->abort(JText::_('Module').' '.JText::_('Install').': '.JText::_('No module file specified'));
	return false;
}

/**
 * ---------------------------------------------------------------------------------------------
 * Filesystem Processing Section
 * ---------------------------------------------------------------------------------------------
 */

/*
 * If the module directory already exists, then we will assume that the
 * module is already installed or another module is using that
 * directory.
 */
if (file_exists($this->parent->getPath('extension_root'))&&!$this->parent->getOverwrite()) {
	$this->parent->abort(JText::_('Module').' '.JText::_('Install').': '.JText::_('Another module is already using directory').': "'.$this->parent->getPath('extension_root').'"');
	return false;
}

// If the module directory does not exist, lets create it
$created = false;
if (!file_exists($this->parent->getPath('extension_root'))) {
	if (!$created = JFolder::create($this->parent->getPath('extension_root'))) {
		$this->parent->abort(JText::_('Module').' '.JText::_('Install').': '.JText::_('Failed to create directory').': "'.$this->parent->getPath('extension_root').'"');
		return false;
	}
}

/*
 * Since we created the module directory and will want to remove it if
 * we have to roll back the installation, lets add it to the
 * installation step stack
 */
if ($created) {
	$this->parent->pushStep(array ('type' => 'folder', 'path' => $this->parent->getPath('extension_root')));
}

// Copy all necessary files
if ($this->parent->parseFiles($element, -1) === false) {
	// Install failed, roll back changes
	$this->parent->abort();
	return false;
}

$clientId = 0;
$row = & JTable::getInstance('module');
$row->title = $this->get('name');
$row->ordering = 0;
$row->position = 'left';
$row->showtitle = 0;
$row->iscore = 0;
$row->access = $clientId == 1 ? 2 : 0;
$row->client_id = $clientId;
$row->module = $mname;
$row->published = 1;
$row->params = '';

if (!$row->store()) {
	// Install failed, roll back changes
	$this->parent->abort(JText::_('Module').' '.JText::_('Install').': '.$db->stderr(true));
	return false;
}

$query = "INSERT INTO #__modules_menu  (`moduleid`, `menuid`) VALUES ({$row->id}, 0)";
$db->setQuery($query);
if(!$db->query())
{
	// Install failed, roll back changes
	$this->parent->abort(JText::_('Module').' '.JText::_('Install').': '.$db->stderr(true));
	return false;
}
$status->set('mod_language_select_site', true);


/***********************************************************************************************
 * ---------------------------------------------------------------------------------------------
 * NOOKU SYSTEM PLUGIN
 * ---------------------------------------------------------------------------------------------
 * **********************************************************************************************/

// Set the installation path
$element =& $this->manifest->getElementByPath('nooku_plugin/files');
if (is_a($element, 'JSimpleXMLElement') && count($element->children())) {
	$files =& $element->children();
	foreach ($files as $file) {
		if ($file->attributes('plugin')) {
			$pname = $file->attributes('plugin');
			break;
		}
	}
}
$group = 'system';
if (!empty ($pname) && !empty($group)) {
	$this->parent->setPath('extension_root', JPATH_ROOT.DS.'plugins'.DS.$group);
} else {
	$this->parent->abort(JText::_('Plugin').' '.JText::_('Install').': '.JText::_('No plugin file specified'));
	return false;
}

/**
 * ---------------------------------------------------------------------------------------------
 * Filesystem Processing Section
 * ---------------------------------------------------------------------------------------------
 */

// If the plugin directory does not exist, lets create it
$created = false;
if (!file_exists($this->parent->getPath('extension_root'))) {
	if (!$created = JFolder::create($this->parent->getPath('extension_root'))) {
		$this->parent->abort(JText::_('Plugin').' '.JText::_('Install').': '.JText::_('Failed to create directory').': "'.$this->parent->getPath('extension_root').'"');
		return false;
	}
}

/*
 * If we created the plugin directory and will want to remove it if we
 * have to roll back the installation, lets add it to the installation
 * step stack
 */
if ($created) {
	$this->parent->pushStep(array ('type' => 'folder', 'path' => $this->parent->getPath('extension_root')));
}

// Copy all necessary files
if ($this->parent->parseFiles($element, -1) === false) {
	// Install failed, roll back changes
	$this->parent->abort();
	return false;
}

/**
 * ---------------------------------------------------------------------------------------------
 * Database Processing Section
 * ---------------------------------------------------------------------------------------------
 */
$db = &JFactory::getDBO();

// Check to see if a plugin by the same name is already installed
$query = 'SELECT `id`' .
		' FROM `#__plugins`' .
		' WHERE folder = '.$db->Quote($group) .
		' AND element = '.$db->Quote($pname);
$db->setQuery($query);
if (!$db->Query()) {
	// Install failed, roll back changes
	$this->parent->abort(JText::_('Plugin').' '.JText::_('Install').': '.$db->stderr(true));
	return false;
}
$id = $db->loadResult();

// Was there a plugin already installed with the same name?
if ($id) {

	if (!$this->parent->getOverwrite())
	{
		// Install failed, roll back changes
		$this->parent->abort(JText::_('Plugin').' '.JText::_('Install').': '.JText::_('Plugin').' "'.$pname.'" '.JText::_('already exists!'));
		return false;
	}

} else {
	$row =& JTable::getInstance('plugin');
	$row->name = JText::_('System').' - Nooku';
	$row->ordering = 1;
	$row->folder = $group;
	$row->iscore = 0;
	$row->access = 0;
	$row->client_id = 0;
	$row->element = $pname;
	$row->published = 1;
	$row->params = '';

	if (!$row->store()) {
		// Install failed, roll back changes
		$this->parent->abort(JText::_('Plugin').' '.JText::_('Install').': '.$db->stderr(true));
		return false;
	}
}

$status->set('nooku_plugin', true);



/***********************************************************************************************
 * ---------------------------------------------------------------------------------------------
 * NOOKU EDITORS-XTD PLUGIN
 * ---------------------------------------------------------------------------------------------
 * **********************************************************************************************/

// Set the installation path
$element =& $this->manifest->getElementByPath('nooku_editor_plugin/files');
if (is_a($element, 'JSimpleXMLElement') && count($element->children())) {
    $files =& $element->children();
    foreach ($files as $file) {
        if ($file->attributes('plugin')) {
            $pname = $file->attributes('plugin');
            break;
        }
    }
}
$group = 'editors-xtd';
if (!empty ($pname) && !empty($group)) {
    $this->parent->setPath('extension_root', JPATH_ROOT.DS.'plugins'.DS.$group);
} else {
    $this->parent->abort(JText::_('Plugin').' '.JText::_('Install').': '.JText::_('No plugin file specified'));
    return false;
}

/**
 * ---------------------------------------------------------------------------------------------
 * Filesystem Processing Section
 * ---------------------------------------------------------------------------------------------
 */

// If the plugin directory does not exist, lets create it
$created = false;
if (!file_exists($this->parent->getPath('extension_root'))) {
    if (!$created = JFolder::create($this->parent->getPath('extension_root'))) {
        $this->parent->abort(JText::_('Plugin').' '.JText::_('Install').': '.JText::_('Failed to create directory').': "'.$this->parent->getPath('extension_root').'"');
        return false;
    }
}

/*
 * If we created the plugin directory and will want to remove it if we
 * have to roll back the installation, lets add it to the installation
 * step stack
 */
if ($created) {
    $this->parent->pushStep(array ('type' => 'folder', 'path' => $this->parent->getPath('extension_root')));
}

// Copy all necessary files
if ($this->parent->parseFiles($element, -1) === false) {
    // Install failed, roll back changes
    $this->parent->abort();
    return false;
}

/**
 * ---------------------------------------------------------------------------------------------
 * Database Processing Section
 * ---------------------------------------------------------------------------------------------
 */
$db = &JFactory::getDBO();

// Check to see if a plugin by the same name is already installed
$query = 'SELECT `id`' .
        ' FROM `#__plugins`' .
        ' WHERE folder = '.$db->Quote($group) .
        ' AND element = '.$db->Quote($pname);
$db->setQuery($query);
if (!$db->Query()) {
    // Install failed, roll back changes
    $this->parent->abort(JText::_('Plugin').' '.JText::_('Install').': '.$db->stderr(true));
    return false;
}
$id = $db->loadResult();

// Was there a plugin already installed with the same name?
if ($id) {

    if (!$this->parent->getOverwrite())
    {
        // Install failed, roll back changes
        $this->parent->abort(JText::_('Plugin').' '.JText::_('Install').': '.JText::_('Plugin').' "'.$pname.'" '.JText::_('already exists!'));
        return false;
    }

} else {
    $row =& JTable::getInstance('plugin');
    $row->name = JText::_('Editor Button').' Nooku';
    $row->ordering = 1;
    $row->folder = $group;
    $row->iscore = 0;
    $row->access = 0;
    $row->client_id = 0;
    $row->element = $pname;
    $row->published = 1;
    $row->params = '';

    if (!$row->store()) {
        // Install failed, roll back changes
        $this->parent->abort(JText::_('Plugin').' '.JText::_('Install').': '.$db->stderr(true));
        return false;
    }
}

$status->set('nooku_editor_plugin', true);

/***********************************************************************************************
 * ---------------------------------------------------------------------------------------------
 * NOOKU XMLRPC PLUGIN
 * ---------------------------------------------------------------------------------------------
 * **********************************************************************************************/

// Set the installation path
$element =& $this->manifest->getElementByPath('nooku_xmlrpc_plugin/files');
if (is_a($element, 'JSimpleXMLElement') && count($element->children())) {
	$files =& $element->children();
	foreach ($files as $file) {
		if ($file->attributes('plugin')) {
			$pname = $file->attributes('plugin');
			break;
		}
	}
}
$group = 'xmlrpc';
if (!empty ($pname) && !empty($group)) {
	$this->parent->setPath('extension_root', JPATH_ROOT.DS.'plugins'.DS.$group);
} else {
	$this->parent->abort(JText::_('Plugin').' '.JText::_('Install').': '.JText::_('No plugin file specified'));
	return false;
}

/**
 * ---------------------------------------------------------------------------------------------
 * Filesystem Processing Section
 * ---------------------------------------------------------------------------------------------
 */

// If the plugin directory does not exist, lets create it
$created = false;
if (!file_exists($this->parent->getPath('extension_root'))) {
	if (!$created = JFolder::create($this->parent->getPath('extension_root'))) {
		$this->parent->abort(JText::_('Plugin').' '.JText::_('Install').': '.JText::_('Failed to create directory').': "'.$this->parent->getPath('extension_root').'"');
		return false;
	}
}

/*
 * If we created the plugin directory and will want to remove it if we
 * have to roll back the installation, lets add it to the installation
 * step stack
 */
if ($created) {
	$this->parent->pushStep(array ('type' => 'folder', 'path' => $this->parent->getPath('extension_root')));
}

// Copy all necessary files
if ($this->parent->parseFiles($element, -1) === false) {
	// Install failed, roll back changes
	$this->parent->abort();
	return false;
}

/**
 * ---------------------------------------------------------------------------------------------
 * Database Processing Section
 * ---------------------------------------------------------------------------------------------
 */
$db = &JFactory::getDBO();

// Check to see if a plugin by the same name is already installed
$query = 'SELECT `id`' .
		' FROM `#__plugins`' .
		' WHERE folder = '.$db->Quote($group) .
		' AND element = '.$db->Quote($pname);
$db->setQuery($query);
if (!$db->Query()) {
	// Install failed, roll back changes
	$this->parent->abort(JText::_('Plugin').' '.JText::_('Install').': '.$db->stderr(true));
	return false;
}
$id = $db->loadResult();

// Was there a plugin already installed with the same name?
if ($id) {

	if (!$this->parent->getOverwrite())
	{
		// Install failed, roll back changes
		$this->parent->abort(JText::_('Plugin').' '.JText::_('Install').': '.JText::_('Plugin').' "'.$pname.'" '.JText::_('already exists!'));
		return false;
	}

} else {
	$row =& JTable::getInstance('plugin');
	$row->name = JText::_('XMLRPC').' - Nooku';
	$row->ordering = 1;
	$row->folder = $group;
	$row->iscore = 0;
	$row->access = 0;
	$row->client_id = 0;
	$row->element = $pname;
	$row->published = 1;
	$row->params = '';

	if (!$row->store()) {
		// Install failed, roll back changes
		$this->parent->abort(JText::_('Plugin').' '.JText::_('Install').': '.$db->stderr(true));
		return false;
	}
}

$status->set('nooku_xmlrpc_plugin', true);


/***********************************************************************************************
 * ---------------------------------------------------------------------------------------------
 * SETUP DEFAULTS
 * ---------------------------------------------------------------------------------------------
 ***********************************************************************************************/

// Get the default site language's iso code, the name and the alias
$iso_code 	= JComponentHelper::getParams('com_languages')->get('site', 'en-GB');
$site		= JApplicationHelper::getClientInfo(0);
$path		= JLanguage::getLanguagePath($site->path);
$xml 		= JApplicationHelper::parseXMLLangMetaFile($path.DS.$iso_code.DS.$iso_code.'.xml');
$lang_name  = preg_replace('/\(.*\)/', '', $xml['name']);
$alias      = strtolower(substr($iso_code, 0, strpos($iso_code, '-')));


// Insert the default language into the nooku table
$iso = $db->Quote($iso_code);
$db->setQuery( 'INSERT INTO `#__nooku_languages` (`name`, `native_name`, `iso_code`, `alias`, `created_date`, `enabled`, `ordering`, `image`)' .
		'VALUES ('.$db->Quote($lang_name).', '.$db->Quote($lang_name).', '.$db->Quote($iso_code).', '.$db->Quote($alias).', NOW(), 1, 1,'.$db->Quote('gb.png').' )' );
if(!$db->query()) {
	JError::raiseWarning( 500, $db->getErrorMsg() );
	return false;
}

//Save the primary language to the config
$table = JTable::getInstance('component');
$data = array();
$data['params'] = array('primary_language'=> $iso_code);
$data['option'] = 'com_nooku';
$table->loadByOption( 'com_nooku' );
$table->bind( $data );

if (!$table->check()) {
	JError::raiseWarning( 500, $table->getError() );
	return false;
}

if (!$table->store()) {
	JError::raiseWarning( 500, $table->getError() );
	return false;
}


// set status
$status->set('primarylang.set', true );
$status->set('primarylang.name', $lang_name);


/***********************************************************************************************
 * ---------------------------------------------------------------------------------------------
 * UPDATE CORE TABLE COMMENTS
 * ---------------------------------------------------------------------------------------------
 ***********************************************************************************************/
$comments = array(
	'banner' => 'Banners from the core banner manager', 	
	'bannerclient' => 'Banner clients from the core banner manager', 	 	
	'categories' => 'Categories for articles and other content types', 	
	'contact_details' => 'Contacts from the core contact manager', 	
	'content' => 'Articles', 	
	'content_frontpage' => 'Articles displayed on the frontpage', 	
	'content_rating' => 'Ratings for articles', 	
	'menu' => 'Menu items', 	
	'modules' => 'Modules', 	
	'newsfeeds' => 'Newsfeeds', 	
	'poll_data' => 'Results from the polls', 	
	'polls' => 'Polls from the core poll manager', 	
	'sections' => 'Article sections',
	'weblinks' => 'Weblinks from the core weblink manager'
);
foreach($comments as $table => $comment)
{
	$db->setQuery("ALTER TABLE `#__$table`  COMMENT = '$comment'");
	$db->query();
}

/***********************************************************************************************
 * ---------------------------------------------------------------------------------------------
 * SET A 'FIRST RUN' FILE
 * ---------------------------------------------------------------------------------------------
 ***********************************************************************************************/
JFile::write(
	JPATH_ADMINISTRATOR.DS.'components'.DS.'com_nooku'.DS.'configs'.DS.'first_run.php', 
	'<?php $first_run=true;'
);

/***********************************************************************************************
 * ---------------------------------------------------------------------------------------------
 * OUTPUT TO SCREEN
 * ---------------------------------------------------------------------------------------------
 ***********************************************************************************************/
?>
<script>$$('table.adminform')[0].getElementsByTagName('tr')[0].setStyle('display', 'none');</script>
<img src="<?php echo JURI::root('true').'/media/com_nooku/images/nooku-60.png' ?>" /><br />
<table class="adminlist">
	<thead>
		<tr>
			<th class="title"><?php echo JText::_('Task'); ?></th>
			<th width="60%"><?php echo JText::_('Status'); ?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
	</tfoot>
	<tbody>
		<tr class="row0">
			<td class="key"><?php echo JText::_('Component'); ?></td>
			<td><strong><?php echo JText::_('Installed'); ?></strong></td>
		</tr>
		<tr class="row1">
			<td class="key"><?php echo JText::_('Language Select Administrator Module'); ?></td>
			<td><?php echo ($status->get('mod_language_select_admin')) ? '<strong>'.JText::_('Installed').'</strong>' : '<em>'.JText::_('NOT Installed').'</em>'; ?></td>
		</tr>
		<tr class="row0">
			<td class="key"><?php echo JText::_('Language Select Site Module'); ?></td>
			<td><?php echo ($status->get('mod_language_select_site')) ? '<strong>'.JText::_('Installed').'</strong>' : '<em>'.JText::_('NOT Installed').'</em>'; ?></td>
		</tr>
        <tr class="row1">
            <td class="key"><?php echo JText::_('Nooku System Plugin'); ?></td>
            <td><?php echo ($status->get('nooku_plugin')) ? '<strong>'.JText::_('Installed').'</strong>' : '<em>'.JText::_('NOT Installed').'</em>'; ?></td>
        </tr>
        <tr class="row0">
            <td class="key"><?php echo JText::_('Nooku Editors-xtd Plugin'); ?></td>
            <td><?php echo ($status->get('nooku_editor_plugin')) ? '<strong>'.JText::_('Installed').'</strong>' : '<em>'.JText::_('NOT Installed').'</em>'; ?></td>
        </tr>
        <tr class="row1">
            <td class="key"><?php echo JText::_('Nooku Xmlrpc Plugin'); ?></td>
            <td><?php echo ($status->get('nooku_xmlrpc_plugin')) ? '<strong>'.JText::_('Installed').'</strong>' : '<em>'.JText::_('NOT Installed').'</em>'; ?></td>
        </tr>
		<tr class="row0">
			<td class="key"><?php echo JText::_('Koowa System Plugin'); ?></td>
			<td><?php echo (defined('KOOWA')) ? '<strong>'.JText::_('Installed').'</strong>' : '<em>'.JText::_('Koowa is NOT active. Please install the Koowa plugin and/or enable it.').'</em>'; ?></td>
		</tr>
		<tr>
			<th colspan="2">&nbsp;</th>
		</tr>
		<tr class="row1">
			<td class="key"><?php echo JText::_('Set Primary Language'); ?></td>
			<td><?php echo ($status->get('primarylang.set')) ? '<strong>'.JText::_('OK').'</strong>' : '<em>'.JText::_('NOT set').'</em>'; ?></td>
		</tr>
		<tr class="row0">
			<td class="key"><?php echo JText::_('Primary Language'); ?></td>
			<td><strong><?php echo $status->get('primarylang.name'); ?></strong></td>
		</tr>
		<tr>
			<th colspan="2">&nbsp;</th>
		</tr>
		<tr class="row1">
			<td class="key"><?php echo JText::_('PHP Version'); ?></td>
			<td>
				<?php echo version_compare(phpversion(), '5.2', '>=') 
					? '<strong>'.JText::_('OK').'</strong> - '.phpversion() 
					: '<em>'.JText::_('You need at least PHP v5.2 to use Nooku. You are using: ').phpversion().'</em>'; ?>
			</td>
		</tr>
		<tr class="row0">
			<td class="key"><?php echo JText::_('MySQL Version'); ?></td>
			<td>
				<?php echo version_compare($db->getVersion(), '4.1', '>=') 
				? '<strong>'.JText::_('OK').'</strong> - '.$db->getVersion() 
				: '<em>'.JText::_('You need at least MySQL v4.1 to use Nooku. You are using: ').$db->getVersion().'</em>'; ?>
			</td>
		</tr>
	</tbody>
</table>
