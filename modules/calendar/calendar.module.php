<?php
function calendar_buildContent($data,$db) {
	switch($data->action[1]){
		case 'event':
			$statement=$db->prepare('getEventById','calendar');
			$statement->execute(array(
				':id' => $data->action[2]
			));
			$data->output['event']=$statement->fetch(PDO::FETCH_ASSOC);
			$data->output['pageTitle']=$data->output['event']['title'];
			break;
		default:
			$month=$data->output['calendarMonth']=(int)(!empty($_GET['month']) ? $_GET['month'] : date('m'));
			$year=$data->output['calendarYear']=(int)(!empty($_GET['year']) ? $_GET['year'] : date('Y'));
			$data->output['pageTitle']=$data->phrases['calendar']['calendar'].' - '.date('F',mktime(0,0,0,$month,1,$year)).' '.$year;
			$statement=$db->prepare('getEventsByYearMonth','calendar');
			$statement->execute(array(
				':yearMonth' => '%'.$year.'-'.$month.'%'
			));
			$data->output['events']=array();
			while($event=$statement->fetch(PDO::FETCH_ASSOC)){
				$data->output['events'][$event['eventDate']][]=$event;
			}
			break;
	}
}
function calendar_content($data) {
	switch($data->action[1]){
		case 'event':
			theme_contentBoxHeader($data->output['pageTitle']);
			calendar_template_showEvent($data->output['event']);
			theme_contentBoxFooter();
			break;
		default:
			theme_contentBoxHeader($data->output['pageTitle']);
			calendar_template_buildCalendar(
				$data,
				$data->output['calendarMonth'],
				$data->output['calendarYear'],
				$data->output['events']);
			theme_contentBoxFooter();
			break;
	}
}