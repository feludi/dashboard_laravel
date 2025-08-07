<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreForeignerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            // Personal Information
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:male,female,other',
            'nationality' => 'required|string|max:255',
            'passport_number' => 'required|string|max:255|unique:foreigners,passport_number',
            
            // Residence Permit Information
            'residence_permit_type' => 'required|in:ITK,ITAS,ITAP,other',
            'residence_permit_status' => 'required|string|max:255',
            'residence_permit_issue_date' => 'nullable|date|before_or_equal:today',
            
            // Address Information
            'status' => 'required|in:active,expiring_soon,expired,pending,cancelled,departed',
            'city' => 'required|string|max:255',
            'state_province' => 'required|string|max:255',
            'village' => 'nullable|string|max:255',
            'current_address' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:255',
            
            // Contact Information
            'email' => 'nullable|email|max:255',
            'phone_number' => 'nullable|string|max:255',
            'sponsor_contact_name' => 'nullable|string|max:255',
            'sponsor_contact_number' => 'nullable|string|max:255',
            
            // Additional Fields
            'entry_date' => 'nullable|date',
            'occupation' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ];

        // Conditional validation for residence permit expiry date
        // ITAP (permanent permit) doesn't require expiry date
        if ($this->input('residence_permit_type') !== 'ITAP') {
            $rules['residence_permit_expiry_date'] = 'required|date|after:today';
        } else {
            $rules['residence_permit_expiry_date'] = 'nullable|date|after:today';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'first_name.required' => 'First name is required.',
            'last_name.required' => 'Last name is required.',
            'date_of_birth.required' => 'Date of birth is required.',
            'date_of_birth.before' => 'Date of birth must be in the past.',
            'gender.required' => 'Gender is required.',
            'nationality.required' => 'Nationality is required.',
            'passport_number.required' => 'Passport number is required.',
            'passport_number.unique' => 'This passport number is already registered.',
            'residence_permit_type.required' => 'Residence permit type is required.',
            'residence_permit_type.in' => 'Please select a valid residence permit type.',
            'residence_permit_status.required' => 'Residence permit status is required.',
            'status.required' => 'Status is required.',
            'city.required' => 'City is required.',
            'state_province.required' => 'Province/State is required.',
            'residence_permit_expiry_date.required' => 'Residence permit expiry date is required for this permit type.',
            'residence_permit_expiry_date.after' => 'Residence permit expiry date must be in the future.',
            'residence_permit_issue_date.before_or_equal' => 'Issue date cannot be in the future.',
            'email.email' => 'Please enter a valid email address.',
        ];
    }
}
