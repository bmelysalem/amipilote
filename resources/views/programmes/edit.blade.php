<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier Programme') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('programmes.update', $programme->idprogrammes) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="Code_agence">Code Agence</label>
                            <input type="text" name="Code_agence" class="form-control"
                                value="{{ $programme->Code_agence }}" required>
                        </div>

                        <div class="form-group">
                            <label for="date_saisie">Date Saisie</label>
                            <input type="date" name="date_saisie" class="form-control"
                                value="{{ $programme->date_saisie }}" required>
                        </div>

                        <div class="form-group hidden" >
                            <label for="date_debut">Date Début</label>
                            <input type="date" name="date_debut" class="form-control"
                                value="{{ $programme->date_debut }}" required>
                        </div>

                        <div class="form-group">
                            <label for="date_fin">Date Fin</label>
                            <input type="date" name="date_fin" class="form-control"
                                value="{{ $programme->date_fin }}" required>
                        </div>

                        <div class="form-group">
                            <label for="programme_cloture">Programme Clôturé</label>
                            <input type="text" name="programme_cloture" class="form-control"
                                value="{{ $programme->programme_cloture }}" required>
                        </div>

                        <div class="form-group">
                            <label for="Code_agent">Code Agent</label>
                            <input type="text" name="Code_agent" class="form-control"
                                value="{{ $programme->Code_agent }}" required>
                        </div>

                        <div class="form-group">
                            <label for="les_secteurs">Les Secteurs</label>
                            <input type="text" name="les_secteurs" class="form-control"
                                value="{{ $programme->les_secteurs }}">
                        </div>

                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h4>Détails des Compteurs</h4>
                    <!-- Button to trigger the modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#searchModal">
        Ajout des abonnée, Secteur et Tourné
    </button>
                    <table class="table mt-4">
                        <thead>
                            <tr>
                                <th>Référence</th>
                                <th>Compteur Posé</th>
                                <th>Branch Repris</th>
                                <th>Compteur Ancien</th>
                                <th>Téléphone</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($programme->details as $detail)
                                <tr>
                                    <td>{{ $detail->REFERENCE }}</td>
                                    <td>{{ $detail->compteur_pose ? 'Oui' : 'Non' }}</td>
                                    <td>{{ $detail->Branch_repris ? 'Oui' : 'Non' }}</td>
                                    <td>{{ $detail->compteur_ancien }}</td>
                                    <td>{{ $detail->telephone_03 }}</td>
                                    <td>
                                        <!-- Bouton pour ouvrir la modale avec les détails de l'abonné -->
                                        <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                            data-bs-target="#abonneModal{{ $detail->REFERENCE }}">
                                            Voir Détails
                                        </button>

                                        <!-- Modal Bootstrap -->
                                        <div class="modal fade" id="abonneModal{{ $detail->REFERENCE }}" tabindex="-1"
                                            aria-labelledby="abonneModalLabel{{ $detail->REFERENCE }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="abonneModalLabel{{ $detail->REFERENCE }}">Détails de
                                                            l'Abonné</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @isset($detail->abonne)
                                                            <p><strong>Nom :</strong> {{ $detail->abonne->NOM }}</p>
                                                            <p><strong>Adresse :</strong> {{ $detail->abonne->ADRESSE }}
                                                            </p>
                                                            <p><strong>Complément d'Adresse :</strong>
                                                                {{ $detail->abonne->ADRESSE_COMPL }}</p>
                                                            <p><strong>Téléphone :</strong>
                                                                {{ $detail->abonne->TELEPHONE_01 }}</p>
                                                            <p><strong>Email :</strong> {{ $detail->abonne->MAIL }}</p>
                                                            <p><strong>Groupe :</strong> {{ $detail->abonne->GROUPE }}</p>
                                                            <p><strong>Code Branchement :</strong>
                                                                {{ $detail->abonne->CODE_BRANCHEMENT }}</p>
                                                            <p><strong>Compteur :</strong>
                                                                {{ $detail->abonne->CODE_COMPTEUR }}</p>
                                                            <p><strong>Latitude :</strong> {{ $detail->abonne->LATITUDE }}
                                                            </p>
                                                            <p><strong>Longitude :</strong>
                                                                {{ $detail->abonne->LONGITUDE }}</p>
                                                            <!-- Ajouter d'autres informations ici si nécessaire -->
                                                        @endisset

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Fermer</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal Structure -->
    <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="searchModalLabel">Rechercher un abonné</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulaire de recherche dans la modale -->
                    <div class="form-group">
                        <label for="reference">Référence ou 4 premiers caractères :</label>
                        <input type="text" id="reference" class="form-control" placeholder="Saisir la référence">
                        <button type="button" id="searchAbonne" class="btn btn-primary mt-2">Rechercher</button>
                    </div>
                    <!-- Loader (caché par défaut) -->
                    <div id="loader" style="display: none; text-align: center;">
                        <img src="{{ asset('images/loader.gif') }}" alt="Loading..." />
                    </div>
                    <!-- Liste des résultats de la recherche -->
                    <div id="searchResults"></div>
                </div>
                <div class="modal-footer">
                    <!-- Ajouter tout button -->
                    <button type="button" id="addAllButton" class="btn btn-success">Ajouter tout</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>



    @push('scripts')
        <script>
            var abonnesReferences = []; // Stocker toutes les références des abonnés trouvés

            document.getElementById('searchAbonne').addEventListener('click', function() {
                var reference = document.getElementById('reference').value;

                if (reference.length >= 4) {
                    // Afficher le loader avant d'envoyer la requête
                    document.getElementById('loader').style.display = 'block';

                    // Cacher les résultats précédents
                    document.getElementById('searchResults').innerHTML = '';
                    abonnesReferences = []; // Réinitialiser les références d'abonnés

                    // Effectuer une requête AJAX pour rechercher les abonnés
                    fetch(`/search-abonnees?reference=${reference}`)
                        .then(response => response.json())
                        .then(data => {
                            // Masquer le loader une fois la réponse reçue
                            document.getElementById('loader').style.display = 'none';

                            var resultsDiv = document.getElementById('searchResults');
                            resultsDiv.innerHTML = '';

                            if (data.length > 0) {
                                // Créer le tableau des résultats
                                var table = `
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Référence</th>
                                    <th>Nom</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;

                                // Ajouter une ligne pour chaque abonné trouvé
                                data.forEach(function(abonne) {
                                    table += `
                            <tr>
                                <td>${abonne.REFERENCE}</td>
                                <td>${abonne.NOM}</td>
                                <td><button type="button" onclick="addProgrammeDet('${abonne.REFERENCE}')" class="btn btn-success">Ajouter</button></td>
                            </tr>
                        `;
                                    abonnesReferences.push(abonne
                                    .REFERENCE); // Ajouter la référence à la liste
                                });

                                table += `
                            </tbody>
                        </table>
                    `;

                                resultsDiv.innerHTML = table;

                            } else {
                                resultsDiv.innerHTML = '<p>Aucun abonné trouvé.</p>';
                            }
                        })
                        .catch(error => {
                            // Masquer le loader en cas d'erreur
                            document.getElementById('loader').style.display = 'none';
                            alert('Erreur lors de la recherche.');
                        });
                } else {
                    alert('Veuillez entrer au moins 4 caractères.');
                }
            });

            // Gestion du bouton "Ajouter tout"
            document.getElementById('addAllButton').addEventListener('click', function() {
                var programmeId = {{ $programme->idprogrammes }}; // Assure-toi que tu as la variable programmeId

                if (abonnesReferences.length > 0) {
                    // Envoyer toutes les références au backend
                    fetch(`/programmes/${programmeId}/add-all-programmedet`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                references: abonnesReferences
                            }) // Envoyer toutes les références
                        }).then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Tous les abonnés ont été ajoutés avec succès.');
                                $('#searchModal').modal('hide'); // Ferme la modale après l'ajout
                            } else {
                                alert('Erreur lors de l\'ajout.');
                            }
                        })
                        .catch(error => {
                            alert('Erreur lors de l\'ajout.');
                        });
                } else {
                    alert('Aucun abonné à ajouter.');
                }
            });



            function addProgrammeDet(reference) {
                var programmeId = {{ $programme->idprogrammes }}; // Assure-toi que tu as la variable programmeId

                fetch(`/programmes/${programmeId}/add-programmedet`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // N'oublie pas d'inclure le token CSRF
                        },
                        body: JSON.stringify({
                            reference: reference
                        })
                    }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('ProgrammeDet ajouté avec succès.');
                            $('#searchModal').modal('hide'); // Ferme la modale après l'ajout
                        } else {
                            alert('Erreur lors de l\'ajout.');
                        }
                    });
            }
        </script>

        <script>
            function addProgrammeDet(reference) {
                var programmeId = {{ $programme->idprogrammes }}; // Assure-toi que tu as la variable programmeId

                fetch(`/programmes/${programmeId}/add-programmedet`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // N'oublie pas d'inclure le token CSRF
                        },
                        body: JSON.stringify({
                            reference: reference
                        })
                    }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('ProgrammeDet ajouté avec succès.');
                            // Tu peux ici mettre à jour la liste des ProgrammesDet
                        } else {
                            alert('Erreur lors de l\'ajout.');
                        }
                    });
            }
        </script>
    @endpush
</x-app-layout>
