<?php

namespace App\Http\Controllers;

use App\Services\KeyCalculationService;
use Illuminate\Http\Request;

class KeyCalculationController extends Controller
{
    protected $keyCalculationService;

    public function __construct(KeyCalculationService $keyCalculationService)
    {
        $this->keyCalculationService = $keyCalculationService;
    }

    public function calculate(Request $request)
    {
        // Assume input validation is handled
        $ssRefer = $request->input('ss_refer');
        $ssRang = $request->input('ss_rang');

        $result = $this->keyCalculationService->calculateKey($ssRefer, $ssRang);

        return response()->json($result);
    }
    public function calculateForm()
    {
        return view('clecalc');
    }


}
