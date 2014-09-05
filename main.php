<?php
/**
 * Plugin name: Link Rewriter
 * author: Mahibul hasan
 * Description: Amazon, Ebay etc affiliate program link
 */
 
 define("WPAFFILIATES_FILE", __FILE__);
 define("WPAFFILIATES_DIR", dirname(__FILE__));
 
 include WPAFFILIATES_DIR . '/classes/wp-link-rewriter.php';
 WpLinkRewriter::init();


 ?>