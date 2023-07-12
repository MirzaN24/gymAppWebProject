<?php

Flight::route('/', function(){
    echo "Hello world!";
});

/**
 * @OA\Get(path="/user_membership", tags={"user_membership"}, security={{"ApiKeyAuth": {}}},
 *         summary="Return all user memberships from the API. ",
 *         @OA\Response( response=200, description="List of meberships.")
 * )
 */

Flight::route('GET /user_membership', function(){
    Flight::json(Flight::user_membership_service()->get_all());
});

/**
 * @OA\Get(path="/user_membership/{id}", tags={"user_membership"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(in="path", name="id", example=1, description="Id of membership."),
 *     @OA\Response(response="200", description="Fetch individual membership.")
 * )
 */

Flight::route('GET /user_membership/@id', function($id){
    Flight::json(Flight::user_membership_service()->get_by_id($id));
});

/**
* @OA\Delete(
*     path="/user_membership/{id}", security={{"ApiKeyAuth": {}}},
*     description="Delete membership.",
*     tags={"user_membership"},
*     @OA\Parameter(in="path", name="id", example=5, description="Membership ID"),
*     @OA\Response(
*         response=200,
*         description="user_membership deleted!"
*     ),
*     @OA\Response(
*         response=500,
*         description="Error!"
*     )
* )
*/

Flight::route('DELETE /user_membership/@id', function($id){
    Flight::user_membership_service()->delete($id);
    Flight::json(['message' => "user_membership deleted!"]);
});

/**
* @OA\Post(
*     path="/user_membership",
*     description="Adding new membership.",
*     tags={"user_membership"},
*     @OA\RequestBody(description="Basic membership info", required=true,
*       @OA\MediaType(mediaType="application/json",
*    			@OA\Schema(
*    				@OA\Property(property="user_id", type="integer", example="1",	description="User ID"),
*    				@OA\Property(property="membership_id", type="integer", example="1",	description="Membership ID"),
*    				@OA\Property(property="start_date", type="date", example="2022-06-02",	description="Start date"),
*    				@OA\Property(property="end_date", type="date", example="2022-07-02",	description="End date")
*        )
*     )),
*     @OA\Response(
*         response=200,
*         description="user_membership added successfuly!"
*     ),
*     @OA\Response(
*         response=404,
*         description="Error!"
*     )
* )
*/

Flight::route('POST /user_membership', function(){
    $request = Flight::request()->data->getData();
    Flight::json(['message' => 'user_membership added successfuly!',
                  'data' => Flight::user_membership_service()->add($request)]);
});

/**
* @OA\Put(
*     path="/user_membership/{id}", security={{"ApiKeyAuth": {}}},
*     description="Update membership.",
*     tags={"user_membership"},
*     @OA\Parameter(in="path", name="id", example=1, description="User Membership ID"),
*     @OA\RequestBody(description="Basic note info", required=true,
*       @OA\MediaType(mediaType="application/json",
*    			@OA\Schema(
*    				@OA\Property(property="user_id", type="integer", example="1",	description="User ID"),
*    				@OA\Property(property="membership_id", type="integer", example="1",	description="Membership ID"),
*    				@OA\Property(property="start_date", type="date", example="2022-06-02",	description="Start date"),
*    				@OA\Property(property="end_date", type="date", example="2022-07-02",	description="End date")
*        )
*     )),
*     @OA\Response(
*         response=200,
*         description="user_membership added successfuly!"
*     ),
*     @OA\Response(
*         response=500,
*         description="Error!"
*     )
* )
*/

Flight::route('PUT /user_membership/@id', function($id){
    $request = Flight::request()->data->getData();
    Flight::json(['message' => 'user_membership updated successfuly!',
                  'data' => Flight::user_membership_service()->update($request, $id)]);
});

#delete and put request do not work because there are restrictions, if you want to fix them, edit it inside workbench
#(Missing ON UPDATE/ON DELETE actions)

#METHODS THAT I AM NOT USING ARE NOT SWAGGER DOCUMENTED#

Flight::route('GET /usermembership/@id', function($id){
    Flight::json(Flight::user_membership_service()->get_users_membership_by_user_id($id)); #works fine
  });


  Flight::route('GET /usermembership', function(){
    Flight::json(Flight::user_membership_service()->get_user_membership()); #works fine
  });

  Flight::route('GET /activeusers', function(){
    Flight::json(Flight::user_membership_service()->get_active_users()); #works fine
  });

  /**
 * @OA\Get(path="/earned", tags={"user"}, security={{"ApiKeyAuth": {}}},
 *         summary="Return money that has been earned.",
 *         @OA\Response( response=200, description="Earned! $$$")
 * )
 */

  Flight::route('GET /earned', function(){
    Flight::json(Flight::user_membership_service()->get_earned()); #works fine
  });

?>