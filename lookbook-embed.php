<?php
/**
 * Plugin Name: LOOKBOOK Embed
 * Version: 0.1.2
 * Description: Just add LOOKBOOK links into your posts and the plugin will add the HYPE button for you.
 * Author: Sören Müller
 * Author URI: http://pattyland.de/
 * Plugin URI: http://pattyland.de/project/lookbook-embed
 */


wp_embed_register_handler( 'lookbook', "/https?:\/\/lookbook.nu\/look\/(\d+)-[a-zA-Z-\._~:\/\?#\[\]@!\$&'()*\+,;=]+/", 'wp_embed_handler_lookbook' );

function wp_embed_handler_lookbook( $matches, $attr, $url, $rawattr ) {

	$look_id = esc_attr($matches[1]);

	$embed = '<!--BEGIN HYPE WIDGET-->';
	$embed .= sprintf( '<div id="hype_container_%s">Loading...</div>', $look_id);
	$embed .= sprintf('<script>var lookbook_ids = lookbook_ids || []; lookbook_ids.push(%s)</script>', $look_id);
	$embed .= '<!--END HYPE WIDGET-->';


	return apply_filters( 'embed_lookbook', $embed, $matches, $attr, $url, $rawattr );
}


/*add_action( 'wp_enqueue_scripts', 'lookbook_script' );

function lookbook_script() {
	wp_enqueue_script( 'lookbook', '//lookbook.nu/look/widget/6456764.js?include=hype&size=medium&style=button&align=center', array(), null, true );
}*/

function display_lookbook_widgets() {
	echo '<script>
    if (typeof lookbook_ids != "undefined"){
    	if (jQuery) {
			$LB = jQuery;
		}
		jQuery.each(lookbook_ids, function( index, value ) {
		  jQuery.getScript( "//lookbook.nu/look/widget/" + value + ".js?include=hype&size=medium&style=button&align=center" )
						  .fail(function( jqxhr, settings, exception ) {
							alert(\'Failed to load LOOKBOOK widgets: \' + exception);
						});
		});
	}
	</script>';
}
add_action('wp_footer', 'display_lookbook_widgets');
