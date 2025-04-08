@extends('layouts.base')

@section('content')
<div class="container">
    <h1>Créer une nouvelle personne</h1>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('people.store') }}">
        @csrf

        <div class="mb-3">
            <label>Prénom</label>
            <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required>
        </div>

        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" required>
        </div>

        <div class="mb-3">
            <label>Nom de naissance</label>
            <input type="text" name="birth_name" class="form-control" value="{{ old('birth_name') }}">
        </div>

        <div class="mb-3">
            <label>Autres prénoms</label>
            <input type="text" name="middle_names" class="form-control" value="{{ old('middle_names') }}">
        </div>

        <div class="mb-3">
            <label>Date de naissance</label>
            <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth') }}">
        </div>

        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
</div>
@endsection
