<?php

namespace App\DataTransferObjects;

class RegistrationData
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
        public readonly ?int $planId = null,
        public readonly ?array $storeData = null,
        public readonly ?array $billingData = null
    ) {}

    public static function fromAccountRequest(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'],
            planId: session('selected_plan')
        );
    }

    public static function fromStoreRequest(array $data): self
    {
        $registrationData = session('registration_data');
        
        return new self(
            name: $registrationData['name'],
            email: $registrationData['email'],
            password: $registrationData['password'],
            planId: session('selected_plan'),
            storeData: [
                'name' => $data['name'],
                'description' => $data['description'],
                'business_name' => $data['business_name'],
                'tax_id' => $data['tax_id'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'address_line1' => $data['address_line1'],
                'address_line2' => $data['address_line2'],
                'city' => $data['city'],
                'state' => $data['state'],
                'postal_code' => $data['postal_code'],
                'country' => $data['country'],
            ]
        );
    }
} 