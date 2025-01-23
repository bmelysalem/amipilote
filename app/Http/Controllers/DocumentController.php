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
}
