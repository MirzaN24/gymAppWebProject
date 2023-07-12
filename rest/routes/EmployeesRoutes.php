<?php

Flight::route('/', function(){
    echo "Hello world!";
});

/**

 * @OA\Get(path="/employees", tags={"employees"}, security={{"ApiKeyAuth": {}}},
 *         summary="Return all employees from the API. ",
 *         @OA\Response( response=200, description="List of employees.")
 * )
 */

Flight::route('GET /employees', function(){
    Flight::json(Flight::employees_service()->get_all());
});

/**
 * @OA\Get(path="/employees/{id}", tags={"employees"}, security={{"ApiKeyAuth": {}}},
 *      summary="Return  employee by id from the API. ",
 *     @OA\Parameter(in="path", name="id", example=1, description="Id of an employee."),
 *     @OA\Response(response="200", description="Fetch individual employee.")
 * )
 */

Flight::route('GET /employees/@id', function($id){
    Flight::json(Flight::employees_service()->get_by_id($id));
});

/**
* @OA\Delete(
*     path="/employees/{id}", security={{"ApiKeyAuth": {}}},
*     description="Delete an employee.",
*     tags={"employees"},
*     @OA\Parameter(in="path", name="id", example=5, description="Employee ID"),
*     @OA\Response(
*         response=200,
*         description="employe deleted"
*     ),
*     @OA\Response(
*         response=500,
*         description="Error"
*     )
* )
*/

Flight::route('DELETE /employees/@id', function($id){
    Flight::employees_service()->delete($id);
    Flight::json(['message' => "Employee deleted!"]);
});

/**
* @OA\Post(
*     path="/employees",
*     description="Add new employee.",
*     tags={"employees"},
*     @OA\RequestBody(description="Basic employe info", required=true,
*       @OA\MediaType(mediaType="application/json",
*    			@OA\Schema(
*    				@OA\Property(property="full_name", type="string", example="John Doe", description="Full name"),
*    				@OA\Property(property="phone_number", type="string", example="061123456", description="Phone number"),
*    				@OA\Property(property="email", type="string", example="employee@gmail.com", description="Email"),
*    				@OA\Property(property="position", type="string", example="Gym coach", description="position" )
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

Flight::route('POST /employees', function(){
    $request = Flight::request()->data->getData();
    Flight::json(['message' => 'Employee added successfuly!',
                  'data' => Flight::employees_service()->add($request)]);
});

/**
* @OA\Put(
*     path="/employees/{id}", security={{"ApiKeyAuth": {}}},
*     description="Update employee",
*     tags={"employees"},
*     @OA\Parameter(in="path", name="id", example=1, description="Employee ID"),
*     @OA\RequestBody(description="Basic employee info", required=true,
*       @OA\MediaType(mediaType="application/json",
*    			@OA\Schema(
*    				@OA\Property(property="full_name", type="string", example="John Doe", description="Full name"),
*    				@OA\Property(property="phone_number", type="string", example="061123456", description="Phone number"),
*    				@OA\Property(property="email", type="string", example="employee@gmail.com", description="Email"),
*    				@OA\Property(property="position", type="string", example="Gym coach", description="position" )
*        )
*     )),
*     @OA\Response(
*         response=200,
*         description="Employee that has been updated"
*     ),
*     @OA\Response(
*         response=500,
*         description="Error"
*     )
* )
*/

Flight::route('PUT /employees/@id', function($id){
    $request = Flight::request()->data->getData();
    return Flight::json(['message' => 'Employee updated successfuly!',
                  'data' => Flight::employees_service()->update($request, $id)]);
});

?>