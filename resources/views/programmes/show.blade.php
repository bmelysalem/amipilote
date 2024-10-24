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
                    @if($programme->programme_valide)
                        @if(!$programme->fiches_generees)
                            <a href="{{ route('generate-fiches', $programme->idprogrammes) }}" class="btn btn-success">
                                Générer les fiches
                            </a>
                        @else
                            <button class="btn btn-secondary" disabled>Fiches déjà générées</button>
                        @endif
                    @endif
                    @if($programme->fiches_generees)
                        <a href="{{ route('download-fiches', $programme->idprogrammes) }}" class="btn btn-success">
                            Télécharger les fiches
                        </a>
                    @else
                        <button class="btn btn-secondary" disabled>Fiches non générées</button>
                    @endif
                    @if(!$programme->programme_valide)
                        <form action="{{ route('programmes.valider', $programme->idprogrammes) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success">Valider le programme</button>
                        </form>
                    @else
                        <button class="btn btn-secondary" disabled>Programme déjà validé</button>
                        <form action="{{ route('programmes.storeChangementsLocal', $programme->idprogrammes) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">Enregistrer les Changements et envoyer à AKILEE</button>
                        </form>
                    @endif
                    <h4>Détails des Compteurs</h4>
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
                                        <!-- Bouton pour télécharger le fichier PDF -->
                                        <a href="{{ route('fichier-pose.pdf', ['programme' => $programme->idprogrammes, 'abonne' => $detail->REFERENCE]) }}"
                                            class="btn btn-success">
                                            Télécharger le fichier PDF
                                        </a>
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

                    <a href="{{ route('programmes.index') }}" class="btn btn-secondary">Retour à la liste</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
