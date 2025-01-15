<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liste des Programmes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <a href="{{ route('programmes.create') }}" class="btn btn-primary mb-4">Ajouter un Programme</a>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Code Agence</th>
                                <th>TARIF</th>
                                <th></th>
                                <th>Date Fin</th>
                                <th>Nombre de Compteurs</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($programmes as $programme)
                            <tr>
                                <td>{{ $programme->idprogrammes }}</td>
                                <td>{{ $programme->Code_agence }}</td>
                                <td>{{ $programme->date_saisie }}</td>
                                <td>{{ $programme->date_debut }}</td>
                                <td>{{ $programme->date_fin }}</td>
                                <td>{{ $programme->details_count }}</td>
                                <td>
                                    <a href="{{ route('programmes.show', $programme->idprogrammes) }}" class="btn btn-info">Voir Détails</a>
                                    <a href="{{ route('programmes.edit', $programme->idprogrammes) }}" class="btn btn-warning">Modifier</a>
                                    <form action="{{ route('programmes.destroy', $programme->idprogrammes) }}"
                                        method="POST" style="display:inline;"
                                        onsubmit="return confirm('Êtes-vous sûr de vouloir retirer cette ligne ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
