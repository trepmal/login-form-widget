<?php
/*
 * Plugin Name: Login Form Widget
 * Plugin URI: trepmal.com
 * Description: A widget with a login form. If logged in, shows log out and register links (if registration is open)
 * Version: 0.1
 * Author: Kailey Lampert
 * Author URI: kaileylampert.com
 * License: GPLv2 or later
 * TextDomain: login-form-widget
 * DomainPath:
 * Network:
 */

add_action( 'widgets_init', 'register_login_form_widget' );
function register_login_form_widget() {
	register_widget( 'Login_Form_Widget' );
}
class Login_Form_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'login-form-widget', 'description' => __( 'About this widget', 'login-form-widget' ) );
		$control_ops = array( 'width' => 300 );
		parent::WP_Widget( 'login_form_widget', __( 'Login Form', 'login-form-widget' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {

		extract( $args, EXTR_SKIP );
		echo $before_widget;

		echo $instance['hide_title'] ? '' : $before_title . apply_filters( 'widget_title', $instance['title'] ) . $after_title;

		if ( is_user_logged_in() ) {
			echo '<ul><li>';
			wp_loginout();
			echo '</li>';
			wp_register();
			echo '</ul>';
		} else {
			wp_login_form();
		}

		echo $after_widget;

	} //end widget()

	function update($new_instance, $old_instance) {

		$instance = $old_instance;
		$instance['title'] = esc_attr( $new_instance['title'] );
		$instance['hide_title'] = (bool) $new_instance['hide_title'] ? 1 : 0;
		return $instance;

	} //end update()

	function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, array( 'title' => 'Login', 'hide_title' => 0 ) );
		extract( $instance );
		?>
		<p style="width:63%;float:left;">
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'login-form-widget' );?>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</label>
		</p>
		<p style="width:33%;float:right;padding-top:20px;height:20px;">
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('hide_title'); ?>" name="<?php echo $this->get_field_name('hide_title'); ?>"<?php checked( $hide_title ); ?> />
			<label for="<?php echo $this->get_field_id('hide_title'); ?>"><?php _e( 'Hide Title?', 'login-form-widget' );?></label>
		</p>
		<?php

	} //end form()
}