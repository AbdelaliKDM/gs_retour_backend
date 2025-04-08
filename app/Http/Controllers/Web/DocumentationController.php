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

public function index(Request $request){

$documentation = Documentation::where('name', explode('.',$request->route()->getName())[1])->first();

  return view('content.documentation.index')->with('documentation',value: $documentation);


}
    public function update(Request $request){

      $this->validateRequest($request, [
          'name' => 'required|exists:documentations,name',
          'content_ar' => 'sometimes|nullable|string',
          'content_en' => 'sometimes|nullable|string',
          'content_fr' => 'sometimes|nullable|string',
      ]);

      try{

        $documentation = Documentation::where('name', $request->name)->first();

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

        $documentation = Documentation::where('name', $request->name)->first();

        return $this->successResponse(data:$documentation->content);

      }catch(\Exception $e){
        return $this->errorResponse($e->getMessage());
      }
    }
}
