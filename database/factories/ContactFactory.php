<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{

    protected $model = Contact::class;

    public function definition(): array
    {
        $contactNumber = '9' . $this->faker->unique()->numerify('########');
        
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(), 
            'contact' => $contactNumber, 
        ];
    }
}