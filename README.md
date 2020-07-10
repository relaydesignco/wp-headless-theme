# Headless Wordpress Theme

Place the following in your wp-config.php to enable versioning of ACF data:

```
/*
 * Specify whether to load Advanced Custom Fields
 * configuration from wp_posts (true) or a PHP export
 * file (false).
 */
define('USE_LOCAL_ACF_CONFIGURATION', true);
```