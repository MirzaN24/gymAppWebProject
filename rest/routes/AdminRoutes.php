<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;


Flight::route('POST /login', function(){
    $login = Flight::request()->data->getData();
    $admin = Flight::adminDao()->get_admin_by_email($login['email']);

    if(isset($admin['id'])){
        if($admin['password'] == md5($login['password'])){
            unset($admin['password']);
            $jwt = JWT::encode($admin, Config::JWT_SECRET(), 'HS256');
            Flight::json(["token" => $jwt]);
        } else {
            Flight::json(["message" => "Password is incorrect."], 404);
        }
    } else {
        Flight::json(["message" => "Admin does not exist."], 404);
    }   

});

?>