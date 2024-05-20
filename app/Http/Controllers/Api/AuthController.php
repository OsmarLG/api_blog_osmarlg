<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\UserRepositoryInterface;
use App\Http\Requests\Users\StoreUserRequest;

/**
* @OA\Info(title="API Usuarios", version="1.0")
*
* 
*/

class AuthController extends Controller
{
    //
    protected $users;

    public function __construct(UserRepositoryInterface $users)
    {
        $this->users = $users;
    }
/**
 * @OA\Post(
 *     path="/api/auth/login",
 *     operationId="Login",
 *     tags={"Login"},
 *     summary="User Login",
 *     description="User login here",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"username","password"},
 *             @OA\Property(property="username", type="string", example="user@example.com"),
 *             @OA\Property(property="password", type="string", example="password")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful login",
 *         @OA\JsonContent(
 *             @OA\Property(property="user", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="John Doe"),
 *                 @OA\Property(property="email", type="string", example="john@example.com"),
 *                 @OA\Property(property="role", type="string", example="author")
 *             ),
 *             @OA\Property(property="token", type="string", example="1|sdfsdfdsfdsfdsfdsfdsf")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="User not exists")
 *         )
 *     )
 * )
 */
    public function login(Request $request) {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('username', $request->input('username'))->first();

        if (!$user){
            return response()->json([
                'message' => 'User not exists'
            ], 401);
        }

        if ($user->status != 'Active'){
            return response()->json([
                'message' => 'Inactive User'
            ], 401);
        }

        if (!$user || !Hash::check($request->input('password'), $user->password)){
            return response()->json([
                'message' => 'Credencials Error'
            ], 401);
        }

        ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'Login',
            'method' => 'POST',
            'description' => 'Login with id: ' . $user->id,
            'slug' => '/api/auth/login',
        ]);

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->getRoleNames()->first(),
            ],
            'token' => $user->createToken('api')->plainTextToken,
        ], 201);
    }

    public function loginForm() {
        return redirect(route('loginForm'));
    }

    public function register(StoreUserRequest $request) {
        $validatedData = $request->validated();
        $user = $this->users->create($validatedData);

        ActivityLog::create([
            'action' => 'Register',
            'method' => 'POST',
            'description' => 'User Register',
            'slug' => '/api/auth/register',
        ]);
        
        return response()->json([
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->getRoleNames()->first(),
            ],
            'token' => $user->createToken('api')->plainTextToken,
        ], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        ActivityLog::create([
            'user_id' => $request->user()->id,
            'action' => 'Logout',
            'method' => 'POST',
            'description' => 'Logout with id: ' . $request->user()->id,
            'slug' => '/api/auth/logout',
        ]);
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
