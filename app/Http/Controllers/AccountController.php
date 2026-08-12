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
    /**
     * Show registration form
     */
    public function register()
    {
        return view('auth.register');
    }

    /**
     * Show login form
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Handle user registration
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'nullable|in:admin,manager,caregiver,healthcare',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('register')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        try {
            // Create user
            $userId = DB::table('users')->insertGetId([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role ?? 'caregiver',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            Log::info('New user registered', [
                'user_id' => $userId,
                'email' => $request->email,
                'role' => $request->role ?? 'caregiver'
            ]);

            return redirect()
                ->route('login')
                ->with('success', 'Registration successful! Please login.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Registration failed', [
                'error' => $e->getMessage(),
                'email' => $request->email
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Registration failed. Please try again.');
        }
    }

    /**
     * Handle user login
     */
    public function authenticate(Request $request)
    {
        // Step 1: Validate login details
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('login')
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
                    ->route('login')
                    ->with('error', 'Invalid email or password.')
                    ->withInput($request->only('email'));
            }

            // Step 3: Check password
            if (!Hash::check($request->password, $user->password)) {
                Log::warning('Login failed: incorrect password', [
                    'email' => $request->email
                ]);

                return redirect()
                    ->route('login')
                    ->with('error', 'Invalid email or password.')
                    ->withInput($request->only('email'));
            }

            // Step 4: Check valid role
            $allowedRoles = ['admin', 'manager', 'caregiver', 'healthcare'];

            if (!in_array($user->role, $allowedRoles, true)) {
                Log::warning('Login failed: invalid role', [
                    'email' => $user->email,
                    'role' => $user->role,
                ]);

                return redirect()
                    ->route('login')
                    ->with('error', 'Your account does not have permission to access the system.');
            }

            // Step 5: Login user
            Auth::loginUsingId($user->id);

            // Prevent session fixation
            $request->session()->regenerate();

            Log::info('User authenticated successfully', [
                'email' => $user->email,
                'role' => $user->role,
            ]);

            // Step 6: Redirect based on role
            return match ($user->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'manager' => redirect()->route('manager.dashboard'),
                'caregiver' => redirect()->route('caregiver.dashboard'),
                'healthcare' => redirect()->route('healthcare.dashboard'),
                default => redirect()->route('login')->with('error', 'Invalid user role.'),
            };

        } catch (\Exception $e) {
            Log::error('Authentication error', [
                'message' => $e->getMessage(),
                'email' => $request->email,
            ]);

            return redirect()
                ->route('login')
                ->with('error', 'An unexpected error occurred. Please try again.')
                ->withInput($request->only('email'));
        }
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Log::info('User logged out', [
            'user_id' => $user->id ?? null,
            'email' => $user->email ?? null
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'You have been logged out successfully.');
    }
}