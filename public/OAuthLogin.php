<?php
ini_set('error_reporting', E_ALL);
ini_set("display_errors", 1);

require_once  '../vendor/autoload.php';
require_once  '../vendor/bshaffer/oauth2-server-php/src/OAuth2/Autoloader.php';
require_once  '../public/MaponPdo.php';

try {
    OAuth2\Autoloader::register();
    $dsn = "mysql:host=db-mapon;port=3306;dbname=mapon";
    $storage = new MaponPdo([
        'dsn' => $dsn,
        'username' => 'root',
        'password' => '123'
    ]);
    $server = new OAuth2\Server($storage);
    $server->addGrantType(new OAuth2\GrantType\UserCredentials($storage));
    $response = $server->handleTokenRequest(OAuth2\Request::createFromGlobals());//->send();
    $data = json_decode($response->getResponseBody(), true);
    if (!isset($data['access_token'])) {
        throw new \Exception('Incorrect Data');
    }
    session_start();
    $_SESSION["access_token"] = $data['access_token'];
    header('Location: home.php');
} catch (\Exception $e) {
    header('Location: index.php');
}


