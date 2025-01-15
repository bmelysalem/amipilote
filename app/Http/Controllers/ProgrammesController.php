<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Programmes;
use App\Models\Abonnes;
use App\Models\ProgrammesDet;
use App\Models\ChangementsLocal;
use App\Models\Nouvabnt;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log; // Importation de Log

class ProgrammesController extends Controller
{
    // Affiche la liste des programmes avec le nombre de détails associés
    public function index()
    {
        // Charger les programmes avec le nombre de détails associés
        $programmes = Programmes::withCount('details')->orderBy('idprogrammes', 'desc')->get();
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

            $programme = Programmes::create($validatedData);

            return $request->expectsJson()
                ? response()->json(['message' => 'Programme créé avec succès.'], 201)
                : redirect()->route('programmes.edit', [$programme->idprogrammes])->with('success', 'Programme créé avec succès.');
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
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
    public function storeChangementsLocalold(Request $request, $programmeId)
    {
        // Récupérer tous les détails du programme (ProgrammesDet) associés à ce programme
        $programmesDet = ProgrammesDet::where('idprogrammes', $programmeId)->with('abonne')->get();

        foreach ($programmesDet as $detail) {

            // Vérifier si IdFiche est déjà présent dans ChangementsLocal
            $existingChangement = ChangementsLocal::where('IdFiche', $detail->idprogemesdet)->first();

            // Si IdFiche existe déjà, continuer sans insérer
            if ($existingChangement) {
                continue; // Passer à l'itération suivante
            }

            // Récupérer les informations de l'abonné lié à ce détail
            $abonne = $detail->abonne;

            // Créer une nouvelle instance de ChangementsLocal
            $changements = new ChangementsLocal();

            // Remplir les colonnes non commençant par 'ak_' avec les données de ProgrammesDet et Abonnes
            $changements->idprogrammes = $detail->idprogrammes;
            $changements->IdFiche = $detail->idprogemesdet;
            $changements->Date_saisie = now(); // ou tu peux utiliser $detail->date_saisie si applicable
            //$changements->Date_pose = $detail->date_saisie; // ou autre champ si nécessaire
            $changements->REFERENCE = $abonne->REFERENCE;
            $changements->telephones = $abonne->TELEPHONE_01; // ou autre champ de téléphones
            $changements->adresse_crm = $abonne->ADRESSE;
            $changements->tarif_crm = $abonne->TARIF;
            $changements->compteur_crm = $abonne->COMPTEUR;
            $changements->compteur_crm_type = $abonne->TYPE_COMPTEUR;
            $changements->compteur_crm_index = $abonne->INDEXE;
            $changements->compteur_crm_ps = $abonne->PS;
            $changements->mode_paiement = 'PRE'; // Remplir avec une valeur appropriée
            $changements->branch_crm = substr($abonne->CODE_BRANCHEMENT, 0, 1); //$abonne->CODE_BRANCHEMENT;

            // Enregistre les changements dans la base de données
            $changements->save();
        }

        return redirect()->back()->with('success', 'Les changements ont été enregistrés avec succès.');
    }
    public function storeChangementsLocal(Request $request, $programmeId)
    {
        // Récupérer tous les détails du programme (ProgrammesDet) associés à ce programme
        $programmesDet = ProgrammesDet::where('idprogrammes', $programmeId)->with('abonne')->get();

        foreach ($programmesDet as $detail) {
            $abonne = $detail->abonne;

            // Vérifier l'état de l'abonné
            if (in_array($abonne->ETAT_ABONNE, [1, 4])) {
                // Remplir ChangementsLocal si l'état est 1 ou 4
                $existingChangement = ChangementsLocal::where('IdFiche', $detail->idprogemesdet)->first();
                if (!$existingChangement) {
                    $changements = new ChangementsLocal();
                    $changements->idprogrammes = $detail->idprogrammes;
                    $changements->IdFiche = $detail->idprogemesdet;
                    $changements->Date_saisie = now();
                    $changements->Date_pose = $detail->date_saisie;
                    $changements->REFERENCE = $abonne->REFERENCE;
                    $changements->telephones = $abonne->TELEPHONE_01;
                    $changements->adresse_crm = $abonne->ADRESSE;
                    $changements->tarif_crm = $abonne->TARIF;
                    $changements->compteur_crm = $abonne->COMPTEUR;
                    $changements->compteur_crm_type = $abonne->TYPE_COMPTEUR;
                    $changements->compteur_crm_index = $abonne->INDEXE;
                    $changements->compteur_crm_ps = $abonne->PS;
                    $changements->mode_paiement = (!isset($abonne->groupe) || (trim($abonne->groupe) == '')) ?  'PRE' : 'POS';; // Remplir avec une valeur appropriée
                    $changements->branch_crm = substr($abonne->CODE_BRANCHEMENT, 0, 1); // Première lettre du branchement
                    $changements->save();
                }

            } elseif (in_array($abonne->ETAT_ABONNE, [9, 3])) {

                $reference = $abonne->REFERENCE;
                // Si l'état est 3, utiliser `successeur` comme référence
                if ($abonne->ETAT_ABONNE == 3) {
                    $reference = $abonne->successeur;
                }

                // Remplir Nouvabnt si l'état est 9 ou 3
                $existingNouvabnt = Nouvabnt::where('REFERENCE', $reference)->first();
                if (!$existingNouvabnt) {
                    $nouvabnt = new Nouvabnt();
                    $nouvabnt->DATE = now(); // ou une autre valeur
                    $nouvabnt->REFERENCE = $reference;
                    $nouvabnt->Adresse = $abonne->ADRESSE;
                    $nouvabnt->TYPE_BRANCHEMENT = substr($abonne->CODE_BRANCHEMENT, 0, 1) == '4' ? 'T' : 'M';
                    if ($abonne->ETAT_ABONNE == '9') {
                        $nouvabnt->type_mutation = '10E'; // Remplir selon les besoins
                        $nouvabnt->Compteur = '999999';
                        $nouvabnt->PS = '06';
                    } else {

                        $nouvabnt->type_mutation = '20E';
                        $nouvabnt->Compteur = '999999';
                        $nouvabnt->PS = $abonne->PS;
                    }
                    $nouvabnt->type_pre_post = (!isset($abonne->groupe) || (trim($abonne->groupe) == '')) ?  'PRE' : 'POS'; // Remplir selon les besoins

                    //$nouvabnt->DATEPOSE = $detail->date_saisie;
                    //$nouvabnt->OBSERVATIONS = '...'; // Remplir selon les besoins
                    $nouvabnt->TARIF = (!isset($abonne->TARIF) || (trim($abonne->TARIF) == '')) ?  '5106' : trim($abonne->TARIF);

                    $nouvabnt->TELEPHONE_01 = '40000000';
                    //$nouvabnt->statut = '...'; // Remplir selon les besoins
                    $nouvabnt->gps_lat = $abonne->LATITUDE;
                    $nouvabnt->gps_long = $abonne->LONGITUDE;
                    //$nouvabnt->cree_ds_crm = '...'; // Remplir selon les besoins
                    $nouvabnt->save();
                }
                //elseif($existingNouvabnt->statut != 'traite'){
                else {
                    if ($abonne->ETAT_ABONNE == '9') {
                        $existingNouvabnt->TYPE_BRANCHEMENT = substr($abonne->CODE_BRANCHEMENT, 0, 1) == '4' ? 'T' : 'M';
                        $existingNouvabnt->type_mutation = '10E'; // Remplir selon les besoins
                        $existingNouvabnt->Compteur = '999999';
                        $existingNouvabnt->save();
                    }
                    // else{
                    //     $existingNouvabnt->type_mutation = '20E';
                    //     $existingNouvabnt->Compteur = '999999';
                    // }
                    // $existingNouvabnt->TARIF = (!isset($abonne->TARIF)||(trim($abonne->TARIF)=='')) ?  '5106' : trim($abonne->TARIF)  ;
                    //$existingNouvabnt->save();
                }
            }
        }

        return redirect()->back()->with('success', 'Les changements ont été enregistrés avec succès.');
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
                // Verification si l'abbonné est resilié a un solde
                // Retourner les erreurs de validation si elles existent
                if ($abonne->ETAT_ABONNE == 3 && $abonne->solde > 0)
                    return response()->json([
                        'success' => false,
                        'message' => 'Abonnée est resilié avec solde :' . $abonne->solde,
                        'errors' => 'Abonnée est resilié avec solde',
                    ], 422);
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
    public function deleteProgrammeDet($programmeId, $programmedetId)
    {
        // Trouver l'élément ProgrammesDet à supprimer
        $programmeDet = ProgrammesDet::where('idprogrammes', $programmeId)->where('idprogemesdet', $programmedetId)->firstOrFail();

        // Supprimer l'élément ProgrammesDet
        $programmeDet->delete();

        return redirect()->back()->with('success', 'Le détail du programme a été supprimé avec succès.');
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
    public function show(Request $request, $id)
    {
        // Trouver le programme par idprogrammes ou échouer
        $programme = Programmes::findOrFail($id);
        
        // Récupérer les détails avec filtres
        $details = $programme->details()->with('abonne');
        
        // Filtre par référence
        if ($request->has('reference')) {
            $reference = $request->get('reference');
            $details = $details->where('REFERENCE', 'LIKE', "{$reference}%");
        }

        // Filtre par type de compteur
        if ($request->has('type') && $request->type !== '') {
            $type = $request->get('type');
            $details = $details->whereHas('abonne', function($query) use ($type) {
                $query->where('CODE_BRANCHEMENT', 'LIKE',"{$type}%");
            });
        }

        // // Filtre par état
        if ($request->has('etat') && $request->etat !== '') {
            $etat = $request->get('etat');
            $details = $details->whereHas('abonne', function($query) use ($etat) {
                $query->where('ETAT_ABONNE','LIKE', "{$etat}%");
            });
        }

        $details = $details->get();

        // Retourner la vue avec tous les paramètres
        return view('programmes.show', [
            'programme' => $programme,
            'details' => $details,
            'reference' => $request->get('reference'),
            'type' => $request->get('type'),
            'etat' => $request->get('etat')
        ]);
    }

    // Supprime un programme
    public function destroy($id)
    {
        $programme = Programmes::findOrFail($id);
        $programme->delete();

        return redirect()->route('programmes.index')->with('success', 'Programme supprimé avec succès.');
    }
}
