<?php
	/**
     * This section includes a sample query that demonstrate features of the API.
     * The code below query performs a time zone request for Github's server (San Francisco, California, United States). The timestamp is set to March 8th, 2012. 
     * 
     * @author Ivan Melgrati
	 * @copyright 2018
	 * @package    GoogleMapsTimeZone
	 * @author     Ivan Melgrati
	 * @version    1.5.0
	 */
    
    use imelgrat\GoogleMapsTimeZone\GoogleMapsTimeZone;
	require_once ('../src/GoogleMapsTimeZone.php');
    
    /**
     * All queries require an API key from Google
     * @link https://developers.google.com/maps/documentation/timezone/get-api-key
     * */
	define('API_KEY', 'YOUR API KEY HERE');

	// Initialize GoogleMapsTimeZone object (New York City coordinates)
	$timezone_object = new GoogleMapsTimeZone(40.730610, -73.935242, 0, GoogleMapsTimeZone::FORMAT_JSON);
    
    // Set Google API key
	$timezone_object->setApiKey(API_KEY);
    
    // Perform query 
	$timezone_data = $timezone_object->queryTimeZone();
	
	echo '<pre>';
	print_r($timezone_data);
	echo '</pre>';
?>