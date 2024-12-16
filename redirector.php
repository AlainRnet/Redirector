<?php
/**
 * @copyright	Copyright (c) 2015 system. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Factory;

/**
 * system - redirector Plugin
 *
 * @package		Joomla.Plugin
 * @subpakage	system.redirector
 */
class plgsystemredirector extends CMSPlugin {

	/**
	 * Constructor.
	 *
	 * @param 	$subject
	 * @param	array $config
	 */
	function __construct(&$subject, $config = array()) {
		// call parent constructor
		parent::__construct($subject, $config);
	}
	function onAfterInitialise() {
		$app = Factory::getApplication();
		if ($app->isClient('administrator')) {
			return true;
		}
		$links = ($this->params->get('link_to_link', array()));
		foreach($links as $link) {
			if ($link->text == $_SERVER['REQUEST_URI'] or str_replace(JURI::root(), '', $link->text) == $_SERVER['REQUEST_URI']) {
				header($this->params->get('header', 'HTTP/1.1 301 Moved Permanently'));
				header('Location: ' . $link->link);
				header('Content-Type: text/html; charset=' . $app->charSet);
				$app->close();
			}
		}
	}
}
