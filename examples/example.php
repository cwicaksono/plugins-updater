<?php
require_once '../vendor/autoload.php';

$client = new Updater("https://github.com/cwicaksono/android_news_app", "");

$client->exec();
/*
TODO - get repo commit message
TODO - if is_update: return to download zip, else: your repository is latest
TODO - Github access token implementation
TODO - Bitbucket API
*/
?>
