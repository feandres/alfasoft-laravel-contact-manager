@extends('layout.layout')

@section('title', 'Contact Details')

@section('content')

<div class="container">
    <h1>Contact Details</h1>

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
