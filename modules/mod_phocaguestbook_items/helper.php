<?php
/**
* @version   1.0.1
* @package   Phoca Guestbook
* @copyright 2017-20 StanisLaw.ru
* @license   GNU/GPL
*/

defined('_JEXEC') or die;

require_once (JPATH_SITE.'/components/com_content/helpers/route.php');

class modPhocaGuestbook
 {

  function getList(&$params)
   {

    global $mainframe;
    $db = JFactory::getDbo();
    $user = JFactory::getUser();
    $userId = (int) $user->get('id');
    $count = (int) $params->get('count', 5);
    $trunc = (int) $params->get('truncate', 30);
    $gbid = trim($params->get('gbid'));
    $dateformat = trim($params->get('datef','d.m.Y H:i'));
    $aid = $user->get('aid', 0);
    $contentConfig = &JComponentHelper::getParams('com_content');
    $access = !$contentConfig->get('shownoauth');
    $nullDate = $db->getNullDate();
    $date = JFactory::getDate();
    $now = $date->toSQL();
    $where = '(1 = 1)';

    // Ordering
    switch ($params->get('ordering'))
     {
      case 'f_dsc':
       $ordering = 'p.date DESC'; // p.date, b.ordering
       break;
      case 'l_dsc':
      default:
       $ordering = 'p.date'; // p.date DESC, b.ordering
       break;
     };

    if ($gbid)
     {
      $ids = explode(',', $gbid);
      JArrayHelper::toInteger($ids);
      $catCondition = ' AND (p.catid = ' . implode(' OR p.catid = ', $ids) . ')';
     };

    // Content Items only
    $query =
     'SELECT p.* ' .
     'FROM ' .
      '#__phocaguestbook_items AS p JOIN ' .
      '#__categories AS b ON b.id = p.catid ' .
     'WHERE ' .
      $where . ' AND ' .
      '(p.id > 0) ' .
      ($gbid ? $catCondition : '') .
      /*($access ? ' AND (b.access <= '.(int)$aid.')' : '') .*/ ' AND ' .
      '(p.published = 1) AND ' .
      '(b.published = 1) ' .
     'ORDER BY ' . $ordering;

    $db->setQuery($query, 0, $count);
    $rows = $db->loadObjectList();

    $i = 0;
    $lists  = array();

    foreach ($rows as $row)
     {

      $lists[$i] = new stdClass();

      $date = JFactory::getDate($row->date);
      $content = $row->content;
      $content = str_replace('<br/>', ' ', $content);
      $content = str_replace('<p>', ' ', $content);

      $lists[$i]->date = $date->Format($dateformat); // d.m.Y H:i
      $lists[$i]->username = htmlspecialchars($row->username);
      $lists[$i]->title = htmlspecialchars($row->title);
      $lists[$i]->content = ltrim(mb_substr(htmlspecialchars(strip_tags($content)), 0, $trunc)) . '…';

      $i++;

     };

    return $lists;

   }

 };

?>
