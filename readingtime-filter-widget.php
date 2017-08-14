<?php
/*
  Plugin Name: Readingtime Filter
  Description: Determine and filter articles by reading time
  Version: 1.0
  Author: solutions.io
  Author URI: https://solutions.io
 */

include( plugin_dir_path( __FILE__ ) . 'core/post-save.php');
include( plugin_dir_path( __FILE__ ) . 'core/filter-widget.php');