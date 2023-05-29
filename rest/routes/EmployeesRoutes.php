<?php

Flight::route('/', function(){
    echo "Hello world!";
});

Flight::route('GET /employees', function(){
    Flight::json(Flight::employees_dao()->get_all());
});

Flight::route('GET /employees/@id', function($id){
    Flight::json(Flight::employees_dao()->get_by_id($id));
});

Flight::route('DELETE /employees/@id', function($id){
    Flight::employees_dao()->delete($id);
    Flight::json(['message' => "Employee deleted!"]);
});

Flight::route('POST /employees', function(){
    $request = Flight::request()->data->getData();
    Flight::json(['message' => 'Employee added successfuly!',
                  'data' => Flight::employees_dao()->add($request)]);
});

Flight::route('PUT /employees/@id', function($id){
    $request = Flight::request()->data->getData();
    Flight::json(['message' => 'Employee updated successfuly!',
                  'data' => Flight::employees_dao()->update($request, $id)]);
});

Flight::start();

?>