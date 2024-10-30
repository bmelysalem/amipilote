<?php

namespace App\Services;

class KeyCalculationService
{
    protected $imax;
    protected $divis;

    public function calculateKey($reference, $function)
    {

        // Initialize response and check function validity
        if (!in_array($function, ["0", "1", "2"])) {
            return ['error' => "Invalid function value"];
        }

        // Validate the input based on the function type
        if (!$this->validateReference($reference, $function)) {
            return ['error' => "Invalid reference format"];
        }

        // Set DIVIS and IMAX based on function
        $this->setDivisAndImax($function);

        // Perform calculations
        $totD1 = 0;
        $totD2 = 0;
        $reference = ' '.$reference;

        $rang = $reference[10] +1;

        if($rang > '5'){
            $rang = $rang - 5;
            $reference = substr_replace($reference, (string)$rang, 10, 1);
        }
        if($rang == '0'){
            $reference = substr_replace($reference, '5', 10, 1);
        }

        $reference = substr_replace($reference, (string)$rang, 10, 1);




        // Convert characters in reference if alphabetic and calculate totals
        for ($i = 1; $i <= $this->imax; $i++) {
            $char = substr($reference, $i, 1);
            $numericVal = $this->convertAlphaToNumeric($char);

            $totD1 += $numericVal;
            $totD2 += $numericVal * ($this->imax + 1 - $i);
        }

        // Perform final division to obtain D1 and D2
        $d1 = $totD1 % $this->divis;
        $d2 = $totD2 % $this->divis;

        //return $d1;

        // Return the calculated key as per the function
        return [
            'sRang' => $rang ,
            'sC1' => $d1 ,
            'sC2' => $d2
        ];
        return $this->calculateSValues($reference, $d1, $d2);
        return $this->formatResult($d1, $d2, $function);
    }

    private function validateReference($reference, $function)
    {
        if ($function == "0") {
            return ctype_digit(substr($reference, 0, 2)) &&
                   ctype_digit(substr($reference, 4, 3)) &&
                   ctype_digit(substr($reference, 7, 3));
        } elseif ($function == "1") {
            return ctype_digit(substr($reference, 0, 5));
        } elseif ($function == "2") {
            return ctype_digit(substr($reference, 0, 6));
        }
        return false;
    }

    private function setDivisAndImax($function)
    {
        if ($function == "0") {
            $this->divis = 11;
            $this->imax = 10;
        } elseif ($function == "1") {
            $this->divis = 10;
            $this->imax = 5;
        } else {
            $this->divis = 11;
            $this->imax = 6;
        }
    }

    private function convertAlphaToNumeric($char)
    {
        $conversionTable = [
            'A' => 0, 'B' => 1, 'C' => 2, 'D' => 3, 'E' => 4,
            'F' => 5, 'G' => 6, 'H' => 7, 'I' => 8, 'J' => 9,
            'K' => 1, 'L' => 2
        ];

        $char = strtoupper($char);
        return is_numeric($char) ? intval($char) : ($conversionTable[$char] ?? 0);
    }

    private function formatResult($d1, $d2, $function)
    {
        if ($function == "1") {
            return [
                'sCleGr' => $d2,
                'suiteGr' => ''
            ];
        } elseif ($function == "2") {
            return [
                'sCleMt' => $d2 == 10 ? 1 : $d2,
                'suiteMt' => ''
            ];
        }

        return [
            'sRang' => $d2 >= 5 ? 0 : ($d2 + 5),
            'sC1' => $d1 == 10 ? 8 : ($d1 ?: 9),
            'sC2' => $d2 == 10 ? 9 : ($d2 ?: 8)
        ];
    }
    public function calculateSValues($tabref, $d1, $d2)
    {
        // Initialize S-RANG
        $sRang = $tabref[10];

        // Logic for TABREF(10) check
        if ($tabref[10] >= 5) {
            $sRang = 0;
        }

        // Set S-C1 and S-C2 based on D1 and D2
        if ($d1 == 10) {
            return $this->handleTest10D2($d2, $sRang);
        } elseif ($d2 == 10) {
            return $this->handleTest0D1($d1, $sRang);
        }

        // Regular move operations
        $sC1 = $d1;
        $sC2 = $d2;

        return [
            'sRang' => $sRang,
            'sC1' => $sC1,
            'sC2' => $sC2
        ];
    }

    private function handleTest10D2($d2, $sRang)
    {
        // TEST-10-D2 logic
        if ($d2 == 10) {
            return [
                'sRang' => $sRang,
                'sC1' => 9,
                'sC2' => 9
            ];
        } elseif ($d2 == 0) {
            return [
                'sRang' => $sRang,
                'sC1' => 9,
                'sC2' => 8
            ];
        } else {
            return [
                'sRang' => $sRang,
                'sC1' => 0,
                'sC2' => $d2
            ];
        }
    }

    private function handleTest0D1($d1, $sRang)
    {
        // TEST-0-D1 logic
        if ($d1 == 0) {
            return [
                'sRang' => $sRang,
                'sC1' => 8,
                'sC2' => 9
            ];
        } else {
            return [
                'sRang' => $sRang,
                'sC1' => $d1,
                'sC2' => 0
            ];
        }
    }

}
