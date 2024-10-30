<?php
/*
Plugin Name: Metar
Version: 0.2.1
Plugin URI: http://www.beliefmedia.com/wp-plugins/metar.php
Description: Display aviation METAR and TAF Data on your website. Use &#91;metar loc="YSSY"&#93; for a metar or &#91;taf loc="YSSY"&#93; for raw data. Use &#91;qnh loc="yssy"&#93; and &#91;temperature loc="klax"&#93; for altimeter and temperature (location must be defined). See our <a href="http://www.beliefmedia.com/wp-plugins/metar.php">website</a> for unit options (celsius and fahrenheit, inches and hectopascals/milibars) and other help. Makes use of data from NOAA.gov.
Author: Marty Khoury
Author URI: http://www.beliefmedia.com/
*/


/*
	Get Metar - Queries either NOAA or BOM (AU)
	More? http://shor.tt/z2
*/


function beliefmedia_internoetics_noaa_metar($loc) {
  $loc = strtoupper($loc);
 
   if (substr($loc, 0, 1) == 'Y') {

     /* Create CURL Request */
     $postData = 'keyword=' . $loc . '&type=search&page=TAF';
     $ch = curl_init();
     curl_setopt($ch,CURLOPT_URL,'http://www.bom.gov.au/aviation/php/process.php');
     curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
     curl_setopt($ch,CURLOPT_HEADER, false); 
     curl_setopt($ch, CURLOPT_POST, count($postData));
     curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);   
     curl_setopt($ch,CURLOPT_USERAGENT,beliefmedia_internoetics_random_user_agent());
     $result = curl_exec($ch);
     curl_close($ch);
 
     preg_match_all('/<p class="product">(.*?)<\/p>/si', $result, $match);
     $result = $match[1][1];

   } else {

    $fileName = 'http://tgftp.nws.noaa.gov/data/observations/metar/stations/' . $loc . '.TXT';
    $metar = '';
    $fileData = @file($fileName) or die('METAR not available');
	
    if ($fileData != false) {
     list($i, $date) = each($fileData);
      while (list($i, $line) = each($fileData)) {
       $metar .= ' ' . trim($line);
      }
     $result = trim(str_replace('  ', ' ', $metar));
    }
  }
 return $result;
}


/*
	Get TAF - Queries either NOAA or BOM (AU)
	More? http://shor.tt/z1
*/


function beliefmedia_internoetics_noaa_taf($loc) {
  $loc = strtoupper($loc);
 
   if (substr($loc, 0, 1) == 'Y') {

     /* Create CURL Request */
     $postData = 'keyword=' . $loc . '&type=search&page=TAF';
     $ch = curl_init();
     curl_setopt($ch,CURLOPT_URL,'http://www.bom.gov.au/aviation/php/process.php');
     curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
     curl_setopt($ch,CURLOPT_HEADER, false); 
     curl_setopt($ch, CURLOPT_POST, count($postData));
     curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);   
     curl_setopt($ch,CURLOPT_USERAGENT,beliefmedia_internoetics_random_user_agent());
     $result = curl_exec($ch);
     curl_close($ch);
 
     preg_match_all('/<p class="product">(.*?)<\/p>/si', $result, $match);
     $result = $match[1][0];

   } else {

    $fileName = 'ftp://tgftp.nws.noaa.gov/data/forecasts/taf/stations/' . $loc . '.TXT';
    $taf = ''; $fileData = @file($fileName) or die('TAF not available');

    if ($fileData != false) {
      list($i, $date) = each($fileData);
        while (list($i, $line) = each($fileData)) {
          $taf .= ' ' . trim($line);
        }
     $result = trim(str_replace('  ', ' ', $taf));
    }
  }
 return $result;
}


/*
	Make CURL Request
	Not best practice to use an agent...
*/


function beliefmedia_internoetics_random_user_agent() {

    $userAgents=array(
        "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6",
        "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)",
        "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30)",
        "Opera/9.20 (Windows NT 6.0; U; en)",
        "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; en) Opera 8.50",
        "Mozilla/4.0 (compatible; MSIE 6.0; MSIE 5.5; Windows NT 5.1) Opera 7.02 [en]",
        "Mozilla/5.0 (Macintosh; U; PPC Mac OS X Mach-O; fr; rv:1.7) Gecko/20040624 Firefox/0.9",
        "Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en) AppleWebKit/48 (like Gecko) Safari/48",
        "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36",
	"Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 7.0; InfoPath.3; .NET CLR 3.1.40767; Trident/6.0; en-IN)",
	"Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)",
	"Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)",
	"Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/5.0)",
	"Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/4.0; InfoPath.2; SV1; .NET CLR 2.0.50727; WOW64)",
	"Mozilla/5.0 (compatible; MSIE 10.0; Macintosh; Intel Mac OS X 10_7_3; Trident/6.0)",
	"Mozilla/4.0 (Compatible; MSIE 8.0; Windows NT 5.2; Trident/6.0)",
	"Mozilla/4.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/5.0)",
	"Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko",
	"Mozilla/1.22 (compatible; MSIE 10.0; Windows 3.1)"
    );
  $random = rand(0,count($userAgents)-1);
 return $userAgents[$random];
}


/*
	METAR Shortcode (http://shor.tt/z2)
	tidy attribute applies only to OZ metars
*/


function beliefmedia_internoetics_metar_shortcode ($atts, $content = null) {
  extract(shortcode_atts(array(
    'loc' => 'yssy',
    'tidy' => 1,
    'p' => 1,
    'cache' => 3600
  ), $atts));

    $transient = "beliefmedia_metar_$loc.$cache.metar";
    $dbresult =  get_transient($transient);

    if ($dbresult == true) {
      $result = $dbresult;

     } else {

      $result = beliefmedia_internoetics_noaa_metar($loc);
      set_transient($transient, $result, $cache);
    }

  if ($tidy) $result = str_replace('<br />', ' ', $result); 
  if ($p) $result = '<p>' . $result . '</p>';

 return $result;
}
add_shortcode('metar', 'beliefmedia_internoetics_metar_shortcode');


/*
	TAF Shortcode (http://shor.tt/z1)
	tidy attribute applies only to OZ metars
*/


function beliefmedia_internoetics_taf_shortcode ($atts, $content = null) {
  extract(shortcode_atts(array(
    'loc' => 'yssy',
    'tidy' => 1,
    'p' => 1,
    'cache' => 3600
  ), $atts));

    $transient = "beliefmedia_metar_$loc.$cache.taf";
    $dbresult =  get_transient($transient);

    if ($dbresult == true) {
      $result = $dbresult;

     } else {

      $result = beliefmedia_internoetics_noaa_taf($loc);
      set_transient($transient, $result, $cache);
    }

  if ($tidy) $result = str_replace('<br />', ' ', $result);
  if ($p) $result = '<p>' . $result . '</p>';

 return $result; 
}
add_shortcode('taf', 'beliefmedia_internoetics_taf_shortcode');


/*
	Convert Naked Temp to Readable Integer
*/


function beliefmedia_internoetics_metar_temp_integer($temp) {
  $temp = str_replace('M', '-', "$temp");
 return intval($temp);
}


/*
	Get QNH from METAR Report
	Ref: ISA 1013.25, 29.92
	Since HPA is ICAO standard, defaults to true
	Naked PHP Usage on www.flight.org
*/


function beliefmedia_internoetics_metar_qnh($atts, $content = null) {
  extract(shortcode_atts(array(
    'loc' => 'yssy',
    'unit' => 1,
    'cache' => 3600
  ), $atts));

  $transient = "beliefmedia_metar_$loc.$cache.metar";
  $dbresult =  get_transient($transient);

  if ($dbresult == true  ) {
   $result = $dbresult;

    } else {
    $result = beliefmedia_internoetics_noaa_metar($loc);
    set_transient($transient, $result, $cache);
   }

  preg_match('/(A|Q)([0-9]{4})/', $result, $results);
   $altimeter_raw = $results['2'];

    if ( ($results[1] == 'A') && ($unit) ):
	$altimeter = round( ($altimeter_raw / 0.02953) / 100, 0);
    elseif ( ($results[1] == 'Q') && (!$unit) ):
	$altimeter = round(0.02953 * $altimeter_raw, 2);
    elseif ( ($results[1] == 'A') && (!$unit) ):
 	$altdiv = ($altimeter_raw/100);
	$altimeter = number_format($altdiv , 2, '.', '');
    else:
	$altimeter = ltrim($altimeter_raw, '0');
    endif;

 return $altimeter;
}
add_shortcode('qnh', 'beliefmedia_internoetics_metar_qnh');


/*
	Get Temperature from METAR Report
	Since Celcius is ICAO standard, defaults to true
	Usage: beliefmedia_internoetics_metar_temp($report);
	Returned as array with all celcius and Fahrenheit values
	$tempArray = beliefmedia_internoetics_metar_temp($report);
 	echo $tempArray['tempc']; echo $tempArray['dpc']; etc.

	Temperature (normalised integer °C) is 14 [temperature loc="kjfk" temp="1"] 
	Dew Point Temp (normalised integer °C) is 12 [temperature loc="kjfk" temp="2"] 
	Raw Temp (from Metar °C) is 14 [temperature loc="kjfk" temp="3"] 
	Raw Dew Point Temp (from Metar °C) is 12 [temperature loc="kjfk" temp="4"] 
	Temperature (°F) (normalised integer) is 57 [temperature loc="kjfk" temp="5"] 
	Dew Point Temp (°F) (normalised integer) is 54 [temperature loc="kjfk" temp="6"] 
	Raw report data is 14/12 [temperature loc="kjfk" temp="7"] 

*/


function beliefmedia_internoetics_metar_temp($atts, $content = null) {
  extract(shortcode_atts(array(
    'loc' => 'yssy',
    'temp' => 1,
    'int' => 1,
    'degrees' => 0,
    'cache' => 3600
  ), $atts));

  $transient = "beliefmedia_metar_$loc.$cache.metar";
  $dbresult =  get_transient($transient);

  if ($dbresult == true) {
   $result = $dbresult;
  } else {
   $result = beliefmedia_internoetics_noaa_metar($loc);
   set_transient($transient, $result, $cache);
  }

  preg_match('/(M?[0-9]{2})\/(M?[0-9]{2}|[X]{2})/', $result, $results);
    $tempC = $results[1]; $dpC = $results[2];

    /* Get temp C as Int */
    $tempC_int = beliefmedia_internoetics_metar_temp_integer($tempC); 
    $dpC_int = beliefmedia_internoetics_metar_temp_integer($dpC);

    /* Temp F */
    $tempF = ( round(1.8 * $tempC_int + 32) );
    $dpF = ( round(1.8 * $dpC_int + 32) );

   if ($temp == '1'):
     $temperature = $tempC_int;
   elseif($temp == '2'):
     $temperature = $dpC_int;
   elseif($temp == '3'):
     $temperature = $results[1];
   elseif($temp == '4'):
     $temperature = $results[2];
   elseif($temp == '5'):
     $temperature = $tempF;
   elseif($temp == '6'):
     $temperature = $dpF;
   elseif($temp == '7'):
     $temperature = $results[0];
   else:
     $temperature = ltrim($tempC, '0');
   endif;

  if ($degrees) {
     if (strripos($temperature,'/') !== false) {
      $temperature = str_replace('/', '&deg;/', $temperature) . '&deg;';
     } else {
    $temperature = $temperature . '&deg;';
   }
  }
 return $temperature;
}
add_shortcode('temperature', 'beliefmedia_internoetics_metar_temp');


/*
	Australian ARFOR Area Forecast from BOM
	http://www.internoetics.com/example-pages/arfor-wordpress-shortcode-example/
*/


function beliefmedia_internoetics_bom_arfor($atts, $content = null) {
  extract(shortcode_atts(array(
    'loc' => '21',
    'cache' => 3600
  ), $atts));

  $transient = "beliefmedia_metar_$loc.$cache.arfor";
  $dbresult =  get_transient($transient);

  if ($dbresult == true  ) {
   return $dbresult;

   } else {

   if (!ctype_digit($loc)) $loc = '21';

   /* Create CURL Request */
   $postData = 'keyword=' . $loc . '&type=search&page=TAF';
   $ch = curl_init();
   curl_setopt($ch,CURLOPT_URL,'http://www.bom.gov.au/aviation/php/process.php');
   curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
   curl_setopt($ch,CURLOPT_HEADER, false); 
   curl_setopt($ch, CURLOPT_POST, count($postData));
   curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);   
   curl_setopt($ch,CURLOPT_USERAGENT,beliefmedia_internoetics_random_user_agent());
   $result = curl_exec($ch);
   curl_close($ch);

   set_transient($transient, $result, $cache);
  return $result;
 }
}
add_shortcode('arfor', 'beliefmedia_internoetics_bom_arfor');



/*
	Menu Links
*/


function beliefmedia_metar_action_links($links, $file) {
  static $this_plugin;
  if (!$this_plugin) {
   $this_plugin = plugin_basename(__FILE__);
  }

  if ($file == $this_plugin) {
	$links[] = '<a href="http://www.beliefmedia.com/wp-plugins/metar.php" target="_blank">Support</a>';
	$links[] = '<a href="http://www.flight.org/aviation-metar-taf-wordpress-plugin" target="_blank">Flight</a>';
  }
 return $links;
}
add_filter('plugin_action_links', 'beliefmedia_metar_action_links', 10, 2);


/*
	Delete Transient Data on Deactivation
*/

	
function remove_beliefmedia_metar_options() {
  global $wpdb;
   $wpdb->query("DELETE FROM $wpdb->options WHERE `option_name` LIKE ('_transient%_beliefmedia_metar__%')" );
   $wpdb->query("DELETE FROM $wpdb->options WHERE `option_name` LIKE ('_transient_timeout%_beliefmedia_metar__%')" );
}
register_deactivation_hook( __FILE__, 'remove_beliefmedia_metar_options' );


/*
	Add shortcode filter for widget if enabled
*/


if (get_option('widget_shortcode', 0) != '0') add_filter('widget_text', 'do_shortcode');


/*
	Menu for Admin Page
*/


function beliefmedia_metar_submenu() {
  add_submenu_page( 'options-general.php', 'Metar Shortcode Options by BeliefMedia', 'Metar Shortcode', 'manage_options', 'beliefmedia-metar-shortcode', 'beliefmedia_metar_admin_page' ); 
}
add_action('admin_menu', 'beliefmedia_metar_submenu');


/*
	Admin Page
*/


function beliefmedia_metar_admin_page() {
echo '<div class="wrap"><div id="icon-tools" class="icon32"></div>';

 /* Process Shortcode Sidebar Form */

 if ( ($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['shortcode_sidebar'])) ) {
 $new_sc_value = $_POST['widget_shortcode'];
     if ( get_option('widget_shortcode', 0) !== false ) {
    	update_option('widget_shortcode', "$new_sc_value");
	} else {
	add_option('widget_shortcode', "$new_sc_value", $deprecated = null, $autoload = 'no' );
     }
  echo '<div id="setting-error-settings_updated" class="updated settings-error"><p><strong>Successfully Updated "Shortcodes in Widgets" Setting ' . $beliefmedia_metar_sc_mg . '</strong></p></div>';
 }

 /* Shortcode Sidebar Form */

 echo '<h2>METAR Plugin</h2>';
 echo '<h3 class="title">Metar - by BeliefMedia</h3>';
 echo 'This page provides basic shortcode option support for METAR. If you require assistance, visit us <a href="http://www.beliefmedia.com/wp-plugins/metar.php" target="_blank">here</a>.';

 /* Shortcode Sidebar Form */

 $beliefmedia_metar_sc_mg = get_option('widget_shortcode');
 ($beliefmedia_metar_sc_mg == '1') ? $beliefmedia_metar_sc_mg = '<code>Currently set to <strong>Yes</strong> (active)</code>' : $beliefmedia_metar_sc_mg = '<code>Currently set to <strong>No</strong> (disabled)</code>';

 echo '<h3>Sidebar Shortcode Support?</h3>';
 echo 'Enable shortcode support to sidebar widgets? (Use <strong>only</strong> if your shortcode doesn\'t execute and instead shows plain text)';
 echo '<table class="form-table" style="width: 100%;">';
 echo '<tr><th scrope="row"><label for="scmsg">Enable Shortcodes in Widgets?</label></th>'; // <br>' . $beliefmedia_metar_sc_mg . '
 echo '<form method="post" action="">';
 echo '<td><select name="widget_shortcode" id="widget_shortcode"><option value="0">No</option><option value="1">Yes</option></select>&nbsp;<strong>Status</strong> :: ' . $beliefmedia_metar_sc_mg . '</td></tr>';	
 echo '</table>';
 echo '<p class="submit"><input type="submit" name="shortcode_sidebar" value="Update &raquo;" class="button button-primary" /></p>';
 echo '</form>';

 echo '<h3 class="title">Basic Usage</h3>';
 echo 'Basic airport METAR: <code>&#91;metar loc="yssy"&#93;</code><br>';
 echo 'Basic airport TAF: <code>&#91;taf loc="yssy"&#93;</code><br><br>';

 echo 'QNH (Hectopascals): <code>&#91;qnh loc="ymml"&#93;</code><br>';
 echo 'QNH (Inches Mercury): <code>&#91;qnh loc="ymml" unit="0"&#93;</code><br><br>';

 echo '<strong>Australian Report Considerations</strong><br><br>';

 echo 'To return an "untidy" report on multiple lines, use <code>tidy="0"</code> (does\'t remove line breaks)<br>';
 echo 'For area forcasts, use: <code>&#91;arfor loc="21"&#93;</code><br><br>';

 echo '<strong>Temperature &amp; Dew Point Temperature in Degrees Celsius</strong><br><br>';

 echo 'The following will return temperature in readable (integer) values (eg: 24, 9, -3)<br>';
 echo 'Temperature in degrees Celsius: <code>&#91;temperature loc="klax" temp="1"&#93;</code><br>';
 echo 'Dew Point Temperature in degrees Celsius: <code>&#91;temperature loc="ksfo" temp="2"&#93;</code><br><br>';

 echo '<strong>Return Temperature as Original Report Value</strong><br><br>';

 echo 'The following will return temperature as their original value (eg: 24, 09, M03)<br>';
 echo 'Temperature in degrees Celsius: <code>&#91;temperature loc="klax" temp="3"&#93;</code><br>';
 echo 'Dew Point Temperature in degrees Celsius: <code>&#91;temperature loc="ksfo" temp="4"&#93;</code><br><br>';

 echo '<strong>Return Temperature in (non-standard) Degrees Fahrenheit</strong><br><br>';

 echo 'Temperature in degrees Fahrenheit: <code>&#91;temperature loc="klax" temp="5"&#93;</code><br>';
 echo 'Dew Point Temperature in degrees Fahrenheit: <code>&#91;temperature loc="ksfo" temp="6"&#93;</code><br><br>';

 echo '<strong>Return Report Temperature (22/04, 13/M04 etc.)</strong><br><br>';

 echo '<code>&#91;temperature loc="klax" temp="7"&#93;</code><br><br>';

 echo '<strong>Other Options</strong><br><br>';

 echo 'To include a degrees sign after any temperature, use <code>degrees="1"</code><br>';
 echo 'By default we wrap the report in paragraph tags. To render inline, use <code>p="0"</code><br>';

echo '</div>';
}
