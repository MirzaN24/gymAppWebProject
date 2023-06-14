<?php

Flight::route('/', function(){
    echo "Hello world!";
});

Flight::route('GET /user_membership', function(){
    Flight::json(Flight::user_membership_service()->get_all());
});

Flight::route('GET /user_membership/@id', function($id){
    Flight::json(Flight::user_membership_service()->get_by_id($id));
});

Flight::route('DELETE /user_membership/@id', function($id){
    Flight::user_membership_service()->delete($id);
    Flight::json(['message' => "user_membership deleted!"]);
});

Flight::route('POST /user_membership', function(){
    $request = Flight::request()->data->getData();
    Flight::json(['message' => 'user_membership added successfuly!',
                  'data' => Flight::user_membership_service()->add($request)]);
});

Flight::route('PUT /user_membership/@id', function($id){
    $request = Flight::request()->data->getData();
    Flight::json(['message' => 'user_membership updated successfuly!',
                  'data' => Flight::user_membership_service()->update($request, $id)]);
});

#update
#delete and put request do not work because there are restrictions, if you want to fix them, edit it inside workbench
#(Missing ON UPDATE/ON DELETE actions)

?>