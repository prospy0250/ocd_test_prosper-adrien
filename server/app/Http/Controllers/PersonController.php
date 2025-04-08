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
        // Validation des données
    $validated = $request->validate([
        'first_name'    => 'required|string|max:255',
        'last_name'     => 'required|string|max:255',
        'birth_name'    => 'nullable|string|max:255',
        'middle_names'  => 'nullable|string|max:255',
        'date_of_birth' => 'nullable|date|date_format:Y-m-d|before:today',
    ]);

    try {
        // Formatage des données avant insertion

        // `first_name` : Première lettre en majuscule, le reste en minuscule
        $firstName = ucfirst(strtolower($validated['first_name']));

        // `middle_names` : Si des prénoms sont fournis, mettre en majuscule la première lettre de chaque prénom, sinon NULL
        $middleNames = $validated['middle_names'] ? 
                        implode(', ', array_map(fn($name) => ucfirst(strtolower(trim($name))), explode(',', $validated['middle_names']))) 
                        : null;

        // `last_name` : Tout en majuscule
        $lastName = strtoupper($validated['last_name']);

        // `birth_name` : Si non renseigné, copier `last_name`, sinon le formater en majuscule
        $birthName = $validated['birth_name'] ? strtoupper($validated['birth_name']) : $lastName;

        // `date_of_birth` : On s'assure que c'est au format 'YYYY-MM-DD', sinon NULL
        $dateOfBirth = $validated['date_of_birth'] ?: null;

        // On obtient l'ID de l'utilisateur connecté
        $createdBy = Auth::check() ? Auth::id() : null;

        // Création de la personne avec les données formatées
        Person::create([
            'created_by'    => $createdBy,
            'first_name'    => $firstName,
            'last_name'     => $lastName,
            'birth_name'    => $birthName,
            'middle_names'  => $middleNames,
            'date_of_birth' => $dateOfBirth,
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
