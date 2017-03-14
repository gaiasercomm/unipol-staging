<?php
ini_set('display_errors', '0');
// only display the error or waring
error_reporting(E_ERROR /* | E_WARNING */);

date_default_timezone_set('UTC');

// ini_set('session.gc_probability', 1);
// ini_set('session.gc_divisor', 1);
// ini_set('session.gc_maxlifetime', 5);
session_cache_expire(120);
session_start();

ob_start();

// server ip
define("_IP", $_SERVER["SERVER_ADDR"]);

// debug ip
define("_DEBUGIP", '192.168.99.121');

// local ip
// define("_LOCALIP", '192.168.99.116');
// deployment folder name
define("_FOLDER_NAME", "BMS");
$_folder_path = (_FOLDER_NAME != "") ? DIRECTORY_SEPARATOR . _FOLDER_NAME : "";

// folder path
define("_FOLDER", (_IP == _DEBUGIP) ? $_folder_path : $_folder_path);

// root
define("_ROOT", $_SERVER["DOCUMENT_ROOT"] . _FOLDER);

// inc folder
define("_INC", _ROOT . "/inc/");

// class folder
define("INC_CLASS", _ROOT . "/inc/class/");

// images folder
define("IMAGES", $_folder_path . "/images");

// funcions folder
define("FUNC", _ROOT . "/functions/");

// configuration folder
define("_CONF", _ROOT . "/conf/");

// upload file path
define("_UPLOAD_PATH", _ROOT . "/upload/");
define("_UPLOAD_URL", _FOLDER . "/upload/");

// encode with the key
define("_DECRYPT_KEY", "fe01ce2a7fbac8fafaed7c982a04e229");

// language translation files
define("_Locale", _ROOT . "/locale/");

// imgcode image file path
define("_IMGCODE_PATH", _ROOT . "/inc/imgcode/");

// database information
define("_DBXML", _CONF . "db.xml");

// developer list
define("_DEVELOPERXML", _CONF . "developer.xml");

// CMSSDK configuration
define("_CMSSDKXML", _CONF . "cmssdk.xml");

// event code map
define("_EVENT_CODE", _CONF . "event_option.xml");

// RF device defnition
define("_RF_DEVICE_DEF", _CONF . "rf_device_def.json");

// the system version
define("_BMS_VER", "3.0R464");

// the title of site
define("_BMS_TITLE", _("Gaia Back-end Management System"));

require_once(_INC . "function.php");
require_once _ROOT . '/vendor/autoload.php';

// define DB
$_db = new ConnectDB;

// Set the language
$_locale = new Locale;

// init log
$_everlog = new Everlog(__FILE__);

// check user if logged in
if (!is_object(unserialize($_SESSION['USER_login'])))
    Auth::check_login_auth();
else
    unserialize($_SESSION['USER_login'])->check_login_auth();

unset($_locale, $_db, $_folder_path);

// trim arrays from post, get, request
// array_map("trim", $_POST, $_GET, $_REQUEST);
Common::TrimArray($_POST);
Common::TrimArray($_GET);
Common::TrimArray($_REQUEST);
session_write_close();