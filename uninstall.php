<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       https://mntshop.ru
 * @since      1.0.0
 *
 * @package    Minter_Yyy_Cashback
 */
global $wpdb;

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
$options = get_option('minter-yyy-cashback');
//Save all generated pushes?
// delete all pushes from database
//if($options['uninstall_delete_minter-push']){
    $query = "DELETE a,b,c
        FROM wp_posts a
        LEFT JOIN wp_term_relationships b
            ON (a.ID = b.object_id)
        LEFT JOIN wp_postmeta c
            ON (a.ID = c.post_id)
        WHERE a.post_type = 'minter-push'";
    if($wpdb->query(
        $query
    )){
        error_log('All posts with minter-push are deleted');
    };
//}

// delete all options from database
//Save options or not?
//if($options['uninstall_delete_options']){
    delete_option('minter-yyy-cashback');
//}

