<?php
/**
 * Created By: Nilesh Sadarangani <nileshsani@gmail.com>
 * Date: 08/07/14
 */
ini_set('display_errors', 1);
require_once('library/TwitterAPIExchange.php');
require_once('config/config.php');

/**
 * Please set the key values in config.php
 */
$settings = array(
    'oauth_access_token' => OAUTH_ACCESS_TOKEN,
    'oauth_access_token_secret' => OAUTH_ACCESS_TOKEN_SECRET,
    'consumer_key' => CONSUMER_KEY,
    'consumer_secret' => CONSUMER_SECRET
);

$requestMethod = 'GET';
$screenName = $_POST['screen_name'];
$getField = '?screen_name=' . $screenName . '&count=' . TWEET_COUNT;

$twitter = new TwitterAPIExchange($settings);
$responses = $twitter->setGetfield($getField)
    ->buildOauth(TWITTER_TIMELINE_API, $requestMethod)
    ->performRequest();
$responses = json_decode($responses, true);

/**
 * Render views now
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title>Twitter Integration - Result Page</title>
    <link rel="stylesheet" type="text/css" href="css/layout.css">
</head>
<body>
    <div style="width:600px; border:1px solid #000; padding: 10px 10px 10px 10px;">
        <?php if (!array_key_exists('errors', $responses)) { ?>
            <div class="title" id="screen_name" style="float: left; font-weight: bold; margin-right:20px; ">Screen Name: <?php echo $screenName; ?></div>
            <div class="title" id="followers" style="float: left; font-weight: bold; margin-right:20px; ">Number of Tweets: <?php echo $responses[0]['user']['listed_count']; ?></div>
            <div class="title" id="followers" style="float: left; font-weight: bold; margin-right:20px; ">Following: <?php echo $responses[0]['user']['friends_count']; ?></div>
            <div class="title" id="followers" style="float: left; font-weight: bold;">Followers: <?php echo $responses[0]['user']['followers_count']; ?></div>
                <br style="clear: both;">
            <?php foreach ($responses as $response) { ?>
                        <div style="border:1px dotted #000; float:left; margin: 10px 0px 0px 0px; font-style: italic;">
                            <?php echo $response['text']; ?>
                        </div>
            <?php
                  }
            } else {
                echo "Error occurred : " . $responses['errors'][0]['message'];
            }
        ?>
        <br style='clear:both;'>
    </div>
</body>
</html>