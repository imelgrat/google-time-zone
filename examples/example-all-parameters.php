<?php
	/**
     * This section includes a sample query that demonstrate features of the API.
     * The code below query performs a time zone request for Github's server (San Francisco, California, United States). The timestamp is set to March 8th, 2012. 
     * 
     * @author Ivan Melgrati
	 * @copyright 2018
	 * @package    GoogleMapsTimeZone
	 * @author     Ivan Melgrati
	 * @version    1.4.0
	 */

	require_once ('../src/GoogleMapsTimeZone.php');
    
    /**
     * All queries require an API key from Google
     * @link https://developers.google.com/maps/documentation/timezone/get-api-key
     * */
	define('API_KEY', 'YOUR API KEY HERE');

	// Create GoogleMapsTimeZone object with default properties
	$timezone_object = new GoogleMapsTimeZone();
    
    // Set Google API key
	$timezone_object->setApiKey(API_KEY);
    
    // Set XML as query return format
    $timezone_object->setFormat($timezone_object::FORMAT_XML);
    
    // Set French as query return language
    // Check  https://developers.google.com/maps/faq#languagesupport for a list of supported languages
    $timezone_object->setLanguage('fr');
    
    // Set latitude and longitude (New York City)
    $timezone_object->setLatitude(40.730610)->setLongitude(-73.935242);
    
    // Set Timestamp (server-side current time)
    $timezone_object->setTimestamp(time());
    
    // Perform query 
	$timezone_data = $timezone_object->queryTimeZone();

	echo '<pre>';
	print_r($timezone_data);
	echo '</pre>';

    
    // Set XML as query return format
    $timezone_object->setFormat($timezone_object::FORMAT_JSON);    
    
	// Set Arabic as query return language
    // Check  https://developers.google.com/maps/faq#languagesupport for a list of supported languages
    $timezone_object->setLanguage('ar');
    
    // Perform query 
	$timezone_data = $timezone_object->queryTimeZone();

	echo '<pre>';
	var_dump($timezone_data);
	echo '</pre>';
?>