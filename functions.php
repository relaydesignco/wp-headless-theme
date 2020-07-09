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


// add ACF fields to theme
if (function_exists('acf_add_local_field_group')) :

  acf_add_local_field_group(array(
    'key' => 'group_5f0619fc9d392',
    'title' => 'Event',
    'fields' => array(
      array(
        'key' => 'field_5f061a0bb0083',
        'label' => 'Speaker',
        'name' => 'speaker',
        'type' => 'text',
        'instructions' => '',
        'required' => 1,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ),
      array(
        'key' => 'field_5f074ede8ac90',
        'label' => 'Image',
        'name' => 'image',
        'type' => 'image',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'return_format' => 'array',
        'preview_size' => 'medium',
        'library' => 'all',
        'min_width' => '',
        'min_height' => '',
        'min_size' => '',
        'max_width' => '',
        'max_height' => '',
        'max_size' => '',
        'mime_types' => '',
      ),
      array(
        'key' => 'field_5f061a29b0084',
        'label' => 'Start Time',
        'name' => 'start',
        'type' => 'time_picker',
        'instructions' => '',
        'required' => 1,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'display_format' => 'g:i a',
        'return_format' => 'g:i a',
      ),
      array(
        'key' => 'field_5f061d5e40ca0',
        'label' => 'End Time',
        'name' => 'end',
        'type' => 'time_picker',
        'instructions' => '',
        'required' => 1,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'display_format' => 'g:i a',
        'return_format' => 'g:i a',
      ),
      array(
        'key' => 'field_5f061a56b0085',
        'label' => 'Link',
        'name' => 'link',
        'type' => 'url',
        'instructions' => '',
        'required' => 1,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
      ),
      array(
        'key' => 'field_5f074e778ac8e',
        'label' => 'Sponsor',
        'name' => 'sponsor',
        'type' => 'image',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'return_format' => 'array',
        'preview_size' => 'medium',
        'library' => 'all',
        'min_width' => '',
        'min_height' => '',
        'min_size' => '',
        'max_width' => '',
        'max_height' => '',
        'max_size' => '',
        'mime_types' => '',
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'post',
        ),
      ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
  ));
endif;


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
