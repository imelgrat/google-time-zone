<?php

/**
 * A PHP wrapper for the Google Maps Time Zone API.
 *
 * @package GoogleMapsTimeZone
 * @author  Ivan Melgrati
 * @version v1.2.0 stable
 */

if (!class_exists('GoogleMapsTimeZone'))
{
    /**
     * A PHP wrapper for the Google Maps Time Zone API.
     *
     * @author    Ivan Melgrati
     * @copyright Copyright 2016 by Ivan Melgrati
     * @license   https://github.com/imelgrat/google-time-zone/blob/master/LICENSE
     * @link      https://developers.google.com/maps/documentation/timezone/intro
     * @version   v1.2.0 stable
     */
    class GoogleMapsTimeZone
    {
        /**
         * URL_DOMAIN Domain portion of the Google Maps Time Zone API URL.
         */
        const URL_DOMAIN = "maps.googleapis.com";

        /**
         * URL_PATH Path portion of the Google Maps Time Zone API URL.
         */
        const URL_PATH = "/maps/api/timezone/";

        /**
         * HTTPS URL of the Google Maps Time Zone API.
         */
        const URL_HTTPS = "https://maps.googleapis.com/maps/api/timezone/";

        /**
         * FORMAT_JSON JSON response format.
         */
        const FORMAT_JSON = "json";

        /**
         * FORMAT_XML XML response format.
         */
        const FORMAT_XML = "xml";

        /**
         * STATUS_SUCCESS No errors occurred, the coordinates were successfully parsed and at least one time zone was returned.
         */
        const STATUS_SUCCESS = "OK";

        /**
         * STATUS_NO_RESULTS Coordinates parsing was successful, but returned no results. Indicates that no time zone data could be found for the specified position or time. Confirm that the request is for a location on land, and not over water.
         */
        const STATUS_NO_RESULTS = "ZERO_RESULTS";

        /**
         * STATUS_OVER_LIMIT Over limit of 2,500 (100,000 if premier) requests per day.
         */
        const STATUS_OVER_LIMIT = "OVER_QUERY_LIMIT";

        /**
         * STATUS_INVALID_REQUEST Invalid request, indicates that the request was malformed or a mandatory parameter was missing.
         */
        const STATUS_INVALID_REQUEST = "INVALID_REQUEST";

        /**
         * Request denied. Indicates that the API did not complete the request. Confirm that the request was sent over HTTPS instead of HTTP.
         */
        const STATUS_REQUEST_DENIED = "REQUEST_DENIED";

        /**
         * STATUS_UNKNOWN_ERROR Unknown server error. May succeed if tried again.
         */
        const STATUS_UNKNOWN_ERROR = "UNKNOWN_ERROR";

        /**
         * Response format.
         *
         * @access protected
         * @var string $format
         */
        protected $format;

        /**
         * Latitude to obtain the Time Zone from.
         *
         * @access protected
         * @var float|string $latitude
         */
        protected $latitude;

        /**
         * Longitude to obtain the Time Zone from.
         *
         * @access protected
         * @var float|string $longitude
         */
        protected $longitude;

        /**
         * Desired time as seconds since midnight, January 1, 1970 UTC. The Google Maps Time Zone API uses the timestamp to determine whether or not Daylight Savings should be applied. Times before 1970 can be expressed as negative values.
         *
         * @access protected
         * @var integer $timestamp
         *
         */
        protected $timestamp;

        /**
         * Language code in which to return results.
         *
         * @access protected
         * @var string $language
         */
        protected $language;

        /**
         * Google Maps API key to authenticate with.
         *
         * @access protected
         * @var string $apiKey
         */
        protected $apiKey;

        /**
         * Google Maps API Client ID for Business clients.
         *
         * @access protected
         * @var string $clientId
         */
        protected $clientId;

        /**
         * Google Maps API Cryptographic signing key for Business clients.
         *
         * @access protected
         * @var string $signingKey
         */
        protected $signingKey;

        /**
         * Constructor. The request is not executed until `queryTimeZone()` is called.
         *
         * @param  float $latitude Latitude of the location to get time zone information from.
         * @param  float $longitude Longitude of the location to get time zone information from.
         * @param  integer|string $timestamp Point in time to get time zone information from. Default: 0 (current time).
         * @param  string $format Optional response format. Default: JSON.
         * @return GoogleMapsTimeZone
         */
        public function __construct($latitude = 0, $longitude = 0, $timestamp = 0, $format = self::FORMAT_JSON)
        {
        $this->setLatitudeLongitude($latitude, $longitude)->setTimestamp($timestamp)->setFormat($format);
        }

        /**
         * Set the response format.
         *
         * @link   https://developers.google.com/maps/documentation/timezone/intro#Responses
         * @param  string $format Response format.
         * @return GoogleMapsTimeZone
         */
        public function setFormat($format)
        {
            $this->format = $format;

            return $this;
        }

        /**
         * Get the response format.
         *
         * @link   https://developers.google.com/maps/documentation/timezone/intro#Responses
         * @return string Response format.
         */
        public function getFormat()
        {
            return $this->format;
        }

        /**
         * Whether the response format is JSON.
         *
         * @link   https://developers.google.com/maps/documentation/timezone/intro#Requests
         * @return bool Ehether JSON.
         */
        public function isFormatJson()
        {
            return $this->getFormat() == self::FORMAT_JSON;
        }

        /**
         * Whether the response format is XML.
         *
         * @link   https://developers.google.com/maps/documentation/timezone/intro#Requests
         * @return bool whether XML
         */
        public function isFormatXml()
        {
            return $this->getFormat() == self::FORMAT_XML;
        }

        /**
         * Set the latitude/longitude of the location to get time zone information from.
         *
         * @link   https://developers.google.com/maps/documentation/timezone/intro#Usage
         * @param  float|string $latitude Latitude of the location to get time zone information from.
         * @param  float|string $longitude Longitude of the location to get time zone information from.
         * @return GoogleMapsTimeZone
         */
        public function setLatitudeLongitude($latitude, $longitude)
        {
            $this->setLatitude($latitude)->setLongitude($longitude);

            return $this;
        }

        /**
         * Get the latitude/longitude of the location to get time zone information from in comma-separated format.
         *
         * @link   https://developers.google.com/maps/documentation/timezone/intro#Usage
         * @return string|false Comma-separated coordinates, or false if not set.
         */
        public function getLatitudeLongitude()
        {
            $latitude = $this->getLatitude();
            $longitude = $this->getLongitude();

            if ($latitude && $longitude)
            {
                return $latitude . "," . $longitude;
            }
            else
            {
                return false;
            }
        }

        /**
         * Set the latitude of the location to get time zone information from.
         *
         * @link   https://developers.google.com/maps/documentation/timezone/intro#Usage
         * @param  float|string $latitude Latitude of the location to get time zone information from.
         * @return GoogleMapsTimeZone
         */
        public function setLatitude($latitude)
        {
            $this->latitude = $latitude;

            return $this;
        }

        /**
         * Get the latitude of the location to get time zone information from.
         *
         * @link   https://developers.google.com/maps/documentation/timezone/intro#Usage
         * @return float|string Latitude of the location to get time zone information from.
         */
        public function getLatitude()
        {
            return $this->latitude;
        }

        /**
         * Set the longitude of the location to get time zone information from.
         *
         * @link   https://developers.google.com/maps/documentation/timezone/intro#Usage
         * @param  float|string $longitude Longitude of the location to get time zone information from.
         * @return GoogleMapsTimeZone
         */
        public function setLongitude($longitude)
        {
            $this->longitude = $longitude;

            return $this;
        }

        /**
         * Get the longitude of the location to get time zone information from.
         *
         * @link   https://developers.google.com/maps/documentation/timezone/intro#Usage
         * @return float|string Longitude of the location to get time zone information from.
         */
        public function getLongitude()
        {
            return $this->longitude;
        }

        /**
         * Set the point in time to get time zone information from (used to determine whether or not DST is active).
         *
         * @link   https://developers.google.com/maps/documentation/timezone/intro#Usage
         * @param  integer|string $timestamp Point in time to get time zone information from. Default: 0 (current time).
         * @return GoogleMapsTimeZone
         */
        public function setTimestamp($timestamp = 0)
        {
            $this->timestamp = intval($timestamp);

            return $this;
        }

        /**
         * Get the point in time to get time zone information from (used to determine whether or not DST is active).
         *
         * @link   https://developers.google.com/maps/documentation/timezone/intro#Usage
         * @return integer|string Point in time to get time zone information from.
         */
        public function getTimestamp()
        {
            return $this->timestamp;
        }

        /**
         * Set the language code in which to return results.
         *
         * @link   https://developers.google.com/maps/faq#languagesupport
         * @param  string $language Language code.
         * @return GoogleMapsTimeZone
         */
        public function setLanguage($language)
        {
            $this->language = $language;

            return $this;
        }

        /**
         * Get the language code in which to return results.
         *
         * @link   https://developers.google.com/maps/faq#languagesupport
         * @return string Language code.
         */
        public function getLanguage()
        {
            return $this->language;
        }

        /**
         * Set the API key to authenticate with.
         *
         * @link   https://developers.google.com/console/help/new/#UsingKeys
         * @param  string $apiKey API key.
         * @return GoogleMapsTimeZone
         */
        public function setApiKey($apiKey)
        {
            $this->apiKey = $apiKey;

            return $this;
        }

        /**
         * Get the API key to authenticate with.
         *
         * @link   https://developers.google.com/console/help/new/#UsingKeys
         * @return string API key.
         */
        public function getApiKey()
        {
            return $this->apiKey;
        }

        /**
         * Set the client ID for Business clients.
         *
         * @link   https://developers.google.com/maps/documentation/business/webservices/#client_id
         * @param  string $clientId Client ID.
         * @return GoogleMapsTimeZone
         */
        public function setClientId($clientId)
        {
            $this->clientId = $clientId;

            return $this;
        }

        /**
         * Get the client ID for Business clients.
         *
         * @link   https://developers.google.com/maps/documentation/business/webservices/#client_id
         * @return string Client ID.
         */
        public function getClientId()
        {
            return $this->clientId;
        }

        /**
         * Set the cryptographic signing key for Business clients.
         *
         * @link   https://developers.google.com/maps/documentation/business/webservices/#cryptographic_signing_key
         * @param  string $signingKey Cryptographic signing key.
         * @return GoogleMapsTimeZone
         */
        public function setSigningKey($signingKey)
        {
            $this->signingKey = $signingKey;

            return $this;
        }

        /**
         * Get the cryptographic signing key for Business clients.
         *
         * @link   https://developers.google.com/maps/documentation/business/webservices/#cryptographic_signing_key
         * @return string Cryptographic signing key.
         */
        public function getSigningKey()
        {
            return $this->signingKey;
        }

        /**
         * Whether the request is for a Business client.
         *
         * @return bool Whether the request is for a Business client.
         */
        public function isBusinessClient()
        {
            return $this->getClientId() && $this->getSigningKey();
        }

        /**
         * Generate the signature for a Business client time zone request.
         *
         * @link   https://developers.google.com/maps/documentation/business/webservices/auth#digital_signatures
         * @param  string $pathQueryString Path and query string of the request.
         * @return string Base64 encoded Signature that's URL safe.
         */
        protected function generateSignature($pathQueryString)
        {
            $decodedSigningKey = self::base64DecodeUrlSafe($this->getSigningKey());

            $signature = hash_hmac('sha1', $pathQueryString, $decodedSigningKey, true);
            $signature = self::base64EncodeUrlSafe($signature);

            return $signature;
        }

        /**
         * Build the query string with all set parameters of the time zone request.
         *
         * @link   https://developers.google.com/maps/documentation/timezone/intro#Requests
         * @return string Encoded query string of the time zone request.
         */
        protected function timezoneQueryString()
        {
            $queryString = array();

            // Get Latitude and Longitude of the location to get time zone information from.
            $latitudeLongitude = $this->getLatitudeLongitude();

            // Get timestamp as seconds since midnight, January 1, 1970 UTC
            $timestamp = intval($this->getTimestamp());

            // Get language of the query results.
            $language = trim($this->getLanguage());

            $queryString['location'] = $latitudeLongitude;

            // Optional language parameter.
            $queryString['language'] = $language;

            // Remove any unset parameters.
            $queryString = array_filter($queryString);

            // Optional language parameter (specified after array_filter to prevent deletion when timestamp = 0).
            $queryString['timestamp'] = $timestamp;

            // Get point in time to get time zone information from.

            // The signature is added later using the path + query string.
            if ($this->isBusinessClient())
            {
                $queryString['client'] = $this->getClientId();
            }
            elseif ($this->getApiKey())
            {
                $queryString['key'] = $this->getApiKey();
            }

            // Convert array to proper query string.
            return http_build_query($queryString);
        }

        /**
         * Build the URL (with query string) of the time zone request.
         *
         * @link   https://developers.google.com/maps/documentation/timezone/intro#Requests
         * @return string URL of the time zone request.
         */
        protected function timezoneUrl()
        {
            // HTTPS is always required.
            $scheme = "https";

            $pathQueryString = self::URL_PATH . $this->getFormat() . "?" . $this->timezoneQueryString();

            if ($this->isBusinessClient())
            {
                $pathQueryString .= "&signature=" . $this->generateSignature($pathQueryString);
            }

            return $scheme . "://" . self::URL_DOMAIN . $pathQueryString;
        }

        /**
         * Execute the time zone request. The return type is based on the requested
         * format: associative array if JSON, SimpleXMLElement object if XML.
         *
         * @link   https://developers.google.com/maps/documentation/timezone/intro#Responses
         * @param  bool $raw Whether to return the raw (string) response.
         * @param  resource $context Stream context from `stream_context_create()`.
         * @return string|array|SimpleXMLElement Response in requested format.
         */
        public function queryTimeZone($raw = false, $context = null)
        {
            $response = file_get_contents($this->timezoneUrl(), false, $context);

            if ($raw)
            {
                return $response;
            }
            elseif ($this->isFormatJson())
            {
                return json_decode($response, true);
            }
            elseif ($this->isFormatXml())
            {
                return new SimpleXMLElement($response);
            }
            else
            {
                return $response;
            }
        }

        /**
         * Encode a string with Base64 using only URL safe characters.
         *
         * @param  string $value Value to encode.
         * @return string encoded Value.
         */
        protected static function base64EncodeUrlSafe($value)
        {
            return strtr(base64_encode($value), '+/', '-_');
        }

        /**
         * Decode a Base64 string that uses only URL safe characters.
         *
         * @param  string $value Value to decode.
         * @return string decoded Value.
         */
        protected static function base64DecodeUrlSafe($value)
        {
            return base64_decode(strtr($value, '-_', '+/'));
        }
    }
}
