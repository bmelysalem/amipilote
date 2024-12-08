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

    // Temps limite pour l'exécution du job (6 minutes)
    public $timeout = 360;

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
    public function handle()
    {
        //ini_set('memory_limit', '512M');

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
}
