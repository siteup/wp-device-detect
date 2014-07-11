<?php 

	/*
	Plugin Name: WP MobCodes
	Version: 1.0.0
	Plugin URI: to-be-announced
	Description: Mobile detect functions and shortcodes
	Author: SiteUP.ro
	Author URI: http://www.siteup.ro
	License: GPL v3

	WP MobCodes
	Copyright (C) 2014, Petrisor Buga & Vladi Iancu http://www.siteup.ro

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.
	*/




	// PHP Mobile Detect class used to detect browser or device type
	include_once('Mobile_Detect.php');
	$md = new Mobile_Detect();

	# display on phone
	$phone = function($atts = array(), $content = "") use ($md) {
		return ($md->isMobile() && !$md->isTablet) ? (!func_num_args() ? true : do_shortcode($content)) : (!func_num_args() ? false : null); 
	};
	function md_is_phone(){ global $phone; return $phone(); }
	add_shortcode('phone', $phone );


	# display on tablet devices
	$tablet = function($atts, $content="") use ($md) {
		return $md->isTablet() ? (!func_num_args() ? true : do_shortcode($content)) : (!func_num_args() ? false : null); 
	};
	function md_is_tablet(){ global $tablet; return $tablet(); }
	add_shortcode('tablet', $tablet);

	# display on phone+tablets
	$mobile = function($atts, $content="") use ($md) {
		return ($md->isMobile() || $md->isTablet()) ? (!func_num_args() ? true : do_shortcode($content)) : (!func_num_args() ? false : null); 
	};
	function md_is_mobile(){ global $mobile; return $mobile(); }
	add_shortcode('mobile', $mobile);
	add_shortcode('device', $mobile);

	# display only on desktop
	$desktop = function($atts, $content="") use ($md){
		return (!$md->isMobile() && !$md->isTablet) ? (!func_num_args() ? true : do_shortcode($content)) : (!func_num_args() ? false : null); 
	};
	function md_is_desktop(){ global $desktop; return $desktop(); }
	add_shortcode('desktop', $desktop);
	add_shortcode('notdevice', $desktop); //alias
	add_shortcode('notmobile', $desktop); //alias

	# only on desktop + tablet
	$notphone = function($atts, $content="") use ($md) {
		return (!$md->isMobile() || $md->isTablet()) ? (!func_num_args() ? true : do_shortcode($content)) : (!func_num_args() ? false : null); 
	};
	function md_is_notphone(){ global $notphone; return $notphone(); }
	add_shortcode('notphone',$notphone);

	# phone + desktop
	$nottablet = function($atts, $content="") use ($md) {
		return !$md->isTablet() ? (!func_num_args() ? true : do_shortcode($content)) : (!func_num_args() ? false : null); 
	};
	function md_is_nottablet(){ global $nottablet; return $nottablet(); }
	add_shortcode('nottablet',$nottablet);