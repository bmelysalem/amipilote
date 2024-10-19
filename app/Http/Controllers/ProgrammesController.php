<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Programmes;

class ProgrammesController extends Controller
{
    // Affiche la liste des programmes avec le nombre de détails associés
    public function index()
    {
        // Charger les programmes avec le nombre de détails associés
        $programmes = Programmes::withCount('details')->get();
        return view('programmes.index', compact('programmes'));
    }
    // Affiche le formulaire de création d'un programme
    public function create()
    {
        return view('programmes.create');
    }

    // Enregistre un nouveau programme
    public function store(Request $request)
    {
        $request->validate([
            'Code_agence' => 'required|max:2',
            'date_saisie' => 'required|date',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
            'programme_cloture' => 'required|max:1',
            'Code_agent' => 'required|max:10',
            'les_secteurs' => 'nullable|max:50'
        ]);

        Programmes::create($request->all());

        return redirect()->route('programmes.index')->with('success', 'Programme créé avec succès.');
    }

    // Affiche le formulaire de modification d'un programme existant
    public function edit($id)
    {
        $programme = Programmes::findOrFail($id);
        return view('programmes.edit', compact('programme'));
    }

    // Met à jour un programme existant
    public function update(Request $request, $id)
    {
        $request->validate([
            'Code_agence' => 'required|max:2',
            'date_saisie' => 'required|date',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
            'programme_cloture' => 'required|max:1',
            'Code_agent' => 'required|max:10',
            'les_secteurs' => 'nullable|max:50'
        ]);

        $programme = Programmes::findOrFail($id);
        $programme->update($request->all());

        return redirect()->route('programmes.index')->with('success', 'Programme mis à jour avec succès.');
    }

    // Afficher les détails d'un programme
    public function show($id)
    {
        // Trouver le programme par idprogrammes ou échouer
        $programme = Programmes::with('details')->findOrFail($id);

        // Retourner la vue avec les détails du programme
        return view('programmes.show', compact('programme'));
    }

    // Supprime un programme
    public function destroy($id)
    {
        $programme = Programmes::findOrFail($id);
        $programme->delete();

        return redirect()->route('programmes.index')->with('success', 'Programme supprimé avec succès.');
    }
}
