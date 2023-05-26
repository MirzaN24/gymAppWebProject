<?php

require '../vendor/autoload.php';
require("dao/UserDao.class.php");

Flight::route('/', function(){
    echo "Hello world!";
});

Flight::route('GET /user', function(){
    $user_dao = new UserDao();
    $result = $user_dao->get_all();
    Flight::json($result);
    //echo "Hello from the route with user";
});

Flight::route('GET /user/@id', function($id){
    $user_dao = new UserDao();
    $result = $user_dao->get_by_id($id);
    Flight::json($result);
    //echo "Hello from the route with user";
});

Flight::route('DELETE /user/@id', function($id){
    $user_dao = new UserDao();
    $user_dao->delete($id);
    Flight::json(['message' => "User deleted!"]);
});

Flight::route('GET /user/@user', function($user){
    echo "Hello from the route with user = " . $user;
});

Flight::route('GET /user/@user/@role', function($user, $role){
    echo "Hello from the route with user = " . $user . " and role = " . $role;
});


Flight::start();


?>