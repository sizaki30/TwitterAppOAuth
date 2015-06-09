# TwitterAppOAuth
A library of Twitter Application-only authentication.
https://dev.twitter.com/oauth/application-only

##Requirements
* php >= 5.4.0

## Usage
```PHP
$connection = new TwitterAppOAuth($consumer_key, $consumer_secret);

$params = array(
    'q' => 'twitterapi'
);

$statuses = $connection->get('search/tweets', $params);
```
