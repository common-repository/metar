=== Metar ===

Contributors: beliefmedia
Donate link: http://www.internoetics.com/
Tags: aviation, aircraft, aerospace, shortcode, weather, meteorology, metar, taf, temperature
Requires at least: 3.1
Tested up to: 4.6
Stable tag: 0.2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Include global (and all Australian) aviation METAR or TAF reports, and individual components of weather data, on your website with shortcodes.

== Description ==

**Metar** is a plugin that includes global (and all Australian) aviation METAR or TAF reports, or extracted data, on your website with the use of shortcode.

Features include:

* Include global METAR or TAF reports in your website.
* Include all Australian METAR/TAF reports and Area Forecasts (ARFORs).
* Include temperature and pressure data in various units.
* Enable shortcodes in widgets through admin panel.

**Metar** is in very early development. The initial purpose was to provide basic METAR data for our [Flight.org](http://www.flight.org/ "Flight") website, but we've since decided to build numerous aviation-weather based functions.

While only limited data is available at the moment, future versions will add more features and functionality. 

Results are cached locally for one hour (the general validity of the report).

Related links:

* [Usage](http://www.beliefmedia.com/wp-plugins/metar.php)
* [Flight](http://www.flight.org/aviation-metar-taf-wordpress-plugin)

== Installation ==

**To install the plugin manually:**

1. Extract the contents of the archive (zip file)
2. Upload the metar folder to your '/wp-content/plugins' folder
3. Activate the plugin through the Plugins section in your WordPress admin panel.

**Upload via the WordPress administration panel:**

1. Click on "Plugins" in the left panel, then click on "Add new".
2. You should now see the Install Plugins page. Click on "Upload".
3. Click on Browse and select your "metar.zip" file.
4. Click on "Install now", activate it and you're done!

== Screenshots ==

1. Example TAF, METAR and temperature data.

== Changelog ==

= 0.2.1 =
* Updated NOAA Metar address.

= 0.2 =
* Rewrite of some code (only cache one version of any report). Added a few basic options. Now includes Australian forecasts and ARFOR reports from BOM (AU). Next (major) release will be quite comprehensive.

= 0.1 =
* Initial Release. Basic features only.

== Upgrade Notice == 

= 0.2.1 =
* Updated NOAA Metar address. An upgrade is required to fetch METARs.

= 0.2 =
* Rewrite of some code (only cache one version of any report). Added a few basic options. Now includes Australian forecasts and ARFOR reports from BOM (AU). Next (major) release will be quite comprehensive.

= 0.1 =
Initial Release. Basic features only.

== Frequently Asked Questions ==

**What will the plugin do?**

The plugin is in very early stages. It will retrieve METAR and TAF data from NOAA.gov (or the Australian BOM) and render the information on your website. Using shortcodes, you can also include individual components of data including temperature and pressure (in various units).

**I can't see shortcode in my WordPress sidebar. What should I do?**

There's an option in the plugin to activate/deactivate the filter that'll enable you to use shortcodes in your sidebar. Go to Settings -> Metar Shortcode.

**What are the plans for the future?**

We plan on developing a huge number of options. They include:

* Include other types of data (from both reports) with shortcode (wind, cloud etc).
* Include traditional weather forecasts.
* Store historical reports for analysis.
* Geo-specific data for visitors.

**Where can I go for more information?**

View the complete FAQs and other Hiztory information [here](http://www.beliefmedia.com/wp-plugins/metar.php). 