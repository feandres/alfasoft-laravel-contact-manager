<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\RestoreContactRequest;
use Illuminate\Support\Facades\Log; 

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        try {
            $contacts = Contact::query()
                ->when($search, function ($q) use ($search) {
                    $q->where(function ($sub) use ($search) {
                        $sub->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('contact', 'like', "%{$search}%");
                    });
                })
                ->whereNull('deleted_at')
                ->orderByDesc('created_at')
                ->paginate(10)
                ->appends(['search' => $search]);

            return view('contacts.index', compact('contacts'));
        } catch (\Throwable $e) {
            Log::error("Error listing contacts in index(): " . $e->getMessage(), ['exception' => $e]);
            return redirect()->route('contacts.index')->with('error', 'An error occurred while loading the contact list.');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Contact $contact, Request $request)
    {

        $page = $request->query('page');
        $search = $request->query('search');

        return view('contacts.show', compact('contact', 'page', 'search'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     * Validation is automatically handled by StoreContactRequest.
     */
    public function store(StoreContactRequest $request): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $contact = Contact::create($request->validated());

            DB::commit();

            return redirect()->route('contacts.show', $contact)
                ->with('success', 'Contact created successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Error creating contact: " . $e->getMessage(), ['request' => $request->all(), 'exception' => $e]);
            return redirect()->route('contacts.create')
                ->with('error', 'Failed to create contact due to a server error.')
                ->withInput();
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        return view('contacts.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     * Validation is automatically handled by UpdateContactRequest.
     */
    public function update(UpdateContactRequest $request, Contact $contact): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $contact->update($request->validated());

            DB::commit();

            return redirect()->route('contacts.show', $contact)
                ->with('success', 'Contact updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Error updating contact ID: {$contact->id}: " . $e->getMessage(), ['request' => $request->all(), 'exception' => $e]);
            return redirect()->route('contacts.edit', $contact)
                ->with('error', 'Failed to update contact due to a server error.')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy(Contact $contact): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $contact->delete();
            DB::commit();

            return redirect()->route('contacts.index')
                ->with('success', 'Contact deleted successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Error deleting contact ID: {$contact->id}: " . $e->getMessage(), ['exception' => $e]);
            return redirect()->route('contacts.index')
                ->with('error', 'Failed to delete contact.');
        }
    }


    /**
     * Restore a soft-deleted contact.
     * ID validation is automatically handled by RestoreContactRequest.
     */
    public function restore(RestoreContactRequest $request, int $contactId): RedirectResponse
    {
        $contact = Contact::withTrashed()->findOrFail($contactId);
        DB::beginTransaction();
        try {
            $contact->restore();
            DB::commit();

            Log::info("Contact ID: {$request->contact} restored successfully.");

            return redirect()->route('contacts.index')
                ->with('success', 'Contact restored successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Error restoring contact ID: {$contact->id}" . $e->getMessage(), ['exception' => $e]);
            return redirect()->route('contacts.trashed')
                ->with('error', 'Failed to restore contact.');
        }
    }

    public function trashed(Request $request)
    {
        $search = $request->input('search');

        try {
            $contacts = Contact::onlyTrashed()
                ->when($search, function ($q) use ($search) {
                    $q->where(function ($sub) use ($search) {
                        $sub->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('contact', 'like', "%{$search}%");
                    });
                })
                ->orderByDesc('deleted_at')
                ->paginate(10)
                ->appends(['search' => $search]);

            return view('contacts.trashed', compact('contacts'));
        } catch (\Throwable $e) {
            Log::error("Error listing trashed contacts in trashed(): " . $e->getMessage(), ['exception' => $e]);
            return redirect()->route('contacts.index')->with('error', 'An error occurred while loading the trash list.');
        }
    }


    /**
     * Permanently delete a contact (hard delete).
     */
    public function wipe(int $id): RedirectResponse
    {
        $contact = Contact::withTrashed()->findOrFail($id);

        DB::beginTransaction();

        try {
            $contact->forceDelete();
            DB::commit();

            return redirect()->route('contacts.trashed')
                ->with('success', 'Contact permanently deleted.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Error permanently wiping contact ID: {$contact->id}: " . $e->getMessage(), ['exception' => $e]);
            return redirect()->route('contacts.trashed')
                ->with('error', 'Failed to permanently delete contact.');
        }
    }
}