<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;

class DocumentController extends Controller
{
    public function destroy($id)
    {
        $document = Document::findOrFail($id);
        
        // Delete the associated file
        if (file_exists($document->file_path)) {
            unlink($document->file_path);
        }

        $document->delete();

        return response()->json(['success' => true]);
    }
    
    public function stream($id)
    {
        $document = Document::findOrFail($id);
        
        return response()->stream(function () use ($document) {
            echo file_get_contents($document->file_path);
        }, 200, [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="' . basename($document->file_path) . '"',
        ]);
    }
}
