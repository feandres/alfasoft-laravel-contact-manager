@extends('layout.layout')

@section('title', 'Contacts Manager')

@section('content')

<div class="container">
    <h1>Contacts</h1>
    <a href="{{ route('contacts.create') }}" class="btn-create">Create</a>

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
                    <td>
                        <a href="{{ route('contacts.show', $contact) }}" class="btn-show">Show</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center">No contacts found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container">
        {{ $contacts->links() }}
    </div>
</div>

<style>
    .container {
        max-width: 960px;
        margin: 0 auto;
        padding: 1rem;
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

    .btn-show {
        display: inline-block;
        padding: 0.3rem 0.5rem;
        font-size: 0.8rem;
        border: 1px solid #333;
        border-radius: 3px;
        text-decoration: none;
        color: #000;
    }

    .btn-show:hover {
        background: #f2f2f2;
    }
</style>
@endsection