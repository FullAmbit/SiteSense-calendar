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
function admin_calendarBuild($data, $db) {
	if (!checkPermission('addEdit','calendar',$data)) {
		$data->output['abortMessage'] = '<h2>Insufficient User Permissions</h2>You do not have the permissions to access this area.';
		return;
	}
	$data->output['addEdit']=new formHandler('addEdit',$data,true);
	if ((!empty($_POST['fromForm'])) && ($_POST['fromForm']==$data->output['addEdit']->fromForm)) {
		$data->output['addEdit']->populateFromPostData();
		if ($data->output['addEdit']->validateFromPost()){
			$data->output['addEdit']->sendArray[':description']=htmlentities($data->output['addEdit']->sendArray[':description'],ENT_QUOTES,'UTF-8');
			$statement=$db->prepare('insertEvent','admin_calendar');
			if ($statement->execute($data->output['addEdit']->sendArray)) {
				$data->output['savedOkMessage']='
				<h2>Values Saved Successfully</h2>';
			} else {
				var_dump($statement->errorInfo());
				$data->output['secondSidebar']='
				<h2>Error in Data</h2>
				<p>
					There were one or more errors. Please correct the fields with the red X next to them and try again.
				</p>';
			}
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