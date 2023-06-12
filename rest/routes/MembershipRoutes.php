<?php

Flight::route('/', function(){
    echo "Hello world!";
});

Flight::route('GET /membership', function(){
    Flight::json(Flight::membership_service()->get_all());
});

Flight::route('GET /membership/@id', function($id){
    Flight::json(Flight::membership_service()->get_by_id($id));
});

Flight::route('DELETE /membership/@id', function($id){
    Flight::membership_service()->delete($id);
    Flight::json(['message' => "Membership deleted!"]);
});

Flight::route('POST /membership', function(){
    $request = Flight::request()->data->getData();
    Flight::json(['message' => 'Membership added successfuly!',
                  'data' => Flight::membership_service()->add($request)]);
});

Flight::route('PUT /membership/@id', function($id){
    $request = Flight::request()->data->getData();
    Flight::json(['message' => 'Membership updated successfuly!',
                  'data' => Flight::membership_service()->update($request, $id)]);
});

?>