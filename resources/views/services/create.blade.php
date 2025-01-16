<x-app-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Créer un nouveau service</h5>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="libelle">Libellé</label>
                                        <input type="text" class="form-control" id="libelle" name="libelle" value="{{ old('libelle') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="groupe">Groupe</label>
                                        <input type="text" class="form-control" id="groupe" name="groupe" value="{{ old('groupe') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h5>Informations réseau internes</h5>
                                    <div class="form-group mb-3">
                                        <label for="ip_interne">IP interne</label>
                                        <input type="text" class="form-control" id="ip_interne" name="ip_interne" value="{{ old('ip_interne') }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="port_interne">Port interne</label>
                                        <input type="text" class="form-control" id="port_interne" name="port_interne" value="{{ old('port_interne') }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h5>Informations réseau externes</h5>
                                    <div class="form-group mb-3">
                                        <label for="ip_publique">IP publique</label>
                                        <input type="text" class="form-control" id="ip_publique" name="ip_publique" value="{{ old('ip_publique') }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="port_externe">Port externe</label>
                                        <input type="text" class="form-control" id="port_externe" name="port_externe" value="{{ old('port_externe') }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="adresse_dns">Adresse DNS</label>
                                        <input type="text" class="form-control" id="adresse_dns" name="adresse_dns" value="{{ old('adresse_dns') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <h5>Paramètres additionnels</h5>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="is_api" name="is_api" {{ old('is_api') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_api">Service API</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="admin_received" name="admin_received" {{ old('admin_received') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="admin_received">Admin reçu</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <a href="{{ route('services.index') }}" class="btn btn-secondary">Annuler</a>
                                <button type="submit" class="btn btn-primary">Créer le service</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
