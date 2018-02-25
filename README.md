google-time-zone
==================

[![License](https://poser.pugx.org/imelgrat/google-time-zone/license)](https://packagist.org/packages/imelgrat/google-time-zone)
[![Latest Stable Version](https://poser.pugx.org/imelgrat/google-time-zone/v/stable)](https://packagist.org/packages/imelgrat/google-time-zone)
[![Total Downloads](https://poser.pugx.org/imelgrat/google-time-zone/downloads)](https://packagist.org/packages/imelgrat/google-time-zone)

A PHP wrapper for the Google Maps TimeZone API. 

The Google Maps Time Zone API provides a simple interface to request the time zone for a location on the earth, as well as that location's time offset from UTC.

The API provides time offset data for any locations on Earch. Requests for the time zone information are made for a specific latitude/longitude pair and timestamp. 

The class automates the query process and returns the name of that time zone (in different languages), the time offset from UTC, and the daylight savings offset in a user-selectable format (XML or JSON).


Developed by [Ivan Melgrati](https://imelgrat.me) 

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

1.  Copy `src/google-time-zone.php` to your codebase, perhaps to the `vendor`
    directory.
2.  Add the `GoogleMapsTimeZone` class to your autoloader or `require` the file
    directly.

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
