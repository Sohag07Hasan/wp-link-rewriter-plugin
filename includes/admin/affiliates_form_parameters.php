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
				
				'aff_id' => array(
					'type' 		    => 'text',
					'name' 			=> 'aff_id',
					'description'   => 'Affiliate ID',
					'default'       => ''
				),
				
				
				'url' => array(
					'type' => 'text',
					'name' => 'url',
					'description' => 'Store info Link',
					'example' => ''
				), 
				
				
				'button_text' => array(
					'type' => 'text',
					'name' => 'button_text',
					'description' => 'Button text',
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
					'name' => 'status',
					'description' => 'Enable Ebay?',
					'default' => 'checked'
				),
				
				'aff_id' => array(
					'type' 		    => 'text',
					'name' 			=> 'aff_id',
					'description'   => 'Affiliate ID',
					'default'       => ''
				),
				
				
				'url' => array(
					'type' => 'text',
					'name' => 'url',
					'description' => 'Store info Link',
					'example' => ''
				), 
				
				'button_text' => array(
					'type' => 'text',
					'name' => 'button_text',
					'description' => 'Button text',
					'note' => 'http://www.amazon.com/s/? <input type"text" value="field-keywords=prodct name">'
				),
			)
		),
		
		
		'entertainment_earth' => array(
			'title' => 'Entertainment Earth',
			'description' => 'Entertainment Earth affiliate settings',
			'form' => array(
			
				'status' => array(
					'type' => 'checkbox',
					'name' => 'status',
					'description' => 'Enable Entertainment Earth?',
					'default' => 'checked'
				),
				
				'aff_id' => array(
					'type' 		    => 'text',
					'name' 			=> 'aff_id',
					'description'   => 'Affiliate ID',
					'default'       => ''
				),
				
				
				'url' => array(
					'type' => 'text',
					'name' => 'url',
					'description' => 'Store info Link',
					'example' => ''
				), 
				
				'button_text' => array(
					'type' => 'text',
					'name' => 'button_text',
					'description' => 'Button text',
					'note' => 'http://www.amazon.com/s/? <input type"text" value="field-keywords=prodct name">'
				),
			)
		),
		
		'forbidden_planet' => array(
			'title' => 'Forbidden Planet',
			'description' => 'Forbidden Planet affiliate settings',
			'form' => array(
			
				'status' => array(
					'type' => 'checkbox',
					'name' => 'status',
					'description' => 'Enable Forbidden planet?',
					'default' => 'checked'
				),
				
				'aff_id' => array(
					'type' 		    => 'text',
					'name' 			=> 'aff_id',
					'description'   => 'Affiliate ID',
					'default'       => ''
				),
				
				
				'url' => array(
					'type' => 'text',
					'name' => 'url',
					'description' => 'Store info Link',
					'example' => ''
				), 
				
				'button_text' => array(
					'type' => 'text',
					'name' => 'button_text',
					'description' => 'Button text',
					'note' => 'http://www.amazon.com/s/? <input type"text" value="field-keywords=prodct name">'
				),
			)
		),
		
		
		'hot_topic' => array(
			'title' => 'Hot Topic',
			'description' => 'Hot Topic affiliate settings',
			'form' => array(
			
				'status' => array(
					'type' => 'checkbox',
					'name' => 'status',
					'description' => 'Enable Hot Topic?',
					'default' => 'checked'
				),
				
				'aff_id' => array(
					'type' 		    => 'text',
					'name' 			=> 'aff_id',
					'description'   => 'Affiliate ID',
					'default'       => ''
				),
				
			
				'url' => array(
					'type' => 'text',
					'name' => 'url',
					'description' => 'Store info Link',
					'example' => ''
				), 
				
				'button_text' => array(
					'type' => 'text',
					'name' => 'button_text',
					'description' => 'Button text',
					'note' => 'http://www.amazon.com/s/? <input type"text" value="field-keywords=prodct name">'
				),
			)
		),
		
	); 
	
	
	return $parameters;
 	