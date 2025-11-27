@extends('layouts.app')

@section('title', 'Contacts Manager - Details')

@section('content')

<div class="minimal-container">
    <h1 class="title">Contact Details</h1>

    <div class="actions-header mb-6">
        <a href="{{ route('contacts.edit', $contact) }}" class="btn-primary-small">Edit</a>

        <form action="{{ route('contacts.destroy', $contact) }}" method="POST" class="inline-form">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-warning-small">Destroy</button>
        </form>

        <form action="{{ route('contacts.wipe', $contact) }}" method="POST" class="inline-form">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-danger-small">Wipe</button>
        </form>
    </div>

    <div class="card">
        <div class="detail-row">
            <label class="detail-label">Name</label>
            <div class="detail-value">{{ $contact->name }}</div>
        </div>

        <div class="detail-row">
            <label class="detail-label">Email</label>
            <div class="detail-value">{{ $contact->email }}</div>
        </div>

        <div class="detail-row">
            <label class="detail-label">Contact</label>
            <div class="detail-value">{{ $contact->contact ?? '-' }}</div>
        </div>
        
        <hr class="divider">

        <div class="detail-row">
            <label class="detail-label">Created At</label>
            <div class="detail-value-meta">{{ \Carbon\Carbon::parse($contact->created_at)->format('d/m/Y - H:i') }}</div>
        </div>

        <div class="detail-row">
            <label class="detail-label">Updated At</label>
            <div class="detail-value-meta">{{ \Carbon\Carbon::parse($contact->updated_at)->format('d/m/Y - H:i') ?? '-' }}</div>
        </div>
        
        @if ($contact->deleted_at)
        <div class="detail-row mt-4">
            <label class="detail-label text-danger">Deleted At</label>
            <div class="detail-value-meta text-danger">{{ \Carbon\Carbon::parse($contact->deleted_at)->format('d/m/Y - H:i') }}</div>
        </div>
        @endif
    </div>

    <div class="actions mt-6 justify-start">
        <a href="{{ route('contacts.index') }}" class="btn-secondary">Back to List</a>
    </div>

</div>

<style>
    .minimal-container {
        max-width: 550px;
        margin: 0 auto;
        padding: 1.5rem;
    }

    .title {
        font-size: 1.6rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 1.5rem;
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
    
    .divider {
        border: 0;
        border-top: 1px solid #f0f0f0;
        margin: 1.5rem 0;
    }

    .detail-row {
        margin-bottom: 1rem;
    }
    
    .detail-row:last-of-type {
        margin-bottom: 0;
    }

    .detail-label {
        font-size: 0.85rem;
        font-weight: 500;
        color: #777;
        display: block;
        margin-bottom: 0.2rem;
        text-transform: uppercase;
    }

    .detail-value {
        font-size: 1.05rem;
        font-weight: 400;
        color: #333;
        background: #f8f8f8; 
        padding: 0.6rem 0.75rem;
        border-radius: 4px;
        border: 1px solid #eee;
    }
    
    .detail-value-meta {
        font-size: 0.9rem;
        color: #777;
        padding: 0.2rem 0;
    }

    .actions-header {
        display: flex;
        gap: 0.75rem;
    }
    
    .inline-form {
        display: inline-block;
    }

    .actions {
        margin-top: 1.5rem;
        display: flex;
        gap: 0.75rem;
        justify-content: flex-start;
    }

    .btn-primary-small,
    .btn-warning-small,
    .btn-danger-small {
        padding: 0.4rem 0.9rem;
        border-radius: 4px;
        font-size: 0.8rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-weight: 500;
        transition: background-color 0.2s;
    }

    .btn-primary-small {
        border: 1px solid #3b82f6; 
        background: #3b82f6; 
        color: #fff;
    }
    .btn-primary-small:hover {
        background: #2563eb;
        border-color: #2563eb;
    }

    .btn-warning-small {
        border: 1px solid #f59e0b;
        background: #f59e0b; 
        color: #fff;
    }
    .btn-warning-small:hover {
        background: #d97706;
        border-color: #d97706;
    }
    
    .btn-danger-small {
        border: 1px solid #ef4444; 
        background: #ef4444; 
        color: #fff;
    }
    .btn-danger-small:hover {
        background: #dc2626;
        border-color: #dc2626;
    }

    .btn-secondary {
        padding: 0.6rem 1.2rem;
        border-radius: 4px;
        font-size: 0.9rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-weight: 500;
        transition: background-color 0.2s;
        border: 1px solid #ccc;
        background: #f9f9f9;
        color: #555;
    }

    .btn-secondary:hover {
        background: #efefef;
    }
    
    .text-danger {
        color: #ef4444;
    }
</style>

@endsection