<?php
ini_set('display_errors', 'On');

date_default_timezone_set('Asia/Bangkok');
//ob_start("ob_gzhandler");
ob_start();
error_reporting(E_ALL);

// start the session
//session_start();

 //database connection config
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = 'warrix';
$dbName = 'warrix_erp';

// setting up the web root, server root and company's name

$thisFile = str_replace('\\', '/', __FILE__);
$docRoot = $_SERVER['DOCUMENT_ROOT'];
$webRoot  = str_replace(array($docRoot, 'library/config.php'), '', $thisFile);
$srvRoot  = str_replace('library/config.php', '', $thisFile);
define('DOC_ROOT', $docRoot);
define('WEB_ROOT', $webRoot);
define('SRV_ROOT', $srvRoot);
define('IMG_DIR',  WEB_ROOT.'img/');
define('LIB_ROOT', SRV_ROOT.'library/');
define("COOKIE_PATH", WEB_ROOT);
define("CLASS_ROOT", SRV_ROOT."library/class/");
define('HELPER_ROOT', SRV_ROOT.'invent/function/');
require_once 'database.php';

function myAutoLoad($pClassName)
{
	$pClassFilePath = CLASS_ROOT . $pClassName . '.php';
	 if (file_exists($pClassFilePath)) {
		require($pClassFilePath);
		return true;
    }
     return false;
}
spl_autoload_register('myAutoLoad');

$company = new company();
define("COMPANY", $company->getName() );

if( ! isset( $_COOKIE['get_rows'] ) )
{
	setcookie('get_rows', 50, 3600);
}



?>
