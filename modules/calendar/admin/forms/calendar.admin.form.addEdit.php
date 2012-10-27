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
$this->formPrefix='addEdit_';
$this->caption=$data->phrases['calendar']['addEditEvent'];
$this->submitTitle=$data->phrases['calendar']['addEditEvent'];
$this->fromForm='addEdit';
$this->fields=array(
	'title' => array(
		'label' => $data->phrases['calendar']['labelTitle'],
		'required' => true,
		'tag' => 'input',
		'value' => '',
		'params' => array(
			'type' => 'text',
			'size' => 128
		),
		'description' => '
			<p>
				<b>'.$data->phrases['calendar']['labelTitle'].'</b><br />
			</p>
		',
		'cannotEqual'=>'',
	),
	'eventDate' => array(
		'label' => $data->phrases['calendar']['labelEventDate'],
		'required' => true,
		'tag' => 'input',
		'value' => 'YYYY-MM-DD HH:MM:SS',
		'params' => array(
			'type' => 'text',
			'size' => 19
		),
		'description' => '
			<p>
				<b>'.$data->phrases['calendar']['labelEventDate'].'</b><br />
			</p>
		',
		'cannotEqual'=>'',
	),
	'description' => array(
		'label' => $data->phrases['calendar']['labelDescription'],
		'tag' => 'textarea',
		'required' => true,
		'value' => '',
		'useEditor' => true,
		'params' => array(
			'cols' => 40,
			'rows' => 20
		),
		'description' => '
			<p>
				<b>'.$data->phrases['calendar']['labelDescription'].'</b><br />
			</p>
		',
		'addEditor' => $data->jsEditor->addEditor($this->formPrefix.'description')
	),
	'url' => array(
		'label' => $data->phrases['calendar']['labelUrl'],
		'required' => false,
		'tag' => 'input',
		'value' => '',
		'params' => array(
			'type' => 'text',
			'size' => 128
		),
		'description' => '
			<p>
				<b>'.$data->phrases['calendar']['labelUrl'].'</b><br />
			</p>
		',
	),
	'live' => array(
		'label' => $data->phrases['calendar']['labelLive'],
		'tag' => 'input',
		'checked' => '',
		'params' => array(
			'type' => 'checkbox'
		),
		'description' => '
			<p>
				<b>'.$data->phrases['calendar']['labelLive'].'</b><br />
			</p>
		'
	)
);