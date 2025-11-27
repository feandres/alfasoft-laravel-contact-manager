@extends('layouts.app')

@section('title', 'Contacts Manager')

@section('content')

<div class="minimal-container">
    <h1 class="title">Contacts</h1>

    <div class="header-actions">
        <a href="{{ route('contacts.create') }}" class="btn-primary">Create New Contact</a>

        <form method="GET" action="{{ route('contacts.index') }}" id="search-form" class="search-form">
            <input type="text" name="search" id="search-input"
                value="{{ request('search') }}"
                placeholder="Search by Name or Email..."
                class="search-input">
        </form>
    </div>

    <div class="card table-card">
        <table>
            <thead>
                <tr>
                    <th class="table-header w-1/3">Name</th>
                    <th class="table-header w-1/3 hidden sm:table-cell">Email</th>
                    <th class="table-header w-1/6 hidden sm:table-cell">Contact</th>
                    @auth
                        <th class="table-header w-1/6 text-center">Actions</th>
                    @endauth    
                </tr>
            </thead>
            <tbody>
                @forelse ($contacts as $contact)
                <tr class="table-row">
                    <td class="table-cell font-medium">{{ $contact->name }}</td>
                    <td class="table-cell hidden sm:table-cell text-sm text-gray-600">{{ $contact->email }}</td>
                    <td class="table-cell hidden sm:table-cell text-sm text-gray-600">{{ $contact->contact ?? '-' }}</td>
                    @auth
                        <td class="table-cell actions-cell">
                            <a href="{{ route('contacts.show', [
                                'contact' => $contact->id,
                                'page' => request('page'),
                                'search' => request('search'),
                            ]) }}" class="btn-show-table">View Details</a>
                        </td>
                    @endauth
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-gray-500">No contacts found matching your criteria.</td>
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

    .header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap; 
    }

    .search-form {
        flex-grow: 1; 
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
        border: 1px solid #10b981; 
        background: #10b981; 
        color: #fff;
        white-space: nowrap;
    }

    .btn-primary:hover {
        background: #059669; 
        border-color: #059669;
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

    .btn-show-table {
        display: inline-block;
        padding: 0.4rem 0.75rem;
        font-size: 0.8rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        text-decoration: none;
        color: #555;
        background: #fff;
        transition: background 0.2s ease;
        white-space: nowrap;
    }

    .btn-show-table:hover {
        background: #f2f2f2;
    }
    
    .pagination-container nav {
        display: flex;
        justify-content: center;
        margin-top: 1.5rem;
    }
    
    @media (max-width: 640px) {
        .table-header {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        .table-cell {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }
</style>
@endsection