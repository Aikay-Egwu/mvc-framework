<?php
use Codenest\Library\Config as Config ;

function configure_settings()
{
    Config::set('site_name', 'MVC');
    Config::set('languages', array('en')) ;
    //routes.  Route name => method prefix
    Config::set('routes', array(
        'default' => '',
        'admin' => 'admin',
        'jquery' => 'jquery'
    ));
    //default page
    Config::set('default_route', 'Default') ;
    //default site language
    Config::set('default_language', 'en') ;
    //default controller
    Config::set('default_controller', 'home') ;
    //default action
    Config::set('default_action', 'index') ;

    //database settings
    Config::set('host', 'mysql:host=localhost;');
    //database username
    Config::set('username', '');
    //database password
    Config::set('password', '');
    //database name
    Config::set('db_name', 'dbname=;');
    Config::set('charser', 'charset=utf8mb4');
}
