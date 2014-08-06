<?php 
	/*
	Plugin Name: SS Device Detector
	Version: 1.0.2
	Plugin URI: http://www.siteup.org.uk/downloads/ss-device-detector-wp-plugin/
	Description: Server-side solution to detect mobile, tablet and desktop devices. Creates functions and shortcodes
	Author: SiteUP&trade;
	Author URI: http://www.siteup.org.uk
	License: GPL v2
	GitHub Plugin URI: https://github.com/siteup/wp-device-detect
	GitHub Branch:     master

	SS Device Detector
	Copyright (C) 2014, Petrisor Buga & Vladi Iancu http://www.siteup.ro

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.
	*/


class SS_DeviceDetector{

	public $exists = false;

	function __construct() {  
		
    }

    function wp_mobcodes_admin_notices() {
	  	delete_option('wp_mobcodes_activate');

	  	if ($notices= get_option('wp_mobcodes_deferred_admin_notices')) {
	    	foreach ($notices as $notice) 
	    	  	echo "<div class='error'><p>$notice</p></div>";

	    	delete_option('wp_mobcodes_deferred_admin_notices');
	  	}
	}

    function wp_mobcodes_activation() {
    	$notices = get_option('wp_mobcodes_deferred_admin_notices', array());
    	
    	if (class_exists('Mobile_Detect') )
    		$notices['conflict'] = "Error: Plugin conflict! Please deactivate it and activate ours, it's better :D!";

    	update_option('wp_mobcodes_activate',class_exists('Mobile_Detect'));
	 	update_option('wp_mobcodes_deferred_admin_notices', $notices);
	}

	function wp_mobcodes_admin_init() {

		if (class_exists('Mobile_Detect') && is_plugin_active( plugin_basename( __FILE__ ))) { 
			deactivate_plugins( plugin_basename( __FILE__ ));

			if (!get_option('wp_mobcodes_activate') ){
				$notices['deactivated'] 	= "SS Device Detector was deactivated to prevent a conflict with another plugin!";
				update_option('wp_mobcodes_deferred_admin_notices', $notices);
				delete_option('wp_mobcodes_activate');

				if (isset(self::$exists))
					self::$exists = true;
			}
			
			if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		} 
	}

    function wp_mobcodes_deactivation() {
    	#no deavtivation options
    }
}

	

	register_activation_hook(__FILE__, array('SS_DeviceDetector','wp_mobcodes_activation'));
	add_action('admin_init', array('SS_DeviceDetector','wp_mobcodes_admin_init'));
	add_action('admin_notices', array('SS_DeviceDetector','wp_mobcodes_admin_notices'));
	register_deactivation_hook(__FILE__, array('SS_DeviceDetector','wp_mobcodes_deactivation'));

	include_once('MobileDetect.php');
	$md = new MobileDetect();

	# display on phone
	function phone_detect($atts = array(), $content = ""){
		global $md;
		return ($md->isMobile() && !$md->isTablet) ? (!func_num_args() ? true : do_shortcode($content)) : (!func_num_args() ? false : null); 
	};
	function stp_phone(){ return phone_detect(); }
	add_shortcode('stp_phone', 'phone_detect' );


	# display on tablet devices
	function tablet_detect($atts, $content=""){
		global $md;
		return $md->isTablet() ? 
				(!func_num_args() ? true : do_shortcode($content)) : 
				(!func_num_args() ? false : null); 
	};
	function stp_tablet(){ return tablet_detect(); }
	add_shortcode('stp_tablet', 'tablet_detect');

	# display on phone+tablets
	function mobile_detect($atts, $content=""){
		global $md;
		return ($md->isMobile() || $md->isTablet()) ? 
				(!func_num_args() ? true : do_shortcode($content)) : 
				(!func_num_args() ? false : null);
	};
	function stp_mobile(){ return mobile_detect(); }
	add_shortcode('stp_mobile', 'mobile_detect');
	add_shortcode('stp_device', 'mobile_detect');

	# display only on desktop
	function desktop_detect($atts, $content=""){
		global $md;
		return (!$md->isMobile() && !$md->isTablet) ? 
				(!func_num_args() ? true : do_shortcode($content)) : 
				(!func_num_args() ? false : null);
	};
	function stp_desktop(){ return desktop_detect(); }
	function stp_notDevice(){ return stp_isDesktop(); }
	function stp_notMobile(){ return stp_isDesktop(); }
	add_shortcode('stp_desktop', 'desktop_detect');
	add_shortcode('stp_notdevice', 'desktop_detect'); //alias
	add_shortcode('stp_notmobile', 'desktop_detect'); //alias

	# only on desktop + tablet
	function notphone_detect($atts, $content=""){
		global $md;
		return (!$md->isMobile() || $md->isTablet()) ? 
				(!func_num_args() ? true : do_shortcode($content)) : 
				(!func_num_args() ? false : null);
	};
	function stp_notPhone(){ return notphone_detect(); }
	add_shortcode('stp_notphone','notphone_detect');

	# phone + desktop
	function nottablet_detect($atts, $content=""){
		global $md;
		return !$md->isTablet() ? 
				(!func_num_args() ? true : do_shortcode($content)) : 
				(!func_num_args() ? false : null);
	};
	function stp_notTablet(){ return nottablet_detect(); }
	add_shortcode('stp_nottablet','nottablet_detect');
