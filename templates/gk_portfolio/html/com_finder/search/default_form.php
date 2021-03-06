<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_finder
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

if(!function_exists('isJoomla4')){
  function isJoomla4() {
    return version_compare(JVERSION, '4.0', 'ge');
  }
}

if(isJoomla4()) {
	if ($this->params->get('show_autosuggest', 1)) {
		JHtml::_('script', 'vendor/awesomplete/awesomplete.min.js', array('version' => 'auto', 'relative' => true));
		JFactory::getDocument()->addScriptOptions('finder-search', array('url' => JRoute::_('index.php?option=com_finder&task=suggestions.suggest&format=json&tmpl=component')));
	}
} else {
	if ($this->params->get('show_advanced', 1) || $this->params->get('show_autosuggest', 1))
	{
	  JHtml::_('jquery.framework');

	  $script = "
	jQuery(function() {";
	  if ($this->params->get('show_advanced', 1))
	  {
	    /*
	    * This segment of code disables select boxes that have no value when the
	    * form is submitted so that the URL doesn't get blown up with null values.
	    */
	    $script .= "
	  jQuery('#finder-search').on('submit', function(e){
	    e.stopPropagation();
	    // Disable select boxes with no value selected.
	    jQuery('#advancedSearch').find('select').each(function(index, el) {
	      var el = jQuery(el);
	      if(!el.val()){
	        el.attr('disabled', 'disabled');
	      }
	    });
	  });";
	  }
	  /*
	  * This segment of code sets up the autocompleter.
	  */
	  if ($this->params->get('show_autosuggest', 1))
	  {
	    JHtml::_('script', 'media/jui/js/jquery.autocomplete.min.js', false, false, false, false, true);

	    $script .= "
	  var suggest = jQuery('#q').autocomplete({
	    serviceUrl: '" . JRoute::_('index.php?option=com_finder&task=suggestions.suggest&format=json&tmpl=component', false) . "',
	    paramName: 'q',
	    minChars: 1,
	    maxHeight: 400,
	    width: 300,
	    zIndex: 9999,
	    deferRequestBy: 500
	  });
	  
	  var wrap = jQuery('#advancedSearch');
	  wrap.css('display', 'block');
	  wrap.hide();
	  var wrap_state = false;
	  
	  jQuery('#advancedSearch-btn').click(function() {
	    if(wrap_state) {
	      wrap.hide();
	      wrap_state = false;
	    } else {
	      wrap.show();
	      wrap_state = true;
	    }
	  });
	  ";
	  }

	  $script .= "
	});";

	  JFactory::getDocument()->addScriptDeclaration($script);
	}
}
?>

<form id="finder-search" action="<?php echo JRoute::_($this->query->toURI()); ?>" method="get" class="search__form">
	<?php echo $this->getFields(); ?>

	<?php //DISABLED UNTIL WEIRD VALUES CAN BE TRACKED DOWN. ?>
	<?php if (false && $this->state->get('list.ordering') !== 'relevance_dsc') : ?>
		<input type="hidden" name="o" value="<?php echo $this->escape($this->state->get('list.ordering')); ?>">
	<?php endif; ?>

	<div class="search__inputs">
		<div class="input-group">
			<input type="text" name="q" class="js-finder-search-query form-control" value="<?php echo $this->escape($this->query->input); ?>">
			<span class="input-group-btn">
			<?php if ($this->escape($this->query->input) != '' || $this->params->get('allow_empty_query')) : ?>
				<button name="Search" type="submit" class="btn btn-primary">
          <span class="fa fa-search icon-white"></span>
          <?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>
      	</button>
			<?php else : ?>
				<button name="Search" type="submit" class="btn btn-primary disabled">
            <span class="fa fa-search icon-white"></span>
            <?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>
        </button>
			<?php endif; ?>
			<?php if ($this->params->get('show_advanced', 1)) : ?>
				<a  id="advancedSearch-btn" href="#advancedSearch" data-toggle="collapse" class="btn btn-secondary" aria-hidden="true">
					<span class="fa fa-search-plus" aria-hidden="true"></span>
         <?php echo JText::_('COM_FINDER_ADVANCED_SEARCH_TOGGLE'); ?></a>
			<?php endif; ?>
			</span>
		</div>
	</div>

	<?php if ($this->params->get('show_advanced', 1)) : ?>
		<div id="advancedSearch" class="js-finder-advanced collapse<?php if ($this->params->get('expand_advanced', 0)) echo ' show'; ?>">
			<?php if ($this->params->get('show_advanced_tips', 1)) : ?>
				<div class="card card-outline-secondary mb-3">
					<div class="card-body">
						<?php echo JText::_('COM_FINDER_ADVANCED_TIPS'); ?>
					</div>
				</div>
			<?php endif; ?>
			<div id="finder-filter-window">
				<?php echo JHtml::_('filter.select', $this->query, $this->params); ?>
			</div>
		</div>
	<?php endif; ?>
</form>
