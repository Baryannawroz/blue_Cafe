<?php

namespace BinaryCastle\Boilerplate\Http\Controllers\API;

use App\Models\User;
use BinaryCastle\Boilerplate\Http\Requests\API\Auth\ChangePasswordRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetController
{
    public function forgotPassword(Request $request): JsonResponse
    {
        $request->validate(['email' => 'required|valid_email']);
        // TODO need to generate token

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => __($status)])
            : response()->json(['message' => __($status)], 400);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|valid_email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return response()->json([
            'message' => 'Password changed successfully',
        ]);
    }

    /**
     * @param ChangePasswordRequest $request
     * @return JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        User::find(auth()->user()->id)->update(['password' => Hash::make($request->password)]);
        return response()->json(['message' => 'Password changed successfully']);
    }
}
