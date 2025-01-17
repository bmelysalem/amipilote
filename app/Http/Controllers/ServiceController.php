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
        $validated = $request->validate([
            'libelle' => 'required|string|max:255',
            'groupe' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ip_interne' => 'nullable|string|max:255',
            'port_interne' => 'nullable|string|max:255',
            'ip_publique' => 'nullable|string|max:255',
            'port_externe' => 'nullable|string|max:255',
            'adresse_dns' => 'nullable|string|max:255',
            'is_api' => 'boolean',
            'admin_received' => 'boolean',
            'image_icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image_icon')) {
            // Supprimer l'ancienne image si elle existe
            if ($service->image_icon) {
                Storage::disk('public')->delete($service->image_icon);
            }
            
            // Stocker la nouvelle image
            $path = $request->file('image_icon')->store('services/icons', 'public');
            $validated['image_icon'] = $path;
        }

        $service->update($validated);

        return redirect()->route('services.show', $service)
            ->with('success', 'Service mis à jour avec succès');
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
