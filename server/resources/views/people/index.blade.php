@extends('layouts.base')

@section('content')
<div class="container">
    <h1>Liste des personnes</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('people.create') }}" class="btn btn-success mb-3">Ajouter une personne</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Créé par</th>
                <th>Date de création</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($people as $person)
                <tr>
                    <td>{{ $person->first_name }} {{ $person->last_name }}</td>
                    <td>{{ $person->user->name ?? 'Inconnu' }}</td>
                    <td>{{ $person->created_at->format('Y/m/d') }}</td>
                    <td><a href="{{ route('people.show', $person->id) }}" class="btn btn-sm btn-primary">Voir</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $people->links() }}
</div>
@endsection
