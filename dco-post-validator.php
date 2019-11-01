<?php

/*
  Plugin Name: DCO Post Validator
  Description: Allows you to make post, page, custom post elements required: title, content, featured image
  Version: 1.0.1
  Author: Denis Yanchevskiy
  Author URI: http://denisco.pro
  License: GPLv2 or later
  Text Domain: dco-post-validator
 */


defined('ABSPATH') or die;

define('DCO_PV__PLUGIN_URL', plugin_dir_url(__FILE__));
define('DCO_PV__PLUGIN_DIR', plugin_dir_path(__FILE__));
define('DCO_PV__PLUGIN_BASENAME', plugin_basename(__FILE__));

if (is_admin()) {
    require_once( DCO_PV__PLUGIN_DIR . 'class.dco-pv-base.php' );
    require_once( DCO_PV__PLUGIN_DIR . 'class.dco-pv.php' );
    require_once( DCO_PV__PLUGIN_DIR . 'class.dco-pv-admin.php' );
}
