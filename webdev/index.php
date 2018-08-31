<?php

echo "hi";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//$file = file_put_contents('1212121.txt', "asjdhkjahsdhakldjkljljladsjlkjlkasjdfddddddddddddddddddddddddgfdg");

$filename = 'testing.text';
$filepath = $_SERVER['SCRIPT_URL'] . $filename;
$username = "epic@epicshops.com";
$password = "1eb2302b0c3b86621fcd85820eef5a12";
$folder = @date('m-y') . '-uploads';
$construct_url = '--user' . $username . ':' . $password . ' ' . 'https://sandbox.epicshops.com/dav/content/';
exec("'curl  --digest ' . $construct_url . $folder.' -X MKCOL' ");
exec("curl --digest --user ' . $username . ':' . $password .' --create-dirs 'https://sandbox.epicshops.com/dav/content/tarun/'");
exec("curl --digest --user' . $username . ':' . $password . '  'https://sandbox.epicshops.com/dav/content/newlder' -X MKCOL '");
exec("curl --digest --user' . $username . ':' . $password . ' -X MKCOL 'https://sandbox.epicshops.com/dav/content/newlderdf'");
exec("curl --request -X MKCOL --anyauth --user ' . $username . ':' . $password . ' 'https://sandbox.epicshops.com/dav/content/' -o /dev/null ");
exec("curl --request -X MKCOL --digest --user ' . $username . ':' . $password . ' 'https://sandbox.epicshops.com/dav/content/ -o /dev/null ");
 

 


//exec('curl --digest --user "' . $username . ':' . $password .' -X MKCOL'.'"https://sandbox.epicshops.com/dav/content/New" ');
exec('curl --digest --user "' . $username . ':' . $password . '" -T "' . $filename . '" "https://sandbox.epicshops.com/dav/content/" ');
//curl --digest --user "username:password" -T "sample.txt" "https://store-xxxxxx.mybigcommerce.com/dav/content/sample.txt"
//exec('curl -T "./abc.txt" -u epic@epicshops.com:1eb2302b0c3b86621fcd85820eef5a12 https://sandbox.epicshops.com/dav/content/NewFolder/aberc.txt');
//exec('curl -T "tdasda.txt" -u epic@epicshops.com:1eb2302b0c3b86621fcd85820eef5a12 https://sandbox.epicshops.com/dav/content/NewFolder/aberc.txt');
//exec('curl -T "./abc.txt" -u "epic@epicshops.com:1eb2302b0c3b86621fcd85820eef5a12 https://sandbox.epicshops.com/dav/content/NewFolder/abcre.txt"');
//$filename = 'ta.txt';
//// requires login
//	define('WEBDAV_REQUIRES_LOGIN', true);
//	// webDav login details if you have set above option true
//	define('WEBDAV_USER', 'epic@epicshops.com');
//	define('WEBDAV_PASSWORD', '1eb2302b0c3b86621fcd85820eef5a12');
//	// Add forward slash at the end or you will break things
//	define('WEBDAV_BASE_URL', 'https://sandbox.epicshops.com/dav/content/NewFolder');
// Either month based folder should be generated on remote machine or not
//define('DATE_BASED_DIR', true);
/* Editable part ends */
//	function recursive_scan($src = './') {
//		if(WEBDAV_REQUIRES_LOGIN == true) {
//			$construct_url = '-u ' . WEBDAV_USER . ':' . WEBDAV_PASSWORD . ' ' . WEBDAV_BASE_URL;
//                        print_r($construct_url);
//		} else {
////			$construct_url = WEBDAV_BASE_URL;
////		}
//	
//		$all_content = scandir($src);
//		if(DATE_BASED_DIR == true) {
//			$folder = @date('m-y') . '-uploads';
//			exec('curl -X MKCOL ' . $construct_url . $folder);
//			$full_url = $construct_url . $folder . '/';
//		} else {
//			$full_url = $construct_url;
//		}
//		$upDir = str_replace('./', '', $src) . '/';
//		if(strlen($upDir) > 0) {
//			 echo exec('curl -X MKCOL ' . $full_url . str_replace(' ', '', $upDir));
//		}
//		$files = array_diff($all_content, array('.', '..', pathinfo(__FILE__, PATHINFO_FILENAME) . '.' . pathinfo(__FILE__, PATHINFO_EXTENSION)));
//		if(is_array($files)) {
//			foreach ($files as $file) {
//				if(is_dir($src.$file)) {
//					echo exec('curl -X MKCOL ' . $full_url . str_replace(' ', '', $upDir) . str_replace(' ' , '', $file));
//					recursive_scan($src.$file.'/');
//				} else {
//					 exec('curl -T "' . $src . $file . '" ' . $full_url . str_replace(' ', '', $upDir) . str_replace(' ', '', $file));
//                                         echo 'curl -T ';
//                                         echo($src . $file);
//                                         echo($full_url);
//                                         echo(str_replace(' ', '', $upDir));
//                                         echo(str_replace(' ', '', $file));
//                                         echo('<br>');
//                                         
//                                         
//                                         
//                                }
//                                
//			}
//		}
//	}
//	// call function to start the upload
//	recursive_scan('./');
