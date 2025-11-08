<?php

namespace App\Http\Controllers;

use App\Services\ProfileService;
use App\Http\Requests\Profile\UpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    protected ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    /**
     * Show profile page
     * RC6: Authorization control with policy
     */
    public function show()
    {
        $user = auth()->user();
        $this->authorize('view', $user);

        $profileData = $this->profileService->getProfileData($user);
        return view('profile.show', $profileData);
    }

    /**
     * Show edit profile form
     * RC6: Authorization control with policy
     */
    public function edit()
    {
        $user = auth()->user();
        $this->authorize('update', $user);

        $profileData = $this->profileService->getProfileData($user);
        return view('profile.edit', $profileData);
    }

    /**
     * Update profile information
     * RC6: Authorization control with policy
     * RC14: Exception handling with proper user feedback
     * RC18: Log all operations
     */
    public function update(UpdateProfileRequest $request)
    {
        try {
            $user = auth()->user();
            $this->authorize('update', $user);

            $originalData = $user->only(['name', 'email']);
            $this->profileService->updateProfile($user, $request->validated());

            // RC18: Log successful operation
            Log::info('Profile updated by user', [
                'user_id' => auth()->id(),
                'changes' => array_diff_assoc($request->validated(), $originalData),
            ]);

            toastr()->success(__('users.profile_updated'));
            return back();
        } catch (\Exception $e) {
            // RC14: Report to logs with details
            Log::error('Profile update failed', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            toastr()->error(__('users.operation_failed', ['error' => $e->getMessage()]));
            return back();
        }
    }

    /**
     * Update password
     * RC6: Authorization control with policy
     * RC10: Form validation
     */
    public function updatePassword(Request $request)
    {
        $user = auth()->user();
        $this->authorize('updatePassword', $user);

        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            $data = $validator->validated();
            $this->profileService->updatePassword(
                $user,
                $data['current_password'],
                $data['password']
            );

            toastr()->success(__('users.password_updated'));
            return back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }

    /**
     * Update settings
     * RC6: Authorization control with policy
     * RC10: Form validation
     */
    public function updateSettings(Request $request)
    {
        $user = auth()->user();
        $this->authorize('updateSettings', $user);

        $validator = Validator::make($request->all(), [
            'preferred_language_id' => ['nullable', 'exists:languages,id'],
            'theme' => ['nullable', 'in:light,dark,system'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            $this->profileService->updateSettings($user, $validator->validated());
            toastr()->success(__('users.settings_updated'));
            return back();
        } catch (\Exception $e) {
            toastr()->error(__('users.settings_update_failed', ['error' => $e->getMessage()]));
            return back();
        }
    }

    /**
     * Update avatar
     * RC6: Authorization control with policy
     * RC10: Form validation - file upload with 2MB limit
     */
    public function updateAvatar(Request $request)
    {
        $user = auth()->user();
        $this->authorize('updateAvatar', $user);

        $validator = Validator::make($request->all(), [
            'avatar' => ['required', 'image', 'max:2048'], // RC10: 2MB limit
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            $this->profileService->updateAvatar($user, $request->file('avatar'));
            toastr()->success(__('users.avatar_updated'));
            return back();
        } catch (\Exception $e) {
            toastr()->error(__('users.avatar_update_failed', ['error' => $e->getMessage()]));
            return back();
        }
    }

    /**
     * Delete avatar
     * RC6: Authorization control with policy
     */
    public function deleteAvatar()
    {
        $user = auth()->user();
        $this->authorize('updateAvatar', $user);

        try {
            $this->profileService->deleteAvatar($user);
            toastr()->success(__('users.avatar_deleted'));
            return back();
        } catch (\Exception $e) {
            toastr()->error(__('users.avatar_delete_failed', ['error' => $e->getMessage()]));
            return back();
        }
    }

    /**
     * Deactivate account
     */
    public function deactivate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'confirm_deactivation' => ['required', 'accepted'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            // Verify password before deactivation
            if (!password_verify($request->current_password, auth()->user()->password)) {
                return back()->withErrors(['current_password' => 'Password is incorrect']);
            }

            $this->profileService->deactivateAccount(auth()->user());

            // Log out user after deactivation
            auth()->logout();

            return redirect()->route('login')->with('success', 'Your account has been deactivated');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to deactivate account: ' . $e->getMessage()]);
        }
    }

    /**
     * Export user data (GDPR)
     */
    public function exportData()
    {
        try {
            $data = $this->profileService->exportUserData(auth()->user());

            return response()->json($data)
                ->header('Content-Disposition', 'attachment; filename="my-data-' . date('Y-m-d') . '.json"')
                ->header('Content-Type', 'application/json');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to export data: ' . $e->getMessage()]);
        }
    }
}
