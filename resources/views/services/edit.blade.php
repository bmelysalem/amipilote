<x-app-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                @if ($errors->any())
                    <div class="alert alert-danger mb-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Modifier le service</h5>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('services.update', $service) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="libelle">Libellé</label>
                                        <input type="text" class="form-control @error('libelle') is-invalid @enderror" id="libelle" name="libelle" value="{{ old('libelle', $service->libelle) }}" required>
                                        @error('libelle')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12 mb-4">
                                    <div class="form-group">
                                        <label for="image_icon">Icône du service</label>
                                        <div class="input-group">
                                            <input type="file" 
                                                   class="form-control @error('image_icon') is-invalid @enderror" 
                                                   id="image_icon" 
                                                   name="image_icon"
                                                   accept="image/*">
                                            @error('image_icon')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        @if($service->image_icon)
                                            <div class="mt-2">
                                                <p class="text-sm text-gray-600">Image actuelle :</p>
                                                <img src="{{ asset('storage/' . $service->image_icon) }}" 
                                                     alt="Icône actuelle" 
                                                     class="mt-2 h-16 w-16 object-contain">
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="groupe">Groupe</label>
                                        <input type="text" class="form-control @error('groupe') is-invalid @enderror" id="groupe" name="groupe" value="{{ old('groupe', $service->groupe) }}" required>
                                        @error('groupe')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $service->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h5>Informations réseau internes</h5>
                                    <div class="form-group mb-3">
                                        <label for="ip_interne">IP interne</label>
                                        <input type="text" class="form-control @error('ip_interne') is-invalid @enderror" id="ip_interne" name="ip_interne" value="{{ old('ip_interne', $service->ip_interne) }}">
                                        @error('ip_interne')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="port_interne">Port interne</label>
                                        <input type="text" class="form-control @error('port_interne') is-invalid @enderror" id="port_interne" name="port_interne" value="{{ old('port_interne', $service->port_interne) }}">
                                        @error('port_interne')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h5>Informations réseau externes</h5>
                                    <div class="form-group mb-3">
                                        <label for="ip_publique">IP publique</label>
                                        <input type="text" class="form-control @error('ip_publique') is-invalid @enderror" id="ip_publique" name="ip_publique" value="{{ old('ip_publique', $service->ip_publique) }}">
                                        @error('ip_publique')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="port_externe">Port externe</label>
                                        <input type="text" class="form-control @error('port_externe') is-invalid @enderror" id="port_externe" name="port_externe" value="{{ old('port_externe', $service->port_externe) }}">
                                        @error('port_externe')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="adresse_dns">Adresse DNS</label>
                                        <input type="text" class="form-control @error('adresse_dns') is-invalid @enderror" id="adresse_dns" name="adresse_dns" value="{{ old('adresse_dns', $service->adresse_dns) }}">
                                        @error('adresse_dns')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <h5>Paramètres additionnels</h5>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <div class="form-check">
                                                <input type="hidden" name="is_api" value="0">
                                                <input type="checkbox" 
                                                       class="form-check-input @error('is_api') is-invalid @enderror" 
                                                       id="is_api" 
                                                       name="is_api" 
                                                       value="1"
                                                       {{ old('is_api', $service->is_api) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_api">Est une API</label>
                                                @error('is_api')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-check">
                                            <input type="hidden" name="admin_received" value="0">
                                            <input type="checkbox" 
                                                   class="form-check-input @error('admin_received') is-invalid @enderror" 
                                                   id="admin_received" 
                                                   name="admin_received" 
                                                   value="1"
                                                   {{ old('admin_received', $service->admin_received) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="admin_received">Admin reçu</label>
                                            @error('admin_received')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="documents">
                                <h3>Documents</h3>
                                @foreach ($service->documents as $index => $document)
                                    <div class="document">
                                        <input type="text" name="documents[{{ $index }}][title]" value="{{ $document->title }}" placeholder="Titre" required>
                                        <input type="text" name="documents[{{ $index }}][category]" value="{{ $document->category }}" placeholder="Catégorie" required>
                                        <input type="file" name="documents[{{ $index }}][file]">
                                        <input type="hidden" name="documents[{{ $index }}][id]" value="{{ $document->id }}">
                                    </div>
                                @endforeach
                                <div class="document">
                                    <input type="text" name="documents[new][title]" placeholder="Titre">
                                    <input type="text" name="documents[new][category]" placeholder="Catégorie">
                                    <input type="file" name="documents[new][file]">
                                </div>
                            </div>

                            <div class="mt-4">
                                <a href="{{ route('services.show', $service) }}" class="btn btn-secondary">Annuler</a>
                                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
