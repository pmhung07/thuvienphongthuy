<?php
/**
 * @version 1.1
 * @package dinke.net
 * @copyright &copy; 2007 Dinke.net
 * @author Dragan Dinic <dragan@dinke.net>
 */

/**
 * Curl based HTTP Client 
 * Simple but effective OOP wrapper around Curl php lib.
 * Contains common methods needed 
 * for getting data from url, setting referrer, credentials, 
 * sending post data, managing cookies, etc.
 * 
 * Samle usage:
 * $curl = &new Curl_HTTP_Client();
 * $useragent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)";
 * $curl->set_user_agent($useragent);
 * $curl->store_cookies("/tmp/cookies.txt");
 * $post_data = array('login' => 'pera', 'password' => 'joe');
 * $html_data = $curl->send_post_data(http://www.foo.com/login.php, $post_data);
 */
class Curl_HTTP_Client
{
	/**
	 * Curl handler
	 * @access private
	 * @var resource
	 */
	var $ch ;

	/**
	 * set debug to true in order to get usefull output
	 * @access private
	 * @var string
	 */
	var $debug = false;

	/**
	 * Contain last error message if error occured
	 * @access private
	 * @var string
	 */
	var $error_msg;
	var $result;


	/**
	 * Curl_HTTP_Client constructor
	 * @param boolean debug
	 * @access public
	 */
	function Curl_HTTP_Client($debug = false)
	{
		$this->debug = $debug;

		// initialize curl handle
		$this->ch = curl_init();

		//set various options

		//set error in case http return code bigger than 300
		curl_setopt($this->ch, CURLOPT_FAILONERROR, true);
		curl_setopt($this->ch, CURLOPT_HTTPHEADER, array('Expect:'));
		// allow redirects
		curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);

		//hack to make code work on windows
		//if(strpos(PHP_OS,"WIN") !== false)
		{
			curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
		}
	}

	/**
	 * Set username/pass for basic http auth
	 * @param string user
	 * @param string pass
	 * @access public
	 */
	function set_credentials($username,$password)
	{
		curl_setopt($this->ch, CURLOPT_USERPWD, "$username:$password");
	}

	/**
	 * Set referrer
	 * @param string referrer url 
	 * @access public
	 */
	function set_referrer($referrer_url)
	{
		curl_setopt($this->ch, CURLOPT_REFERER, $referrer_url);
	}

	/**
	 * Set client's useragent
	 * @param string user agent
	 * @access public
	 */
	function set_user_agent($useragent)
	{
		curl_setopt($this->ch, CURLOPT_USERAGENT, $useragent);
	}

	/**
	 * Set to receive output headers in all output functions
	 * @param boolean true to include all response headers with output, false otherwise
	 * @access public
	 */
	function include_response_headers($value)
	{
		curl_setopt($this->ch, CURLOPT_HEADER, $value);
	}


	/**
	 * Set proxy to use for each curl request
	 * @param string proxy
	 * @access public
	 */
	function set_proxy($proxy)
	{
		curl_setopt($this->ch, CURLOPT_PROXY, $proxy);
	}



	/**
	 * Send post data to target URL	 
	 * return data returned from url or false if error occured
	 * @param string url
	 * @param array assoc post data array ie. $foo['post_var_name'] = $value
	 * @param string ip address to bind (default null)
	 * @param int timeout in sec for complete curl operation (default 10)
	 * @return string data
	 * @access public
    */
	function send_post_data($url, $postdata, $ip=null, $timeout=30)
	{
		//set various curl options first

		// set url to post to
		curl_setopt($this->ch, CURLOPT_URL,$url);

		// return into a variable rather than displaying it
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER,true);

		//bind to specific ip address if it is sent trough arguments
		if($ip)
		{
			if($this->debug)
			{
				echo "Binding to ip $ip\n";
			}
			curl_setopt($this->ch,CURLOPT_INTERFACE,$ip);
		}

		//set curl function timeout to $timeout
		curl_setopt($this->ch, CURLOPT_TIMEOUT, $timeout);

		//set method to post
		curl_setopt($this->ch, CURLOPT_POST, true);


		//generate post string
		$post_array = array();
		if(!is_array($postdata))
		{
			return false;
		}
		foreach($postdata as $key=>$value)
		{
			$post_array[] = urlencode($key) . "=" . urlencode($value);
		}

		$post_string = implode("&",$post_array);

		if($this->debug)
		{
			echo "Post String: $post_string\n";
		}

		// set post string
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, $post_string);


		//and finally send curl request
		$this->result = curl_exec($this->ch);

		if(curl_errno($this->ch))
		{
			if($this->debug)
			{
				echo "Error Occured in Curl\n";
				echo "Error number: " .curl_errno($this->ch) ."\n";
				echo "Error message: " .curl_error($this->ch)."\n";
			}

			return false;
		}
		else
		{
			return $this->result;
		}
	}

	/**
	 * fetch data from target URL	 
	 * return data returned from url or false if error occured
	 * @param string url	 
	 * @param string ip address to bind (default null)
	 * @param int timeout in sec for complete curl operation (default 5)
	 * @return string data
	 * @access public
    */
	function fetch_url($url, $ip=null, $timeout=60)
	{
		// set url to post to
		curl_setopt($this->ch, CURLOPT_URL,$url);

		//set method to get
		curl_setopt($this->ch, CURLOPT_HTTPGET,true);

		// return into a variable rather than displaying it
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER,true);

		//bind to specific ip address if it is sent trough arguments
		if($ip)
		{
			if($this->debug)
			{
				echo "Binding to ip $ip\n";
			}
			curl_setopt($this->ch,CURLOPT_INTERFACE,$ip);
		}

		//set curl function timeout to $timeout
		curl_setopt($this->ch, CURLOPT_TIMEOUT, $timeout);

		//and finally send curl request
		$this->result = curl_exec($this->ch);

		if(curl_errno($this->ch))
		{
			if($this->debug)
			{
				echo "Error Occured in Curl\n";
				echo "Error number: " .curl_errno($this->ch) ."\n";
				echo "Error message: " .curl_error($this->ch)."\n";
			}

			return false;
		}
		else
		{
			return $this->result;
		}
	}

	/**
	 * Fetch data from target URL
	 * and store it directly to file	 	 
	 * @param string url	 
	 * @param resource value stream resource(ie. fopen)
	 * @param string ip address to bind (default null)
	 * @param int timeout in sec for complete curl operation (default 5)
	 * @return boolean true on success false othervise
	 * @access public
    */
	function fetch_into_file($url, $fp, $ip=null, $timeout=5)
	{
		// set url to post to
		curl_setopt($this->ch, CURLOPT_URL,$url);

		//set method to get
		curl_setopt($this->ch, CURLOPT_HTTPGET, true);

		// store data into file rather than displaying it
		curl_setopt($this->ch, CURLOPT_FILE, $fp);

		//bind to specific ip address if it is sent trough arguments
		if($ip)
		{
			if($this->debug)
			{
				echo "Binding to ip $ip\n";
			}
			curl_setopt($this->ch, CURLOPT_INTERFACE, $ip);
		}

		//set curl function timeout to $timeout
		curl_setopt($this->ch, CURLOPT_TIMEOUT, $timeout);

		//and finally send curl request
		$this->result = curl_exec($this->ch);

		if(curl_errno($this->ch))
		{
			if($this->debug)
			{
				echo "Error Occured in Curl\n";
				echo "Error number: " .curl_errno($this->ch) ."\n";
				echo "Error message: " .curl_error($this->ch)."\n";
			}

			return false;
		}
		else
		{
			return true;
		}
		fclose($fp);
	}

	/**
	 * Send multipart post data to the target URL	 
	 * return data returned from url or false if error occured
	 * (contribution by vule nikolic, vule@dinke.net)
	 * @param string url
	 * @param array assoc post data array ie. $foo['post_var_name'] = $value
	 * @param array assoc $file_field_array, contains file_field name = value - path pairs
	 * @param string ip address to bind (default null)
	 * @param int timeout in sec for complete curl operation (default 30 sec)
	 * @return string data
	 * @access public
    */


	/**
	 * Set file location where cookie data will be stored and send on each new request
	 * @param string absolute path to cookie file (must be in writable dir)
	 * @access public
	 */
	     function CurlFileUploader ($filePath, $uploadURL, $formFileVariableName, /* assosiative array */ $otherParams = false) {
        $this->filePath = $filePath;
        $this->uploadURL = $uploadURL;
        if(is_array($otherParams) && $otherParams != false) {
            foreach ($otherParams as $fieldName => $fieldValue) {
                $this->postParams[$fieldName] = $fieldValue;
            }
        }
        $this->postParams[$formFileVariableName] = "".$filePath;
        
    }
    
    /*
    * function to upload file
    * if unable to upload file produce error and exit
    * else upload file
    */
    function UploadFile () {
           $ch = curl_init();
           curl_setopt($ch, CURLOPT_URL, $this->uploadURL );
           curl_setopt($ch, CURLOPT_POST, 1 );
           print_r($this->postParams);
           curl_setopt($ch, CURLOPT_POSTFIELDS, $this->postParams);
           curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
           $postResult = curl_exec($ch);

           if (curl_errno($ch)) {
               print curl_error($ch);
               print "<br>Unable to upload file.";
               exit();
           }
           curl_close($ch);
        
    } 
	function store_cookies($cookie_file)
	{
		// use cookies on each request (cookies stored in $cookie_file)
		curl_setopt ($this->ch, CURLOPT_COOKIEJAR, $cookie_file);
		
	}
	function use_cookies($cookie_file)
	{
		curl_setopt ($this->ch, CURLOPT_COOKIEFILE, $cookie_file);
	}
	function set_cookies($name)
	{
		curl_setopt ($this->ch, CURLOPT_COOKIE, $name);
	}

	/**
	 * Get last URL info 
	 * usefull when original url was redirected to other location	
	 * @access public
	 * @return string url
	 */
	function get_effective_url()
	{
		return curl_getinfo($this->ch,CURLINFO_EFFECTIVE_URL);
	}

	/**
	 * Get http response code	 
	 * @access public
	 * @return int
	 */
	function get_http_response_code()
	{
		return curl_getinfo($this->ch,CURLINFO_HTTP_CODE);
	}

	/**
	 * Return last error message and error number
	 * @return string error msg
	 * @access public
    */
	function get_error_msg()
	{
		$err = "Error number: " .curl_errno($this->ch) ."\n";
		$err .="Error message: " .curl_error($this->ch)."\n";

		return $err;
	}
	function close()
	{
		curl_close($this->ch);
		unset($this->ch);
	}
}

?>