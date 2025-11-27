@extends('layouts.app')

@section('title', 'Contacts Manager - Create')

@section('content')

<div class="minimal-container">
    <h1 class="title">Create Contact</h1>

    <form action="{{ route('contacts.store') }}" method="POST">
        @csrf

        <div class="card">

            <div class="form-group">
                <label for="name" class="form-label">Name</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    class="form-input-minimal"
                    value="{{ old('name') }}"
                    minlength="5"
                    required>
                @error('name')
                <div class="text-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    class="form-input-minimal"
                    value="{{ old('email') }}"
                    required>
                @error('email')
                <div class="text-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="contact" class="form-label">Contact (9 digits)</label>
                <input
                    type="text"
                    name="contact"
                    id="contact"
                    class="form-input-minimal"
                    value="{{ old('contact') }}"
                    placeholder="Ex: 912345678"
                    pattern="\d{9}"
                    minlength="9"
                    maxlength="9">
                @error('contact')
                <div class="text-error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="actions mt-6">
            <a href="{{ route('contacts.index') }}" class="btn-secondary">Back</a>
            <button type="submit" class="btn-primary">Save Contact</button>
        </div>
    </form>
</div>

<style>
    .minimal-container {
        max-width: 500px;
        margin: 0 auto;
        padding: 1.5rem;
    }

    .title {
        font-size: 1.6rem;
        font-weight: 600; 
        color: #333;
        margin-bottom: 2rem;
        border-bottom: 1px solid #eee; 
        padding-bottom: 0.5rem;
    }

    .card {
        border: 1px solid #e0e0e0; 
        border-radius: 6px;
        padding: 1.5rem;
        background: #ffffff; 
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05); 
    }

    .form-group {
        margin-bottom: 1.25rem;
    }

    .form-label {
        font-size: 0.9rem;
        font-weight: 500;
        color: #4a4a4a;
        display: block;
        margin-bottom: 0.4rem;
    }

    .form-input-minimal {
        width: 100%;
        border: 1px solid #ccc; 
        padding: 0.6rem 0.75rem;
        border-radius: 4px;
        background: #fff;
        font-size: 0.95rem;
        transition: border-color 0.2s;
    }
    
    .form-input-minimal:focus {
        border-color: #3b82f6; 
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }

    .actions {
        display: flex;
        gap: 0.75rem;
        justify-content: flex-end; 
    }

    .btn-secondary,
    .btn-primary {
        padding: 0.6rem 1.2rem;
        border-radius: 4px;
        font-size: 0.9rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-weight: 500;
        transition: background-color 0.2s, border-color 0.2s;
    }

    .btn-secondary {
        border: 1px solid #ccc;
        background: #f9f9f9;
        color: #555;
    }

    .btn-secondary:hover {
        background: #efefef;
    }

    .btn-primary {
        border: 1px solid #10b981; 
        background: #10b981; 
        color: #fff;
    }

    .btn-primary:hover {
        background: #059669; 
        border-color: #059669;
    }

    .text-error {
        color: #ef4444; 
        font-size: 0.75rem;
        margin-top: 0.3rem;
    }
</style>

@endsection