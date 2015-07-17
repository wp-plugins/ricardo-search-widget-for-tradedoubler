<?php
/*
Plugin Name: Ricardo Widget
Plugin URI: http://www.ricardo.ch/
Description: Integriert die Suchmaske von Ricardo in die Sidebar.
Version: 1.1
Author: adresult AG
Author URI: http://www.adresult.ch
*/



class wp_ricardo_plugin extends WP_Widget {

	// constructor
	function wp_ricardo_plugin() {
		parent::WP_Widget(false, $name = __('Ricardo Widget', 'wp_widget_plugin') );
	}

	// widget form creation
	function form($instance) {	
		// Check values
		if( $instance): $tdID = esc_attr($instance['tdID']); else:  $tdID = ''; endif; ?>
		<p>
			<label for="<?php echo $this->get_field_id('tdID'); ?>"><?php _e('TradeDoubler ID', 'wp_widget_plugin'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('tdID'); ?>" name="<?php echo $this->get_field_name('tdID'); ?>" type="text" value="<?php echo $tdID; ?>" />
		</p>
	<?php
	}

	// widget update
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		
		// Fields
		$instance['tdID'] = strip_tags($new_instance['tdID']);
		return $instance;
	}

	// widget display
	function widget($args, $instance) {
		
		extract( $args );
	   // these are the widget options
	   $tdID = $instance['tdID'];
	   echo $before_widget; ?>
	   
	   
		<div class="ricardo-widget-holder">
			<div class="ricardo-logo"><img src="http://ricardo.adresult.ch/search_widget/img/logo_2015.png" alt="ricardo.ch"></div><!-- .logo -->
			<div class="ricardo-search-holder">
			<?php 
			/*
			|--------------------------------------------------------------------------
			| Tradedoubler Version
			|--------------------------------------------------------------------------
			*/	
			if($tdID): ?>
			<form class="ricardo-form" role="form" method="GET" action="http://clkgb.tradedoubler.com/click" target="_blank" style="margin-bottom:0px">
			  <input type="hidden" name="p" value="118233">
			  <input type="hidden" name="a" value="<?php echo $tdID; ?>">
			  <input type="hidden" name="g" value="22502144">
			  <input type="hidden" name="url" value="http://www.ricardo.ch/search/index?utm_source=tdo&utm_medium=widget&utm_campaign=ffl_de&">
			  <label class="sr-only" for="exampleInputEmail2">Suchen</label>
			  <input type="text" class="form-control ricardo-suche" id="suche" name="txtSearch" placeholder="Suchen...">
			  <button type="submit" class="btn btn-default ricardo search-btn gradient"><i class="fa fa-search"></i></button>
			</form>
			<?php
			/*
			|--------------------------------------------------------------------------
			| Normal Version
			|--------------------------------------------------------------------------
			*/	
			else: ?>
			<form class="ricardo-form" role="form" method="POST" action="http://www.ricardo.ch/search/index?utm_source=tdo&utm_medium=widget&utm_campaign=ffl_de" target="_blank" style="margin-bottom:0px">
			  <label class="sr-only" for="exampleInputEmail2">Suchen</label>
			  <input type="text" class="form-control ricardo-suche" id="suche" name="txtSearch" placeholder="Suchen...">
			  <button type="submit" class="btn btn-default ricardo search-btn gradient"><i class="fa fa-search"></i></button>
			</form>
			<?php endif; ?>
			</div><!-- .search-holder -->
		</div><!-- .widget-holder -->
		<img src="http://www.adtracker.ch/views.adtracker?Kampagne_ID=MTYw" border="0" />
           
	   <?php
	   echo $after_widget;
	}
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("wp_ricardo_plugin");'));

function ricardo_widget_scripts() {
	wp_enqueue_style( 'ricardo_widget', 'http://ricardo.adresult.ch/search_widget/css/custom.css' );
	wp_enqueue_style( 'fontawesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css');
}
add_action( 'wp_enqueue_scripts', 'ricardo_widget_scripts' );

?>