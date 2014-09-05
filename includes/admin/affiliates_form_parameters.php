<?php

$parameters = array(
		'amazon' => array(
			'title' => 'Amazon',
			'description' => 'Amazon affiliate settings',
			'form' => array(
			
				'status' => array(
					'type' => 'checkbox',
					'name' => 'status',
					'description' => 'Enable amazon?',
					'default' => 'checked'
				),
				
				/*
				'url' => array(
					'type' => 'text',
					'name' => 'url',
					'description' => 'amazon product search url',
					'example' => ''
				), 
				*/
				
				
				
				'url_structure' => array(
					'type' => 'text',
					'name' => 'url_structure',
					'description' => 'Url structure',
					'note' => 'http://www.amazon.com/s/? <input type"text" value="field-keywords=prodct name">'
				),
			)
		),
		
		
		'ebay' => array(
			'title' => 'Ebay',
			'description' => 'Ebay affiliate settings',
			'form' => array(
			
				'status' => array(
					'type' => 'checkbox',
					'name' => 'enable',
					'description' => 'Enable Ebay?',
					'default' => 'checked'
				),
				
				/*
				'url' => array(
					'type' => 'text',
					'name' => 'url',
					'description' => 'amazon product search url',
					'example' => ''
				), 
				*/
				
				'url_structure' => array(
					'type' => 'text',
					'name' => 'url_structure',
					'description' => 'Url structure',
					'note' => 'http://www.amazon.com/s/? <input type"text" value="field-keywords=prodct name">'
				),
			)
		),
		
	); 
	
	
	return $parameters;
 	