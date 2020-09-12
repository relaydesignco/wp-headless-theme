<?php

/**
 * Headless functions and definitions
 */

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

// add featured images to posts
add_theme_support('post-thumbnails');

// We are using the SVG-Support plugin - below is all you need to allow SVGs, but getting them to display in the dashboard correctly is a pain

// function allow_svg($mimes)
// {
//     $mimes['svg'] = 'image/svg+xml';
//     $mimes['svgz'] = 'image/svg+xml';
//     return $mimes;
// }
// add_filter('upload_mimes', 'allow_svg');

// function fix_mime_type_svg($data = null, $file = null, $filename = null, $mimes = null)
// {
//     $ext = isset($data['ext']) ? $data['ext'] : '';
//     if (strlen($ext) < 1) {
//         $exploded=explode('.', $filename);
//         $ext=strtolower(end($exploded));
//     }
//     if ($ext==='svg') {
//         $data['type']='image/svg+xml' ;
//         $data['ext']='svg' ;
//     } elseif ($ext==='svgz') {
//         $data['type']='image/svg+xml' ;
//         $data['ext']='svgz' ;
//     }
//     return $data;
// }
// add_filter('wp_check_filetype_and_ext', 'fix_mime_type_svg', 75, 4);
