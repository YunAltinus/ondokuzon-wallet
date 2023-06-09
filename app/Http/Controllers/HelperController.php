<?php

namespace App\Http\Controllers;

class HelperController extends Controller
{
    /**
     * @param string|array $data
     * @param integer $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponse($data = ["message" => "İşlem Başarılı!"], $code = 200)
    {
        return response()->json($data, $code);
    }

    /**
     * @param string $message
     * @param integer $code
     * @param array $messages
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendError($message, $code = 404, $messages = [])
    {
        $response["message"] = $message;

        !empty($messages) ? $response["errors"] = $messages : null;
        return response()->json($response, $code);
    }
}
