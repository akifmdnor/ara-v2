<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class StorageHelper
{
    /**
     * Get the URL for a file stored in V1 application storage
     *
     * @param string $path
     * @return string
     */
    public static function v1Url(string $path): string
    {
        $v1Url = config('app.v1_url', 'https://old-app.example.com');

        // Remove leading slash if present
        $path = ltrim($path, '/');

        // Remove 'public/' prefix if present (V1 storage doesn't use public directory structure)
        $path = preg_replace('/^public\//', '', $path);

        // Ensure the URL ends with a slash and combine with the path
        $v1Url = rtrim($v1Url, '/');

        return $v1Url . '/storage/' . $path;
    }

    /**
     * Get the URL for a file (local storage or V1 depending on configuration)
     *
     * @param string $path
     * @param bool $forceV1 Force using V1 URL instead of local storage
     * @return string
     */
    public static function url(string $path, bool $forceV1 = false): string
    {
        // If forceV1 is true or if we want to use V1 for all storage URLs, use V1 URL
        if ($forceV1 || config('app.use_v1_storage', false)) {
            return self::v1Url($path);
        }

        // Otherwise use local storage URL
        return Storage::url($path);
    }

    /**
     * Check if a file exists in V1 storage
     *
     * @param string $path
     * @return bool
     */
    public static function v1Exists(string $path): bool
    {
        // For V1 storage, we assume the file exists if the path is provided
        // In a real implementation, you might want to make an HTTP request to check
        return !empty($path);
    }
}
