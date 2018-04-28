<?php
/**
 *
 */
class Updater
{
    private $repo_name    = "";
    private $user_name    = "";
    private $base_url     = "https://api.github.com/repos/_user_/_repo_/branches";
    private $access_token = "";
    private $branch       = "";

    function __construct($repo_url, $token = "")
    {
        $this->access_token = $token;
        $this->branch = "master";
        $repos_url = preg_split('/\//', $repo_url);

        $this->repo_name = $repos_url[4];
        $this->user_name = $repos_url[3];

        $this->base_url = preg_replace('/_repo_/', $this->repo_name, $this->base_url);
        $this->base_url = preg_replace('/_user_/', $this->user_name, $this->base_url);
        // echo $this->base_url;
        // $this->callGitHubAPI($this->base_url, $this->user_name);

        $file_name = "./tmp/".$this->repo_name."-".$this->branch.".tar.gz";
        $file_data = file_get_contents($repo_url . "/archive/master.tar.gz");

    	// Create File
    	$handle = fopen($file_name, 'w');
    	fclose($handle);

    	// Save Content to file
    	$downloaded = file_put_contents($file_name, $file_data);
    	if($downloaded > 0)
    	{
    		echo 'Datei wurde erfolgreich heruntergeladen!<br>';
    	}

    	// exec('tar xfvz '. $file_name, $extract);
        //
    	// if($extract > 0)
    	// {
    	// 	echo 'Datei wurde entpackt';
    	// }
        // file_put_contents("./tmp/master.tar.gz", fopen($repo_url . "/archive/master.tar.gz"));
    }

    function callGitHubAPI($url, $username){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; rv:2.2) Gecko/20110201');;

        $output = curl_exec($ch);
        echo $output;

        curl_close($ch);
    }

}

?>
