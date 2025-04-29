<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    
    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            
            // Check if user exists in database
            $existingUser = User::where('google_id', $user->id)->first();
            
            if($existingUser) {
                // User exists, log them in
                Auth::login($existingUser);
                return redirect()->intended('/dashboard');
            } else {
                // Check if email exists
                $existingEmail = User::where('email', $user->email)->first();
                
                if ($existingEmail) {
                    // Update existing user with Google ID
                    $existingEmail->google_id = $user->id;
                    $existingEmail->google_token = $user->token;
                    $existingEmail->avatar = $user->avatar;
                    $existingEmail->save();
                    
                    Auth::login($existingEmail);
                    return redirect()->intended('/dashboard');
                } else {
                    // Create new user
                    $newUser = User::create([
                        'name' => $user->name,
                        'email' => $user->email,
                        'username' => $this->generateUsername($user->name),
                        'google_id' => $user->id,
                        'password' => Hash::make(Str::random(16)), // Random password for security
                    ]);
                    
                    Auth::login($newUser);
                    return redirect()->intended('/dashboard');
                }
            }
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Google authentication failed: ' . $e->getMessage());
        }
    }
    
    /**
     * Generate unique username from name
     * 
     * @param string $name
     * @return string
     */
    private function generateUsername($name)
    {
        // Convert name to lowercase and replace spaces with underscores
        $username = Str::slug($name, '_');
        
        // Check if username already exists
        $existingUsername = User::where('username', $username)->first();
        
        if (!$existingUsername) {
            return $username;
        }
        
        // Add random string to make it unique
        return $username . '_' . Str::random(5);
    }
}