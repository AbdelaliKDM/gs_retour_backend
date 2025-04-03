<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Models\Documentation;

class DocumentationController extends Controller
{
use ApiResponse;

    public function get(Request $request){
      $this->validateRequest($request, [
          'name' => 'required|exists:documentations,name',
      ]);

      try{

        $documentation = Documentation::findOrFail($request->name);

        return $this->successResponse(data:$documentation->content);

      }catch(\Exception $e){
        return $this->errorResponse($e->getMessage());
      }
    }
}
