google-time-zone
==================

[![GitHub license](https://img.shields.io/github/license/imelgrat/google-time-zone.svg?style=flat-square)](https://github.com/imelgrat/google-time-zone/blob/master/LICENSE)
[![GitHub release](https://img.shields.io/github/release/imelgrat/google-time-zone.svg?style=flat-square)](https://github.com/imelgrat/google-time-zone/releases)
[![Total Downloads](https://poser.pugx.org/imelgrat/google-time-zone/downloads)](https://packagist.org/packages/imelgrat/google-time-zone)
[![GitHub issues](https://img.shields.io/github/issues/imelgrat/google-time-zone.svg?style=flat-square)](https://github.com/imelgrat/google-time-zone/issues)
[![GitHub stars](https://img.shields.io/github/stars/imelgrat/google-time-zone.svg?style=flat-square)](https://github.com/imelgrat/google-time-zone/stargazers)

A PHP wrapper for the Google Maps TimeZone API. 

The Google Maps Time Zone API provides a simple interface to request the time zone for a location on the earth, as well as that location's time offset from UTC.

The API provides time offset data for any locations on Earch. Requests for the time zone information are made for a specific latitude/longitude pair and timestamp. 

The class automates the query process and returns the name of that time zone (in different languages), the time offset from UTC, and the daylight savings offset in a user-selectable format (XML or JSON).


Developed by [Ivan Melgrati](https://imelgrat.me)
 
=======
A PHP wrapper for the Google Maps Time Zone API.

Developed by [Ivan Melgrati](https://imelgrat.me) [![Twitter](https://img.shields.io/twitter/url/https/github.com/imelgrat/tab-collapse.svg?style=social)](https://twitter.com/imelgrat)

Requirements
------------

*   PHP >= 5.3.0
*   In order to be able to use this class, it's necessary to provide an API key or, for business clients, Client ID and signing key.

Installation
------------

### Composer

The recommended installation method is through
[Composer](http://getcomposer.org/), a dependency manager for PHP. Just add
`imelgrat/google-time-zone` to your project's `composer.json` file:

```json
{
    "require": {
        "imelgrat/google-time-zone": "*"
    }
}
```

[More details](http://packagist.org/packages/imelgrat/google-time-zone) can be found over at [Packagist](http://packagist.org).

### Manually

1.  Copy `src/GoogleMapsTimeZone.php` to your codebase, perhaps to the `vendor`
    directory.
2.  Add the `GoogleMapsTimeZone` class to your autoloader or `require` the file
    directly.
	

Then, in order to use the GoogleMapsTimeZone class, you need to invoke the "use" operator to bring the class into skope.

```php
<?php
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
```

Feedback
--------

Please open an issue to request a feature or submit a bug report. Or even if
you just want to provide some feedback, I'd love to hear. I'm also available on
Twitter as [@imelgrat](https://twitter.com/imelgrat).

Contributing
------------

1.  Fork it.
2.  Create your feature branch (`git checkout -b my-new-feature`).
3.  Commit your changes (`git commit -am 'Added some feature'`).
4.  Push to the branch (`git push origin my-new-feature`).
5.  Create a new Pull Request.
