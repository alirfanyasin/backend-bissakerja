<?php

namespace App\Http\Controllers\Auth;

use App\Enum\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            // 'avatar' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'role' => 'required|string|in:user,perusahaan,admin,superadmin',
        ]);

        if ($request->role === RoleEnum::ADMIN->value && Auth::user()->hasRole(RoleEnum::SUPER_ADMIN->value)) {
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission to register an admin user.',
            ], 403);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => $request->avatar,
            'role' => $request->role,
        ]);

        $user->assignRole($request->role);

        return response()->json([
            'status' => true,
            'message' => 'User registered successfully',
        ], 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            // $request->session()->regenerate();
            $user = Auth::user();
            return response()->json([
                'status' => true,
                'message' => 'Login successful',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'avatar' => $user->avatar,
                    'role' => $user->getRoleNames()->first(),
                    'token' => $user->createToken($user->name)->plainTextToken,
                ],
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Login Failed'
        ], 401); // Ubah ke 401 untuk unauthorized


    }

    public function user(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
        return response()->json([
            'status' => true,
            'user' => $user,
            'role' => $user->getRoleNames()->first(),
        ]);
    }


    public function updateProfile(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            // Validate input data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|min:2',
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('users')->ignore($user->id)
                ],
                'password' => 'nullable|string|min:6|confirmed',
                'current_password' => 'nullable|string|required_with:password'
            ]);

            // If password is being updated, verify current password
            if (!empty($validatedData['password'])) {
                if (empty($validatedData['current_password'])) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Current password is required when updating password',
                        'errors' => [
                            'current_password' => ['Current password is required']
                        ]
                    ], 422);
                }

                if (!Hash::check($validatedData['current_password'], $user->password)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Current password is incorrect',
                        'errors' => [
                            'current_password' => ['Current password is incorrect']
                        ]
                    ], 422);
                }

                // Hash new password
                $validatedData['password'] = Hash::make($validatedData['password']);
            } else {
                // Remove password from update data if not provided
                unset($validatedData['password']);
            }

            // Remove confirmation and current password from update data
            unset($validatedData['password_confirmation']);
            unset($validatedData['current_password']);

            // Update user data using transaction
            DB::beginTransaction();

            $user->update($validatedData);

            DB::commit();

            // Return updated user data (excluding password)
            $updatedUser = $user->fresh();
            $updatedUser->makeHidden(['password', 'remember_token']);

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'data' => [
                    'user' => $updatedUser
                ]
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating profile',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    public function updateAvatar(Request $request)
    {
        try {
            // Get authenticated user
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 401);
            }

            // Validate request
            $validator = Validator::make($request->all(), [
                'avatar' => 'required|string', // Base64 image data
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $avatarData = $request->input('avatar');

            // Validate base64 image format
            if (!$this->isValidBase64Image($avatarData)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid image format',
                    'errors' => [
                        'avatar' => ['Please provide a valid image file']
                    ]
                ], 422);
            }

            // Extract image data and extension
            $imageInfo = $this->extractImageInfo($avatarData);

            if (!$imageInfo) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unable to process image',
                    'errors' => [
                        'avatar' => ['Invalid image data']
                    ]
                ], 422);
            }

            // Validate image size (max 5MB)
            $imageSize = strlen(base64_decode($imageInfo['data']));
            $maxSize = 5 * 1024 * 1024; // 5MB

            if ($imageSize > $maxSize) {
                return response()->json([
                    'success' => false,
                    'message' => 'Image too large',
                    'errors' => [
                        'avatar' => ['Image size must be less than 5MB']
                    ]
                ], 422);
            }

            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Generate unique filename
            $filename = 'avatars/' . $user->id . '_' . Str::random(10) . '.' . $imageInfo['extension'];

            // Store the image
            $stored = Storage::disk('public')->put($filename, base64_decode($imageInfo['data']));

            if (!$stored) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to save image',
                    'errors' => [
                        'avatar' => ['Unable to save image file']
                    ]
                ], 500);
            }

            // Update user avatar path
            $user->avatar = Storage::disk('public')->url($filename);
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Profile photo updated successfully!',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'avatar' => $user->avatar,
                        'role' => $user->role,
                        'email_verified_at' => $user->email_verified_at,
                        'created_at' => $user->created_at,
                        'updated_at' => $user->updated_at
                    ]
                ]
            ], 200);
        } catch (\Exception $e) {
            // Log error for debugging
            Log::error('Avatar update error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating profile photo',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Validate if string is a valid base64 image
     */
    private function isValidBase64Image($data)
    {
        // Check if it's a data URL format
        if (!preg_match('/^data:image\/(\w+);base64,/', $data)) {
            return false;
        }

        // Extract the base64 part
        $base64 = substr($data, strpos($data, ',') + 1);

        // Validate base64
        if (!base64_decode($base64, true)) {
            return false;
        }

        return true;
    }

    /**
     * Extract image info from base64 data URL
     */
    private function extractImageInfo($data)
    {
        // Match data URL pattern
        if (!preg_match('/^data:image\/(\w+);base64,(.+)$/', $data, $matches)) {
            return false;
        }

        $extension = $matches[1];
        $base64Data = $matches[2];

        // Validate extension
        $allowedExtensions = ['jpeg', 'jpg', 'png', 'gif'];
        if (!in_array(strtolower($extension), $allowedExtensions)) {
            return false;
        }

        // Normalize jpeg extension
        if ($extension === 'jpeg') {
            $extension = 'jpg';
        }

        return [
            'extension' => $extension,
            'data' => $base64Data
        ];
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => true,
            'message' => 'Logout successful',
        ], 200);
    }
}


// 'token' => $user->createToken($user->name)->plainTextToken,
// return $user->createToken($user->name)->plainTextToken;
