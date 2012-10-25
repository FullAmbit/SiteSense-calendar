<?php
function calendar_buildContent($data,$db) {
	$month=$data->output['calendarMonth']=(int)(!empty($_GET['month']) ? $_GET['month'] : date('m'));
	$year=$data->output['calendarYear']=(int)(!empty($_GET['year']) ? $_GET['year'] : date('Y'));
	$data->output['pageTitle']=$data->phrases['calendar']['calendar'].' - '.date('F',mktime(0,0,0,$month,1,$year)).' '.$year;
	$statement=$db->prepare('getEventsByYearMonth','calendar');
	$statement->execute(array(
		':yearMonth' => $year.'-'.$month
	));
	$data->output['events']=array();
	while($event=$statement->fetch(PDO::FETCH_ASSOC)){
		$data->output['events'][$event['eventDate']][]=$event;
	}
}
function calendar_content($data) {
	theme_contentBoxHeader($data->output['pageTitle']);
	calendar_template_buildCalendar(
		$data->output['calendarMonth'],
		$data->output['calendarYear'],
		$data->output['events']);
	theme_contentBoxFooter();
}