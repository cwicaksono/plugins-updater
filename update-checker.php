<?php
/**
 *
 */
class Updater
{
    private $repo_url     = "";
    private $repo_name    = "";
    private $user_name    = "";
    private $base_url     = "https://api.github.com/repos/_user_/_repo_/branches";
    private $access_token = "";
    private $branch       = "";
    private $core_file    = "";

    function __construct($repo_url, $branch, $core_file, $current_version, $token = "")
    {
        $this->writeLog("setup Updater");
        $this->repo_url = $repo_url;
        $this->access_token = $token;
        $this->branch = $branch;
        $this->core_file = $core_file;

        $repos_url = preg_split('/\//', $repo_url);

        $this->repo_name = $repos_url[4];
        $this->user_name = $repos_url[3];

        $this->base_url = preg_replace('/_repo_/', $this->repo_name, $this->base_url);
        $this->base_url = preg_replace('/_user_/', $this->user_name, $this->base_url);

        // get repo version
        $this->writeLog("get version from core file");
        $contents = preg_split('/Version:\ /', $this->readCoreFile())[1];
        $repo_version = trim(preg_split('/\n/', $contents)[0]);

        $this->writeLog("compare current version with repo version " . $repo_version ." vs " . $current_version);

        // compare current_version with repo_version
        if($current_version != $repo_version){

            $this->writeLog("download patch");

            $branch = preg_replace('/\//', '', $this->branch);
            $file_name = "./tmp/".$this->core_file."-".$branch.".tar.gz";

            $this->writeLog("start downloading");
            $file_data = file_get_contents($repo_url . "/archive/".$this->branch.".tar.gz");

            $handle = fopen($file_name, 'w');
            fclose($handle);

            // Save Content to file
            $downloaded = file_put_contents($file_name, $file_data);
            if($downloaded > 0)
            {
                echo 'file downloaded';
                $this->writeLog("Complete.");
            }

        }
        
    }

    function readCoreFile(){
        $file = $this->repo_url . "/" . $this->branch . $this->core_file . ".php";

        $core_file_raw = preg_replace('/github.com/', "raw.githubusercontent.com", $file);
        
        $core_contents = $this->getContents($core_file_raw);
        return htmlentities($core_contents);
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

    function getContents($url){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; rv:2.2) Gecko/20110201');;

        $output = curl_exec($ch);

        curl_close($ch);
        return $output;
    }

    function writeLog($param){
        $fd = fopen("./tmp.txt", "a"); 

        $msg = "[".date('d/M/Y H:i:s')."] " . $param;
        fwrite($fd, $msg . "\n"); 
        fclose($fd); 
    }

}

?>
