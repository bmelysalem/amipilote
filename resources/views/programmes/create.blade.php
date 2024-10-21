<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Créer Programme') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Afficher les erreurs de validation -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('programmes.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="Code_agence">Code Agence</label>
                            <input type="text" name="Code_agence" class="form-control" value="{{ old('Code_agence') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="date_saisie">Date Saisie</label>
                            <input type="date" name="date_saisie" class="form-control" value="{{ old('date_saisie') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="date_debut">Date Début</label>
                            <input type="date" name="date_debut" class="form-control" value="{{ old('date_debut') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="date_fin">Date Fin</label>
                            <input type="date" name="date_fin" class="form-control" value="{{ old('date_fin') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="programme_cloture">Programme Clôturé</label>
                            <input type="text" name="programme_cloture" class="form-control" value="{{ old('programme_cloture') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="Code_agent">Code Agent</label>
                            <input type="text" name="Code_agent" class="form-control" value="{{ old('Code_agent') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="les_secteurs">Les Secteurs</label>
                            <input type="text" name="les_secteurs" class="form-control" value="{{ old('les_secteurs') }}">
                        </div>

                        <button type="submit" class="btn btn-primary">Créer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
