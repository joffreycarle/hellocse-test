<?php

namespace App\Services;

use App\DTOs\UpdateProfileDTO;
use App\Models\Profile;

class ProfileService
{
    const string IMAGE_STORAGE_PATH = 'profiles';

    public function updateProfile(Profile $profile, UpdateProfileDTO $updateProfileDTO): bool
    {
        $data = [
            'first_name' => $updateProfileDTO->first_name,
            'last_name' => $updateProfileDTO->last_name,
            'status' => $updateProfileDTO->status,
        ];

        if ($updateProfileDTO->image) {
            $data['image'] = $updateProfileDTO->image->store(self::IMAGE_STORAGE_PATH, 'public');
        }

        return $profile->update($data);
    }
}
