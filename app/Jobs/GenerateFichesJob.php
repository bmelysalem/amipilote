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
use setasign\Fpdi\Fpdi;

class GenerateFichesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // Temps limite pour l'exécution du job (10 minutes)
    public $timeout = 600;
    public $tries = 50;
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
        ini_set('memory_limit', '2048M');

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

            // Get a query builder instance for `abonnes`
            $abonnesQuery = ProgrammesDet::where('idprogrammes', $this->programmeId)->with('abonne');

            if (!$abonnesQuery->exists()) {
                Log::warning("No abonnés found for programme {$this->programmeId}. Canceling generation.");
                $programme->generation_in_progress = false;
                $programme->save();
                return;
            }

            $tempPdfs = []; // Store temporary PDF paths
            $chunkCounter = 1;

            // Process abonnes in chunks and generate individual PDFs
            $abonnesQuery->chunk(50, function ($chunk) use (&$tempPdfs, &$chunkCounter) {
                $tempPath = storage_path("fiches/temp_chunk_{$this->programmeId}_{$chunkCounter}.pdf");
                
                // Generate PDF for this chunk
                $pdf = PDF::loadView('fichier-pose.pose_multiple', ['abonnes' => $chunk]);
                $pdf->save($tempPath);
                
                $tempPdfs[] = $tempPath;
                $chunkCounter++;
            });

            // Merge PDFs using FPDI
            $pdf = new Fpdi();
            
            foreach ($tempPdfs as $tempPdf) {
                $pageCount = $pdf->setSourceFile($tempPdf);
                for ($i = 1; $i <= $pageCount; $i++) {
                    $template = $pdf->importPage($i);
                    $size = $pdf->getTemplateSize($template);
                    $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                    $pdf->useTemplate($template);
                }
            }

            // Save the merged PDF
            $pdf->Output('F', storage_path("fiches/fiches_poses_{$this->programmeId}.pdf"));

            // Clean up temporary files
            foreach ($tempPdfs as $tempPdf) {
                if (file_exists($tempPdf)) {
                    unlink($tempPdf);
                }
            }

            // Mark the programme as completed
            $programme->fiches_generees = true;
            $programme->generation_in_progress = false;
            $programme->save();

            Log::info("Fiches for programme {$this->programmeId} generated and merged successfully.");
        } catch (\Exception $e) {
            Log::error("Error during fiche generation for programme {$this->programmeId}: " . $e->getMessage());
            
            // Clean up any temporary files in case of error
            if (isset($tempPdfs)) {
                foreach ($tempPdfs as $tempPdf) {
                    if (file_exists($tempPdf)) {
                        unlink($tempPdf);
                    }
                }
            }

            // Reset the generation state
            if (isset($programme)) {
                $programme->generation_in_progress = false;
                $programme->save();
            }
        }
    }
}
