<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    header("Location: /wordpress");
    exit('Direct script access denied.');
}

global $wpdb, $table_prefix;

$wp_emp = $table_prefix . 'emp';

$q = "DROP TABLE IF EXISTS $wp_emp";

$wpdb->query($q);
