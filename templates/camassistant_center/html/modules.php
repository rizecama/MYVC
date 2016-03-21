<?php
/**
 * @version		$Id: modules.php 14401 2010-01-26 14:10:00Z louis $
 * @package		Joomla
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * This is a file to add template specific chrome to module rendering.  To use it you would
 * set the style attribute for the given module(s) include in your template to use the style
 * for each given modChrome function.
 *
 * eg.  To render a module mod_test in the sliders style, you would use the following include:
 * <jdoc:include type="module" name="test" style="slider" />
 *
 * This gives template designers ultimate control over how modules are rendered.
 *
 * NOTICE: All chrome wrapping methods should be named: modChrome_{STYLE} and take the same
 * two arguments.
 */

/*
 * Module chrome for rendering the module in a slider
 */
function modChrome_beezDivision($module, &$params, &$attribs)
{
	$headerLevel = isset($attribs['headerLevel']) ? (int) $attribs['headerLevel'] : 3;
	if (!empty ($module->content)) : ?>
		<div class="moduletable<?php echo $params->get('moduleclass_sfx'); ?>">
			<?php if ($module->showtitle) : ?>
				<h<?php echo $headerLevel; ?>><?php echo $module->title; ?></h><?php echo $headerLevel; ?>>
			<?php endif; ?>
			<?php echo $module->content; ?>
		</div>
	<?php endif;
}
// for leftmenu  codeed by anand babau  for apply class for customer modules  green  css
function modChrome_left_menu($module, &$params, &$attribs)
{
	
	if (!empty ($module->content)) : ?>
		<div class="links_pan">
			<?php if ($module->showtitle) : ?>
				<?php echo $headerLevel; ?>
<div class="head_geenbg"><?php echo $module->title; ?></div><?php echo $headerLevel; ?>
			<?php endif; ?>
			<div class="likns_pan">
<div class="likns_pan_top green"><?php echo $module->content; ?></div>
<div class="likns_pan_bot"></div>
</div>
		</div><div class="left_menudevider"></div>
	<?php endif;
}


// for leftmenu  codeed by anand babau  for apply class for customer modules  yellow css
function modChrome_left_menu_yellow($module, &$params, &$attribs)
{
	
	if (!empty ($module->content)) : ?>
		<div class="links_pan">
			<?php if ($module->showtitle) : ?>
				<?php echo $headerLevel; ?>
<div class="head_yellowbg"><?php echo strtoupper($module->title); ?></div><?php echo $headerLevel; ?>
			<?php endif; ?>
			<div class="likns_pan">
<div class="likns_pan_top yellow"><?php echo $module->content; ?></div>
<div class="likns_pan_bot"></div>
</div>
		</div><div class="left_menudevider"></div>
	<?php endif;
}


// for leftmenu  codeed by anand babau  for apply class for camfrimadmin modules  green css
function modChrome_left_frim_green($module, &$params, &$attribs)
{
	
	if (!empty ($module->content)) : ?>
		<div class="links_pan">
			<?php if ($module->showtitle) : ?>
				<?php echo $headerLevel; ?>
<div class="head_geenbg"><?php echo $module->title; ?></div><?php echo $headerLevel; ?>
			<?php endif; ?>
			<div class="likns_pan">
<div class="likns_pan_top green"><?php echo $module->content; ?></div>
<div class="likns_pan_bot"></div>
</div>
		</div><div class="left_menudevider"></div>
	<?php endif;
}

// for leftmenu  codeed by anand babau  for apply class for customer modules  yellow css
function modChrome_left_frim_yellow($module, &$params, &$attribs)
{
	
	if (!empty ($module->content)) : ?>
		<div class="links_pan">
			<?php if ($module->showtitle) : ?>
				<?php echo $headerLevel; ?>
<div class="head_yellowbg"><?php echo $module->title; ?></div><?php echo $headerLevel; ?>
			<?php endif; ?>
			<div class="likns_pan">
<div class="likns_pan_top yellow"><?php echo $module->content; ?></div>
<div class="likns_pan_bot"></div>
</div>
		</div><div class="left_menudevider"></div>
	<?php endif;
}

// for leftmenu  codeed by anand babau  for apply class for customer modules ash css
function modChrome_left_frim_ash($module, &$params, &$attribs)
{
	
	if (!empty ($module->content)) : ?>
		<div class="links_pan">
			<?php if ($module->showtitle) : ?>
				<?php echo $headerLevel; ?>
<div class="head_greybg"><?php echo strtoupper($module->title); ?></div><?php echo $headerLevel; ?>
			<?php endif; ?>
			<div class="likns_pan">
<div class="likns_pan_top green"><?php echo $module->content; ?></div>
<div class="likns_pan_bot"></div>
</div>
		</div><div class="left_menudevider"></div>
	<?php endif;
}
