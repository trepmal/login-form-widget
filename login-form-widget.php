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

	/**
	 *
	 */
	function __construct() {
		$widget_ops = array(
			'classname'   => 'login-form-widget',
			'description' => __( 'Show a login form.', 'login-form-widget' )
		);
		$control_ops = array();
		parent::__construct( 'login_form_widget', __( 'Login Form', 'login-form-widget' ), $widget_ops, $control_ops );
	}

	/**
	 *
	 */
	function widget( $args, $instance ) {

		echo $args['before_widget'];

		echo $instance['hide_title'] ? '' : $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];

		if ( is_user_logged_in() ) {
			echo '<ul><li>';
			wp_loginout();
			echo '</li>';
			wp_register(); // defaults to being wrapped in <li></li>
			echo '</ul>';
		} else {
			wp_login_form();
		}

		echo $args['after_widget'];

	} //end widget()

	/**
	 *
	 */
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title']      = esc_attr( $new_instance['title'] );
		$instance['hide_title'] = (bool) $new_instance['hide_title'] ? 1 : 0;
		return $instance;

	} //end update()

	/**
	 *
	 */
	function form( $instance ) {
		$defaults = array(
			'title'      => 'Log in',
			'hide_title' => 0,
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'login-form-widget' );?>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" />
			</label>
			<span>
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('hide_title'); ?>" name="<?php echo $this->get_field_name('hide_title'); ?>"<?php checked( $instance['hide_title'] ); ?> />
				<label for="<?php echo $this->get_field_id('hide_title'); ?>"><?php _e( 'Hide Title?', 'login-form-widget' );?></label>
			</span>
		</p>
		<?php

	} //end form()
}
