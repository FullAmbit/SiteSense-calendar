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
common_include('libraries/forms.php');
function admin_calendarBuild($data,$db) {
	if(!checkPermission('addEdit','calendar',$data)) {
		$data->output['abortMessage'] = '<h2>Insufficient User Permissions</h2>You do not have the permissions to access this area.';
		return;
	}
	$statement=$db->prepare('getEventById','admin_calendar');
	$statement->execute(array(
		':id' => $data->action[3]
	));
	$data->output['event']=$item=$statement->fetch();
	if(!$item){
		$data->output['abortMessage'] = 'Event not found.';
		return;
	}
	$data->output['addEdit']= $form = new formHandler('addEdit',$data,true);
	foreach ($data->output['addEdit']->fields as $key => $value) {
		if ((!empty($value['params']['type'])) && ($value['params']['type']=='checkbox')){
			$data->output['addEdit']->fields[$key]['checked']= ($item[$key] ? 'checked' : '');
		} elseif($key!=='eventTime') {
			$data->output['addEdit']->fields[$key]['value']=$item[$key];
		}
	}
	$data->output['addEdit']->fields['description']['value']=html_entity_decode($data->output['addEdit']->fields['description']['value'],ENT_QUOTES,'UTF-8');
	list($data->output['addEdit']->fields['eventDate']['value'],
		$data->output['addEdit']->fields['eventTime']['value'])=explode(' ',$item['eventDate'],2);
	if ((!empty($_POST['fromForm'])) && ($_POST['fromForm']==$data->output['addEdit']->fromForm)) {
		$data->output['addEdit']->populateFromPostData();
		// Validate Form
		if ($data->output['addEdit']->validateFromPost()) {
			$data->output['addEdit']->sendArray[':eventDate'].=' '.$data->output['addEdit']->sendArray[':eventTime'];
			unset($data->output['addEdit']->sendArray[':eventTime']);
			$statement=$db->prepare('updateEventById','admin_calendar');
			$data->output['addEdit']->sendArray[':id']=$data->action[3];
			$statement->execute($data->output['addEdit']->sendArray);
			$data->output['savedOkMessage']='<h2>Values Saved Successfully</h2>';
		} else {
			$data->output['secondSidebar']='
				<h2>Error in Data</h2>
				<p>
					There were one or more errors. Please correct the fields with the red X next to them and try again.
				</p>';
		}
	}
}
function admin_calendarShow($data) {
	if (!empty($data->output['savedOkMessage'])) {
		echo $data->output['savedOkMessage'];
	} else {
		theme_buildForm($data->output['addEdit']);
	}
}