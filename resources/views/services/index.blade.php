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

                    <!-- Onglets -->
                    <div class="mb-4 border-b border-gray-200">
                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="serviceTabs" role="tablist">
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 border-b-2 rounded-t-lg active" 
                                        id="all-tab" 
                                        data-tab="all">
                                    Tous
                                </button>
                            </li>
                            @foreach($services->pluck('groupe')->unique() as $groupe)
                                <li class="mr-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:border-gray-300"
                                            id="{{ Str::slug($groupe) }}-tab"
                                            data-tab="{{ Str::slug($groupe) }}">
                                        {{ $groupe }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($services as $service)
                            <div class="card service-card flex flex-col h-full" data-groupe="{{ Str::slug($service->groupe) }}">
                                <div class="card-body flex flex-col flex-grow">
                                    <div class="flex-grow">
                                        <div class="mb-4 flex justify-center">
                                            @if($service->image_icon)
                                                <img src="{{ asset('storage/' . $service->image_icon) }}" 
                                                     alt="Icône {{ $service->libelle }}"
                                                     class="w-16 object-contain cursor-pointer hover:opacity-75 transition-opacity"
                                                     onclick="openImageModal('{{ asset('storage/' . $service->image_icon) }}', '{{ $service->libelle }}')">
                                            @else
                                                <i class="fas fa-cogs text-6xl text-gray-400"></i>
                                            @endif
                                        </div>
                                        <h5 class="card-title font-bold mb-2">{{ $service->groupe }} : {{ $service->libelle }}</h5>
                                        <p class="card-text mb-2"><strong>ID:</strong> {{ $service->id }}</p>
                                        <p class="card-text mb-2"><strong>Adresse IP:</strong> {{ $service->ip_interne }}:{{ $service->port_interne }}</p>
                                        <p class="card-text mb-4"><strong>Description:</strong> {{ $service->description }}</p>
                                    </div>
                                    
                                    <div class="flex space-x-2 mt-auto pt-4 border-t">
                                        <a href="{{ route('services.show', $service->id) }}" class="btn btn-info">
                                            <i class="fas fa-eye mr-1"></i> Voir
                                        </a>
                                        <a href="{{ route('services.edit', $service->id) }}" class="btn btn-warning">
                                            <i class="fas fa-edit mr-1"></i> Modifier
                                        </a>
                                        <form action="{{ route('services.destroy', $service->id) }}"
                                            method="POST" style="display:inline;"
                                            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce service ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-trash-alt mr-1"></i> Supprimer
                                            </button>
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

    <!-- Modal pour l'image -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="relative">
            <button onclick="closeImageModal()" class="absolute -top-10 right-0 text-white text-xl hover:text-gray-300">
                <i class="fas fa-times"></i>
            </button>
            <img id="modalImage" src="" alt="" class="max-h-[80vh] max-w-[90vw] object-contain">
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('[data-tab]');
            const cards = document.querySelectorAll('.service-card');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    // Retirer la classe active de tous les onglets
                    tabs.forEach(t => {
                        t.classList.remove('active');
                        t.classList.add('border-transparent');
                    });

                    // Ajouter la classe active à l'onglet cliqué
                    tab.classList.add('active');
                    tab.classList.remove('border-transparent');
                    tab.classList.add('border-blue-600', 'text-blue-600');

                    const selectedGroupe = tab.getAttribute('data-tab');

                    // Afficher/masquer les cartes selon le groupe sélectionné
                    cards.forEach(card => {
                        if (selectedGroupe === 'all' || card.getAttribute('data-groupe') === selectedGroupe) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });
        });

        function openImageModal(imageSrc, imageAlt) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            
            modalImage.src = imageSrc;
            modalImage.alt = imageAlt;
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            // Fermer la modale en cliquant en dehors de l'image
            modal.onclick = function(e) {
                if (e.target === modal) {
                    closeImageModal();
                }
            }

            // Fermer la modale avec la touche Echap
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeImageModal();
                }
            });
        }

        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</x-app-layout>
