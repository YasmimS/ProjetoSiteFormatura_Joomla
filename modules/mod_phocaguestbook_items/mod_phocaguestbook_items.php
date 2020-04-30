<?php
/**
* @version   1.0.1
* @package   Phoca Guestbook
* @copyright 2017-20 StanisLaw.ru
* @license   GNU/GPL
*/

defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once (dirname(__FILE__).'/helper.php');

$list = modPhocaGuestbook::getList($params);
require(JModuleHelper::getLayoutPath('mod_phocaguestbook_items'));

?>
