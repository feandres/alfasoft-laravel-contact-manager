<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Contact;
use Tests\TestCase;

class ContactFeatureTest extends TestCase
{
    //Garantee that the database is refreshed for each test
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Contact::factory()->count(15)->create();
    }

    /** @test */
    public function contacts_index_page_is_displayed_and_shows_paginated_data(): void
    {
        // ACTION
        $response = $this->get(route('contacts.index'));

        // ASSERTIONS
        
        $response->assertStatus(200); 
        
        $response->assertViewIs('contacts.index');
        
        $response->assertViewHas('contacts');
        
        $response->assertViewHas('contacts', function ($contacts) {
            return $contacts->count() === 10;
        });
        
        $latestContact = Contact::latest()->first();

        $response->assertSee($latestContact->name);
    }

    /** @test */
    public function contact_details_page_is_displayed_correctly(): void
    {
        // PREP
        // Mock contact 
        $contact = Contact::factory()->create();

        // ACTION
        $response = $this->get(route('contacts.show', $contact));

        // ASSERTIONS
        
        $response->assertStatus(200);

        $response->assertViewIs('contacts.show');

        $response->assertViewHas('contact', $contact);
        
        $response->assertSee($contact->name);
        
        $response->assertSee($contact->email);
        
        $response->assertSee($contact->contact);
        
        $response->assertSee($contact->created_at->toDateTimeString());
    }

    /** @test */
    public function create_contact_form_is_displayed(): void
    {
        // ACTION
        $response = $this->get(route('contacts.create'));

        // ASSERTIONS
        
        $response->assertStatus(200);

        $response->assertViewIs('contacts.create');
    }
    
    /** @test */
    public function contact_can_be_stored_with_valid_data(): void
    {
        // PREP
        $validData = [
            'name' => 'John Doe Test',
            'contact' => '987654321', 
            'email' => 'john.doe@test.com',
        ];

        // ACTION
        $response = $this->post(route('contacts.store'), $validData);

        // ASSERTIONS

        $response->assertStatus(302); 
        
        $contact = Contact::where('email', $validData['email'])->first();

        $response->assertRedirect(route('contacts.show', $contact));

        $this->assertDatabaseHas('contacts', $validData);
    }
    
    /** @test */
    public function store_fails_if_name_is_missing_or_too_short(): void
    {
        // PREP:
        $invalidData = [
            'name' => 'Nuno', 
            'contact' => '912345678',
            'email' => 'invalido@short.com',
        ];

        // ACTION
        $response = $this->post(route('contacts.store'), $invalidData);

        // ASSERTION
        
        $response->assertStatus(422); 
        
        $response->assertSessionHasErrors('name'); 
        
        $this->assertDatabaseMissing('contacts', ['email' => 'invalido@short.com']);
    }

    /** @test */
    public function store_fails_if_contact_is_not_9_digits(): void
    {
        // PREP
        $invalidData = [
            'name' => 'Valid Name',
            'contact' => '12345', 
            'email' => 'invalido@contact.com',
        ];

        // ACTION
        $response = $this->post(route('contacts.store'), $invalidData);

        // ASSERTION
        
        $response->assertStatus(422);
        $response->assertSessionHasErrors('contact');
        $this->assertDatabaseMissing('contacts', ['email' => 'invalido@contact.com']);
    }

    /** @test */
    public function store_fails_if_email_or_contact_is_not_unique(): void
    {
        // PREP
        Contact::factory()->create([
            'contact' => '999888777',
            'email' => 'double@teste.com',
        ]);
        
        $duplicateEmailData = [
            'name' => 'Other Name',
            'contact' => '111222333',
            'email' => 'double@teste.com', //same email
        ];

        $duplicateContactData = [
            'name' => 'Another Name',
            'contact' => '999888777', // same contact
            'email' => 'novo@teste.com',
        ];
        
        // ACTION
        $responseEmail = $this->post(route('contacts.store'), $duplicateEmailData);

        // ASSERTIONS
        $responseEmail->assertStatus(422);
        $responseEmail->assertSessionHasErrors('email');
        
        // ACTION
        $responseContact = $this->post(route('contacts.store'), $duplicateContactData);
        // ASSERTIONS
        $responseContact->assertStatus(422);
        $responseContact->assertSessionHasErrors('contact');
    }
}
