@extends('layouts.app')

@section('title', 'Contacts Manager - Details')


@section('content')

<div class="container">
    <h1>Contact Details</h1>
    <div class="actions-header" style="margin-bottom: 1rem; display: flex; gap: 0.5rem;">
        <a href="{{ route('contacts.edit', $contact) }}" class="btn-edit">Edit</a>

        <form action="{{ route('contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this contact?')" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-destroy">Destroy</button>
        </form>

        <form action="{{ route('contacts.wipe', $contact) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this contact?')" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-wipe">Wipe</button>
        </form>
    </div>
    <div class="details-card">
        <div class="details-row">
            <label>Name</label>
            <div class="details-value">{{ $contact->name }}</div>
        </div>

        <div class="details-row">
            <label>Email</label>
            <div class="details-value">{{ $contact->email }}</div>
        </div>

        <div class="details-row">
            <label>Contact</label>
            <div class="details-value">{{ $contact->contact ?? '-' }}</div>
        </div>

        <div class="details-row">
            <label>Created At</label>
            <div class="details-value">{{ \Carbon\Carbon::parse($contact->created_at)->format('d/m/Y - m:i') }}</div>
        </div>

        <div class="details-row">
            <label>Updated At</label>
            <div class="details-value">{{ \Carbon\Carbon::parse($contact->updated_at)->format('d/m/Y - m:i') ?? '-' }}</div>
        </div>


    </div>

    <div class="actions">
        <a href="{{ route('contacts.index') }}" class="btn-back">Back</a>
    </div>
</div>

<style>
    .container {
        max-width: 600px;
        margin: 0 auto;
        padding: 1rem;
    }

    h1 {
        font-size: 1.4rem;
        font-weight: bold;
        margin-bottom: 1.5rem;
    }





    .details-card {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 1rem;
        background: #fafafa;
    }

    .details-row {
        margin-bottom: 1rem;
    }

    .details-row:last-child {
        margin-bottom: 0;
    }

    .details-row label {
        font-size: 0.9rem;
        color: #555;
        display: block;
        margin-bottom: 0.25rem;
    }

    .details-value {
        border: 1px solid #ddd;
        padding: 0.5rem;
        background: #fff;
        border-radius: 3px;
        font-size: 0.95rem;
    }

    .btn-edit {
        display: inline-block;
        padding: 0.4rem 0.8rem;
        font-size: 0.85rem;
        border: 1px solid #333;
        border-radius: 3px;
        text-decoration: none;
        color: #000;
        background: #fff;
        transition: background 0.2s ease;
    }

    .btn-edit:hover {
        background: #f2f2f2;
    }

    .btn-destroy {
        padding: 0.4rem 0.8rem;
        font-size: 0.85rem;
        border: 1px solid #f0ad4e;
        border-radius: 3px;
        background: #fff3e0;
        color: #e67e22;
        cursor: pointer;
        transition: background 0.2s ease;
    }

    .btn-destroy:hover {
        background: #f8d9b5;
    }

    .btn-wipe {
        padding: 0.4rem 0.8rem;
        font-size: 0.85rem;
        border: 1px solid #d9534f;
        border-radius: 3px;
        background: #fbeaea;
        color: #c0392b;
        cursor: pointer;
        transition: background 0.2s ease;
    }

    .btn-wipe:hover {
        background: #f5c6c6;
    }

    .details-card {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 1rem;
        background: #fafafa;
    }

    .details-row {
        margin-bottom: 1rem;
    }

    .details-row:last-child {
        margin-bottom: 0;
    }

    .details-row label {
        font-size: 0.9rem;
        color: #555;
        display: block;
        margin-bottom: 0.25rem;
    }

    .details-value {
        border: 1px solid #ddd;
        padding: 0.5rem;
        background: #fff;
        border-radius: 3px;
        font-size: 0.95rem;
    }

    .actions {
        margin-top: 1.5rem;
    }

    .btn-back {
        display: inline-block;
        padding: 0.5rem 0.9rem;
        border: 1px solid #aaa;
        background: #fff;
        text-decoration: none;
        border-radius: 3px;
        font-size: 0.9rem;
        color: #333;
    }

    .btn-back:hover {
        background: #f2f2f2;
    }
</style>

@endsection