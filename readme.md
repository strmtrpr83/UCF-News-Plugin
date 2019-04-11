 # UCF News Plugin #

Provides a shortcode, widget, functions, and default styles for displaying UCF news.


## Description ##

This plugin provides a shortcode, widget, helper functions, and default styles for displaying news stories from [today.ucf.edu](https://today.ucf.edu).  It is written to work out-of-the-box for non-programmers, but is also extensible and customizable for developers.


## Installation ##

### Manual Installation ###
1. Upload the plugin files (unzipped) to the `/wp-content/plugins` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the "Plugins" screen in WordPress
3. Configure plugin settings from the WordPress admin under "UCF News".

### WP CLI Installation ###
1. `$ wp plugin install --activate https://github.com/UCF/UCF-News-Plugin/archive/master.zip`.  See [WP-CLI Docs](http://wp-cli.org/commands/plugin/install/) for more command options.
2. Configure plugin settings from the WordPress admin under "UCF News".


## Changelog ##

### 2.1.6 ###
* Enhancements:
    * In preparation for a rebuilt UCF Today site, `UCF_News_Common::get_story_image_or_fallback()` has been modified to prioritize the custom `thumbnail` feed value when retrieving a story's image.  If the `thumbnail` value isn't present in the feed, WordPress's standard media details will be referenced, like before, and the "medium" thumbnail size is returned instead.
    * Updated `.ucf-news-thumbnail-image` class to force thumbnails to span the full width of their parent container (in case a very small thumbnail is returned for some reason).

### 2.1.5 ###
* Enhancements:
    * Removed duplicate hard-coded default feed url values throughout the plugin
* Bug Fixes:
    * Updated default `ucf_news_feed_url` option value to exclude "/posts/", so this url works out-of-the-box
    * Fixed handling of invalid feed results in provided news layouts: layouts now avoid accessing non-existent object properties when feed results return `false`.


### 2.1.4 ###
* Enhancements:
    * Added Github Plugin URI to allow for installation from Github plugin.

### 2.1.3 ###
* Bug Fixes:
    * Added missing default `offset` value in `UCF_News_Config::$default_options`
    * Updated widget markup to respect `before_widget` and `after_widget` markup defined in themes
* Enhancements:
    * Added http_timeout setting to allow for adjustment.


### 2.1.2 ###
* Bug Fixes:
    * Added some hardening to `UCF_News_Common::get_story_image_or_fallback()` to account for stories that may have an invalid `$featured_media` object/broken thumbnails
    * Fixed typo in plugin deactivation function name
    * Fixed WP Shortcode Interface registration
* Enhancements:
    * Added conditional WP Shortcode Interface preview styles

### 2.1.1 ###
* Bug Fixes:
    * Added activation and deactivation hooks to handle default options.

### 2.1.0 ###
* Enhancements:
    * Added `$fallback_message` parameter to allow a no results message to be customized. Add the message by inserting it in between the opening and closing shortcodes (the content area), i.e. `[ucf-news-feed]<insert message here>[/ucf-news-feed]`.

### 2.0.0 ###
* Enhancements:
    * Updated `UCF_News_Common::display_news_items()` to render layout parts using filters instead of actions.  Please note this change is not backward-compatible with layouts registered using hooks provided by older versions of the plugin.

### 1.1.4 ###

* Bug Fixes:
    * Fixed `display_news_items()` in `UCF_News_Common` not being declared as a static method
    * Updated filtering of options in `UCF_News_Feed::get_news_items()` to allow 0 values, fixing undefined index notices in some cases.

### 1.1.3 ###

* Enhancements:
    * Updated mobile styles for card layouts.

### 1.1.2 ###

* Enhancements:
    * Added modern and card layouts.

### 1.1.1 ###

* Bug Fixes:
    * Make sure UCF_News_Feed::get_news_items() always has a feed_url set, even if the plugin option's value is empty (thanks @jorgedonoso!)

### 1.1.0 ###

* Bug Fixes:
    * Updated to match the new query params available on UCF Today.

### 1.0.4 (Deprecated) ###

* Bug Fixes:
  * Updates the way the news feed is pulled to prevent error when accessing external host.

### 1.0.3 ###

* Enhancements:
  * Adds empty alt tag to classic layout images for accessibility.

### 1.0.2 ###

* Bug Fixes:
  * Corrects filter name from category to category_name.

### 1.0.1 ###

* Bug Fixes:
  * Corrects a bug with sections and topics filters.

### 1.0.0 ###
* Initial release


## Upgrade Notice ##

n/a


## Installation Requirements ##

None


## Development & Contributing ##

TODO
