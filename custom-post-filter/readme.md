# Custom Post Filter Plugin

## Description

The Custom WordPress Post Filter Plugin enhances your WordPress website by providing a customizable post filtering system. This plugin allows users to filter posts based on post type, category, and search parameters. Additionally, it introduces shortcodes for displaying filtered posts and related insights.

## Features

- **Post Filtering:** Filter posts by post type, category, and search queries.
- **Dynamic Menu:** Automatically creates a "Post Filter Settings" menu upon activation.
- **Shortcodes:**
  - `[post_filter]`: Display post filter using this shortcode.
  - `[related_insights]`: Show related posts based on post type.

## Installation

1. Upload the `custom-post-filter` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Navigate to the "Post Filter Settings" menu to configure post types.

## Usage

### Shortcodes

1. **Post Filter Shortcode:**
   - Use `[post_filter]` in your post or page to display the post filter.
   - Example: `[post_filter]`

2. **Related Insights Shortcode:**
   - Implement `[related_insights]` to showcase related posts based on post type.
   - Example: `[related_insights]`

### Post Filter Settings

1. After activation, go to "Post Filter Settings" in the WordPress admin menu.
2. Choose the post types to include in the filter (default is 'post').
3. Save changes.

## Example

```php
// Use the following code to display the related insights in your theme files.
<?php echo do_shortcode('[related_insights]'); ?>
```

## Changelog

1.0.0
