@extends('layout.layout')

@section('title', 'Contacts Manager')

@section('content')

<div class="container">
    <h1>Contacts</h1>
    <div style="display:flex; gap:0.5rem; align-items:center; margin-bottom:1rem;">
        <a href="{{ route('contacts.create') }}" class="btn-create">Create</a>

        <form method="GET" action="{{ route('contacts.index') }}" id="search-form">
            <input type="text" name="search" id="search-input"
                value="{{ request('search') }}"
                placeholder="Search..."
                class="search-input">
        </form>

    </div>

    <div class="table-wrapper">
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
                    <td class="actions">
                        <a href="{{ route('contacts.show', $contact) }}" class="btn-show">Show</a>
                        <a href="{{ route('contacts.edit', $contact) }}" class="btn-show">Edit</a>
                        <form action="{{ route('contacts.destroy', $contact) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-show">Destroy</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">No contacts found.</td>
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

    .btn-show {
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
</style>
@endsection