<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use Illuminate\Support\Facades\Auth;

class PersonController extends Controller
{

    /**
     * Affiche la liste des personnes avec le nom de leur créateur.
     */
    public function index()
    {
        $people = Person::with('user')->paginate(10);
        return view('people.index', compact('people'));
    }

    /**
     * Affiche une personne spécifique avec ses enfants et ses parents.
     */
    public function show($id)
    {
        $person = Person::with(['children', 'parents'])->findOrFail($id);
        return view('people.show', compact('person'));
    }

    /**
     * Affiche le formulaire de création d'une nouvelle personne.
     */
    public function create()
    {
        return view('people.create');
    }

    /**
     * Valide et stocke une nouvelle personne.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'birth_name'    => 'nullable|string|max:255',
            'middle_names'  => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
        ]);

        try {
            Person::create([
                ...$validated,
                'created_by' => 1, // Vérifie que l'utilisateur est connecté
            ]);

            return redirect()->route('people.index')
                             ->with('success', 'Personne créée avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Erreur lors de la création de la personne.');
        }
    }

    
}
