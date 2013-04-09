== Changelog ==

= 1.1 Nov 5 2012 =
* Move functions for grabbing bits of content directly into the theme includes
* Clean up unused functions
* Replace esc_attr( printf() ) with sprintf to prevent potential XSS and potential broken code
* Updates to audio player JS and jQuery dependencies
* Make sure attribute escaping occurs after printing
* PNG image compression
* Remove esc_html() from get_the_author() since it's not being used in an attribute
* Updated screenshot for HiDPI support
* Add Jetpack compatibility file