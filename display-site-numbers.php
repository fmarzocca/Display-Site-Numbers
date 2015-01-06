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


/******** Creating widget front-end ********************************/
	
	public function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters( 'widget_title', $instance['title'] );
		$ck_posts = $instance['ck_posts'];
		$ck_cats = $instance['ck_cats'];
		$ck_auth = $instance['ck_auth'];
		$ck_tags = $instance['ck_tags'];
		$ck_comm = $instance['ck_comm'];
		$ck_imgs = $instance['ck_imgs'];
		
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];

		// This is where you run the code and display the output
		$count_arr = $this->DSN_counters();
		echo '<div class="DSN-wrapper"><ul>';
		if ($ck_posts == "1" ): 			
			$this->DSN_dressit('Posts',$count_arr['posts']);
		endif;
		if ($ck_cats == "1" ): 			
			$this->DSN_dressit('Categories' ,$count_arr['cats']);
		endif;
		if ($ck_auth == "1" ): 			
			$this->DSN_dressit('Authors' ,$count_arr['auth']);
		endif;
		if ($ck_tags == "1" ): 			
			$this->DSN_dressit('Tags' ,$count_arr['tags']);
		endif;
		if ($ck_comm == "1" ): 			
			$this->DSN_dressit('Comments' ,$count_arr['comm']);
		endif;
		if ($ck_imgs == "1" ): 			
			$this->DSN_dressit('Images' ,$count_arr['imgs']);
		endif;
		echo "</ul></div>";
		echo $args['after_widget'];
	}
		
/********** Widget Backend **********************************/

	public function form( $instance ) {
		if ($instance) {
			$title = $instance[ 'title' ];
			$ck_posts = $instance['ck_posts'];
			$ck_cats = $instance['ck_cats'];
			$ck_auth = $instance['ck_auth'];
			$ck_tags = $instance['ck_tags'];
			$ck_comm = $instance['ck_comm'];
			$ck_imgs = $instance['ck_imgs'];
		}
		else {
			$title = __( 'Total Site Numbers', 'display-site-numbers' );
			$ck_posts = "1";
			$ck_cats = "1";
			$ck_auth = "1";
			$ck_tags = "1";
			$ck_comm = "1";
			$ck_imgs = "1";
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
			<ul><li><input id="<?php echo $this->get_field_id('ck_posts'); ?>" name="<?php echo $this->get_field_name( 'ck_posts' ); ?>" type="checkbox" value="1" <?php checked( '1', $ck_posts ); ?> />
<label class="choice" >Posts count</label></li>
<li><input id="<?php echo $this->get_field_id('ck_cats'); ?>" name="<?php echo $this->get_field_name( 'ck_cats' ); ?>" type="checkbox" value="1" <?php checked( '1', $ck_cats ); ?> />
<label class="choice" >Categories count</label></li>
<li><input id="<?php echo $this->get_field_id('ck_auth'); ?>" name="<?php echo $this->get_field_name( 'ck_auth' ); ?>" type="checkbox" value="1" <?php checked( '1', $ck_auth ); ?> />
<label class="choice" >Authors count</label></li>
<li><input id="<?php echo $this->get_field_id('ck_tags'); ?>" name="<?php echo $this->get_field_name( 'ck_tags' ); ?>" type="checkbox" value="1" <?php checked( '1', $ck_tags ); ?> />
<label class="choice" >Tags count</label></li>
<li><input id="<?php echo $this->get_field_id('ck_comm'); ?>" name="<?php echo $this->get_field_name( 'ck_comm' ); ?>" type="checkbox" value="1" <?php checked( '1', $ck_comm ); ?> />
<label class="choice" >Comments count</label></li>
<li><input id="<?php echo $this->get_field_id('ck_imgs'); ?>" name="<?php echo $this->get_field_name( 'ck_imgs' ); ?>" type="checkbox" value="1" <?php checked( '1', $ck_imgs ); ?> />
<label class="choice" >Images count</label></li></span>
</li></ul></p>
<?php 
	}
	
/****** Updating widget replacing old instances with new *****************/

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( 	$new_instance['title'] ) : '';
		 $instance['ck_posts'] = $new_instance['ck_posts'];
		 $instance['ck_cats'] = $new_instance['ck_cats'];
		 $instance['ck_auth'] = $new_instance['ck_auth'];
		 $instance['ck_tags'] = $new_instance['ck_tags'];
		 $instance['ck_comm'] = $new_instance['ck_comm'];
		 $instance['ck_imgs'] = $new_instance['ck_imgs'];

		return $instance;
	}

/************** Get the counters ********************/
	
	private function DSN_counters() {
		global $wpdb;
		$count_arr = array();
		$count_arr['posts'] = wp_count_posts()->publish;
		$count_arr['imgs'] = $wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->prefix}posts WHERE post_type = 'attachment'");
		$count_arr['cats'] = wp_count_terms('category');
		$count_arr['tags'] = wp_count_terms('post_tag');
		$count_arr['comm'] = wp_count_comments()->total_comments;
		$users = count_users();
		$count_arr['auth'] = $users['avail_roles']['author']; 
		return $count_arr;
	}
	
/*************** Dress the rows ****************/

	private function DSN_dressit($item, $count) {
		echo "<li><span class='item'>".__($item, 'display-site-numbers') .": </span><span class='count'>". $count."</span></li>";
	}

} // Class display_site_numbers ends here

/********************** *********************************/
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