<?php

require '../vendor/autoload.php';
require("dao/UserDao.class.php");

Flight::register('user_dao', "UserDao");

Flight::route('/', function(){
    echo "Hello world!";
});

Flight::route('GET /user', function(){
    Flight::json(Flight::user_dao()->get_all());
});

Flight::route('GET /user/@id', function($id){
    Flight::json(Flight::user_dao()->get_by_id($id));
});

Flight::route('DELETE /user/@id', function($id){
    Flight::user_dao()->delete($id);
    Flight::json(['message' => "User deleted!"]);
});

Flight::route('POST /user', function(){
    $request = Flight::request()->data->getData();
    Flight::json(['message' => 'User added successfuly!',
                  'data' => Flight::user_dao()->add($request)]);
});

Flight::route('PUT /user/@id', function($id){
    $request = Flight::request()->data->getData();
    Flight::json(['message' => 'User updated successfuly!',
                  'data' => Flight::user_dao()->update($request, $id)]);
});

Flight::start();

?>