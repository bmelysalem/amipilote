<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Détails du Programme') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <h3>Programme : {{ $programme->idprogrammes }}</h3>
                    <p><strong>Code Agence : </strong> {{ $programme->Code_agence }}</p>
                    <p><strong>Date Saisie : </strong> {{ $programme->date_saisie }}</p>
                    <p><strong>Date Début : </strong> {{ $programme->date_debut }}</p>
                    <p><strong>Date Fin : </strong> {{ $programme->date_fin }}</p>
                    <p><strong>Code Agent : </strong> {{ $programme->Code_agent }}</p>

                    <!-- Boutons de génération et de téléchargement -->
@if($programme->programme_valide)
@if(!$programme->fiches_generees && !$programme->generation_in_progress)
    <a href="{{ route('generate-fiches', $programme->idprogrammes) }}" class="btn btn-success">
        Générer les fiches
    </a>
@elseif($programme->generation_in_progress)
    <button class="btn btn-warning" disabled>
        Génération en cours...
    </button>
@else
    <a href="{{ route('generate-fiches', $programme->idprogrammes) }}" class="btn btn-primary">
        Re-Générer les fiches
    </a>
@endif
@endif

@if($programme->fiches_generees && !$programme->generation_in_progress)
<a href="{{ route('download-fiches2', $programme->idprogrammes) }}" class="btn btn-success">
    Télécharger les fiches
</a>
@else
<button class="btn btn-secondary" disabled>
    @if($programme->generation_in_progress)
        Génération en cours...
    @else
        Fiches non générées
    @endif
</button>
@endif


                    <!-- Formulaire pour valider le programme et envoyer les données à Akilee -->
                    @if(!$programme->programme_valide)
                        <form action="{{ route('programmes.valider', $programme->idprogrammes) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success">Valider le programme</button>
                        </form>
                    @else
                        <button class="btn btn-secondary" disabled>Programme déjà validé</button>
                        <form action="{{ route('programmes.storeChangementsLocal', $programme->idprogrammes) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-primary">Envoyer les données à AKILEE DATABASE</button>
                        </form>
                    @endif

                    <a href="{{ route('programmes.index') }}" class="btn btn-secondary">Retour à la liste des programmes</a>

                    <!-- Table des abonnés avec cases à cocher -->
                    <h4>Détails des Compteurs</h4>
                    
                    <!-- Formulaire de recherche et filtres -->
                    <div class="mb-4">
                        <form id="searchForm" action="{{ route('programmes.show', $programme->idprogrammes) }}" method="GET" class="flex flex-wrap gap-4 items-end p-4 border border-gray-200 rounded-lg shadow-sm bg-gray-50">
                            <div class="form-group">
                                <label for="reference" class="block text-sm font-medium text-gray-700 mb-1">Référence, Secteur ...</label>
                                <input type="text" id="reference" name="reference" class="form-control border-gray-300" placeholder="Rechercher une référence" value="{{ request('reference') }}">
                            </div>
                            
                            <div class="form-group">
                                <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                                <select id="type" name="type" class="form-control border-gray-300">
                                    <option value="">Tous</option>
                                    <option value="1" {{ request('type') == '1' ? 'selected' : '' }}>Monophasé (M)</option>
                                    <option value="4" {{ request('type') == '4' ? 'selected' : '' }}>Triphasé (T)</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="etat" class="block text-sm font-medium text-gray-700 mb-1">État</label>
                                <select id="etat" name="etat" class="form-control border-gray-300">
                                    <option value="">Tous</option>
                                    @for($i = 1; $i <= 9; $i++)
                                        <option value="{{ $i }}" {{ request('etat') == $i ? 'selected' : '' }}>État {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            
                            <div class="flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    Filtrer
                                </button>
                                <a href="{{ route('programmes.show', $programme->idprogrammes) }}" class="btn btn-secondary">
                                    Réinitialiser
                                </a>
                            </div>
                        </form>
                    </div>

                    <form action="{{ route('generateFichesByList') }}" method="POST">
                        @csrf
                        <input type="hidden" name="programme_id" value="{{ $programme->idprogrammes }}">
                        <table class="table mt-4">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAll"></th>
                                    <th>Référence</th>
                                    <th>TARIF</th>
                                    <th>TYPE</th>
                                    <th>ETAT</th>
                                    <th>Compteur Ancien</th>
                                    <th>Téléphone</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($details as $detail)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="abonne_ids[]" value="{{ $detail->idprogemesdet }}">
                                        </td>
                                        <td>{{ $detail->REFERENCE }}</td>
                                        <td>{{ $detail->abonne->TARIF }}</td>
                                        <td>{{ substr($detail->abonne->CODE_BRANCHEMENT, 0, 1) == '4' ? 'T' : 'M' }}</td>
                                        <td>{{ $detail->abonne->ETAT_ABONNE }}</td>
                                        <td>{{ $detail->compteur_ancien }}</td>
                                        <td>{{ $detail->telephone_03 }}</td>
                                        <td>
                                            @if($programme->programme_valide)
                                                <a href="{{ route('fichier-pose.pdf', ['programme' => $programme->idprogrammes, 'abonne' => $detail->REFERENCE]) }}" class="btn btn-success">
                                                    Télécharger le fichier PDF
                                                </a>
                                            @endif
                                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#abonneModal{{ $detail->REFERENCE }}">
                                                Voir Détails
                                            </button>
                                            @include('programmes.modals.abonne', ['detail' => $detail]) <!-- Utiliser une vue partielle pour le modal -->
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary mt-3">Générer et Télécharger les Fiches Sélectionnées</button>
                        <a href="{{ route('download-table', $programme->idprogrammes) }}" class="btn btn-success">
                            Télécharger les données sous forme de table
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script pour sélectionner tous les abonnés -->
    <script>
        document.getElementById('selectAll').addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('input[name="abonne_ids[]"]');
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        });
    </script>
</x-app-layout>
