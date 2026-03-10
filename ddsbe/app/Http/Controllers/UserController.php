<?php
namespace App\Http\Controllers;

use App\Models\User;  // Changed from App\User
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    private $request;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    /**
     * Get all users
     */
    public function index()
    {
        $users = User::all();
        return response()->json([
            'data' => $users,
            'message' => 'Users retrieved successfully'
        ], 200);
    }
    
    /**
     * Get single user by ID
     */
    public function show($id)
    {
        $user = User::find($id);
        
        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }
        
        return response()->json([
            'data' => $user,
            'message' => 'User retrieved successfully'
        ], 200);
    }
    
    /**
     * Create new user
     */
    public function add(Request $request)
    {
        $rules = [
            'username' => 'required|max:20',
            'password' => 'required|max:20',
            'gender' => 'required|in:Male,Female',
        ];
        
        $this->validate($request, $rules);
        
        $user = User::create($request->all());
        
        return response()->json([
            'data' => $user,
            'message' => 'User created successfully'
        ], 201);
    }
    
    /**
     * Update existing user
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'username' => 'max:20',
            'password' => 'max:20',
            'gender' => 'in:Male,Female',
        ];
        
        $this->validate($request, $rules);
        
        $user = User::find($id);
        
        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }
        
        $user->fill($request->all());
        
        if ($user->isClean()) {
            return response()->json([
                'message' => 'At least one value must change'
            ], 422);
        }
        
        $user->save();
        
        return response()->json([
            'data' => $user,
            'message' => 'User updated successfully'
        ], 200);
    }
    
    /**
     * Delete user
     */
    public function delete($id)
    {
        $user = User::find($id);
        
        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }
        
        $user->delete();
        
        return response()->json([
            'message' => 'User deleted successfully'
        ], 200);
    }
}