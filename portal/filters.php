<?php

/*
  |--------------------------------------------------------------------------
  | Application & Route Filters
  |--------------------------------------------------------------------------
  |
  | Below you will find the "before" and "after" events for the application
  | which may be used to do any work before or after a request into your
  | application. Here you may also register your custom route filters.
  |
 */

 
if (isset($_COOKIE['lang']))
{
    App::setLocale($_COOKIE['lang']);
}

App::before(function($request)
{
    //
    #*********
    define("_FOLDER", "portal");

    define("_FOLDER_PATH", (_FOLDER != "") ? DIRECTORY_SEPARATOR . _FOLDER : "");
    // define("_ROOT", "/var/www/html" . _FOLDER_PATH);

    #*********
    define("_CGI", "http://neutral_sl:8080/cgi/");

    #*********
    define("_DMSI", "http://neutral_dmsi:3000/");
    
    // define("_CLASS", _ROOT . "/inc/class/");

    #*********
    define("_PORTAL_VER", "3.1.13d");

    #*********
    define("_COOKIEDOMAIN", "http://neutral_web/");

    #*********
    define("_DOMAIN", "neutral_web");

    define("_FB_APPID", "1003853789650560");
    
    define("_SERVICE_ID", "2");
    
    define("_RATEPLAN_ID", "1");
    
    define("_WEBSOCKET_ADDR", $_SERVER['SERVER_NAME']);
    
    define("_RELAY_ADDR", $_SERVER['SERVER_NAME']);
    
    define("_RELAY_PORT", "80");
    
    define("_STORAGE_ADDR", $_SERVER['SERVER_NAME']);
    
    global $_CDataCenterMSG;
    $_CDataCenterMSG = [
        'STATUS_OFFLINE' => -1,
        'STATUS_DISARM' => 0,
        'STATUS_ARM' => 1,
        'STATUS_STAYARM' => 2,
        'STATUS_QUICK_EXIT' => 3,
        'STATUS_ENTER_DELAY' => 5,
        'STATUS_ALARM' => 10
    ];
    
    global $_PERMISSIONS_CONTROL;
    $_PERMISSIONS_CONTROL = [
        'DIAGNOSTIC' => true,
        'ONEBTNDIAG' => true
    ];
});


App::after(function($request, $response)
{
    //
});

/*
  |--------------------------------------------------------------------------
  | Authentication Filters
  |--------------------------------------------------------------------------
  |
  | The following filters are used to verify that the user of the current
  | session is logged into this application. The "basic" filter easily
  | integrates HTTP Basic authentication for quick, simple checking.
  |
 */

Route::filter('auth', function()
{
    if (Auth::guest())
    {
        if (Request::ajax())
        {
            return Response::make('Unauthorized', 401);
        }
        else
        {
            return Redirect::guest('login');
        }
    }
});


Route::filter('auth.basic', function()
{
    return Auth::basic();
});

/*
  |--------------------------------------------------------------------------
  | Guest Filter
  |--------------------------------------------------------------------------
  |
  | The "guest" filter is the counterpart of the authentication filters as
  | it simply checks that the current user is not logged in. A redirect
  | response will be issued if they are, which you may freely change.
  |
 */

Route::filter('guest', function()
{
    if (Auth::check())
        return Redirect::to('/');
});

/*
  |--------------------------------------------------------------------------
  | CSRF Protection Filter
  |--------------------------------------------------------------------------
  |
  | The CSRF filter is responsible for protecting your application against
  | cross-site request forgery attacks. If this special token in a user
  | session does not match the one given in this request, we'll bail.
  |
 */

Route::filter('csrf', function()
{
    if (Session::token() != Input::get('_token'))
    {
        throw new Illuminate\Session\TokenMismatchException;
    }
});

Route::filter('detect_old_IE', function()
{
    if (Route::currentRouteName() != 'not_support')
    {
        $ie = ['MSIE 9.0', 'MSIE 8.0', 'MSIE 7.0', 'MSIE 6.0'];
        foreach ($ie as $v)
        {
            if (substr_count($_SERVER['HTTP_USER_AGENT'], $v) > 0)
            {
                return Redirect::route("not_support");
            }
        }
    }
});