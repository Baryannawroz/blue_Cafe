<?php

namespace BinaryCastle\Boilerplate\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use BinaryCastle\Boilerplate\Http\Requests\API\Auth\LoginRequest;
use BinaryCastle\Boilerplate\Http\Requests\API\Auth\RegistrationRequest;
use BinaryCastle\Boilerplate\Models\SideNavMenu;
use BinaryCastle\Boilerplate\Rules\MatchCurrentPassword;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $agent = new Agent();
        $credentials = $request->only(['email', 'password']);
        if (Auth::attempt($credentials)) {
            $user = User::where('email', $request->email)->firstOrFail();
            return response()->json([
                'message' => 'Login successfully',
                'token' => $user->createToken("{$agent->platform()} | {$agent->browser()}", ["*"])->plainTextToken
            ]);
        }
        return response()->json([
            'message' => 'The given data was invalid.',
            'errors' => ['email' => ['The provided credentials do not match our records']]
        ], 422);
    }

    /**
     * @param RegistrationRequest $request
     * @return JsonResponse
     */
    public function register(RegistrationRequest $request): JsonResponse
    {
        $user = new User();
        $user->fill($request->all());
        $user->password = Hash::make($request->password);
        if ($user->save()) {
            return response()->json(['message' => 'User saved successfully']);
        }
        return response()->json(['error' => 'Bad Request'], 400);
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function forgotPassword(Request $request): bool
    {
        $request->validate(['email' => 'required|valid_email']);

        $status = Password::sendResetLink($request->only('email'));
        return $status === Password::RESET_LINK_SENT;
    }


    /**
     * @param Request $request
     * @return bool
     */
    public function checkToken(Request $request): bool
    {
        return auth('sanctum')->check();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['data' => 'token removed']);
    }

    /**
     * @param Request $request
     * @return mixed
     * TODO : it should return the sidebar as well
     */
    public function currentUser(Request $request)
    {
        $menus = SideNavMenu::where('role_id', $request->user()->roles->first()->id)->first();
        $user = $request->user();
        $user['name'] = $request->user()->name;
        $user['scopes'] = $user->getAllPermissions()->pluck('name')->toArray();
        $user['menus'] = json_decode($menus->menu_json);
        return $user;
    }


    public function changeEmailAddress(Request $request)
    {
        $request->validate([
            'password' => ['required', 'min:6', 'max:40', new MatchCurrentPassword()],
            'email' => 'required|email',
        ]);
        User::find(auth()->user()->id)->update(['email' => $request->email]);
        return response()->json(['message' => 'Email changed Successfully']);
    }

    public function authHistory(Request $request)
    {
        $search = $request->input('search');
        $limit = $request->input('limit', 20); // Default to 20 if limit is not provided

        $tokens = auth()->user()->tokens()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%$search%");
            })
            ->paginate($limit);

        return response()->json($tokens);
    }

    public function deleteAuthHistory($id)
    {
        \auth()->user()->tokens()->delete($id);
        return response()->json(['message' => 'Token has been removed']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string|unique:users,id,' . auth()->id(),
            'photo' => 'nullable',
            'address' => 'required'
        ]);

        $user = User::find(auth()->id());
        $user->fill($request->only(['name', 'phone', 'photo', 'address']));
        if ($user->save()) {
            return response()->json(['message' => 'User profile updated']);
        }
    }
}
