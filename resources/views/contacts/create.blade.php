@extends('layout.layout')

@section('title', 'Create Contact')

@section('content')

<div class="container">
    <h1>Create Contact</h1>

    <form action="{{ route('contacts.store') }}" method="POST">
        @csrf

        <div class="form-card">

            <div class="form-row">
                <label>Name</label>
                <input 
                    type="text" 
                    name="name" 
                    class="form-input"
                    value="{{ old('name') }}"
                    minLength="5"
                    required
                >
            </div>

            <div class="form-row">
                <label>Email</label>
                <input 
                    type="email" 
                    name="email" 
                    class="form-input"
                    value="{{ old('email') }}"
                    required
                >
            </div>

            <div class="form-row">
                <label>Contact</label>
                <input 
                    type="text" 
                    name="contact" 
                    class="form-input"
                    value="{{ old('contact') }}"
                    pattern="\d{9}"
                    minLength="9"
                    maxLength="9"
                >
            </div>
        </div>

        <div class="actions">
            <a href="{{ route('contacts.index') }}" class="btn-back">Back</a>
            <button type="submit" class="btn-save">Save</button>
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

    .form-card {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 1rem;
        background: #fafafa;
    }

    .form-row {
        margin-bottom: 1rem;
    }

    .form-row:last-child {
        margin-bottom: 0;
    }

    label {
        font-size: 0.9rem;
        color: #555;
        display: block;
        margin-bottom: 0.25rem;
    }

    .form-input {
        width: 100%;
        border: 1px solid #ddd;
        padding: 0.5rem;
        border-radius: 3px;
        background: #fff;
        font-size: 0.95rem;
    }

    .actions {
        margin-top: 1.5rem;
        display: flex;
        gap: 0.5rem;
    }

    .btn-back,
    .btn-save {
        padding: 0.5rem 0.9rem;
        border-radius: 3px;
        font-size: 0.9rem;
        text-decoration: none;
        display: inline-block;
    }

    .btn-back {
        border: 1px solid #aaa;
        background: #fff;
        color: #333;
    }

    .btn-back:hover {
        background: #f2f2f2;
    }

    .btn-save {
        border: 1px solid #4a4a4a;
        background: #fff;
        cursor: pointer;
    }

    .btn-save:hover {
        background: #f2f2f2;
    }
</style>

@endsection
