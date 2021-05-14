<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Celebra Su Vida integration api",
 *      description="This Api is private. To use it, contact us to generate your credentials.",
 *      @OA\Contact(
 *          email="admin@admin.com"
 *      )
 * )
 *
 * @OA\ExternalDocumentation(
 *     description="Celebra Su Vida",
 *     url=""
 * )
 *
 * @OA\Server(
 *      url="{schema}://albia.celebrasuvida.es/api",
 *      description="development server",
 *      @OA\ServerVariable(
 *          serverVariable="schema",
 *          enum={"https", "http"},
 *          default="https"
 *      )
 * )
 *
 * @OA\Server(
 *      url="{schema}://albia.local/api",
 *      description="development server local",
 *      @OA\ServerVariable(
 *          serverVariable="schema",
 *          enum={"https", "http"},
 *          default="http"
 *      )
 * )
 *
 * @OA\SecurityScheme(
 *      securityScheme="api_key",
 *      type="apiKey",
 *      in="header",
 *      description="Enter in the following field 'Bearer' followed by the token obtained in the endpoint /auth/login",
 *      name="Authorization"
 * )
 *
 * @OA\Parameter(parameter="profile_id", name="profile_id", in="path", required=true,
 *      description="Profile identifier",
 *      @OA\Schema(type="integer", example="3")
 * )
 *
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($message, $result = null, $code = 200)
    {
    	$response = [
            'success' => true,
            'message' => $message ?? __('Request processed successfully.'),
        ];

        if($result !== null){
            $response['data'] = $result;
        }

        return response()->json($response, $code);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($message, $error = null, $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $message,
        ];

        if($error !== null){
            $response['error'] = $error;
        }

        return response()->json($response, $code);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError500($error)
    {
    	$response = [
            'success' => false,
            'message' => __('Internal Server Error'),
            'error' => $error
        ];

        return response()->json($response, 500);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError404()
    {
    	$response = [
            'success' => false,
            'message' => __('Not Found')
        ];

        return response()->json($response, 404);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError403()
    {
    	$response = [
            'success' => false,
            'message' => __('This action is unauthorized.')
        ];

        return response()->json($response, 403);
    }
}

/**
 *
 * @OA\RequestBody(request="response_200", description="OK",
 *      @OA\JsonContent(
 *          @OA\Property(property="success", example=true),
 *          @OA\Property(property="message", example="Server message")
 *      )
 * )
 *
 * @OA\RequestBody(request="response_201", description="Successful created",
 *      @OA\JsonContent(
 *          @OA\Property(property="message", example="Server message")
 *      )
 * )
 *
 * @OA\RequestBody(request="response_400", description="Error: Bad Request",
 *          @OA\JsonContent(
 *              @OA\Property(property="success", example=false),
 *              @OA\Property(property="message", example="Solicitud Incorrecta")
 *          )
 * )
 *
 * @OA\RequestBody(request="response_401", description="Error: Unauthorized",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", example="Unauthenticated.")
 *          )
 * )
 *
 * @OA\RequestBody(request="response_403", description="Error: Forbidden",
 *          @OA\JsonContent(
 *              @OA\Property(property="success", example=false),
 *              @OA\Property(property="message", example="You do not have permissions for the requested resources")
 *          )
 * )
 *
 * @OA\RequestBody(request="response_404", description="Error: Not Found",
 *      @OA\JsonContent(
 *          @OA\Property(property="success", example=false),
 *          @OA\Property(property="message", example="No Encontrado")
 *      )
 * )
 *
 * @OA\RequestBody(request="response_500", description="Error: Internal Server Error",
 *      @OA\JsonContent(
 *          @OA\Property(property="success", example=false),
 *          @OA\Property(property="message", example="Internal Server Error")
 *      )
 * )
 */
