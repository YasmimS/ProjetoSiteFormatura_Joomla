<?php
/**
* @version   1.0.1
* @package   Phoca Guestbook
* @copyright 2017-20 StanisLaw.ru
* @license   GNU/GPL
*/

defined('_JEXEC') or die;?>

<?php foreach ($list as $item):?>
<div class="mod_phocaguestbook<?php echo $params->get('moduleclass_sfx');?>">
  <?php echo $item->date;?> <b><?php echo $item->username;?></b> <?php echo JText::_('MOD_PHOCAGUESTBOOK_ITEMS_WROTE');?>:
  <blockquote><?php echo $item->content;?></blockquote>
</div>
<?php endforeach;?>
