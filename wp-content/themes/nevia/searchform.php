<?php
/**
 * The template for displaying search forms in Nevia
 *
 * @package Nevia
 * @since Nevia 1.0
 */
?>
	<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
		<button class="search-btn-widget"></button>
        <input type="text" class="search-field" name="s" id="s" onblur="if(this.value=='')this.value='<?php _e('Search','purepress'); ?>';" onfocus="if(this.value=='<?php _e('Search','purepress'); ?>')this.value='';"  value="<?php esc_attr_e( 'Search', 'purepress' ); ?>" />
	</form>
<div class="clearfix"></div>
