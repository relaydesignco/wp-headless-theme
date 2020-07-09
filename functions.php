<?php

/**
 * Headless functions and definitions
 */


// add ACF fields to default WP REST API posts endpoint
// http://midwestdesignweekapi.local/wp-json/wp/v2/posts
function acf_to_rest_api($response, $post, $request)
{
  if (!function_exists('get_fields')) return $response;

  if (isset($post)) {
    $acf = get_fields($post->id);
    $response->data['acf'] = $acf;
  }
  return $response;
}
add_filter('rest_prepare_post', 'acf_to_rest_api', 10, 3);


// create custom events endpoint
// http://midwestdesignweekapi.local/wp-json/events/v2/posts
function  events_endpoint($request_data)
{
  $args = array(
    'post_type' => 'post',
    'posts_per_page' => -1,
    'numberposts' => -1
  );
  $posts = get_posts($args);
  foreach ($posts as $key => $post) {
    $posts[$key]->acf = get_fields($post->ID);
  }
  return  $posts;
}
add_action('rest_api_init', function () {
  register_rest_route('events/v2', '/posts/', array(
    'methods' => 'GET',
    'callback' => 'events_endpoint'
  ));
});


// specify whether I’m using a local Advanced Custom Fields configuration (development) or my PHP export (staging/production)
// must also add the following to wp-config.php in your dev environment ONLY: define('USE_LOCAL_ACF_CONFIGURATION', true);
if (!defined('USE_LOCAL_ACF_CONFIGURATION') || !USE_LOCAL_ACF_CONFIGURATION) {
  require_once dirname(__FILE__) . '/advanced-custom-fields.php';
}


// We are using the Safe SVG plugin to enabe SVGs - it sanitizes the XML and also enables image preview in the dashboard, but the code below would also work
// // Allow SVG
// add_filter('wp_check_filetype_and_ext', function ($data, $file, $filename, $mimes) {
//   global $wp_version;
//   if ($wp_version == '4.7' || ((float) $wp_version < 4.7)) {
//     return $data;
//   }
//   $filetype = wp_check_filetype($filename, $mimes);
//   return [
//     'ext'             => $filetype['ext'],
//     'type'            => $filetype['type'],
//     'proper_filename' => $data['proper_filename']
//   ];
// }, 10, 4);

// function cc_mime_types($mimes)
// {
//   $mimes['svg'] = 'image/svg+xml';
//   return $mimes;
// }
// add_filter('upload_mimes', 'cc_mime_types');

// function fix_svg()
// {
//   echo '<style type="text/css">
//         .attachment-266x266, .thumbnail img {
//              width: 100% !important;
//              height: auto !important;
//         }
//         </style>';
// }
// add_action('admin_head', 'fix_svg');
