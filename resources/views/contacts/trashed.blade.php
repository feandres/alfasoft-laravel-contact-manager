@extends('layouts.app')

@section('title', 'Contacts Manager - Deleted List')

@section('content')
<div class="container">
    <h1>Soft Deleted Contacts</h1>

    <form method="GET" action="{{ route('contacts.trashed') }}" id="search-form">
        <input type="text" name="search" id="search-input"
            value="{{ request('search') }}"
            placeholder="Search..."
            class="search-input">
    </form>

    <div class="table-wrapper">

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($errors->has('restore'))
        <div class="alert alert-danger">{{ $errors->first('restore') }}</div>
        @endif


        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($contacts as $contact)
                <tr>
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->contact ?? '-' }}</td>
                    <td>
                        <form action="{{ route('contacts.restore', $contact->id) }}" method="POST" onsubmit="return confirm('Restore this contact?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn-restore">Restore</button>
                        </form>
                        <form action="{{ route('contacts.wipe', $contact) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this contact?')" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-wipe">Wipe</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">No deleted contacts found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container">
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
        }, 300); // debounce 300ms
    });
</script>


<style>
    .container {
        max-width: 960px;
        margin: 0 auto;
        padding: 1rem;
    }

    .search-input {
        padding: 0.4rem 0.6rem;
        font-size: 0.85rem;
        border: 1px solid #ccc;
        border-radius: 3px;
        width: 200px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }

    thead th {
        text-align: left;
        padding: 0.5rem;
        font-size: 0.85rem;
        border-bottom: 1px solid #ccc;
    }

    tbody td {
        padding: 0.5rem;
        border-bottom: 1px solid #eee;
        font-size: 0.9rem;
    }

    tbody tr:last-child td {
        border-bottom: none;
    }

    h1 {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .btn-create {
        padding: 0.4rem 0.7rem;
        border: 1px solid #333;
        border-radius: 3px;
        font-size: 0.85rem;
        text-decoration: none;
        color: #000;
        background: #fff;
    }

    .btn-create:hover {
        background: #f2f2f2;
    }

    .pagination {
        display: flex;
        justify-content: center;
        list-style: none;
        padding: 0;
        margin-top: 1rem;
    }

    .pagination li {
        margin: 0 0.25rem;
    }

    .pagination a,
    .pagination span {
        display: block;
        padding: 0.4rem 0.6rem;
        text-decoration: none;
        border: 1px solid #ccc;
        border-radius: 3px;
        font-size: 0.85rem;
    }

    td.actions {
        display: flex;
        gap: 0.4rem;
        align-items: center;
    }

    td.actions form {
        margin: 0;
    }

    .btn-show,
    .btn-restore {
        display: inline-block;
        padding: 0.3rem 0.5rem;
        font-size: 0.8rem;
        border: 1px solid #333;
        border-radius: 3px;
        text-decoration: none;
        color: #000;
        background: #fff;
        cursor: pointer;
    }

    .btn-show:hover {
        background: #f2f2f2;
    }

    .btn-show button {
        all: unset;
        cursor: pointer;
        display: inline-block;
        width: 100%;
        text-align: center;
    }

    .btn-restore {
        border-color: #28a745;
        color: #155724;
        background: #d4edda;
    }

    .btn-restore:hover {
        background: #c3e6cb;
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

    .alert {
        padding: 0.5rem 0.75rem;
        margin-bottom: 1rem;
        border-radius: 3px;
        font-size: 0.9rem;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #28a745;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #c0392b;
    }
</style>
@endsection