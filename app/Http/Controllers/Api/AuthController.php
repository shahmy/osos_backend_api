<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Author;
use Laravel\Passport\Token;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\RefreshToken;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AuthorResource;
use App\Http\Requests\UserRegistrationRequest;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function userRegistration(UserRegistrationRequest $request): JsonResponse
    {
        try{

                DB::beginTransaction();

                $validated = $request->validated();

                $user = new User();
                $user->name = $validated['first_name'] . ' ' . $validated['last_name'];
                $user->email = $validated['email'];
                $user->password =  bcrypt($validated['password']);
                $user->user_type = 'author';

                $user->save();

                $user->syncRoles(['author']);

                $user_id = $user->id;

                $author = new Author();
                $author->first_name = $validated['first_name'];
                $author->last_name = $validated['last_name'];
                $author->user_id = $user_id;
                $author->status = 1;

                $author->save();

                $token = $user->createToken('api-auth-token')->accessToken;


                DB::commit();

                return response()->json([
                    'message' => 'User registered successfully',
                    'user' => new UserResource($user),
                    'author' => new AuthorResource($author),
                    'token' => $token,
                ],201);
            

        }catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ],500);
        }

        
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!auth()->guard('user')->attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => [trans('auth.failed')],
            ]);

            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        $user = User::whereEmail($request->email)->firstOrFail();

        if($user->user_type != 'author'){
            $token = $user->createToken('api-auth-token')->accessToken;
            return response()->json([
                'user' => new UserResource($user),
                'token' => $token,
            ], 201);
        }

        if($user->user_type == 'author' && $user->author->status == 0){
            return response()->json([
                'message' => 'Your account is deactivated by admin. Please contact admin for more details.',
                'token' => null,
            ], 401);
        }

        $token = $user->createToken('api-auth-token')->accessToken;

        return response()->json([
            'user' => new UserResource($user),
            'token' => $token,
        ], 201);
    }

    public function logout(): JsonResponse
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        // it will logout from all devices
        $tokens =  $user->tokens->pluck('id');
        Token::whereIn('id', $tokens)
        ->update(['revoked'=> true]);

        RefreshToken::whereIn('access_token_id', $tokens)->update(['revoked' => true]);

        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
}
