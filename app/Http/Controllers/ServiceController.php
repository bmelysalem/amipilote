<?php
namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::all();
        return view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'groupe' => 'nullable|string|max:255',
            'libelle' => 'required|string|max:255',
            'port_interne' => 'nullable|integer',
            'port_externe' => 'nullable|integer',
            'ip_interne' => 'nullable|string|max:255',
            'ip_publique' => 'nullable|string|max:255',
            'adresse_dns' => 'nullable|string|max:255',
            'image_icon' => 'nullable|string|max:255',
            'is_api' => 'nullable|boolean',
            'admin_received' => 'nullable|boolean',
            'description' => 'nullable|string|max:255',
        ]);

        $validated['is_api'] = $request->has('is_api');

        Service::create($validated);
        return redirect()->route('services.index')->with('success', 'Service ajouté avec succès.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show(Service $service)
    {
        return view('services.show', compact('service'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'groupe' => 'required',
            'libelle' => 'required',
            'description' => 'nullable|string',
            'ip_interne' => 'nullable|string|max:255',
            'port_interne' => 'nullable|string|max:255',
            'ip_publique' => 'nullable|string|max:255',
            'port_externe' => 'nullable|string|max:255',
            'adresse_dns' => 'nullable|string|max:255',
            'is_api' => 'boolean',
            'admin_received' => 'boolean',
            'image_icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'documents.*.title' => 'nullable',
            'documents.*.category' => 'nullable',
            'documents.*.file' => 'nullable|file|mimes:pdf,docx,pptx,jpeg,png|max:2048',
        ]);

        $service->update($request->all());

        if ($request->hasFile('image_icon')) {
            // Supprimer l'ancienne image si elle existe
            if ($service->image_icon) {
                Storage::disk('public')->delete($service->image_icon);
            }
            
            // Stocker la nouvelle image
            $path = $request->file('image_icon')->store('services/icons', 'public');
            $service->image_icon = $path;
            $service->save();
        }

        // Gestion des documents
        if ($request->has('documents')) {
            foreach ($request->documents as $doc) {
                if (isset($doc['file'])) {
                    if ($doc['file']->getSize() > 2 * 1024 * 1024 && $doc['file']->getClientOriginalExtension() === 'pdf') { // Vérifier si le fichier est un PDF et plus grand que 2 Mo
                        $originalPath = $doc['file']->store('documents/originals'); // Stocker le fichier original
                        $compressedPath = 'documents/compressed/' . uniqid() . '.pdf'; // Chemin pour le fichier compressé

                        // Commande Ghostscript pour compresser le PDF
                        $command = "gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=/screen -dNOPAUSE -dBATCH -sOutputFile=" . storage_path('app/' . $compressedPath) . " " . storage_path('app/' . $originalPath);
                        exec($command);

                        $filePath = $compressedPath; // Utiliser le chemin du fichier compressé
                    } else {
                        $filePath = $doc['file']->store('documents'); // Stockage du fichier
                    }
                    $service->documents()->create([
                        'title' => $doc['title'],
                        'category' => $doc['category'],
                        'file_path' => $filePath,
                    ]);
                } 
            }
        }

        return redirect()->route('services.show', $service)
            ->with('success', 'Service mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Service supprimé avec succès.');
    }
}
