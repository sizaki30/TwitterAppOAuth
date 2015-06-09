<?php
/**
 * Twitter Application-only authentication
 * https://dev.twitter.com/oauth/application-only
 *
 * @author sizaki30
 * @license MIT
 */
class TwitterAppOAuth
{
    private $_bearer_token;
    
    public function __construct($consumer_key, $consumer_secret)
    {
        $this->_bearer_token = $this->_getBearerToken($consumer_key, $consumer_secret);
    }
    
    private function _getBearerToken($consumer_key, $consumer_secret)
    {
        $oauth2_url = 'https://api.twitter.com/oauth2/token';
        
        $token = base64_encode(urlencode($consumer_key) . ':' . urlencode($consumer_secret));
        
        $request = array(
            'grant_type' => 'client_credentials'
        );
        
        $opts['http'] = array(
            'method'    => 'POST',
            'header'    => 'Content-type: application/x-www-form-urlencoded;charset=UTF-8' . "\r\n"
                         . 'Authorization: Basic ' . $token,
            'content'   => http_build_query($request, '', '&', PHP_QUERY_RFC3986)
        );
        
        $context = stream_context_create($opts);
        
        $response_json = file_get_contents($oauth2_url, false, $context);
        
        $response_arr = json_decode($response_json, true);
        
        return $response_arr['access_token'];
    }
    
    public function get($api, $params = array())
    {
        $api_url = 'https://api.twitter.com/1.1/' . $api . '.json';
        
        if ($params) {
            $request = http_build_query($params, '', '&', PHP_QUERY_RFC3986);
            $api_url .= '?' . $request;
        }
        
        $opts['http'] = array(
            'header' => 'Authorization: Bearer ' . $this->_bearer_token
        );
        
        $context = stream_context_create($opts);
        
        return file_get_contents($api_url, false, $context);
    }
}
