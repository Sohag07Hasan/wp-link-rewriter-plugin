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
				
				'position' => array(
					'type' => 'select',
					'name' => 'position',
					'description' => 'Button Position',
					'default' => '1'
				)
				 
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
				
				'position' => array(
					'type' => 'select',
					'name' => 'position',
					'description' => 'Button Position',
					'default' => '2'
				)
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
				
				'position' => array(
					'type' => 'select',
					'name' => 'position',
					'description' => 'Button Position',
					'default' => '3'
				)
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
				
				'position' => array(
					'type' => 'select',
					'name' => 'position',
					'description' => 'Button Position',
					'default' => '4'
				)
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
				
				'position' => array(
					'type' => 'select',
					'name' => 'position',
					'description' => 'Button Position',
					'default' => '5'
				)
			)
		),
		
		'local_links' => array(
			'title' => 'Local Links',
			'form' => array(
				'status' => array(
					'type' => 'checkbox',
					'name' => 'status',
					'description' => 'Enable Local Links',
					'default' => 'checked'
				),
				
				'position' => array(
					'type' => 'select',
					'name' => 'position',
					'description' => 'Button Position',
					'default' => '6'
				)
			)
		)
		
	); 
	
	
	return $parameters;
 	