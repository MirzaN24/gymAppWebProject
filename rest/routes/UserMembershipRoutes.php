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

#delete and put request do not work because there are restrictions, if you want to fix them, edit it inside workbench
#(Missing ON UPDATE/ON DELETE actions)

Flight::route('GET /usermembership/@id', function($id){
    Flight::json(Flight::user_membership_service()->get_users_membership_by_user_id($id)); #works fine
  });


  Flight::route('GET /usermembership', function(){
    Flight::json(Flight::user_membership_service()->get_user_membership()); #works fine
  });

  Flight::route('GET /activeusers', function(){
    Flight::json(Flight::user_membership_service()->get_active_users()); #works fine
  });

  Flight::route('GET /earned', function(){
    Flight::json(Flight::user_membership_service()->get_earned()); #works fine
  });

?>