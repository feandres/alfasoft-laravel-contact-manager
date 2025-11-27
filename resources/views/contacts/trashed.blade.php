@extends('layouts.app')

@section('title', 'Contacts Manager - Deleted List')

@section('content')
<div class="minimal-container">
    <h1 class="title">Soft Deleted Contacts</h1>

    <div class="header-actions-trashed">
        <form method="GET" action="{{ route('contacts.trashed') }}" id="search-form" class="search-form">
            <input type="text" name="search" id="search-input"
                value="{{ request('search') }}"
                placeholder="Search deleted contacts..."
                class="search-input">
        </form>
    </div>
    
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($errors->has('restore'))
    <div class="alert alert-danger">{{ $errors->first('restore') }}</div>
    @endif

    <div class="card table-card">
        <table>
            <thead>
                <tr>
                    <th class="table-header w-1/4">Name</th>
                    <th class="table-header w-1/4 hidden sm:table-cell">Email</th>
                    <th class="table-header w-1/4 hidden sm:table-cell">Contact</th>
                    <th class="table-header w-1/4 hidden sm:table-cell">Deleted Date</th>
                    <th class="table-header w-1/4 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($contacts as $contact)
                <tr class="table-row">
                    <td class="table-cell font-medium">{{ $contact->name }}</td>
                    <td class="table-cell hidden sm:table-cell text-sm text-gray-600">{{ $contact->email }}</td>
                    <td class="table-cell hidden sm:table-cell text-sm text-gray-600">{{ $contact->contact }}</td>
                    <td class="table-cell hidden sm:table-cell text-sm text-gray-600">
                        {{ \Carbon\Carbon::parse($contact->deleted_at)->format('d/m/Y H:i') }}
                    </td>
                    <td class="table-cell actions-cell">
                        
                        <form action="{{ route('contacts.restore', $contact->id) }}" method="POST" class="inline-form">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn-success-small">Restore</button>
                        </form>
                        
                        <form action="{{ route('contacts.wipe', $contact) }}" method="POST" class="inline-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger-small">Wipe</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-gray-500">No deleted contacts found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container mt-6">
        {{ $contacts->links() }}
    </div>
</div>

<script>
    const input = document.getElementById('search-input');

    let timer = null;
    input.addEventListener('input', function() {
        clearTimeout(timer);
        timer = setTimeout(() => {
            document.getElementById('search-form').submit();
        }, 300); 
    });
</script>


<style>
    .minimal-container {
        max-width: 960px;
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

    .header-actions-trashed {
        display: flex;
        justify-content: flex-end; 
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .search-form {
        max-width: 300px;
    }
    
    .search-input {
        width: 100%;
        border: 1px solid #ccc; 
        padding: 0.6rem 0.75rem;
        border-radius: 4px;
        background: #fff;
        font-size: 0.95rem;
        transition: border-color 0.2s;
    }
    
    .search-input:focus {
        border-color: #3b82f6; 
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }
    
    .card {
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        padding: 0; 
        background: #ffffff; 
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05); 
    }
    
    .table-card {
        overflow-x: auto; 
        padding: 1px; 
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    .table-header {
        text-align: left;
        padding: 0.75rem 1.5rem;
        font-size: 0.8rem;
        text-transform: uppercase;
        color: #555;
        background: #f8f8f8;
        border-bottom: 2px solid #e0e0e0;
        font-weight: 600;
    }
    
    .table-header:first-child {
        border-top-left-radius: 6px;
    }
    
    .table-header:last-child {
        border-top-right-radius: 6px;
    }
    
    .table-row {
        transition: background-color 0.2s;
    }

    .table-row:hover {
        background: #fdfdfd; 
    }
    
    .table-cell {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #f0f0f0;
        color: #333;
    }

    .table-row:last-child .table-cell {
        border-bottom: none;
    }

    .actions-cell {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
    }
    
    .inline-form {
        display: inline-block;
        margin: 0;
    }

    .btn-success-small,
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
        white-space: nowrap;
    }

    .btn-success-small {
        border: 1px solid #10b981; 
        background: #10b981; 
        color: #fff;
    }
    .btn-success-small:hover {
        background: #059669;
        border-color: #059669;
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
    
    .alert {
        padding: 0.75rem 1rem;
        margin-bottom: 1rem;
        border-radius: 4px;
        font-size: 0.9rem;
        border: 1px solid transparent;
    }

    .alert-success {
        background-color: #d1e7dd;
        color: #0f5132;
        border-color: #badbcc;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #842029;
        border-color: #f5c2c7;
    }
    
    @media (max-width: 640px) {
        .table-header, .table-cell {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        .actions-cell {
            flex-direction: column;
            gap: 0.25rem;
            align-items: flex-start;
        }
    }
</style>
@endsection