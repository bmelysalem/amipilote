<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function update(Request $request, $id)
    {
        $document = Document::findOrFail($id);
        
        // Validation des données
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf|max:2048', // Exemple de validation pour un fichier PDF
        ]);

        // Mise à jour des champs
        $document->title = $request->input('title');
        $document->category = $request->input('category');

        // Si un nouveau fichier est téléchargé, gérez-le ici
        if ($request->hasFile('file')) {
            // Logique pour gérer le fichier (par exemple, stockage)
        }

        $document->save();

        return redirect()->back()->with('success', 'Document mis à jour avec succès.');
    }
}
