<?php
	/**
	 * A PHP wrapper for the Google Maps TimeZone API.
	 *
	 * @package GoogleMapsTimeZone
	 * @author    Ivan Melgrati
     * @version   v1.5.0 
	 */
    
    namespace imelgrat\GoogleMapsTimeZone;
    
	if (!class_exists('GoogleMapsTimeZone'))
	{
		/**
		 * A PHP wrapper for the Google Maps TimeZone API. 
		 *
		 * The Google Maps Time Zone API provides a simple interface to request the time zone for a location on the earth, as well as that location's time offset from UTC.
		 * The API provides time offset data for locations on the surface of the earth. Requests for the time zone information are made for a specific latitude/longitude pair and date. 
		 * The API returns the name of that time zone (in different languages), the time offset from UTC, and the daylight savings offset in a user-selectable format (XML or JSON).
		 * In order to be able to use this class, it's necessary to provide an API key or, for business clients, Client ID and signing key.
		 * @author    Ivan Melgrati
         * @version   1.5.0
		 * @copyright Copyright 2018 by Ivan Melgrati
		 * @link https://developers.google.com/maps/documentation/timezone/intro
		 * @license   https://github.com/imelgrat/google-time-zone/blob/master/LICENSE
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
			 *  STATUS_SUCCESS No errors occurred, the coordinates were successfully parsed and at lease one time zone was returned.
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
			 * STATUS_INVALID_REQUEST Invalid request, indicates that the request was malformed or a mandatory parameter was missing
			 */
			const STATUS_INVALID_REQUEST = "INVALID_REQUEST";

			/**
			 * Request denied. Indicates that the the API did not complete the request. Confirm that the request was sent over HTTPS instead of HTTP.
			 */
			const STATUS_REQUEST_DENIED = "REQUEST_DENIED";

			/**
			 * STATUS_UNKNOWN_ERROR Unknown server error. May succeed if tried again.
			 */
			const STATUS_UNKNOWN_ERROR = "UNKNOWN_ERROR";

			/**
			 * Response format (XML or JSON).
             * 
             * @access protected
			 * @var string $format
			 */
			protected $format;

			/**
			 * Latitude to obtain the Time Zone for.
             * 
             * @access protected
			 * @var float|string $latitude
			 */
			protected $latitude;

			/**
			 * Longitude to obtain the Time Zone for.
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
			 * Google Maps API Client ID to authenticate Business clients with.
             * 
             * @access protected
			 * @var string $clientId
			 */
			protected $clientId;

			/**
			 * Google Maps API Cryptographic signing key to authenticate Business clients with.
             * 
             * @access protected
			 * @var string $signingKey
			 */
			protected $signingKey;		 

			/**
			 * Constructor. The request is not executed until `queryTimeZone()` is called.
			 *
			 * @param  float $latitude latitude of the location of the location to get timezone information for. Default: 0
			 * @param  float $longitude longitude of the location of the location to get timezone information for. Default: 0
			 * @param  integer|string $timestamp point in time to get timezone information from. Default: 0 (current time)
			 * @param  string $format optional response format (JSON default)
			 * @return GoogleMapsTimeZone
			 */
			public function __construct($latitude = 0, $longitude = 0, $timestamp = 0, $format = self::FORMAT_JSON)
			{
                $this->setLatitudeLongitude($latitude, $longitude)->setTimestamp($timestamp)->setFormat($format);
			}

			/**
			 * Set the response format (JSON or XML).
			 *
			 * @param  string $format response format
			 * @return GoogleMapsTimeZone
			 */
			public function setFormat($format)
			{
				$this->format = $format;

				return $this;
			}

			/**
			 * Get the response format (JSON or XML).
			 *
			 * @return string response format
			 */
			public function getFormat()
			{
				return $this->format;
			}

			/**
			 * Returns true if the response format is JSON.
			 *
			 * @return bool
			 */
			public function isFormatJson()
			{
				return $this->getFormat() == self::FORMAT_JSON;
			}

			/**
			 * Returns true if the response format is XML.
			 *
			 * @return bool
			 */
			public function isFormatXml()
			{
				return $this->getFormat() == self::FORMAT_XML;
			}

			/**
			 * Set the latitude/longitude of the location to get timezone information for
			 *
			 * @param  float|string $latitude latitude 
			 * @param  float|string $longitude longitude of the location of the location to get timezone information for
			 * @return GoogleMapsTimeZone
			 */
			public function setLatitudeLongitude($latitude, $longitude)
			{
				$this->setLatitude($latitude)->setLongitude($longitude);

				return $this;
			}

			/**
			 * Get the latitude/longitude of the location of the location to get timezone information for
			 * in comma-separated format.
			 *
			 * @return string|false comma-separated coordinates, or false if not set
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
			 * Set the latitude of the location of the location to get timezone information for
			 *
			 * @param  float|string $latitude latitude of the location of the location to get timezone information for
			 * @return GoogleMapsTimeZone
			 */
			public function setLatitude($latitude)
			{
				$this->latitude = $latitude;

				return $this;
			}

			/**
			 * Get the latitude of the location to get timezone information for
			 *
			 * @return float|string latitude of the location of the location to get timezone information for
			 */
			public function getLatitude()
			{
				return $this->latitude;
			}

			/**
			 * Set the longitude of the location to get timezone information for
			 *
			 * @param  float|string $longitude longitude of the location of the location to get timezone information for
			 * @return GoogleMapsTimeZone
			 */
			public function setLongitude($longitude)
			{
				$this->longitude = $longitude;

				return $this;
			}

			/**
			 * Get the longitude of the location to get timezone information for
			 *
			 * @return float|string longitude of the location of the location to get timezone information for
			 */
			public function getLongitude()
			{
				return $this->longitude;
			}

			/**
			 * Set the point in time to get timezone information for (used to determine whether or not DST is active).
			 * This can be used to get the selected place's timezone in a point in time.
			 *
			 * @param  integer|string $timestamp point in time to get timezone information for. Default: 0 (current time)
			 * @return GoogleMapsTimeZone
			 */
			public function setTimestamp($timestamp = 0)
			{
				$this->timestamp = intval($timestamp);

				return $this;
			}

			/**
			 * Get the point in time to get timezone information from (used to determine whether or not DST is active).
			 *
			 * @return integer|string point in time to get timezone information for.
			 */
			public function getTimestamp()
			{
				return $this->timestamp;
			}

			/**
			 * Set the language code in which to return results.
			 *
			 * @link   https://developers.google.com/maps/faq#languagesupport
			 * @param  string $language language code
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
			 * @return string language code
			 */
			public function getLanguage()
			{
				return $this->language;
			}

			/**
			 * Set the API key to authenticate with.
			 *
			 * @link   https://developers.google.com/maps/documentation/timezone/intro?hl=en
			 * @param  string $apiKey API key
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
			 * @link   https://developers.google.com/maps/documentation/timezone/intro?hl=en
			 * @return string API key
			 */
			public function getApiKey()
			{
				return $this->apiKey;
			}

			/**
			 * Set the client ID for Business clients.
			 *
			 * @link   https://developers.google.com/maps/documentation/business/webservices/#client_id
			 * @param  string $clientId client ID
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
			 * @return string client ID
			 */
			public function getClientId()
			{
				return $this->clientId;
			}

			/**
			 * Set the cryptographic signing key for Business clients.
			 *
			 * @link   https://developers.google.com/maps/documentation/business/webservices/#cryptographic_signing_key
			 * @param  string $signingKey cryptographic signing key
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
			 * @return string cryptographic signing key
			 */
			public function getSigningKey()
			{
				return $this->signingKey;
			}

			/**
			 * Whether the request is for a Business client.
			 *
			 * @return bool Returns true if the request is for a Business client. Otherwise, it returns false.
			 */
			public function isBusinessClient()
			{
				return $this->getClientId() && $this->getSigningKey();
			}

			/**
			 * Generate the signature for a Business client timezone request.
			 *
			 * @link   https://developers.google.com/maps/documentation/business/webservices/auth#digital_signatures
			 * @param  string $pathQueryString path and query string of the request
			 * @return string Base64 encoded signature that's URL safe
			 */
			protected function generateSignature($pathQueryString)
			{
				$decodedSigningKey = self::base64DecodeUrlSafe($this->getSigningKey());

				$signature = hash_hmac('sha1', $pathQueryString, $decodedSigningKey, true);
				$signature = self::base64EncodeUrlSafe($signature);

				return $signature;
			}

			/**
			 * Build the query string with all set parameters of the timezone request.
			 *
			 * @return string encoded query string of the timezone request
			 */
			protected function timezoneQueryString()
			{
				$queryString = array();

				// Get Latitude and Longitude of the location to get timezone information from.
				$latitudeLongitude = $this->getLatitudeLongitude();
                
                // Get timestamp as seconds since midnight, January 1, 1970 UTC                
				$timestamp = intval($this->getTimestamp());
                
                // Get language of the query results
				$language = trim($this->getLanguage());

				$queryString['location'] = $latitudeLongitude;

				// Optional language parameter.
				$queryString['language'] = $language;

				// Remove any unset parameters.
				$queryString = array_filter($queryString);
                
				// Optional language parameter (specified after array_filter to prevent deletion when timestamp = 0).
				$queryString['timestamp'] = $timestamp;

				// Get point in time to get timezone information from.

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
			 * Build the URL (with query string) of the timezone request.
			 *
			 * @return string URL of the timezone request
			 */
			protected function timezoneUrl()
			{
				// HTTPS is always required
				$scheme = "https";

				$pathQueryString = self::URL_PATH . $this->getFormat() . "?" . $this->timezoneQueryString();

				if ($this->isBusinessClient())
				{
					$pathQueryString .= "&signature=" . $this->generateSignature($pathQueryString);
				}

				return $scheme . "://" . self::URL_DOMAIN . $pathQueryString;
			}

			/**
			 * Execute the timezone request. The return type is based on the requested
			 * format: associative array if JSON, SimpleXMLElement object if XML. 
			 * Queries are performed using cURL and, if not available, using file_get_contents()
			 *
			 * @param  bool $raw If true, the function returns the raw (string) response. 
			 * Otherwise, it returns an array or SimpleXMLElement object with the decoded response.
			 * @param  resource $context stream context from `stream_context_create()`
			 * @return string|array|SimpleXMLElement response in requested format
			 */
			public function queryTimeZone($raw = false, $context = null)
			{
				if  (in_array  ('curl', get_loaded_extensions())) 
				{
					$options = array(
						CURLOPT_RETURNTRANSFER => true,   // return web page
						CURLOPT_HEADER         => false,  // don't return headers
						CURLOPT_FOLLOWLOCATION => true,   // follow redirects
						CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
						CURLOPT_ENCODING       => "",     // handle compressed
						CURLOPT_USERAGENT      => "test", // name of client
						CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
						CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
						CURLOPT_TIMEOUT        => 120,    // time-out on response
					); 

					$ch = curl_init($this->timezoneUrl());
					curl_setopt_array($ch, $options);
					$response  = curl_exec($ch);
				}
				else 
				{
					$response = file_get_contents($this->timezoneUrl(), false, $context);
				}				

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
					return new \SimpleXMLElement($response);
				}
				else
				{
					return $response;
				}
			}

			/**
			 * Encode a string with Base64 using only URL safe characters.
			 *
			 * @param  string $value value to encode
			 * @return string encoded value
			 */
			protected static function base64EncodeUrlSafe($value)
			{
				return strtr(base64_encode($value), '+/', '-_');
			}

			/**
			 * Decode a Base64 string that uses only URL safe characters.
			 *
			 * @param  string $value value to decode
			 * @return string decoded value
			 */
			protected static function base64DecodeUrlSafe($value)
			{
				return base64_decode(strtr($value, '-_', '+/'));
			}

		}
	}