<?php

namespace App\Http\Requests\Affiliate;

use Illuminate\Foundation\Http\FormRequest;

class CarListingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'pickup_location' => 'nullable|string|max:255',
            'return_location' => 'nullable|string|max:255',
            'pickup_latitude' => 'nullable|numeric|between:-90,90',
            'pickup_longitude' => 'nullable|numeric|between:-180,180',
            'return_latitude' => 'nullable|numeric|between:-90,90',
            'return_longitude' => 'nullable|numeric|between:-180,180',
            'pickup_date' => 'nullable|string|max:20',
            'return_date' => 'nullable|string|max:20',
            'pickup_time' => 'nullable|string|max:20',
            'return_time' => 'nullable|string|max:20',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
            'category' => 'nullable|array',
            'category.*' => 'string|max:100',
            'sort_by' => 'nullable|string|in:ASC,DESC',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'pickup_latitude.between' => 'Pickup latitude must be between -90 and 90 degrees.',
            'pickup_longitude.between' => 'Pickup longitude must be between -180 and 180 degrees.',
            'return_latitude.between' => 'Return latitude must be between -90 and 90 degrees.',
            'return_longitude.between' => 'Return longitude must be between -180 and 180 degrees.',
            'min_price.min' => 'Minimum price cannot be negative.',
            'max_price.min' => 'Maximum price cannot be negative.',
            'sort_by.in' => 'Sort order must be either ASC or DESC.',
        ];
    }

    /**
     * Get the validated search parameters with defaults.
     */
    public function getSearchParams(): array
    {
        $validated = $this->validated();

        return [
            'pickup_location' => $validated['pickup_location'] ?? '',
            'return_location' => $validated['return_location'] ?? '',
            'pickup_latitude' => $validated['pickup_latitude'] ?? '',
            'pickup_longitude' => $validated['pickup_longitude'] ?? '',
            'return_latitude' => $validated['return_latitude'] ?? '',
            'return_longitude' => $validated['return_longitude'] ?? '',
            'pickup_date' => $validated['pickup_date'] ?? '',
            'return_date' => $validated['return_date'] ?? '',
            'pickup_time' => $validated['pickup_time'] ?? '9:00 AM',
            'return_time' => $validated['return_time'] ?? '9:00 AM',
            'min_price' => $validated['min_price'] ?? 0,
            'max_price' => $validated['max_price'] ?? 1500,
            'category' => $validated['category'] ?? ['All'],
            'sort_by' => $validated['sort_by'] ?? 'ASC',
        ];
    }

    /**
     * Get search parameters for AJAX search requests.
     */
    public function getSearchParamsForAjax(): array
    {
        return $this->getSearchParams();
    }

    /**
     * Get search parameters for page load (index).
     */
    public function getSearchParamsForIndex(): array
    {
        return $this->getSearchParams();
    }
}
