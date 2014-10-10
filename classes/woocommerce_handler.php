<?php 
/**
 * this class is to keep relation wih woocommerce
 */
 
 class LinkRewriterWithWoocommerce{
 	
	function init(){
		//add_action('woocommerce_product_meta_end', array(__CLASS__, 'include_affiliates_below_meta'));
		add_filter('woocommerce_loop_add_to_cart_link', array(__CLASS__, 'woocommerce_loop_add_to_cart_link'), 100, 2);
	}
	
	
	/*
	 * This function is not longer used. It is replaced by child theme
	 */
	static function include_affiliates_below_meta(){		
		global $post;		
		$affiliates = WpLinkRewriter::get_affiliates_below_product_meta();	
		
		foreach($affiliates as $af => $aff_details){
			echo '<p>' . $aff_details . '</p>';
		}						
	}
	
	
	static function woocommerce_loop_add_to_cart_link($text, $product){
		
		if($product->product_type == 'external'){
				
			return sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="button %s product_type_%s">%s</a>',
				esc_url( get_permalink($product->id) ),
				esc_attr( $product->id ),
				esc_attr( $product->get_sku() ),
				esc_attr( isset( $quantity ) ? $quantity : 1 ),
				$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
				esc_attr( $product->product_type ),
				esc_html( 'See buying options' )
			);
		}
	
		else{
			return $text;
		}
	
 	}
 }
 
?>