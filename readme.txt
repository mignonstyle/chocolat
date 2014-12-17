/* ------------------------------------
License
------------------------------------ */

Chocolat WordPress Theme, Copyright 2014 Mignon Style
Chocolat is distributed under the terms of the GNU GPL, Version 2 (or later)

This program is free software:
You can redistribute it and/or modify it under the terms of GNU General Public License version 2 (or later).

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY.
Without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
See the GNU General Public License for more details.

License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html

Unless otherwise specified, all the theme files, scripts and images are licensed under the terms of the GNU GPL, Version 2 (or later).

Scripts and Image was created by Mignon Style, Copyright 2014 Mignon Style
All scripts in "/js" and "/admin/js" folder (Except html5.js and jquery.cookie.js)
All images in "/img" and "/admin/img" folder

/* ------------------------------------
Chocolat WordPress Theme bundles 
the following third-party resources
------------------------------------ */

html5.js jQuery library
License: MIT/GPL2 License
Source:  https://github.com/aFarkas/html5shiv

jquery.cookie.js jQuery library, Copyright 2013 Klaus Hartl
License: MIT License
Source:  https://github.com/carhartl/jquery-cookie

Google Fonts:
License: SIL Open Font License, 1.1
Source:  http://www.google.com/fonts

fontello icon font: Fontelico, Font Awesome, Modern Pictograms, Zocial, Brandico
All files in the "/font" folder is a thing of the fontello.
License: SIL Open Font License, MIT License
Source:  http://fontello.com/

Boxer jQuery plugin Copyright 2014 Ben Plum
Included in "/plugin/boxer" folder, all files, image and script is a thing of the boxer.
License: MIT License
Source:  http://formstone.it/components/boxer

FlexSlider jQuery plugin Copyright 2012 WooThemes
Included in "/plugin/flexslider" folder, all files, script is a thing of the FlexSlider.
License: GPLv2 license
Source:  http://www.woothemes.com/flexslider/

CodeMirror JavaScript plugin Copyright 2014 by Marijn Haverbeke and others
Included in "/admin/inc/codemirror" folder, all files, css and script is a thing of the CodeMirror.
License: MIT license
Source:  http://codemirror.net/

TGM Plugin Activation Copyright 2012 Thomas Griffin
/admin/inc/class-tgm-plugin-activation.php.
License: GPL v2 or later
Source:  https://github.com/thomasgriffin/TGM-Plugin-Activation

/* ------------------------------------
Installation
------------------------------------ */

=== Installation using "Add New Theme" ===
1. From your Admin UI (Dashboard), go to Appearance => Themes. Click the "Add New" button.
2. Search for theme, or click the "Upload" button, and then select the theme you want to install.
3. Click the "Install Now" button.

=== Manual installation ===
1. Upload the "chocolat" folder to the "/wp-content/themes/" directory.

=== Activiation and Use ===
1. Activate the Theme through the "Themes" menu in WordPress.
2. Go to Appearance => "Chocolat Settings" page. Complete the input of all necessary, please click on the "Save changes" button.

/* ------------------------------------
Theme features
------------------------------------ */

=== Features ===
Responsive Layout, Theme Customize, Page Navigation, Theme options

=== Theme options ===
Chocolat has theme options panel, for easy setup and config theme setting for your needs.

=== Upload logo, favicon, smartphone icon, No-Image ===
From the theme options page, upload logo, favicon, smartphone icon, the No-Image image.

Recommended image size
logo: max-width 350px (png, jpg or gif)
favicon: width 16px, height 16px (ico file)
smartphone icon: width 144px, height 144px (png)
No-Image: width 300px, height 300px (png, jpg or gif)

Logo or No-Image image is display the reduced by depending on the size of the browser.

=== The display in the header image slider ===
The display in the slider the image set in the header.

How to use:
1. Check "Use the slider to the header image" check box.
2. Select Light Color or Dark Color from the color of the slider.
3. Set an image from the Slider Image 1.
   It is displayed as a slider if you set the image to Slider Image 1 and Slider Image 2.
   Caption and Link URL is optional.
4. Click "Save Changes" button.

=== Widgets Areas ===
The Theme has customizable sidebar and footer.
You can use these widgets areas to customize the content of your website.

=== AdSense or Ad Banner Widgets Areas ===
AdSense and Ad Banner widget area, you can use the widget you want to see it without the frame.

Display location
AdSense Small: the top of the sidebar
AdSense Medium: After Posts of single post page
AdSense Large: Between the footer and sidebar
Ad Banner: the bottom of the sidebar

Size varies depending on the size of the browser.

The smartphone, if the widget is set to AdSense Small, AdSense Small is displayed instead of AdSense Medium and AdSense Large.

Display of Widgets AdSense(Small, Medium, Large) is based on the AdSense program policies.
Ad Banner can be used for other than AdSense.

=== Custom widgets ===
/* -- Page Navi -- */
View navigation menu to a fixed page that have a parent-child page.
It is displayed in only the fixed page.

/* -- Related Entry -- */
Display with a thumbnail for related posts, within the same category In a single page.
It appears on a single page.

/* -- New Entry (with thumbnails) -- */
Display with a thumbnail for new posts.
Check "Do not want to display the top page of the Web site.", does not appear on the top page of the Web site.

=== Global navigation menu ===
Global navigation menu is displayed in the header.

=== Social Link menu ===
Social link menu is displayed on header, footer and sidebar.

The position to display is set up
Appearance > "Chocolat Settings" page > "Links Setting" tab > Position to display

How to use:
1. Click Appearance > Menus > "Edit Menus" tab
   URL: url of the social link
   Link Text: name of the social link
2. Click "Add to Menu" button.

A corresponding social link:
Twitter, Facebook, Google+, Tumblr, Pinterest, Instagram, LinkedIn,
Flickr, Dribbble, YouTube, Vimeo, GitHub, Viadeo, Bloglovin, pixiv

/* ------------------------------------
Translations
------------------------------------ */

Currently the following translations are available:

Japanese (by Mignon Style)
Spanish (ES, MX) (by Raxa Kau)

If you are translating this theme to your language,
Please send the translation to mignonxstyle@gmail.com

Please write your name in the Last-Translator.
I will write your name in the translator name in reaeme.txt.

/* ------------------------------------
Changelog
------------------------------------ */

v1.1.9
* Delete wp-pointer (SNS link)

v1.1.8
* Add wp-pointer (SNS link)
* Add pixiv to SNS link
* Bug and Text fixes

v1.1.7
* Corresponding to the author of microformats
* Pagination fix (for smartphones)
* Add viadeo, the Bloglovin to SNS link
* Add TGM Plugin Activation
* Change screenshot.png
* Text and CSS fixes

v1.1.6
* Theme option fixes
* Add save the value of an option (corresponds the child theme)
* Add Featured Image Settings
* Add Display of heading archive of page
* Add Link in the header image
* Add custom CSS Settings
* The hook of wp_title() fixes
* Corresponds to override the child theme
* Delete function chocolat_title_fix()
* Text fixes

v1.1.5
* Fixed a bug when using a custom post type or custom taxonomy

v1.1.4
* Text fixes
* Bug fixes

v1.1.3
* Add function of the header image slider
* Corresponds to override the child theme
* Text fixes
* Bug fixes

v1.1.2
* Add options of the display of the number of comments in the index page
* Add option to not display when closed the comments
* Add the languages file (Spanish)
* Text fixes
* Css fixes
* Bug fixes

v1.1.1
* Corresponding css to the number of related posts and new posts of theme options
* Delete function chocolat_nav_menu_item_id()
* Add Social Links
* Change screenshot
* Text fixes
* Css fixes

v1.1.0
* Fixed a bug when a child theme is used
* Css fixes

v1.0.10
* Fix based on the theme review
* I18n of style.css the Description
* Text fixes
* Css fixes

v1.0.9
* Fix based on the theme review
* Change the script of the tooltip into jquery-ui-tooltip of the core
* Change the script of the tab into jquery-ui-tabs of the core
* Delete function chocolat_get_comment_author_url_link()
* Delete function chocolat_remove_hentry()
* Fixes of the theme options
* Text fixes
* Css fixes

v1.0.8
* Fix based on the theme review
* Delete files and folders that not using
* Delete function chocolat_remove_ver()
* Fixes of the theme options
* Text fixes
* Css fixes
* Bug fixes

v1.0.7
* Add Image

v1.0.6
* Fix based on the theme review
* Remove unused image

v1.0.5
* Fix based on the theme review
* Fixed an array of theme options

v1.0.4
* Fix based on the theme review
* Fixed the text of the copyright of theme options
* Css fixes

v1.0.3
* Fix based on the theme review
* Fix chocolat_site_title()
* Added switch_theme in the theme options
* Css fixes

v1.0.2
* Fix based on the theme review
* Fix display when comments is disabled
* Add add_theme_support( 'html5' )
* Add setting of the logo of the Web site
* Change screenshot
* Css fixes
* Fixes of the theme options

v1.0.1
* Remove robots meta tag from header.php
* Fix to hide shortcut icon/favicon of default
* Removed code of remove_action() of functions.php
* The change in the admin_enqueue_scripts admin_print_styles
* The change in the wp_enqueue_scripts wp_print_styles
* Sharing services buttons or Open Graph Settings removed from theme options
* Fix of the Credit link
* Css fixes
* Fixes of the theme options
* General bug fix

v1.0
* Initial Release