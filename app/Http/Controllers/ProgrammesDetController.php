<?php

namespace App\Http\Controllers;

use App\Models\ProgrammesDet;
use App\Models\Abonnes;
use PDF; // Import de la façade DOMPDF
use Illuminate\Http\Request;

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
        //return view('fichier-pose.pdf', compact('fiche', 'abonne'));// Générer le PDF à partir d'une vue
        $pdf = PDF::loadView('fichier-pose.pdf', compact('fiche', 'abonne'));

        // Télécharger le fichier PDF
        return $pdf->download('fichier_pose_abonne_' . $abonne->REFERENCE . '.pdf');
    }
}
