<?php
/*------------------------------------------------------------------------
# mod_quickpublish - Quick Article Publish
# ------------------------------------------------------------------------
# author    Codeboxr
# copyright Copyright (C) 2014 codeboxr.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://codeboxr.com
# Technical Support:  Forum - http://codeboxr.com/product/joomla-quick-publish-admin-module
-------------------------------------------------------------------------*/
//error_reporting(E_ALL);
//ini_set("display_errors", 1);


defined('_JEXEC') or die;



$language = JFactory::getLanguage();
$language->load('com_content', JPATH_ADMINISTRATOR, 'en-GB', true);
$language->load('com_content', JPATH_ADMINISTRATOR, null, true);

//$language->load('mod_quickpublish', JPATH_ADMINISTRATOR, 'en-GB', true);
//$language->load('mod_quickpublish', JPATH_ADMINISTRATOR, null, true);

// Include the mod_popular functions only once.
require_once __DIR__ . '/helper.php';


// Render the module
require JModuleHelper::getLayoutPath('mod_quickpublish', $params->get('layout', 'default'));