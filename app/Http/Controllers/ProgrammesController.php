<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Programmes;
use App\Models\Abonnes;
use App\Models\ProgrammesDet;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;

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
    public function storeOld(Request $request)
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
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'Code_agence' => 'required|max:2',
                'date_saisie' => 'required|date',
                'date_debut' => 'nullable|date',
                'date_fin' => 'nullable|date',
                'programme_cloture' => 'required|max:1',
                'Code_agent' => 'required|max:10',
                'les_secteurs' => 'nullable|max:50'
            ]);

            Programmes::create($validatedData);

            return $request->expectsJson()
                ? response()->json(['message' => 'Programme créé avec succès.'], 201)
                : redirect()->route('programmes.index')->with('success', 'Programme créé avec succès.');

        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la création du programme'], 500);
        }
    }

    public function valider($id)
    {
        // Récupérer le programme à valider
        $programme = Programmes::findOrFail($id);

        // Vérifier si le programme est déjà validé
        if ($programme->programme_valide) {
            return redirect()->back()->with('error', 'Ce programme est déjà validé.');
        }

        // Marquer le programme comme validé
        $programme->programme_valide = true;
        $programme->save();

        return redirect()->back()->with('success', 'Le programme a été validé avec succès.');
    }

    public function addProgrammeDet(Request $request, $programmeId)
{
    try {
        // Valider l'entrée du champ 'reference'
        $request->validate([
            'reference' => 'required|string|max:12'
        ]);

        // Vérifier si le programme existe
        $programme = Programmes::findOrFail($programmeId);

        // Récupérer l'abonné en fonction de la référence
        $reference = $request->input('reference');
        $abonne = Abonnes::where('REFERENCE', $reference)->first();

        if ($abonne) {
            // Vérifier si la référence existe déjà dans ProgrammesDet pour ce programme
            $existing = ProgrammesDet::where('idprogrammes', $programme->idprogrammes)
                                     ->where('REFERENCE', $reference)
                                     ->first();

            if ($existing) {
                // Si la référence existe déjà, retour d'un message d'erreur
                return response()->json([
                    'success' => false,
                    'message' => "La référence $reference est déjà présente dans le programme.",
                ], 409); // 409 Conflict pour signaler un doublon
            }

            // Créer un nouvel enregistrement dans ProgrammesDet
            ProgrammesDet::create([
                'idprogrammes' => $programme->idprogrammes,
                'REFERENCE' => $abonne->REFERENCE,
                'compteur_ancien' => $abonne->COMPTEUR,
                // Ajouter d'autres champs si nécessaire
            ]);

            // Retourner une réponse JSON de succès
            return response()->json(['success' => true, 'message' => 'ProgrammeDet ajouté avec succès.'], 201);
        }

        // Retourner une réponse JSON d'erreur si l'abonné n'est pas trouvé
        return response()->json(['success' => false, 'message' => 'Abonné non trouvé.'], 404);

    } catch (ValidationException $e) {
        // Retourner les erreurs de validation si elles existent
        return response()->json([
            'success' => false,
            'message' => 'Erreur de validation',
            'errors' => $e->errors(),
        ], 422);

    } catch (ModelNotFoundException $e) {
        // Gestion d'erreur si le programme n'est pas trouvé
        return response()->json([
            'success' => false,
            'message' => 'Programme non trouvé.',
        ], 404);

    } catch (\Exception $e) {
        // Gestion générale des autres erreurs
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de l\'ajout du ProgrammeDet.',
            'error' => $e->getMessage()
        ], 500);
    }
}


    public function addAllProgrammesDetOld(Request $request, $programmeId)
    {
        $programme = Programmes::findOrFail($programmeId);
        $references = $request->input('references');

        if ($references && is_array($references)) {
            foreach ($references as $reference) {
                $abonne = Abonnes::where('REFERENCE', $reference)->first();
                if ($abonne) {
                    // Créer un nouvel enregistrement dans ProgrammesDet
                    ProgrammesDet::create([
                        'idprogrammes' => $programme->idprogrammes,
                        'REFERENCE' => $abonne->REFERENCE,
                        // Remplir les autres champs selon les besoins
                    ]);
                }
            }
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Aucune référence trouvée.']);
    }

    public function addAllProgrammesDet(Request $request, $programmeId)
{
    try {
        // Valider les données envoyées
        $request->validate([
            'references' => 'required|array',   // S'assurer que 'references' est un tableau
            'references.*' => 'string|max:12',  // Valider chaque référence individuellement
        ]);

        // Récupérer le programme, ou échouer s'il n'existe pas
        $programme = Programmes::findOrFail($programmeId);
        $references = $request->input('references');

        // Initialiser des tableaux pour les références qui échouent ou sont des doublons
        $failedReferences = [];
        $duplicateReferences = [];

        if ($references && is_array($references)) {
            foreach ($references as $reference) {
                // Vérifier si l'abonné existe
                $abonne = Abonnes::where('REFERENCE', $reference)->first();

                if ($abonne) {
                    // Vérifier si la référence existe déjà dans ce programme
                    $existing = ProgrammesDet::where('idprogrammes', $programme->idprogrammes)
                        ->where('REFERENCE', $reference)
                        ->first();

                    if ($existing) {
                        // Si la référence existe déjà dans le programme, on l'ajoute aux doublons
                        $duplicateReferences[] = $reference;
                    } else {
                        // Créer un nouvel enregistrement dans ProgrammesDet
                        ProgrammesDet::create([
                            'idprogrammes' => $programme->idprogrammes,
                            'REFERENCE' => $abonne->REFERENCE,
                            'compteur_ancien' => $abonne->COMPTEUR,
                            // Ajouter d'autres champs si nécessaire
                        ]);
                    }
                } else {
                    // Ajouter les références qui échouent à un tableau de suivi
                    $failedReferences[] = $reference;
                }
            }

            // Vérifier s'il y a des doublons ou des erreurs
            if (!empty($failedReferences) || !empty($duplicateReferences)) {
                $failedCount = count($failedReferences);
    $duplicateCount = count($duplicateReferences);

    // Construire un message plus explicite en fonction des références concernées
    $message = 'Certaines références n\'ont pas été traitées correctement. ';

    if ($failedCount > 0) {
        $message .= "$failedCount référence(s) non trouvée(s). ";
    }

    if ($duplicateCount > 0) {
        $message .= "$duplicateCount référence(s) déjà présente(s) dans le programme.";
    }
                // Si certaines références échouent ou sont des doublons
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'failed_references' => $failedReferences,
                    'duplicate_references' => $duplicateReferences
                ], 206); // 206 Partial Content pour signifier que certaines opérations ont échoué ou doublonné
            }

            // Si toutes les références ont été ajoutées avec succès
            return response()->json(['success' => true, 'message' => 'Tous les ProgrammesDet ont été ajoutés avec succès.'], 201);
        }

        // Si 'references' est vide ou incorrect
        return response()->json(['success' => false, 'message' => 'Aucune référence valide trouvée.'], 400);

    } catch (ValidationException $e) {
        // Gestion des erreurs de validation
        return response()->json([
            'success' => false,
            'message' => 'Erreur de validation des données.',
            'errors' => $e->errors(),
        ], 422);

    } catch (ModelNotFoundException $e) {
        // Gestion de l'erreur lorsque le programme n'est pas trouvé
        return response()->json([
            'success' => false,
            'message' => 'Programme non trouvé.',
        ], 404);

    } catch (\Exception $e) {
        // Gestion des autres exceptions
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de l\'ajout des ProgrammesDet.',
            'error' => $e->getMessage(),
        ], 500);
    }
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
