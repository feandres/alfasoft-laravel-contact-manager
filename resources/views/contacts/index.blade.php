@extends('layout.layout')

@section('title', 'Contacts')

@section('content')

<div class="container">
    <h1>Contacts</h1>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($contacts as $contact)
                <tr>
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->contact ?? '-' }}</td>
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
</style>
@endsection