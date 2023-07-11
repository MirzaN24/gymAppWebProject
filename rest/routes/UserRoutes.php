<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

Flight::route('/', function(){
    echo "Hello world!";
});

Flight::route('GET /jwt', function(){

$key = 'example_key';
$payload = [
    'iss' => 'http://example.org',
    'aud' => 'http://example.com',
    'iat' => 1356999524,
    'nbf' => 1357000000
];

$jwt = JWT::encode($payload, $key, 'HS256');
$decoded = (array) JWT::decode($jwt, new Key($key, 'HS256'));

print_r($jwt);
print_r($decoded);

});

Flight::route('GET /user', function(){
    Flight::json(Flight::user_service()->get_all());
});

Flight::route('GET /user/@id', function($id){
    Flight::json(Flight::user_service()->get_by_id($id));
});

Flight::route('DELETE /user/@id', function($id){
    Flight::user_service()->delete($id);
    Flight::json(['message' => "User deleted!"]);
});

Flight::route('POST /user', function(){
    $request = Flight::request()->data->getData();
    Flight::json(['message' => 'User added successfuly!',
                  'data' => Flight::user_service()->add($request)]);
});

Flight::route('PUT /user/@id', function($id){
    $request = Flight::request()->data->getData();
    Flight::json(['message' => 'User updated successfuly!',
                  'data' => Flight::user_service()->update($request, $id)]);
});

Flight::route('GET /usercount', function(){
    Flight::json(Flight::user_service()->get_user_count());
  });

?>