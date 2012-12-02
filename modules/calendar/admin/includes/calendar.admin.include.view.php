<?php
/*
* SiteSense
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@sitesense.org so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade SiteSense to newer
* versions in the future. If you wish to customize SiteSense for your
* needs please refer to http://www.sitesense.org for more information.
*
* @author     Full Ambit Media, LLC <pr@fullambit.com>
* @copyright  Copyright (c) 2011 Full Ambit Media, LLC (http://www.fullambit.com)
* @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
function admin_calendarBuild($data,$db) {
	$month=$data->output['calendarMonth']=(int)(!empty($_GET['month']) ? $_GET['month'] : date('m'));
	$year=$data->output['calendarYear']=(int)(!empty($_GET['year']) ? $_GET['year'] : date('Y'));
	$statement=$db->prepare('getEventsByYearMonth','admin_calendar');
	$statement->execute(array(
		':yearMonth' => '%'.$year.'-'.$month.'%'
	));
	$data->output['events']=array();
	while($event=$statement->fetch(PDO::FETCH_ASSOC)){
		$data->output['events'][$event['eventDate']][]=$event;
	}
}
function admin_calendarShow($data) {
	admin_calendar_template_buildCalendar($data,$data->output['calendarMonth'],$data->output['calendarYear'],$data->output['events']);
}