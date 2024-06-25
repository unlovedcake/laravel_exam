<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {


        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'contactNumber' => ['required', 'string', 'max:11'],
            'age' => ['required', 'string'],
            'gender' => ['required'],
            'email' => ['string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => [Rules\Password::defaults()],
        ]);


        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "errors" => $validator->errors()
            ]);
        }


        $user_id = Auth::user()->id;

        User::where('id', $user_id)->update([

            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'age' => $request->age,
            'contactNumber' => $request->contactNumber,
            'gender' => $request->gender,

        ]);

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully'
        ]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
