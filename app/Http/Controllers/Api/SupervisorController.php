<?php

namespace App\Http\Controllers\Api;

use App\Models\Supervisor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class SupervisorController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'Email' => 'required|email',
            'Password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }

    public function store(Request $request)
    {
        // Validate request data
        $validator = Validator::make(
            $request->all(),
            [
                'ID' => 'required',
                'Full_Name' => 'required',
                'Email' => 'required|email',
                'Phone' => 'numeric',
                'Password' => 'required ',
                'Address' => 'string',
                'location' => 'string'
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        Supervisor::create(array_merge(
            $validator->validated(),
            ['Password' => bcrypt($request->Password)]
        ));
        return response()->json([
            'message' => 'SuperVisor successfully Stored',
        ], 201);
    }

    public function index()
    {
        $supervisors = Supervisor::all();

        return response()->json(['supervisors' => $supervisors], 200);
    }


    public function getSupervisor($ID)
    {
        $supervisor = Supervisor::findOrFail($ID);

        return response()->json([
            'success' => true,
            'Supervisor' => $supervisor,
        ]);
    }


    //Update Function
    public function  update(Request $request, $id)
    {
        // Find the supervisor
        $supervisor = Supervisor::find($id);

        if (!$supervisor) {
            return response()->json(['message' => 'Supervisor not found'], 404);
        }

        // Validate request data
        $validator = Validator::make(
            $request->only(['Full_Name', 'Email', 'Phone', 'Address',]),
            [
                'Full_Name' => 'required',
                'Email' => 'required|email',
                'Phone' => 'numeric',
                'Address' => 'string',

            ]
        );

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 400);
        }

        $supervisor->update([
            'Full_Name' => $request->Full_Name,
            'Email' => $request->Email,
            'Phone' => $request->Phone,
            'Address' => $request->Address,
        ]);
        $supervisor->save();
        return response()->json(['message' => 'Supervisor updated successfully', 'supervisor' => $supervisor], 201);
    }

    //Delete Function
    public function destroy($id)
    {
        $supervisor = Supervisor::find($id);

        if (!$supervisor) {
            return response()->json(['message' => 'Supervisor not found'], 404);
        }

        $supervisor->destroy($id);
        return response()->json(['message' => 'Supervisor deleted successfully'], 200);
    }

}
