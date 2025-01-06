<?php

namespace App\Http\Controllers;

use App\Models\ProgrammesDet;
use App\Models\Programmes;
use App\Models\Abonnes;
use App\Jobs\GenerateFichesJob;
use Illuminate\Support\Facades\Log; // Importation de Log
use PDF;
// Import de la façade DOMPDF
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// Si vous utilisez Laravel-Excel, ajoutez aussi :
use Maatwebsite\Excel\Facades\Excel;

class ProgrammesDetController extends Controller
{
    public function generatePdf($programmeId, $abonneId)
    {
        // Récupérer les informations du programme et de l'abonné
        $fiche = ProgrammesDet::where('idprogrammes', $programmeId)
            ->where('REFERENCE', $abonneId)
            ->firstOrFail();

        $abonne = Abonnes::where('REFERENCE', $fiche->REFERENCE)->firstOrFail();

        // Générer le PDF à partir d'une vue
        //return view( 'fichier-pose.pdf', compact( 'fiche', 'abonne' ) );
        // Générer le PDF à partir d'une vue
        $pdf = PDF::loadView('fichier-pose.pdf', compact('fiche', 'abonne'));

        // Télécharger le fichier PDF
        return $pdf->download('fichier_pose_abonne_' . $abonne->REFERENCE . '.pdf');
    }
    public function generateFiches($programmeId)
    {
        try {
            // Vérifier si le programme existe
            $programme = Programmes::findOrFail($programmeId);
            // Vérifier si la génération est déjà en cours
            if ($programme->generation_in_progress) {
                Log::info("La génération des fiches pour le programme {$programmeId} est déjà en cours.");
                return;
            }
            // Marquer le début de la génération
            $programme->generation_in_progress = true;
            $programme->save();

            // Dispatch le job pour générer les fiches
            GenerateFichesJob::dispatch($programmeId);

            // Ajouter un log pour le suivi
            Log::info("Génération des fiches lancée pour le programme ID: {$programmeId}");

            // Retourner une réponse pour indiquer que le processus a démarré
            return redirect()->route('programmes.show', $programmeId)
                ->with('success', 'La génération des fiches a été lancée. Vous recevrez une notification une fois terminé.');
        } catch (\Exception $e) {
            // Ajouter un log en cas d'erreur
            Log::error("Erreur lors de la génération des fiches pour le programme ID: {$programmeId} - " . $e->getMessage());

            // Retourner une réponse d'erreur
            return redirect()->route('programmes.show', $programmeId)
                ->with('error', 'Une erreur est survenue lors du lancement de la génération des fiches. Veuillez réessayer.');
        }
    }

    public function generateFichesOld($programmeId)
    {
        // Récupérer le programme
        $programme = Programmes::findOrFail($programmeId);

        // Vérifier si les fiches ont déjà été générées
        // if ($programme->fiches_generees) {
        //     return redirect()->back()->with('error', 'Les fiches pour ce programme ont déjà été générées.');
        // }


        // Récupérer les abonnés liés à ce programme
        $abonnes = ProgrammesDet::where('idprogrammes', $programmeId)->with('abonne')->get();

        // Générer un seul PDF pour toutes les fiches
        $pdf = PDF::loadView('fichier-pose.pose_multiple', compact('abonnes'));

        // Sauvegarder le PDF consolidé
        $pdf->save(storage_path("fiches/fiches_pose_{$programmeId}.pdf"));

        // Marquer le programme comme ayant ses fiches générées
        $programme->fiches_generees = true;
        $programme->save();

        return redirect()->route('programmes.show', $programmeId)->with('success', 'Toutes les fiches ont été générées dans un seul fichier PDF.');
    }
    public function generateFichesByList(Request $request)
    {

        // Vérifier que la liste d'ID n'est pas vide
        $abonneIds = $request->input('abonne_ids');
        if (empty($abonneIds) || !is_array($abonneIds)) {
            return redirect()->back()->with('error', 'Veuillez sélectionner au moins un abonné pour générer les fiches.');
        }

        // Récupérer les abonnés dont les ids sont dans la liste fournie
        $abonnes = ProgrammesDet::whereIn('idprogemesdet', $abonneIds)->with('abonne')->get();

        // Vérifier que des abonnés ont été trouvés
        if ($abonnes->isEmpty()) {
            return redirect()->back()->with('error', 'Aucun abonné trouvé pour les ID sélectionnés.');
        }

        // Générer un seul PDF pour toutes les fiches sélectionnées
        $pdf = PDF::loadView('fichier-pose.pose_multiple', compact('abonnes'));

        // Télécharger le fichier PDF
        return $pdf->download('fichier_pose_abonne_list.pdf');
    }

    public function downloadFiches($programmeId)
    {
        //return $programmeId;
        // Récupérer le programme
        $programme = Programmes::findOrFail($programmeId);

        // Vérifier si les fiches ont été générées
        if (!$programme->fiches_generees) {
            return redirect()->back()->with('error', 'Les fiches n\'ont pas encore été générées.');
        }

        // Chemin du fichier PDF consolidé
        $filePath = storage_path("fiches/fiches_poses_{$programmeId}.pdf");

        Log::info($filePath);

        // Vérifier si le fichier existe
        if (file_exists($filePath)) {
            return response()->download($filePath, "fiches_poses_{$programmeId}.pdf", [
                'Cache-Control' => 'no-cache, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ]);
            //return response()->download($filePath);
        } else {
            return redirect()->back()->with('error', 'Le fichier PDF des fiches n\'existe pas.');
        }
    }

    public function downloadTable($programmeId)
    {
        // Récupérer le programme et ses abonnés avec leurs détails
        $programme = Programmes::findOrFail($programmeId);
        $abonnes = ProgrammesDet::where('idprogrammes', $programmeId)
            ->with('abonne')
            ->get();

        // Créer un nouveau spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Définir les en-têtes
        $sheet->setCellValue('A1', 'N° FICHE');
        $sheet->setCellValue('B1', 'REFERENCE');
        $sheet->setCellValue('C1', 'ADRESSE');
        $sheet->setCellValue('D1', 'COMPTEUR');

        // Style pour l'en-tête
        $sheet->getStyle('A1:D1')->getFont()->setBold(true);
        
        // Remplir les données
        $row = 2;
        foreach ($abonnes as $abonne) {
            $sheet->setCellValue('A' . $row, $abonne->idprogemesdet);
            
            // Forcer le format texte pour la référence
            $sheet->setCellValueExplicit(
                'B' . $row, 
                $abonne->REFERENCE,
                \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING
            );
            
            $sheet->setCellValue('C' . $row, $abonne->abonne->ADRESSE ?? 'N/A');
            $sheet->setCellValue('D' . $row, $abonne->compteur_ancien ?? 'N/A');
            $row++;
        }

        // Définir toute la colonne B (REFERENCE) en format texte
        $sheet->getStyle('B:B')->getNumberFormat()
              ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);

        // Ajuster automatiquement la largeur des colonnes
        foreach (range('A', 'D') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Créer le fichier Excel
        $writer = new Xlsx($spreadsheet);
        
        // Définir les headers pour le téléchargement
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="liste_abonnes_programme_' . $programmeId . '.xlsx"');
        header('Cache-Control: max-age=0');

        // Envoyer le fichier au navigateur
        $writer->save('php://output');
        exit;
    }


    public function generateFiches_old($programmeId)
    {
        $programme = Programmes::findOrFail($programmeId);

        // Vérifier si les fiches ont déjà été générées
        if ($programme->fiches_generees) {
            return redirect()->back()->with('error', 'Les fiches pour ce programme ont déjà été générées.');
        }

        // Générer des fiches pour tous les abonnés liés à ce programme
        $abonnes = ProgrammesDet::where('idprogrammes', $programmeId)->get();

        foreach ($abonnes as $fiche) {
            $pdf = PDF::loadView('fichier-pose.pdf', ['fiche' => $fiche, 'abonne' => $fiche->abonne]);
            $pdf->save(storage_path("fiches/fiche_pose_{$programmeId}_{$fiche->REFERENCE}.pdf"));
        }

        // Marquer le programme comme ayant ses fiches générées
        $programme->fiches_generees = true;
        $programme->save();

        return redirect()->route('programmes.show', $programmeId)->with('success', 'Fiches générées avec succès.');
    }
}
