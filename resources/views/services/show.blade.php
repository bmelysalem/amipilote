@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        @if($service->image_icon)
                            <img src="{{ asset('storage/' . $service->image_icon) }}" alt="Icon" class="me-2" style="height: 24px;">
                        @endif
                        <span class="h5 mb-0">{{ $service->libelle }}</span>
                    </div>
                    <span class="badge bg-primary">{{ $service->groupe }}</span>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Informations réseau internes</h5>
                            <table class="table table-sm">
                                <tr>
                                    <th>IP interne</th>
                                    <td>{{ $service->ip_interne }}</td>
                                </tr>
                                <tr>
                                    <th>Port interne</th>
                                    <td>{{ $service->port_interne }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h5>Informations réseau externes</h5>
                            <table class="table table-sm">
                                <tr>
                                    <th>IP publique</th>
                                    <td>{{ $service->ip_publique }}</td>
                                </tr>
                                <tr>
                                    <th>Port externe</th>
                                    <td>{{ $service->port_externe }}</td>
                                </tr>
                                <tr>
                                    <th>Adresse DNS</th>
                                    <td>
                                        @if($service->adresse_dns)
                                            <a href="http://{{ $service->adresse_dns }}" target="_blank">
                                                {{ $service->adresse_dns }}
                                            </a>
                                        @else
                                            <span class="text-muted">Non définie</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h5>Paramètres additionnels</h5>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" disabled {{ $service->is_api ? 'checked' : '' }}>
                                    <label class="form-check-label">Service API</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" disabled {{ $service->admin_received ? 'checked' : '' }}>
                                    <label class="form-check-label">Admin reçu</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('services.index') }}" class="btn btn-secondary">Retour à la liste</a>
                        <a href="{{ route('services.edit', $service) }}" class="btn btn-primary">Modifier</a>
                        <form action="{{ route('services.destroy', $service) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce service ?')">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
