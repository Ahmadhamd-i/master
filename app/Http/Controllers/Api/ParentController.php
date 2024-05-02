<?php

namespace App\Http\Controllers\Api;

use App\Models\Parents;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ParentResource;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ApiResponse;
use App\Helpers\ApiResponse as HelpersApiResponse;

class ParentController extends Controller
{


    public function index() //Have route
    {

        $parents = Parents::all();
        return ApiResponse::sendresponse(200, "parents", ParentResource::collection($parents));
    }

    public function getParent($ID)
    {
        $parent = Parents::findOrFail($ID);
        if ($parent) {
            return ApiResponse::sendresponse(200, "parent", new ParentResource($parent));
        } {
            return $this->ApiResponse(null, 'Parent Table Not Found', 404);
        }
    }

    public function store(Request $request)
    {
        $ran = mt_rand(40000, 50000);
        // Validate request data
        $validator = Validator::make(
            $request->all(),
            [

                'Full_Name' => 'required',
                'Password' => 'required ',
                'Email' => 'required|email',
                'Phone' => 'required',
                'address' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $parent = Parents::create(array_merge(
            $validator->validated(),
            ['ID' => $ran, 'Password' => bcrypt($request->Password)]
        ));
        return ApiResponse::sendresponse(201, 'Parent stored Successfully ', new ParentResource($parent));
    }
    //Update Function
    public function update(Request $request, $id)

    {
        $validator = Validator::make($request->only(['Full_Name', 'Email', 'address', 'Phone',]), [
            'Full_Name' => 'sometimes',
            'Email' => 'sometimes|email',
            'address' => 'sometimes',
            'Phone' => 'sometimes',
        ]);

        $Parent = Parents::find($id);

        if (!$Parent) {
            return response()->json(['message' => 'Parent not found'], 404);
        }
        $oldparent = Parents::find($id);
        if (!$oldparent) {
            return response()->json(['message' => 'student not found'], 404);
        }
        $Parent->update([
            'Full_Name' => $request->Full_Name ?? $oldparent->Full_Name,
            'Email' => $request->Email ?? $oldparent->Email,
            'Phone' => $request->Phone ?? $oldparent->Phone,
            'Address' => $request->address ?? $oldparent->Address,
        ]);


        return response()->json(['message' => 'Parent updated successfully', 'Parent' => new ParentResource($Parent)], 200);
    }


    //search missing

    public function destroy($id)
    {
        $Parent = Parents::find($id);

        if (!$Parent) {
            return response()->json(['message' => 'Parent not found'], 404);
        }

        $Parent->destroy($id);
        return response()->json(['message' => 'Parent deleted successfully'], 200);
    }
}
