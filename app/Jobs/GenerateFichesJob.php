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

    // Temps limite pour l'exécution du job (3 minutes)
    public $timeout = 180;

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
        ini_set('memory_limit', '512M');

        try {
            // Récupérer le programme
            $programme = Programmes::findOrFail($this->programmeId);

            // Vérifier si les fiches ont déjà été générées
            if ($programme->fiches_generees) {
                Log::info("Les fiches pour le programme {$this->programmeId} ont déjà été générées.");
                return;
            }

            // Récupérer les abonnés liés à ce programme
            $abonnes = ProgrammesDet::where('idprogrammes', $this->programmeId)->with('abonne')->get();

            // Générer un seul PDF pour toutes les fiches
            $pdf = PDF::loadView('fichier-pose.pose_multiple', compact('abonnes'));

            // Sauvegarder le PDF consolidé
            $pdfPath = storage_path("fiches/fiches_poses_{$this->programmeId}.pdf");
            $pdf->save($pdfPath);

            // Marquer le programme comme ayant ses fiches générées
            $programme->fiches_generees = true;
            $programme->save();

            Log::info("Fiches pour le programme {$this->programmeId} générées avec succès.");

        } catch (\Exception $e) {
            Log::error("Erreur lors de la génération des fiches pour le programme {$this->programmeId}: " . $e->getMessage());
        }
    }
}
