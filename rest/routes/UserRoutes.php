<?php

Flight::route('/', function(){
    echo "Hello world!";
});

/**
 * @OA\Get(path="/user", tags={"user"}, security={{"ApiKeyAuth": {}}},
 *         summary="Return all user  from the API. ",
 *         @OA\Response( response=200, description="List of users.")
 * )
 */

Flight::route('GET /user', function(){
    Flight::json(Flight::user_service()->get_all());
});

/**
 * @OA\Get(path="/user/{id}", tags={"user"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(in="path", name="id", example=1, description="ID of a user"),
 *     @OA\Response(response="200", description="Fetch individual user")
 * )
 */

Flight::route('GET /user/@id', function($id){
    Flight::json(Flight::user_service()->get_by_id($id));
});

/**
* @OA\Delete(
*     path="/user/{id}", security={{"ApiKeyAuth": {}}},
*     description="Delete ",
*     tags={"user"},
*     @OA\Parameter(in="path", name="id", example=5, description="User ID"),
*     @OA\Response(
*         response=200,
*         description="User deleted"
*     ),
*     @OA\Response(
*         response=500,
*         description="Error"
*     )
* )
*/

Flight::route('DELETE /user/@id', function($id){
    Flight::user_service()->delete($id);
    Flight::json(['message' => "User deleted!"]);
});

/**
* @OA\Post(
*     path="/user",
*     description="Adding a new user",
*     tags={"user"},
*     @OA\RequestBody(description="Basic user info", required=true,
*       @OA\MediaType(mediaType="application/json",
*    			@OA\Schema(
*    				@OA\Property(property="first_name", type="string", example="Novi User", description="First name"),
*                   @OA\Property(property="last_name", type="string", example="Novi User", description="Last name"),
*    				@OA\Property(property="email", type="string", example="mirzamirza@gmail.com", description="Email"),
*    				@OA\Property(property="pass", type="string", example="pass1", description="Password"),
*        )
*     )),
*     @OA\Response(
*         response=200,
*         description="JWT Token on successful response"
*     ),
*     @OA\Response(
*         response=404,
*         description="Wrong Password | User doesn't exist"
*     )
* )
*/

Flight::route('POST /user', function(){
    $request = Flight::request()->data->getData();
    Flight::json(['message' => 'User added successfuly!',
                  'data' => Flight::user_service()->add($request)]);
});

/**
* @OA\Put(
*     path="/user/{id}", security={{"ApiKeyAuth": {}}},
*     description="Update user",
*     tags={"user"},
*     @OA\Parameter(in="path", name="id", example=1, description="User ID"),
*     @OA\RequestBody(description="Basic user info", required=true,
*       @OA\MediaType(mediaType="application/json",
*    			@OA\Schema(
*    				@OA\Property(property="first_name", type="string", example="Novi User", description="First name"),
*                   @OA\Property(property="last_name", type="string", example="Novi User", description="Last name"),
*    				@OA\Property(property="email", type="string", example="mirzamirza@gmail.com", description="Email"),
*    				@OA\Property(property="pass", type="string", example="pass1", description="Password"),
*        )
*     )),
*     @OA\Response(
*         response=200,
*         description="Note that has been updated"
*     ),
*     @OA\Response(
*         response=500,
*         description="Error"
*     )
* )
*/

Flight::route('PUT /user/@id', function($id){
    $request = Flight::request()->data->getData();
    Flight::json(['message' => 'User updated successfuly!',
                  'data' => Flight::user_service()->update($request, $id)]);
});

/**
 * @OA\Get(path="/userscount", tags={"user"}, security={{"ApiKeyAuth": {}}},
 *         summary="Return users count ",
 *         @OA\Response( response=200, description="users count")
 * )
 */

Flight::route('GET /usercount', function(){
    Flight::json(Flight::user_service()->get_user_count());
  });

?>