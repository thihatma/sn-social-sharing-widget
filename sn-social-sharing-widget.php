<?php
/*
Plugin Name: Synapse Social
Description: Social Sharing Widget for Heads-Up
Version: 1.0
Author: Synapse Original
*/
/* Start Adding Functions Below this Line */


/* Stop Adding Functions Below this Line */
?>
<?php

function wpb_adding_styles() {
wp_register_style('sn-social-sharing-widget', plugins_url('sn-social-sharing-widget.css', __FILE__));
wp_enqueue_style('sn-social-sharing-widget');
}

add_action( 'wp_enqueue_scripts', 'wpb_adding_styles' );  

// Creating the widget 
class wpb_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'wpb_widget', 

// Widget name will appear in UI
__('SN Social Share', 'wpb_widget_domain'), 

// Widget description
array( 'description' => __( 'Social Sharing Widget for Heads-Up', 'wpb_widget_domain' ), ) 
);
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

$posttitle = get_permalink( $post->ID );
echo __( "<div class='socialmain'><a class='socialshare' href='https://www.facebook.com/sharer/sharer.php?u=$posttitle' target='_blank'>F</a><a class='socialshare' href='http://twitter.com/share?' target='_blank'>T</a><a class='socialshare' href='http://www.linkedin.com/shareArticle?mini=true&amp;url=$posttitle' target='_blank'>L</a><a class='socialshare' href='http://pinterest.com/pin/create/button/?url=$posttitle' target='_blank'>P</a><a class='socialshare' href='https://plus.google.com/share?url=$posttitle' target='_blank'>G</a></div>", 'wpb_widget_domain' );
echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'New title', 'wpb_widget_domain' );
}
// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<?php 
}
	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
return $instance;
}
} // Class wpb_widget ends here

// Register and load the widget
function wpb_load_widget() {
	register_widget( 'wpb_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );