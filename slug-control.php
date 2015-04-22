<?php
/**
 * Plugin Name: Slug Control
 * Plugin URI:  
 * Description: Helps you craft amazing post URL slugs, for that hand-crafted URL feel.
 * Version:     0.1.0
 * Author:      Mark Jaquith
 * Author URI:  http://markjaquith.com/
 * License:     GPLv2+
 * Text Domain: cws-slug-control
 * Domain Path: /languages
 */

/**
 * Copyright (c) 2015 Mark Jaquith (email : mark@jaquith.me)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

defined( 'WPINC' ) or die;

include( dirname( __FILE__ ) . '/lib/requirements-check.php' );

$cws_slug_control_requirements_check = new CWS_Slug_Control_Requirements_Check( array(
	'title' => 'Slug Control',
	'php'   => '5.3',
	'wp'    => '4.0',
	'file'  => __FILE__,
));

if ( $cws_slug_control_requirements_check->passes() ) {
	// Pull in the plugin classes and initialize
	include( dirname( __FILE__ ) . '/lib/wp-stack-plugin.php' );
	include( dirname( __FILE__ ) . '/classes/plugin.php' );
	CWS_Slug_Control_Plugin::start( __FILE__ );
}

unset( $cws_slug_control_requirements_check );
