<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Exception;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Models\Documentation;

class DocumentationController extends Controller
{
use ApiResponse;
    public function update(Request $request){
      $this->validateRequest($request, [
          'name' => 'required|exists:documentations,name',
          'content_ar' => 'sometimes|nullable|string',
          'content_en' => 'sometimes|nullable|string',
          'content_fr' => 'sometimes|nullable|string',
      ]);

      try{

        $documentation = Documentation::findOrFail($request->name);

        $documentation->update($request->all());

        return $this->successResponse();

      }catch(\Exception $e){
        return $this->errorResponse($e->getMessage());
      }
    }

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
