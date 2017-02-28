# UCF News Plugin #

Provides a shortcode, widget, functions, and default styles for displaying UCF news.


## Description ##

This plugin provides a shortcode, widget, helper functions, and default styles for displaying news stories from [today.ucf.edu](https://today.ucf.edu).  It is written to work out-of-the-box for non-programmers, but is also extensible and customizable for developers.


## Installation ##

### Manual Installation ###
1. Upload the plugin files (unzipped) to the `/wp-content/plugins` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the "Plugins" screen in WordPress
3. Configure plugin settings from the WordPress admin under "TODO".

### WP CLI Installation ###
1. `$ wp plugin install --activate https://github.com/UCF/UCF-News-Plugin/archive/master.zip`.  See [WP-CLI Docs](http://wp-cli.org/commands/plugin/install/) for more command options.
2. Configure plugin settings from the WordPress admin under "TODO".


## Frequently Asked Questions ##

TODO



## Changelog ##

### 1.1.0 ###

* Bug Fixes
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

NOTE: this plugin's readme.md file is automatically generated.  Please only make modifications to the readme.txt file, and make sure the `gulp readme` command has been run before committing readme changes.

### Wishlist/TODOs ###
* Convert customizer options to unique plugin options page
* Add per-display_type hooks for modifying news list titles (instead of forcing developers to re-write all display_type use-cases in `ucf_news_display_classic_before` action)
* Complete shortcode interface registration (need to complete shortcode wysiwyg interface plugin first)
* Add rich snippet support, or remove references to rich snippets if this isn't desired
* Update readme TODOs
