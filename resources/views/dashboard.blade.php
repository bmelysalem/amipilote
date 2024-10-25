<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header text-center bg-primary text-white">
                        <h3>Gestion des Programmes</h3>
                    </div>
                    <div class="card-body">
                        <p class="text-center fs-5">
                            Désormais, vous avez la possibilité d'ajouter les <strong>changements</strong>, les <strong>successions</strong> et les <strong>créations</strong>.
                        </p>

                        <h4 class="text-primary">Voici la liste des étapes :</h4>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">1 - Créer un programme.</li>
                            <li class="list-group-item">2 - Ajouter des abonnés au Programme.</li>
                            <li class="list-group-item">3 - Valider le programme.</li>
                            <li class="list-group-item">4 - Générer les fiches de pose pour les abonnés.</li>
                            <li class="list-group-item">5 - Télécharger les fiches générées (fichier PDF consolidé).</li>
                            <li class="list-group-item">6 - Enregistrer les changements dans Akilee.</li>
                        </ul>
                        <h4 class="text-primary">Informations supplémentaires :</h4>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Les nouveaux programmes sont désormais listés en haut de la liste.</li>
                            <li class="list-group-item">Désormais, l'application ouvre directement la page d'édition après la création du programme.</li>
                            <li class="list-group-item">Une fois un programme validé, il n'est plus possible d'y ajouter de nouveaux abonnés.</li>
                            <li class="list-group-item">Pour pouvoir télécharger les fiches, le programme doit d'abord être validé.</li>
                            <li class="list-group-item">Depuis la page d'édition d'un programme, le bouton "Je veux les autres étapes" vous dirige vers la page de gestion pour la validation et d'autres actions.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
