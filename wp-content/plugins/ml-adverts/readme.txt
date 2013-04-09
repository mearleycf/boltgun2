=== Plugin Name ===
Contributors: matchalabs
Tags: advert, banner, google ads, ads, adzerk, advertisement, advertiser
Requires at least: 3.3
Tested up to: 3.5
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Lightweight Banner Management System

== Description ==

Lightweight, flexible banner management system, with a focus on a simple process to publish banners.

Features:

* Use the built in widget or short code to display adverts
* Define unlimited advert locations (e.g. header, footer, sidebar etc)
* Configure the number of adverts to display in each location (default is 1)
* Display random adverts (when number of adverts in the location is set to 1)
* Create image or HTML adverts
* Set start and end dates for adverts
* Restrict advert to showing on specific pages, post types and tag archives
* Record impressions and clicks per advert
* No advert size restrictions
* Mask Advert URL in the browser status bar - no ugly click tracking URLs

Tested with:

* Google Adsense
* Adzerk

== Installation ==

Setup Steps:

1. Upload the `ml-adverts` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Navigate to 'ML Adverts -> Advert Locations' and create the locations you want to place adverts (e.g., header, footer, sidebar)
1. Make a note of the shortcodes for each location (shortcodes are displayed in the table)
1. If you have a suitable widget area, use the widget manager to add the 'ML Adverts' widget to the page
1. If required, update your templates and put the shortcode for the remaining locations in the correct place: `<?php echo do_shortcode("[ml-adverts location=your-location-name]"); ?>`

Advert creation:

1. Navigate to 'ML Adverts -> Add New' to create a new advert
1. Select the advert type (Either upload an image or use HTML/Javascript)
1. Tag the advert to one or more of your previously created locations (e.g. sidebar)
1. Optionally restrict the advert to be displayed on specific posts or pages (e.g. home page)
1. Publish!

== Frequently Asked Questions ==

= Why isn't my advert displaying? =

If the advert Status is "Active", then ensure the correct location shortcode is placed in the template (see "Installation"), otherwise fix the issues listed in the Status column on the advert listing page.

= What happens if 2 active adverts are tagged to the same location, but the location is only set to display 1 advert? =

A single random advert for that location will be displayed. 

= Why is the clicks count listed as "N/A"? =

Clicks are only counted for image type banners. For HTML type banners (e.g. Google Ads) you should use your
publishing account to view the number of clicks.

== Screenshots ==

1. Creating advert locations
2. Insert shortcodes into template
3. Creating adverts

== Changelog ==

= 1.0 =
* Daily banner impressions now stored in single row
* nofollow added to image banners
* nopin attribute added to image banners
* ml-adverts-location taxonomy hidden from public view

= 0.3 =
* Widget added

= 0.2 =
* Minor fixes

= 0.1 =
* Initial version

== Upgrade Notice ==

= 1.0 =
* Core changes

= 0.3 =
* Widget support added

= 0.1 =
* Initial version
