<?php
use Codenest\Library\App as App ;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('Europe/London');
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('VIEWS_PATH', ROOT.DS.'Codenest'.DS.'Views');

define('TRUST_PATH', DS.'assets'.DS.'trust_images'.DS);
//Define the root folder
//Default is an empty string if in site root
define('ROOT_FOLDER', DS.'mvcproject');
require_once __DIR__ . "/../core/init.php" ;

session_start();

App::run($_SERVER['REQUEST_URI']);
