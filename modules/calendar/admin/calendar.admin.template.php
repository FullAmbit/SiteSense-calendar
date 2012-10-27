<?php
function admin_calendar_template_wrapper($data){
	echo '<div class="buttonList">
		<a href="',$data->linkRoot,'admin/calendar/list">',$data->phrases['calendar']['listEvents'],'</a>
		<a href="',$data->linkRoot,'admin/calendar/add">',$data->phrases['calendar']['addEvent'],'</a>
		<a href="',$data->linkRoot,'calendar">',$data->phrases['calendar']['viewCalendar'],'</a>
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