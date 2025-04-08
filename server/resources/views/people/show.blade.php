@extends('layouts.base')

@section('content')
<div class="container">
    <h1>{{ $person->first_name }} {{ $person->last_name }}</h1>

    <p><strong>Nom de naissance :</strong> {{ $person->birth_name ?? '—' }}</p>
    <p><strong>Autres prénoms :</strong> {{ $person->middle_names ?? '—' }}</p>
    <p><strong>Date de naissance :</strong> {{ $person->date_of_birth ?? '—' }}</p>
    <p><strong>Créé par :</strong> {{ $person->creator->name ?? 'Inconnu' }}</p>

    <hr>

    <h4>Parents :</h4>
    <ul>
        @forelse($person->parents as $parent)
            <li>{{ $parent->first_name }} {{ $parent->last_name }}</li>
        @empty
            <li>Aucun parent renseigné.</li>
        @endforelse
    </ul>

    <h4>Enfants :</h4>
    <ul>
        @forelse($person->children as $child)
            <li>{{ $child->first_name }} {{ $child->last_name }}</li>
        @empty
            <li>Aucun enfant renseigné.</li>
        @endforelse
    </ul>

    <a href="{{ route('people.index') }}" class="btn btn-secondary mt-3">← Retour à la liste</a>
</div>
@endsection
