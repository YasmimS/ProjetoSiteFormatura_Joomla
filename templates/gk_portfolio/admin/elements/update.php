<?php

defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');
jimport('joomla.version');

class JFormFieldUpdate extends JFormField {
	protected $type = 'Update';

	protected function getInput() {
		$doc = JFactory::getDocument();
		$config = JFactory::getConfig();
		$secret = $config->get('secret');
		$phpVersion = phpversion();
		$verify = md5(md5(md5(md5(md5($secret . strtotime(date('Y-m-d H:00:00')))))));

		$doc->addScriptOptions('gkparams', array('token' => $verify, 'juri_root' => JUri::root()));

		$jversion = new JVersion;
		$jver = $jversion->getShortVersion();
	
		$base_path = str_replace('admin'.DS.'elements', '', dirname(__FILE__)).'templateDetails.xml';
		$xml = simplexml_load_file($base_path);
		$version = (string) $xml->version;
		$info = pathinfo((string) $xml->updateservers->server);
		$tpl = $info['filename'];
		
		$html = '<div style="display:none;" id="gk_template_updates" data-tpl="'.$tpl.'" data-gktplversion="'.$version.'" data-jversion="'.$jver.'"></div>';
		return $html;
	}
}