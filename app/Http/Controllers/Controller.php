<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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
     *      url="{schema}://laravel8.local/api",
     *      description="development server local",
     *      @OA\ServerVariable(
     *          serverVariable="schema",
     *          enum={"https", "http"},
     *          default="http"
     *      )
     * )
     *
     * @OA\Server(
     *      url="{schema}://laravel8.com/api",
     *      description="development server",
     *      @OA\ServerVariable(
     *          serverVariable="schema",
     *          enum={"https", "http"},
     *          default="https"
     *      )
     * )
     *
     *
     * @OA\SecurityScheme(
     *      securityScheme="api_key",
     *      type="apiKey",
     *      in="header",
     *      description="Enter in the following field 'Bearer' followed by the token obtained in the endpoint /auth/login",
     *      name="Authorization"
     * )
     *
     */
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
 *              @OA\Property(property="message", example="auth.failed")
 *          )
 * )
 *
 * @OA\RequestBody(request="response_404", description="Error: Not Found",
 *      @OA\JsonContent(
 *          @OA\Property(property="message", example="No encontrado")
 *      )
 * )
 *
 * @OA\RequestBody(request="response_500", description="Error: Internal Server Error",
 *      @OA\JsonContent(
 *          @OA\Property(property="message", example="Error Interno del Servidor")
 *      )
 * )
 */
