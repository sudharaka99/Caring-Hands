<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        // Step 1: Validate login details
        $validator = Validator::make($request->all(), [
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('auth.login')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

        try {

            // Step 2: Find user by email
            $user = DB::table('users')
                ->where('email', $request->email)
                ->first();

            // User not found
            if (!$user) {

                Log::warning('Login failed: user not found', [
                    'email' => $request->email
                ]);

                return redirect()
                    ->route('auth.login')
                    ->with('error', 'Either Email/Password is incorrect')
                    ->withInput($request->only('email'));
            }


            // Step 3: Check password
            if (!Hash::check($request->password, $user->password)) {

                Log::warning('Login failed: incorrect password', [
                    'email' => $request->email
                ]);

                return redirect()
                    ->route('auth.login')
                    ->with('error', 'Either Email/Password is incorrect')
                    ->withInput($request->only('email'));
            }


            // Step 4: Check valid role
            $allowedRoles = [
                'admin',
                'manager',
                'caregiver',
                'healthcare',
            ];

            if (!in_array($user->role, $allowedRoles, true)) {

                Log::warning('Login failed: invalid role', [
                    'email' => $user->email,
                    'role'  => $user->role,
                ]);

                return redirect()
                    ->route('auth.login')
                    ->with('error', 'Your account does not have permission to access the system.');
            }


            // Step 5: Login user
            Auth::loginUsingId($user->id);

            // Prevent session fixation
            $request->session()->regenerate();


            Log::info('User authenticated successfully', [
                'email' => $user->email,
                'role'  => $user->role,
            ]);


            // Step 6: Redirect based on role
            return match ($user->role) {

                'admin' =>
                    redirect()->route('admin.dashboard'),

                'manager' =>
                    redirect()->route('manager.dashboard'),

                'caregiver' =>
                    redirect()->route('caregiver.dashboard'),

                'healthcare' =>
                    redirect()->route('healthcare.dashboard'),

                default =>
                    redirect()->route('auth.login')
                        ->with('error', 'Invalid user role.'),
            };


        } catch (\Exception $e) {

            Log::error('Authentication error', [
                'message' => $e->getMessage(),
                'email'   => $request->email,
            ]);

            return redirect()
                ->route('auth.login')
                ->with('error', 'An unexpected error occurred. Please try again.')
                ->withInput($request->only('email'));
        }
    }



}
