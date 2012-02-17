<?php
/**
 * @version		$Id$
 * @category	Nooku
 * @package		Nooku_Templates
 * @subpackage	Witblits
 * @copyright	Copyright (C) 2010 Timble CVBA and Contributors. (http://www.timble.net)
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link		http://www.nooku.org
 */

jimport('joomla.application.module.helper');

/*
 * xhtml (divs and font headder tags)
 */
function modChrome_xhtmls($module, &$params, &$attribs)
{
	if (!empty ($module->content)) : ?>
		<div class="module clearfix <?php echo $module->module; ?>">
		<?php if ($module->showtitle != 0) : ?>
			<h3><?php echo $module->title; ?></h3>
		<?php endif; ?>
			<?php echo $module->content; ?>
		</div>
	<?php endif;
}

/*
 * No Module Title shown
 */
function modChrome_notitle($module, &$params, &$attribs)
{
	if (!empty ($module->content)) : ?>
		<div class="module <?php echo $module->module; ?>">
			<?php echo $module->content; ?>
		</div>
	<?php endif;
}

/*
 * Search style (only mod_search)
 */
function modChrome_search($module, &$params, &$attribs)
{
	if (!empty ($module->content) && $module->module == 'mod_search') : ?>
		<div class="module <?php echo $module->module; ?>">
			<?php echo $module->content; ?>
		</div>
	<?php endif;
}

/*
 * Call style (only mod_call_us)
 */
function modChrome_call($module, &$params, &$attribs)
{
	if (!empty ($module->content) && $module->module == 'mod_call_us') : ?>
		<div class="module <?php echo $module->module; ?>">
			<?php echo $module->content; ?>
		</div>
	<?php endif;
}

/*
 * Sitename style (only mod_sitename)
 */
function modChrome_sitename($module, &$params, &$attribs)
{
	if (!empty ($module->content) && $module->module == 'mod_sitename') : ?>
		<?php echo $module->content; ?>
	<?php endif;
}

/*
 * User3 style (only mod_mainmenu)
 */
function modChrome_user3($module, &$params, &$attribs)
{
	if (!empty ($module->content) && $module->module == 'mod_mainmenu') : ?>
		<div class="module <?php echo $module->module; ?>">
			<?php echo $module->content; ?>
		</div>
	<?php endif;
}

/*
 * Language style (only mod_language_select)
 */
function modChrome_language($module, &$params, &$attribs)
{
	if (!empty ($module->content) && $module->module == 'mod_language_select') : ?>
		<div class="module <?php echo $module->module; ?>">
			<?php echo $module->content; ?>
		</div>
	<?php endif;
}

/*
 * Breadcrumbs style (only mod_breadcrumbs)
 */
function modChrome_breadcrumbs($module, &$params, &$attribs)
{
	if (!empty ($module->content) && $module->module == 'mod_breadcrumbs') : ?>
		<div class="module <?php echo $module->module; ?>">
			<?php echo $module->content; ?>
		</div>
	<?php endif;
}

/*
 * Syndicate style (only mod_syndicate)
 */
function modChrome_syndicate($module, &$params, &$attribs)
{
	if (!empty ($module->content) && $module->module == 'mod_syndicate') : ?>
		<div class="module <?php echo $module->module; ?>">
			<?php echo $module->content; ?>
		</div>
	<?php endif;
}