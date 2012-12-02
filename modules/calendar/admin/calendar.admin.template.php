<?php
function admin_calendar_template_wrapper($data){
	echo '<div class="buttonList">
		<a href="',$data->linkRoot,'admin/calendar/list">',$data->phrases['calendar']['listEvents'],'</a>
		<a href="',$data->linkRoot,'admin/calendar/add">',$data->phrases['calendar']['addEvent'],'</a>
		<a href="',$data->linkRoot,'admin/calendar/view">',$data->phrases['calendar']['viewCalendar'],'</a>
	</div>';
}
function admin_calendar_template_listEvents($data){
	echo '<table class="pagesList">
		<thead>
			<tr>
				<th>',$data->phrases['calendar']['labelTitle'],'</th>
				<th>',$data->phrases['calendar']['labelEventDate'],'</th>
				<th>',$data->phrases['calendar']['labelLive'],'</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>';
	foreach($data->output['events'] as $event){
		echo '<tr>
			<td>',$event['title'],'</td>
			<td>',$event['eventDate'],'</td>
			<td>',($event['live']?$data->phrases['core']['yes']:$data->phrases['core']['no']),'</td>
			<td class="buttonList">
				<a href="',$data->linkRoot,'admin/calendar/edit/',$event['id'],'">',$data->phrases['calendar']['editEvent'],'</a>
				<a href="',$data->linkRoot,'admin/calendar/delete/',$event['id'],'">',$data->phrases['calendar']['deleteEvent'],'</a>
			</td>
		</tr>';
	}
	echo '</tbody>
	</table>';
}
function admin_calendar_template_buildCalendar($data,$month,$year,$events){
	$select_month_control = '<select name="month" id="month">';
	for($x = 1; $x <= 12; $x++) {
		$select_month_control.= '
	<option value="'.$x.'"'.($x != $month ? '' : ' selected="selected"').'>'.date('F',mktime(0,0,0,$x,1,$year)).'</option>';
	}
	$select_month_control.= PHP_EOL.'</select>';
	$year_range = 7;
	$select_year_control = PHP_EOL.'<select name="year" id="year">';
	for($x = ($year-floor($year_range/2)); $x <= ($year+floor($year_range/2)); $x++) {
		$select_year_control.= '
	<option value="'.$x.'"'.($x != $year ? '' : ' selected="selected"').'>'.$x.'</option>';
	}
	$select_year_control.= PHP_EOL.'</select>';
	$next_month_link = '<a href="?month='.($month != 12 ? $month + 1 : 1).'&amp;year='.($month != 12 ? $year : $year + 1).'" class="control">Next Month &gt;&gt;</a>';
	$previous_month_link = '<a href="?month='.($month != 1 ? $month - 1 : 12).'&amp;year='.($month != 1 ? $year : $year - 1).'" class="control">&lt;&lt; Previous Month</a>';
	/* bringing the controls together */
	$controls = '<form method="get">
	'.$select_month_control.$select_year_control.PHP_EOL.'<input type="submit" value="Go" /> '.$previous_month_link.' '.$next_month_link.'</form>';
	echo '<div style="float:left;">'.$controls.'</div>';
	/* draw table */
	$calendar = '<table cellpadding="0" cellspacing="0" class="calendar pagesList">';
	/* table headings */
	$headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
	$calendar.='<caption>'.date('F',mktime(0,0,0,$month,1,$year)).' '.$year.'</caption>';
	$calendar.= '<tr class="calendar-row"><th class="calendar-day-head">'.implode('</th>	<th class="calendar-day-head">',$headings).'</th></tr>';
	/* days and weeks vars now ... */
	$running_day = date('w',mktime(0,0,0,$month,1,$year));
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();
	/* row for week one */
	$calendar.= '<tr class="calendar-row">';
	/* print "blank" days until the first of the current week */
	for($x = 0; $x < $running_day; $x++){
		$calendar.= '<td class="calendar-day-np">&nbsp;</td>';
		$days_in_this_week++;
	}
	/* keep going with days.... */
	for($list_day = 1; $list_day <= $days_in_month; $list_day++){
		$calendar.= '	<td class="calendar-day"><div style="position:relative;height:100px;">';
		/* add in the day number */
		$calendar.= '<div class="day-number">'.$list_day.'</div>';
		$event_day = $year.'-'.$month.'-'.$list_day;
		if(isset($events[$event_day])) {
			foreach($events[$event_day] as $event) {
			$calendar.= '<div class="event">
				<a href="'.$data->linkRoot.'admin/calendar/edit/'.$event['id'].'">'.$event['title'].'</a>
			</div>';
			}
		}
		else {
			$calendar.= str_repeat('<p>&nbsp;</p>',2);
		}
		$calendar.= '</div></td>';
		if($running_day == 6){
			$calendar.= '</tr>';
			if(($day_counter+1) != $days_in_month){
				$calendar.= '<tr class="calendar-row">';
			}
			$running_day = -1;
			$days_in_this_week = 0;
		}
		$days_in_this_week++; $running_day++; $day_counter++;
	}
	/* finish the rest of the days in the week */
	if($days_in_this_week < 8){
		for($x = 1; $x <= (8 - $days_in_this_week); $x++){
		$calendar.= '<td class="calendar-day-np">&nbsp;</td>';
		}
	}
	/* final row */
	$calendar.= '</tr>';
	/* end the table */
	$calendar.= '</table>';
	$calendar = str_replace('</td>','</td>'."\n",$calendar);
	$calendar = str_replace('</tr>','</tr>'."\n",$calendar);
	/* all done, return result */
	echo '<br/><br/>'.$calendar;
}