<?php

namespace App\Http\Controllers\Api;

use App\Models\Parents;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ParentResource;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Apiresponse;
use App\Helpers\ApiResponse as HelpersApiResponse;

class ParentController extends Controller
{


    public function index() //Have route
    {

        $parents = Parents::all();
        return Apiresponse::sendresponse(200, "parents", ParentResource::collection($parents));
    }

    public function getParent($ID)
    {
        $parent = Parents::findOrFail($ID);
        if ($parent) {

            return Apiresponse::sendresponse(200, "parent", new ParentResource($parent));
        } {
            return $this->apiresponse(null, 'Parent Table Not Found', 404);
        }
    }

    public function store(Request $request)
    {
        // Validate request data
        $validator = Validator::make(
            $request->all(),
            [
                'ID' => 'required',
                'Full_Name' => 'required',
                'Password' => 'required ',
                'Child_Name' => 'required',
                'Email' => 'required|email',
                'Phone' => 'required',
                'address' => 'required',
                'Supervisor_ID' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        Parents::create(array_merge(
            $validator->validated(),
            ['Password' => bcrypt($request->Password)]
        ));
        return response()->json([
            'message' => 'Parent successfully Stored',
        ], 201);
    }
    //Update Function
    public function update(Request $request, $id)

    {
        $validator = Validator::make($request->only(['Full_Name', 'Email', 'address', 'Phone', 'Child_Name',]), [
            'Full_Name' => 'sometimes',
            'Email' => 'sometimes|email',
            'address' => 'sometimes',
            'Phone' => 'sometimes',
            'Child_Name' => 'string',

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
            'Child_Name' => $request->Child_Name ?? $oldparent->Child_Name,
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
