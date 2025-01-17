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

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($services as $service)
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title font-bold mb-2">{{ $service->groupe }} : {{ $service->libelle }}</h5>
                                    <p class="card-text mb-2"><strong>ID:</strong> {{ $service->id }}</p>
                                    <p class="card-text mb-2"><strong>Adresse IP:</strong> {{ $service->ip_interne }}:{{ $service->port_interne }}</p>
                                    <p class="card-text mb-4"><strong>Description:</strong> {{ $service->description }}</p>
                                    
                                    <div class="flex space-x-2">
                                        <a href="{{ route('services.show', $service->id) }}" class="btn btn-info">Voir</a>
                                        <a href="{{ route('services.edit', $service->id) }}" class="btn btn-warning">Modifier</a>
                                        <form action="{{ route('services.destroy', $service->id) }}"
                                            method="POST" style="display:inline;"
                                            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce service ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Supprimer</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
