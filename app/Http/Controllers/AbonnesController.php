<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Abonnes;

class AbonnesController extends Controller {
    public function search( Request $request ) {
        $reference = $request->query( 'reference' );

        // Rechercher les abonnés dont la référence correspond aux 4 premiers caractères
        $abonnes = Abonnes::where( 'REFERENCE', 'LIKE', $reference . '%' )->get();

        return response()->json( $abonnes );
    }

}
