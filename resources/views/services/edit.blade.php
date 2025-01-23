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
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Titre</th>
                                            <th>Catégorie</th>
                                            <th>Fichier</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($service->documents as $index => $document)
                                            <tr>
                                                <td>
                                                    <input type="text" name="documents[{{ $index }}][title]" value="{{ $document->title }}" placeholder="Titre" required>
                                                </td>
                                                <td>
                                                    <input type="text" name="documents[{{ $index }}][category]" value="{{ $document->category }}" placeholder="Catégorie" required>
                                                </td>
                                                <td>
                                                    <input type="file" name="documents[{{ $index }}][file]">
                                                    <input type="hidden" name="documents[{{ $index }}][id]" value="{{ $document->id }}">
                                                </td>
                                                <td>
                                                    <button type="button" onclick="confirmDelete({{ $document->id }})">Supprimer</button>
                                                    <button type="button" onclick="openEditDialog({{ $document->id }})">Modifier</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="document">
                                    <input type="text" name="documents[new][title]" placeholder="Titre">
                                    <input type="text" name="documents[new][category]" placeholder="CatÃ©gorie">
                                    <input type="file" name="documents[new][file]">
                                </div>
                            </div>

                            <!-- Modal d'édition -->
                            <div id="editModal" style="display:none;">
                                <div class="modal-content">
                                    <span class="close" onclick="closeEditDialog()">&times;</span>
                                    <h2>Modifier le Document</h2>
                                    <form id="editForm" method="POST" action="{{ route('documents.update', 'document_id') }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="id" id="editDocumentId">
                                        <label for="editTitle">Titre:</label>
                                        <input type="text" name="title" id="editTitle" required>
                                        <label for="editCategory">Catégorie:</label>
                                        <input type="text" name="category" id="editCategory" required>
                                        <label for="editFile">Fichier:</label>
                                        <input type="file" name="file" id="editFile">
                                        <button type="submit">Sauvegarder</button>
                                    </form>
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

    <script>
        function confirmDelete(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer ce document ?')) {
                // Logique pour supprimer le document
                fetch(`/documents/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => {
                    if (response.ok) {
                        // Supprimer la ligne du tableau
                        const documentRow = document.querySelector(`input[value="${id}"]`).closest('tr');
                        documentRow.remove();
                    } else {
                        alert('Erreur lors de la suppression du document.');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                });
            }
        }

        function openEditDialog(id) {
            // Récupérer les données du document à modifier
            const documentRow = document.querySelector(`input[value="${id}"]`).closest('tr');
            const title = documentRow.querySelector('input[name*="[title]"]').value;
            const category = documentRow.querySelector('input[name*="[category]"]').value;

            // Remplir le modal avec les données
            document.getElementById('editTitle').value = title;
            document.getElementById('editCategory').value = category;
            document.getElementById('editDocumentId').value = id;

            // Mettre à jour l'action du formulaire
            document.getElementById('editForm').action = document.getElementById('editForm').action.replace('document_id', id);

            // Afficher le modal
            document.getElementById('editModal').style.display = 'block';
        }

        function closeEditDialog() {
            document.getElementById('editModal').style.display = 'none';
        }
    </script>
</x-app-layout>
