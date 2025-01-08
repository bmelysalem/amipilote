<?php

namespace App\Jobs;

use App\Models\Programmes;
use App\Models\ProgrammesDet;
use PDF;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GenerateFichesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // Temps limite pour l'exécution du job (10 minutes)
    public $timeout = 600;

    protected $programmeId;

    /**
     * Crée une nouvelle instance de job.
     *
     * @param  int  $programmeId
     */
    public function __construct($programmeId)
    {
        $this->programmeId = $programmeId;
    }

    /**
     * Exécute le job.
     */
    public function oldhandle()
    {
        ini_set('memory_limit', '1024M');

        try {
            Log::info("HANDLING GenerateFichesJob FOR programmeId: {$this->programmeId}");
            // Récupérer le programme
            $programme = Programmes::findOrFail($this->programmeId);

            // Chemin du fichier PDF généré
            $pdfPath = storage_path("fiches/fiches_poses_{$this->programmeId}.pdf");

            // Supprimer le fichier existant si présent
            if (file_exists($pdfPath)) {
                unlink($pdfPath);
                Log::info("Fichier existant supprimé : {$pdfPath}");
            }

            // Récupérer les abonnés liés à ce programme
            $abonnes = ProgrammesDet::where('idprogrammes', $this->programmeId)->with('abonne')->get();

            // Vérification : s'assurer qu'il y a des abonnés
            if ($abonnes->isEmpty()) {
                Log::warning("Aucun abonné trouvé pour le programme {$this->programmeId}. Annulation de la génération.");
                $programme->generation_in_progress = false;
                $programme->save();
                return;
            }

            // Générer un seul PDF pour toutes les fiches
            $pdf = PDF::loadView('fichier-pose.pose_multiple', compact('abonnes'));

            // Sauvegarder le PDF consolidé
            $pdf->save($pdfPath);

            // Marquer le programme comme ayant ses fiches générées
            $programme->fiches_generees = true;
            $programme->generation_in_progress = false;
            $programme->save();

            Log::info("Fiches pour le programme {$this->programmeId} générées avec succès. Fichier : {$pdfPath}");
        } catch (\Exception $e) {
            Log::error("Erreur lors de la génération des fiches pour le programme {$this->programmeId}: " . $e->getMessage());

            // Réinitialiser l'état de la génération en cas d'erreur
            if (isset($programme)) {
                $programme->generation_in_progress = false;
                $programme->save();
            }
        }
    }
    public function handle()
    {
        ini_set('memory_limit', '1024M'); // Set memory limit to avoid memory exhaustion.

        try {
            Log::info("HANDLING GenerateFichesJob FOR programmeId: {$this->programmeId}");

            // Retrieve the programme
            $programme = Programmes::findOrFail($this->programmeId);

            // Path for the generated PDF
            $pdfPath = storage_path("fiches/fiches_poses_{$this->programmeId}.pdf");

            // Delete existing file if it exists
            if (file_exists($pdfPath)) {
                unlink($pdfPath);
                Log::info("Existing file deleted: {$pdfPath}");
            }

            // Get a query builder instance for `abonnes` to enable chunking
            $abonnesQuery = ProgrammesDet::where('idprogrammes', $this->programmeId)->with('abonne');

            // Check if there are any `abonnes`
            if (!$abonnesQuery->exists()) {
                Log::warning("No abonnés found for programme {$this->programmeId}. Canceling generation.");
                $programme->generation_in_progress = false;
                $programme->save();
                return;
            }

            // Generate the PDF in chunks
            $pdf = PDF::loadHTML(''); // Initialize an empty PDF object
            $htmlContent = []; // Store the combined HTML content for the PDF

            // Process abonnes in chunks
            $abonnesQuery->chunk(100, function ($chunk) use (&$htmlContent) {
                // Render view for each chunk and append it to the HTML content
                $htmlContent[] = view('fichier-pose.pose_multiple', ['abonnes' => $chunk])->render();
            });

            // Combine all HTML content into a single string
            $finalHtml = implode('', $htmlContent);

            // Load the combined HTML into the PDF
            $pdf = PDF::loadHTML($finalHtml);

            // Save the consolidated PDF
            $pdf->save($pdfPath);

            // Mark the programme as having its fiches generated
            $programme->fiches_generees = true;
            $programme->generation_in_progress = false;
            $programme->save();

            Log::info("Fiches for programme {$this->programmeId} generated successfully. File: {$pdfPath}");
        } catch (\Exception $e) {
            Log::error("Error during fiche generation for programme {$this->programmeId}: " . $e->getMessage());

            // Reset the generation state in case of an error
            if (isset($programme)) {
                $programme->generation_in_progress = false;
                $programme->save();
            }
        }
    }
}
