<?php
namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait ApiResponse
{
  protected function validateRequest(Request $request, array $rules): void
  {
      $validator = Validator::make($request->all(), $rules);

      if ($validator->fails()) {
          abort(response()->json([
              'status' => 0,
              'message' => $validator->errors()->first()
          ], 422));
      }
  }

  protected function successResponse($message = 'Success', $data = null, $statusCode = 200)
    {
        $response = [
            'status' => 1,
            'message' => $message
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        return response()->json($response, $statusCode);
    }

    protected function errorResponse($message = 'An error occurred', $statusCode = 400)
    {
        return response()->json([
            'status' => 0,
            'message' => $message
        ], $statusCode);
    }
}
