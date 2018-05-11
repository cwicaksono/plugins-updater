<?php
require_once '../vendor/autoload.php';

// example with woocommerce plugins
// $repo            = "https://github.com/woocommerce/woocommerce";
// $branch          = "release/3.3/";
// $core_file       = "woocommerce.php";
// $current_version = "3.3.4";

// $client = new Updater($repo, $branch, $core_file, $current_version, "");

// example with twitter plugins from github
// $client = new Updater("https://github.com/twitter/wordpress", "master/", "twitter", "2.0.1", "");

// example with bitbucket
$client = new Updater("https://bitbucket.org/cwicaksono/dummy_plugins", "master/", "woocommerce", "3.3.4", "");
?>
