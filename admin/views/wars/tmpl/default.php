<?php
/*------------------------------------------------------------------------
# com_squadmanagement - Squadmanagement!
# ------------------------------------------------------------------------
# author    Lars Hildebrandt
# copyright Copyright (C) 2014 Lars Hildebrandt. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.larshildebrandt.de
# Technical Support:  Forum - http://www..larshildebrandt.de/forum/
-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// load tooltip behavior
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
JHtml::_('formbehavior.chosen', 'select');

$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base().'components/com_squadmanagement/style/admin.css');

$app		= JFactory::getApplication();
$user		= JFactory::getUser();
$userId		= $user->get('id');
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$ordering 	= ($listOrder == 'a.ordering');
$canChange  = true; 
$canOrder	= $user->authorise('core.edit.state',	'com_squadmanagement');
$saveOrder 	= ($listOrder == 'a.ordering' && $listDirn == 'asc');
if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_squadmanagement&task=wars.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'articleList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}
$sortFields = $this->getSortFields();
?>
<script type="text/javascript">
	Joomla.orderTable = function() 
	{
		table = document.getElementById("sortTable");
		direction = document.getElementById("directionTable");
		order = table.options[table.selectedIndex].value;
		if (order != '<?php echo $listOrder; ?>')
		{
			dirn = 'asc';
		} 
		else 
		{
			dirn = direction.options[direction.selectedIndex].value;
		}
		Joomla.tableOrdering(order, dirn, '');
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_squadmanagement&view=wars'); ?>" method="post" name="adminForm" id="adminForm">
	<?php if (!empty( $this->sidebar)): ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
</div>
<div id="j-main-container" class="span10">
	<?php else : ?>
<div id="j-main-container">
	<?php endif;?>
		<div id="filter-bar" class="btn-toolbar">
			<div class="filter-search btn-group pull-left">
				<label for="filter_search" class="element-invisible"><?php echo JText::_('COM_SQUADMANAGEMENT_ITEMS_SEARCH_FILTER');?></label>
				<input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('COM_SQUADMANAGEMENT_ITEMS_SEARCH_FILTER'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_TAGS_ITEMS_SEARCH_FILTER'); ?>" />
			</div>
			<div class="btn-group hidden-phone">
				<button class="btn tip" type="submit" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
				<button class="btn tip" type="button" onclick="document.id('filter_search').value='';this.form.submit();" title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>"><i class="icon-remove"></i></button>
			</div>
			<div class="btn-group pull-right hidden-phone">
				<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
				<?php echo $this->pagination->getLimitBox(); ?>
			</div>
			<div class="btn-group pull-right hidden-phone">
				<label for="directionTable" class="element-invisible"><?php echo JText::_('JFIELD_ORDERING_DESC');?></label>
				<select name="directionTable" id="directionTable" class="input-medium" onchange="Joomla.orderTable()">
					<option value=""><?php echo JText::_('JFIELD_ORDERING_DESC');?></option>
					<option value="asc" <?php if ($listDirn == 'asc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_ASCENDING');?></option>
					<option value="desc" <?php if ($listDirn == 'desc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_DESCENDING');?></option>
				</select>
			</div>
			<div class="btn-group pull-right">
				<label for="sortTable" class="element-invisible"><?php echo JText::_('JGLOBAL_SORT_BY');?></label>
				<select name="sortTable" id="sortTable" class="input-medium" onchange="Joomla.orderTable()">
					<option value=""><?php echo JText::_('JGLOBAL_SORT_BY');?></option>
					<?php echo JHtml::_('select.options', $sortFields, 'value', 'text', $listOrder);?>
				</select>
			</div>
			<div class="clearfix"></div>
		</div>		
	
	<table class="table table-striped" id="articleList">
		<thead>
			<tr>
				<th width="20">
					<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
				</th>			
				<th style="text-align:left">
					<?php echo JHtml::_('grid.sort', 'COM_SQUADMANAGEMENT_WAR_HEADING_WARDATETIME', 'a.wardatetime', $listDirn, $listOrder); ?>
				</th>	
				<th style="text-align:left">
					<?php echo JHtml::_('grid.sort', 'COM_SQUADMANAGEMENT_WAR_HEADING_STATE', 'a.state', $listDirn, $listOrder); ?>
				</th>				
				<th></th>
				<th style="text-align:left">
					<?php echo JHtml::_('grid.sort', 'COM_SQUADMANAGEMENT_WAR_HEADING_SQUAD', 'squad', $listDirn, $listOrder); ?>
				</th>	
				<th></th>
				<th style="text-align:left" class="nowrap hidden-phone">
					<?php echo JHtml::_('grid.sort', 'COM_SQUADMANAGEMENT_WAR_HEADING_OPPONENT', 'opponent', $listDirn, $listOrder); ?>
				</th>	
				<th style="text-align:left" class="nowrap hidden-phone">
					<?php echo JHtml::_('grid.sort', 'COM_SQUADMANAGEMENT_WAR_HEADING_LEAGUE', 'league', $listDirn, $listOrder); ?>
				</th>
				<th style="text-align:left" class="nowrap hidden-phone">
					<?php echo JHtml::_('grid.sort', 'COM_SQUADMANAGEMENT_WAR_HEADING_SCORE', 'score', $listDirn, $listOrder); ?>
				</th>
				<th style="text-align:left" class="nowrap hidden-phone">
					<?php echo JHtml::_('grid.sort', 'COM_SQUADMANAGEMENT_WAR_HEADING_SCOREOPPONENT', 'scoreopponent', $listDirn, $listOrder); ?>
				</th>
				<th class="nowrap">
					<?php echo JHtml::_('grid.sort', 'JSTATUS', 'a.published', $listDirn, $listOrder); ?>
				</th>
				<th width="1%" class="nowrap">
					<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
				</th>
			</tr>	
		</thead>
		<tbody>
			<?php foreach($this->items as $i => $item): ?>
			<?php
				$pageNav = $this->pagination;
			?>
			<tr class="row<?php echo $i % 2; ?>">
				<td>
					<?php echo JHtml::_('grid.id', $i, $item->id); ?>
				</td>			
				<td class="nowrap" style="text-align:center;">
					<a href="<?php echo JRoute::_('index.php?option=com_squadmanagement&task=war.edit&id=' . $item->id); ?>">
						<?php 
						
						$wardatetime = JHtml::_('date', $item->wardatetime, JText::_('DATE_FORMAT_LC4'));
						echo $wardatetime; 
						
						?>
					</a>
				</td>
				<td>
					<?php 
					
					if ($item->state == 0)
					{
						echo JText::_('ALL_SQUADMANAGEMENT_WARS_STATE_SCHEDULED');
					}
					elseif ($item->state == 1)
					{
						echo JText::_('ALL_SQUADMANAGEMENT_WARS_STATE_PLAYED');	
					}	
					else
					{
						echo JText::_('ALL_SQUADMANAGEMENT_WARS_STATE_CHALLENGED');	
					}					
					?>
				</td>	
				<td style="text-align:center;">
				<?php
				if ($item->squadlogo != '')
				{
					echo '<img src="'.JURI::root().$item->squadlogo.'" alt="' . $item->squad . '" style="height:20px;width:20px;max-width: none;"/>'; 	
				}
				else
				{
					echo '<img src="'.JURI::root().'components/com_squadmanagement/images/defaultfieldimage.png" alt="' . $item->squad . '" style="height:20px;width:20px;max-width: none;"/>'; 		
				}
				?>
</td>
<td>
					<?php echo $item->squad; ?>
</td>
<td style="text-align:center;">
				<?php
				if ($item->opponentlogo != '')
				{
					echo '<img src="'.JURI::root().$item->opponentlogo.'" alt="' . $item->opponent . '" style="height:20px;width:20px;max-width: none;"/>'; 	
				}
				else
				{
					echo '<img src="'.JURI::root().'components/com_squadmanagement/images/defaultfieldimage.png" alt="' . $item->opponent . '" style="height:20px;width:20px;max-width: none;"/>'; 		
				}
				?>
				</td>
				<td class="nowrap hidden-phone">
					<?php echo $item->opponent; ?>
				</td>
				<td class="nowrap hidden-phone">
					<?php echo $item->league; ?>
				</td>				
				<td class="nowrap hidden-phone">
					<?php echo $item->score; ?>
				</td>
				<td class="nowrap hidden-phone">
					<?php echo $item->scoreopponent; ?>
				</td>
				<td class="center">
					<?php echo JHtml::_('jgrid.published', $item->published, $i, 'leagues.'); ?>
				</td>
				<td align="center">
					<?php echo $item->id; ?>
				</td>
			</tr>
			<?php endforeach; ?>	
		</tbody>
		<tfoot>
			<tr>
				<td colspan="12"><?php echo $this->pagination->getListFooter(); ?></td>
			</tr>
		</tfoot>
	</table>
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
	<?php echo JHtml::_('form.token'); ?>
</form>
