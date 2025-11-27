<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Contact;
use App\Models\User; // <--- Importante: Importar o model User
use Tests\TestCase;

class ContactFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Generate mock user to authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    /** @test */
    public function contacts_index_page_is_displayed_and_shows_paginated_data(): void
    {
        // PREP
        Contact::factory()->count(15)->create();

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
    public function contacts_index_search_functionality_works(): void
    {
        // PREP
        Contact::factory()->create(['name' => 'Target Person', 'email' => 'target@test.com']);
        Contact::factory()->create(['name' => 'Ignored Person', 'email' => 'ignore@test.com']);

        // ACTION
        $response = $this->get(route('contacts.index', ['search' => 'Target']));

        // ASSERTIONS
        $response->assertStatus(200);
        $response->assertSee('Target Person');
        $response->assertDontSee('Ignored Person');
    }

    /** @test */
    public function contact_details_page_is_displayed_correctly(): void
    {
        // PREP
        $contact = Contact::factory()->create();

        // ACTION
        $response = $this->get(route('contacts.show', $contact));

        // ASSERTIONS
        $response->assertStatus(200);
        $response->assertViewHas('contact', function ($viewContact) use ($contact) {
            return $viewContact->id === $contact->id;
        });
        
        $response->assertSee($contact->name);
        $response->assertSee($contact->email);
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
        $this->assertNotNull($contact);

        $response->assertRedirect(route('contacts.show', $contact));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contacts', $validData);
    }
    
    /** @test */
    public function store_fails_if_data_is_invalid(): void
    {
        // PREP
        $invalidData = [
            'name' => 'No', 
            'contact' => '123',
            'email' => 'not-an-email',
        ];

        // ACTION
        $response = $this->post(route('contacts.store'), $invalidData);

        // ASSERTION
        $response->assertStatus(302); 
        $response->assertSessionHasErrors(['name', 'contact', 'email']); 
        
        $this->assertDatabaseCount('contacts', 0);
    }

    /** @test */
    public function store_fails_if_email_or_contact_is_not_unique(): void
    {
        // PREP
        Contact::factory()->create([
            'contact' => '999888777',
            'email' => 'duplicate@test.com',
        ]);
        
        $data = [
            'name' => 'Another Name',
            'contact' => '999888777',
            'email' => 'duplicate@test.com',
        ];
        
        // ACTION
        $response = $this->post(route('contacts.store'), $data);

        // ASSERTIONS
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['email', 'contact']);
    }

    /** @test */
    public function edit_contact_form_is_displayed(): void
    {
        // PREP
        $contact = Contact::factory()->create();

        // ACTION
        $response = $this->get(route('contacts.edit', $contact));

        // ASSERTIONS
        $response->assertStatus(200);
        $response->assertViewIs('contacts.edit');
        $response->assertSee($contact->name);
    }

    /** @test */
    public function contact_can_be_updated_with_valid_data(): void
    {
        // PREP
        $contact = Contact::factory()->create([
            'name' => 'Old Name',
            'email' => 'old@email.com',
        ]);

        $updatedData = [
            'name' => 'New Name Updated',
            'contact' => '123456789',
            'email' => 'new.updated@email.com',
        ];

        // ACTION
        $response = $this->put(route('contacts.update', $contact), $updatedData);

        // ASSERTIONS
        $response->assertStatus(302);
        $response->assertRedirect(route('contacts.show', $contact));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'name' => 'New Name Updated',
            'email' => 'new.updated@email.com',
        ]);
    }

    /** @test */
    public function update_allows_same_email_for_same_contact(): void
    {
        $contact = Contact::factory()->create(['email' => 'me@test.com', 'contact' => '999999999']);

        $data = [
            'name' => 'New Name',
            'email' => 'me@test.com',
            'contact' => '999999999'
        ];

        $response = $this->put(route('contacts.update', $contact), $data);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('contacts.show', $contact));
        $this->assertDatabaseHas('contacts', ['name' => 'New Name']);
    }

    /** @test */
    public function update_fails_if_email_is_taken_by_another_contact(): void
    {
        // PREP
        Contact::factory()->create(['email' => 'other@test.com']);
        $myContact = Contact::factory()->create(['email' => 'me@test.com']);

        $data = [
            'name' => 'Try Steal Email',
            'contact' => '123123123',
            'email' => 'other@test.com',
        ];

        // ACTION
        $response = $this->put(route('contacts.update', $myContact), $data);

        // ASSERTIONS
        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function contact_can_be_soft_deleted(): void
    {
        // PREP
        $contact = Contact::factory()->create();

        // ACTION
        $response = $this->delete(route('contacts.destroy', $contact));

        // ASSERTIONS
        $response->assertStatus(302);
        $response->assertRedirect(route('contacts.index'));
        $response->assertSessionHas('success');

        $this->assertSoftDeleted('contacts', ['id' => $contact->id]);
    }

    /** @test */
    public function trashed_page_is_displayed_and_shows_only_deleted_contacts(): void
    {
        // PREP
        Contact::factory()->create(['name' => 'Active User']);
        Contact::factory()->trashed()->create(['name' => 'Deleted User']);

        // ACTION
        $response = $this->get(route('contacts.trashed'));

        // ASSERTIONS
        $response->assertStatus(200);
        $response->assertViewIs('contacts.trashed');
        
        $response->assertSee('Deleted User');
        $response->assertDontSee('Active User');
    }

    /** @test */
    public function trashed_search_functionality_works(): void
    {
        // PREP
        Contact::factory()->trashed()->create(['name' => 'Deleted Alpha']);
        Contact::factory()->trashed()->create(['name' => 'Deleted Beta']);

        // ACTION
        $response = $this->get(route('contacts.trashed', ['search' => 'Alpha']));

        // ASSERTIONS
        $response->assertSee('Deleted Alpha');
        $response->assertDontSee('Deleted Beta');
    }

    /** @test */
    public function contact_can_be_restored_from_trash(): void
    {
        // PREP
        $deletedContact = Contact::factory()->trashed()->create();

        // ACTION
        $response = $this->patch(route('contacts.restore', $deletedContact->id), [
            'contact' => $deletedContact->id 
        ]);

        // ASSERTIONS
        $response->assertStatus(302);
        $response->assertRedirect(route('contacts.index'));
        $response->assertSessionHas('success');

        $this->assertNotSoftDeleted('contacts', ['id' => $deletedContact->id]);
    }

    /** @test */
    public function contact_can_be_permanently_deleted_wiped(): void
    {
        // PREP
        $deletedContact = Contact::factory()->trashed()->create();

        // ACTION
        $response = $this->delete(route('contacts.wipe', $deletedContact->id));

        // ASSERTIONS
        $response->assertStatus(302);
        $response->assertRedirect(route('contacts.trashed'));
        $response->assertSessionHas('success');

        // Check hard delete
        $this->assertDatabaseMissing('contacts', ['id' => $deletedContact->id]);
    }
}