=== Custom Recovery Mode Email ===

Plugin Name: Custom Recovery Mode Email
Description: Change the recipient address when WordPress sends an email if a Fatal Error occurs.
Tags: recovery mode, recovery mode email, fatal error
Contributors: jairoochoa, dixitalmedia
Requires at least: 5.2
Tested up to: 6.5.5
Stable tag: trunk
Version: 1.0.4
Requires PHP: 7.4
Text Domain: custom-recovery-mode-email
Domain Path: /languages/
License: GPL v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


Change the recipient address when WordPress sends an email if a Fatal Error occurs.


== Description ==

Since WordPress 5.2 there is a built-in feature that detects when a plugin or theme causes a fatal error on your site, and notifies you with an automated email.

But sometimes the message bothers people who don't know how to handle with it and how to fix the bug which causes the crash.

With *Custom Recovery Mode Email* now you can choose the right recipient email of the person who can deal with it.

Optionally you can also set Email and Name sender.


== Installation ==

1. Upload the entire plugin folder to the /wp-content/plugins/ directory.
2. Activate the plugin through the “Plugins” menu in WordPress.
3. Go to Settings -> Recovery Mode Email to access settings page.

= Minimum Requirements =

* PHP version 5.6 or greater (PHP 7.4 or greater is recommended)


== Frequently Asked Questions ==
 
= Does it works with WordPress Multisite ? =
 
Not yet. Next release of *Custom Recovery Mode Email* will allow you to set your preferences in the Network Admin.


== Screenshots ==
 
1. Settings page /assets/screenshot-1.png


== Changelog ==

= 1.0 =
* Initial Release

= 1.0.1 =
* Fix to prevent activation in WordPress Multisite to avoid site to crash
* Fix wrong text domain

= 1.0.2 =
* Added class "regular-text" to input fields

= 1.0.3 =
* Updated last WordPress version tested

= 1.0.4 =
* Updated last WordPress version tested



== Translations ==

* English
* Español (España)
* Euskara (thanks to @garridinsi)
* Galego
* Svenska (thanks to @tobifjellner)

*Note:* Please, contact me if you would like to help translating the plugin into your language.



