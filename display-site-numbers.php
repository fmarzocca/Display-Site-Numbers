<?php
/*
	Plugin Name: Display Site Numbers
	Plugin URI: https://github.com/fmarzocca/display-site-numbers
	Description: A widget to display all relevant site content numbers
	Version: 0.5
	Author: Fabio Marzocca
	Author URI: http://www.marzocca.net
	Text Domain:   display-site-numbers
  	Domain Path:   /languages/
	License: GPL2
	
	Copyright 2015  by Fabio Marzocca  (email : marzoccafabio@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


defined('ABSPATH') or die("No script kiddies please!");
define('DSN_DIR', dirname(__FILE__));


class display_site_numbers extends WP_Widget {

		function display_site_numbers() {
			parent::WP_Widget(false, $name = __('Display Site Numbers', 'display-site-numbers') );
		}


	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
		echo $args['before_title'] . $title . $args['after_title'];

		// This is where you run the code and display the output
		echo __( 'Hello, World!', 'display-site-numbers' );
		echo $args['after_widget'];
	}
		
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
		$title = $instance[ 'title' ];
		}
		else {
		$title = __( 'New title', 'display-site-numbers' );
		}
		// Widget admin form
		?>
<p>
<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<p>

<label class="description" for="element_1">Select what to display: </label>
		<span>
			<ul><li><input checked="checked" id="element_1_1" name="element_1_1" class="element checkbox" type="checkbox" value="1" />
<label class="choice" for="element_1_1">Posts count</label></li>
<li><input checked="checked id="element_1_2" name="element_1_2" class="element checkbox" type="checkbox" value="1" />
<label class="choice" for="element_1_2">Categories count</label></li>
<li><input checked="checked id="element_1_3" name="element_1_3" class="element checkbox" type="checkbox" value="1" />
<label class="choice" for="element_1_3">Authors count</label></li>
<li><input checked="checked id="element_1_4" name="element_1_4" class="element checkbox" type="checkbox" value="1" />
<label class="choice" for="element_1_4">Tags count</label></li>
<li><input checked="checked id="element_1_5" name="element_1_5" class="element checkbox" type="checkbox" value="1" />
<label class="choice" for="element_1_5">Comments count</label></li></span>
</li></ul></p>
<?php 
	}
	
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( 	$new_instance['title'] ) : '';
		return $instance;
	}

} // Class display_site_numbers ends here

// Register and load the widget
function DSN_load_widget() {
	register_widget( 'display_site_numbers' );
}
add_action( 'widgets_init', 'DSN_load_widget' );



/* Add CSS */	
function DSN_css(){
		wp_register_style( 'DSN_css', plugins_url( 'DSN.css' , __FILE__ ) );
		wp_enqueue_style( 'DSN_css' );
	} // function
add_action( 'wp_enqueue_scripts', 'DSN_css' );

?>