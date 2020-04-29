<?php 
defined('_JEXEC') or die;

$input = JFactory::getApplication()->input;
$template = $input->get('template');
$token = $input->get('token');

if (!$template) {
	die('template error');
}

$config = JFactory::getConfig();
$secret = $config->get('secret');
$phpVersion = phpversion();
$verify = md5(md5(md5(md5(md5($secret . strtotime(date('Y-m-d H:00:00')))))));
if ($token !== $verify) {
	die('token error');
}

$file = __DIR__ . '/templateDetails.xml';
$xml = simplexml_load_file($file);
$version = (string) $xml->version;

$updateServer = (string) $xml->updateservers->server;

$xmlUpdate = @simplexml_load_file($updateServer);
if (!$xmlUpdate) {
	die('xml error');
}

$newVersion = (string) $xmlUpdate->update->version;

$response = array();
if (version_compare($version, $newVersion, 'ge')) {
	$response['updated'] = true;
	$response['msg'] = '<div class="gk-msg gk-updated">You are using latest version of Gavick Template.</div>';
} else {
	$response['updated'] = false;
	$response['msg'] = '<div calss="gk-msg gk-error">New version of this template is available. Please check the upgrade instruction <a target="_blank" href="http://www.joomlart.com/update-steps">HERE</a>.</div>';
}

die(json_encode($response));