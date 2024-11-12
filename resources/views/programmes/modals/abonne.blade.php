<div class="modal fade" id="abonneModal{{ $detail->REFERENCE }}" tabindex="-1"
    aria-labelledby="abonneModalLabel{{ $detail->REFERENCE }}" aria-hidden="true">
   <div class="modal-dialog modal-lg"> <!-- Classe modal-lg pour élargir la taille -->
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title" id="abonneModalLabel{{ $detail->REFERENCE }}">Détails de l'Abonné</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
           </div>
           <div class="modal-body">

               <!-- Section CRM Somelec -->
               <h5>Informations CRM Somelec</h5>
               @isset($detail->abonne)
                   <p><strong>Nom :</strong> {{ $detail->abonne->NOM }}</p>
                   <p><strong>Adresse :</strong> {{ $detail->abonne->ADRESSE }}</p>
                   <p><strong>Complément d'Adresse :</strong> {{ $detail->abonne->ADRESSE_COMPL }}</p>
                   <p><strong>Téléphone :</strong> {{ $detail->abonne->TELEPHONE_01 }}</p>
                   <p><strong>Email :</strong> {{ $detail->abonne->MAIL }}</p>
                   <p><strong>Tarif :</strong> {{ $detail->abonne->TARIF }}</p>
                   <p><strong>Groupe :</strong> {{ $detail->abonne->GROUPE }}</p>
                   <p><strong>Code Branchement :</strong> {{ $detail->abonne->CODE_BRANCHEMENT }}</p>
                   <p><strong>Compteur :</strong> {{ $detail->abonne->COMPTEUR }}</p>
                   <p><strong>Latitude :</strong> {{ $detail->abonne->LATITUDE }}</p>
                   <p><strong>Longitude :</strong> {{ $detail->abonne->LONGITUDE }}</p>
               @endisset

               <!-- Section ChangementsLocal (Akilee) -->
               @isset($detail->changementLocal)
                   <hr>
                   <h5>Informations Changements Local (Akilee)</h5>
                   <p><strong>Adresse Site :</strong> {{ $detail->changementLocal->ak_adresse_site }}</p>
                   <p><strong>Compteur sur Site :</strong> {{ $detail->changementLocal->ak_compteur_sur_site }}</p>
                   <p><strong>Type de Fraude :</strong> {{ $detail->changementLocal->ak_type_fraude }}</p>
                   <p><strong>GPS Latitude :</strong> {{ $detail->changementLocal->ak_gps_lat }}</p>
                   <p><strong>GPS Longitude :</strong> {{ $detail->changementLocal->ak_gps_long }}</p>
                   <!-- Ajoute d'autres champs nécessaires provenant de ChangementsLocal -->
               @endisset

               <!-- Section Nouvabnt (Akilee) -->
               @if($detail->nouvabnt() != null)
                   <hr>
                   <h5>Informations Nouvabnt (Akilee) : Mutation ( {{ $detail->nouvabnt()->type_mutation }}) | $detail->nouvabnt()->statut</h5>
                   <p><strong>Reference :</strong> {{ $detail->nouvabnt()->REFERENCE }}</p>
                   <p><strong>Adresse :</strong> {{ $detail->nouvabnt()->Adresse }}</p>
                   <p><strong>Type de Branchement :</strong> {{ $detail->nouvabnt()->TYPE_BRANCHEMENT }}</p>
                   <p><strong>Compteur :</strong> {{ $detail->nouvabnt()->Compteur }}</p>
                   <p><strong>Date de Pose :</strong> {{ $detail->nouvabnt()->DATEPOSE }}</p>
                   <p><strong>Tarif :</strong> {{ $detail->nouvabnt()->TARIF }}</p>
                   <p><strong>Observations :</strong> {{ $detail->nouvabnt()->OBSERVATIONS }}</p>
                   <p><strong>PS :</strong> {{ $detail->nouvabnt()->PS }}</p>
                   <!-- Ajoute d'autres champs nécessaires provenant de Nouvabnt -->
               @endif
           </div>
           <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
           </div>
       </div>
   </div>
</div>
