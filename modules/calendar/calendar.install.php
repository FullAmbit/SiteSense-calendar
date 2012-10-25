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
function calendar_settings() {
	return array(
		'name'      => 'calendar',
		'shortName' => 'calendar',
		'version'   => '1.0'
	);
}
function calendar_install($db,$drop=false,$firstInstall=false,$lang='en_us') {
	$structures=array(
		'events' => array(
			'id'                    => SQR_IDKey,
			'title'                 => SQR_title,
			'eventDate'             => SQR_time,
			'description'           => 'MEDIUMTEXT NOT NULL',
			'url'                   => SQR_title,
			'live'			        => SQR_boolean,
			'KEY `eventDate_title` (`eventDate`,`title`)'
		),
		'event_attributes' => array(
			'event'                 => SQR_ID,
			'attribute'             => SQR_title,
			'value'                 => 'MEDIUMTEXT NOT NULL',
		),
	);
	if($drop)
		calendar_uninstall($db,$lang);

	$db->createTable('events',$structures['events']);
	$db->createTable('event_attributes',$structures['events_attributes']);
}
function calendar_uninstall($db,$lang='en_us') {
	$db->dropTable('events',$lang);
	$db->dropTable('event_attributes');
}