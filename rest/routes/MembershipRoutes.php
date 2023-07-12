<?php

Flight::route('/', function(){
    echo "Hello world!";
});

/**
 * @OA\Get(path="/membership", tags={"membership"}, security={{"ApiKeyAuth": {}}},
 *         summary="Return all memberships from the API. ",
 *         @OA\Response( response=200, description="List of all mebership plans.")
 * )
 */

Flight::route('GET /membership', function(){
    Flight::json(Flight::membership_service()->get_all());
});

/**
 * @OA\Get(path="/membership/{id}", tags={"membership"}, security={{"ApiKeyAuth": {}}},
 *      summary="Return membership plans by its id from the API. ",
 *     @OA\Parameter(in="path", name="id", example=1, description="Id of membership plan"),
 *     @OA\Response(response="200", description="Fetch individual membership plan")
 * )
 */

Flight::route('GET /membership/@id', function($id){
    Flight::json(Flight::membership_service()->get_by_id($id));
});

/**
* @OA\Delete(
*     path="/membership/{id}", security={{"ApiKeyAuth": {}}},
*     description="Delete membership plan.",
*     tags={"membership"},
*     @OA\Parameter(in="path", name="id", example=5, description="Membership ID"),
*     @OA\Response(
*         response=200,
*         description="Membership deleted"
*     ),
*     @OA\Response(
*         response=500,
*         description="Error"
*     )
* )
*/

Flight::route('DELETE /membership/@id', function($id){
    Flight::membership_service()->delete($id);
    Flight::json(['message' => "Membership deleted!"]);
});

/**
* @OA\Post(
*     path="/membership",
*     description="Add new membership plan.",
*     tags={"membership"},
*     @OA\RequestBody(description="Basic membership plan info", required=true,
*       @OA\MediaType(mediaType="application/json",
*    			@OA\Schema(
*    				@OA\Property(property="type", type="string", example="Diamond",	description="Type of membership plan."),
*    				@OA\Property(property="price", type="double", example="50",	description="Cost of membership plan."),
*        )
*     )),
*     @OA\Response(
*         response=200,
*         description="Membership added successfully!"
*     ),
*     @OA\Response(
*         response=404,
*         description="Error!"
*     )
* )
*/

Flight::route('POST /membership', function(){
    $request = Flight::request()->data->getData();
    Flight::json(['message' => 'Membership added successfuly!',
                  'data' => Flight::membership_service()->add($request)]);
});

/**
* @OA\Put(
*     path="/membership/{id}", security={{"ApiKeyAuth": {}}},
*     description="Update membership plan",
*     tags={"membership"},
*     @OA\Parameter(in="path", name="id", example=1, description="Membership plan ID"),
*     @OA\RequestBody(description="Basic membership plan info", required=true,
*       @OA\MediaType(mediaType="application/json",
*    			@OA\Schema(
*    				@OA\Property(property="type", type="string", example="Diamond",	description="Type of membership plan."),
*    				@OA\Property(property="price", type="double", example="50",	description="Cost of membership plan."),
*        )
*     )),
*    @OA\Response(
*         response=200,
*         description="Membership updated successfully!"
*     ),
*     @OA\Response(
*         response=404,
*         description="Error!"
*     )
* )
*/

Flight::route('PUT /membership/@id', function($id){
    $request = Flight::request()->data->getData();
    Flight::json(['message' => 'Membership updated successfuly!',
                  'data' => Flight::membership_service()->update($request, $id)]);
});

?>