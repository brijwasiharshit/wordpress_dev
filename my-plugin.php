<?php
/**
 * Plugin Name: My-Plugin
 * Description: This is a test Plugin.
 * Version: 1.0
 * Author: Harshit
 * Author URI: https://itswebspace.in
 */

if (!defined('ABSPATH')) {
    header("Location: /wordpress");
    exit;
}

function my_plugin_activation() {
    // Your activation code here
    // For example, creating a table
    global $wpdb;
    $table_name = $wpdb->prefix . 'emp';

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        `Name` VARCHAR(255) NOT NULL,
        `Email` VARCHAR(255) NOT NULL,
        `Number` INT NOT NULL,
        `Age` INT NOT NULL,
        PRIMARY KEY (`Name`)
    ) ENGINE = InnoDB;";

    $wpdb->query($sql);

    // Example data insertion
    $data = array(
        'Name'   => 'Harshit',
        'Email'  => 'harshit.brizwasi@gmail.com',
        'Number' => '7500270686',
        'Age'    => '20'
    );
    $wpdb->insert($table_name, $data);
}
register_activation_hook(__FILE__, 'my_plugin_activation');

function my_plugin_deactivation() {
    // Your deactivation code here
    // For example, truncating the table
    global $wpdb;
    $table_name = $wpdb->prefix . 'emp';
    $wpdb->query("TRUNCATE TABLE $table_name");
}
register_deactivation_hook(__FILE__, 'my_plugin_deactivation');

function w1_posts() {
    $args = array(
        'numberposts' => 99999,
        'post_type'   => 'post'
    );
    $posts = get_posts($args);
    $data = array();

    foreach ($posts as $post) {
        $data[] = array(
            'id'      => $post->ID,
            'title'   => $post->post_title,
            'content' => $post->post_content,
        );
    }

    return $data;
}

add_action('rest_api_init', function () {
    register_rest_route('w1/v1', 'posts', array(
        'methods'  => 'GET',
        'callback' => 'w1_posts',
    ));
});
