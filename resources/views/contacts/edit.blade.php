@extends('layouts.app')

@section('title', 'Contacts Manager - Edit')


@section('content')

<div class="container">
    <h1>Edit Contact</h1>

    <form action="{{ route('contacts.update', $contact) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="details-card">
            <div class="details-row">
                <label for="name">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name', $contact->name) }}" class="details-input">
                @error('name')
                    <div class="text-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="details-row">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', $contact->email) }}" class="details-input">
                @error('email')
                    <div class="text-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="details-row">
                <label for="contact">Contact</label>
                <input id="contact" type="text" name="contact" value="{{ old('contact', $contact->contact) }}" class="details-input">
                @error('contact')
                    <div class="text-error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="actions">
            <button type="submit" class="btn-save">Save</button>
            <a href="{{ route('contacts.show', $contact) }}" class="btn-back">Cancel</a>
        </div>
    </form>
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

    .details-row label {
        font-size: 0.9rem;
        color: #555;
        display: block;
        margin-bottom: 0.25rem;
    }

    .details-input {
        width: 100%;
        padding: 0.5rem;
        border-radius: 3px;
        border: 1px solid #ddd;
        font-size: 0.95rem;
    }

    .text-error {
        color: red;
        font-size: 0.8rem;
        margin-top: 0.2rem;
    }

    .actions {
        margin-top: 1.5rem;
    }

    .btn-save {
        padding: 0.5rem 1rem;
        border: none;
        background: #333;
        color: #fff;
        border-radius: 3px;
        cursor: pointer;
        font-size: 0.9rem;
    }

    .btn-save:hover {
        background: #555;
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
        margin-left: 0.5rem;
    }

    .btn-back:hover {
        background: #f2f2f2;
    }
</style>

@endsection
