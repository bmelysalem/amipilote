<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Créer Service') }}
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
                    <form action="{{ route('services.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="Code_service">Code Service</label>
                            <input type="text" name="Code_service" class="form-control" value="{{ old('Code_service') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="Libelle">Libellé</label>
                            <input type="text" name="Libelle" class="form-control" value="{{ old('Libelle') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="Description">Description</label>
                            <textarea name="Description" class="form-control" rows="3">{{ old('Description') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Créer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
