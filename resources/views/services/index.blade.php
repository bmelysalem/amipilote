<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liste des Services') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <a href="{{ route('services.create') }}" class="btn btn-primary mb-4">Ajouter un Service</a>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom du Service</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($services as $service)
                            <tr>
                                <td>{{ $service->id }}</td>
                                <td>{{ $service->groupe }} : {{ $service->libelle }}</td>
                                <td>{{ $service->description }}</td>
                                <td>
                                    <a href="{{ route('services.show', $service->id) }}" class="btn btn-info">Voir</a>
                                    <a href="{{ route('services.edit', $service->id) }}" class="btn btn-warning">Modifier</a>
                                    <form action="{{ route('services.destroy', $service->id) }}"
                                        method="POST" style="display:inline;"
                                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce service ?');">
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
