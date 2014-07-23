<?php 
	/*
	Plugin Name: SS Device Detector
	Version: 1.0.0
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


class MobCodes{

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
    		$notices['conflict'] = "Error: Plugin conflict! Please deactivate XXX and activate ours, it's better :D!";

    	update_option('wp_mobcodes_activate',class_exists('Mobile_Detect'));
	 	update_option('wp_mobcodes_deferred_admin_notices', $notices);
	}

	function wp_mobcodes_admin_init() {

		if (class_exists('Mobile_Detect') && is_plugin_active( plugin_basename( __FILE__ ))) { 
			deactivate_plugins( plugin_basename( __FILE__ ));

			if (!get_option('wp_mobcodes_activate') ){
				$notices['deactivated'] 	= "MobCodes was deactivated to prevent a conflict!";
				update_option('wp_mobcodes_deferred_admin_notices', $notices);
				delete_option('wp_mobcodes_activate');

				if (isset(self::$exists))
					self::$exists = true;
			}
			
			if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		} 
	}

    function wp_mobcodes_deactivation() {
	 	//delete_option('wp_mobcodes_version'); 
	  	//delete_option('wp_mobcodes_deferred_admin_notices'); 
	}
}

	

	register_activation_hook(__FILE__, array('MobCodes','wp_mobcodes_activation'));
	add_action('admin_init', array('MobCodes','wp_mobcodes_admin_init'));
	add_action('admin_notices', array('MobCodes','wp_mobcodes_admin_notices'));
	register_deactivation_hook(__FILE__, array('MobCodes','wp_mobcodes_deactivation'));

	include_once('Mobile_Detect.php');
	$md = new MobileDetect();

	# display on phone
	$phone = function($atts = array(), $content = "") use ($md) {
		return ($md->isMobile() && !$md->isTablet) ? (!func_num_args() ? true : do_shortcode($content)) : (!func_num_args() ? false : null); 
	};
	function md_isPhone(){ global $phone; return $phone(); }
	add_shortcode('phone', $phone );


	# display on tablet devices
	$tablet = function($atts, $content="") use ($md) {
		return $md->isTablet() ? 
				(!func_num_args() ? true : do_shortcode($content)) : 
				(!func_num_args() ? false : null); 
	};
	function md_isTablet(){ global $tablet; return $tablet(); }
	add_shortcode('tablet', $tablet);

	# display on phone+tablets
	$mobile = function($atts, $content="") use ($md) {
		return ($md->isMobile() || $md->isTablet()) ? 
				(!func_num_args() ? true : do_shortcode($content)) : 
				(!func_num_args() ? false : null);
	};
	function md_isMobile(){ global $mobile; return $mobile(); }
	add_shortcode('mobile', $mobile);
	add_shortcode('device', $mobile);

	# display only on desktop
	$desktop = function($atts, $content="") use ($md){
		return (!$md->isMobile() && !$md->isTablet) ? 
				(!func_num_args() ? true : do_shortcode($content)) : 
				(!func_num_args() ? false : null);
	};
	function md_isDesktop(){ global $desktop; return $desktop(); }
	function md_isNotDevice(){ return md_isDesktop(); }
	function md_isNotMobile(){ return md_isDesktop(); }
	add_shortcode('desktop', $desktop);
	add_shortcode('notdevice', $desktop); //alias
	add_shortcode('notmobile', $desktop); //alias

	# only on desktop + tablet
	$notphone = function($atts, $content="") use ($md) {
		return (!$md->isMobile() || $md->isTablet()) ? 
				(!func_num_args() ? true : do_shortcode($content)) : 
				(!func_num_args() ? false : null);
	};
	function md_isNotPhone(){ global $notphone; return $notphone(); }
	add_shortcode('notphone',$notphone);

	# phone + desktop
	$nottablet = function($atts, $content="") use ($md) {
		return !$md->isTablet() ? 
				(!func_num_args() ? true : do_shortcode($content)) : 
				(!func_num_args() ? false : null);
	};
	function md_isNotTablet(){ global $nottablet; return $nottablet(); }
	add_shortcode('nottablet',$nottablet);
