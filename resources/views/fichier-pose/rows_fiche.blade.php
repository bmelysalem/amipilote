<table class="full-width">
    <!-- Header section -->
    <tr>
        <td class="left">
            <p class="center bold">SOMELEC / CSMTN <br> Projet CI</p>
        </td>
        <td colspan="2" class="center">
            <h1>Fiche de pose Compteur Intelligent</h1>
            <h2>{{$fiche->abonne->ETAT_ABONNE == 9 ? 'Création 10E':($fiche->abonne->ETAT_ABONNE == 3 ?'Succession 20E':'Changement')}}</h2>
        </td>
        <td class="right">
            <p>Date : {{ now()->format('d/m/Y') }}</p>
        </td>
    </tr>

    <!-- Program and ID information -->
    <tr>
        <td>
            <label>Programme ID</label>
            <div class="field bordered">{{ $fiche->idprogrammes }}</div>
        </td>
        <td>
            <label>ID Fiche</label>
            <div class="field bordered">{{ $fiche->idprogemesdet }}</div>
        </td>
        <td class="right">
            <label>Date de pose</label>
            <div class="field bordered">{{ '..../..../.......' }}</div>
        </td>
    </tr>

    <!-- Reference and Address information -->
    <tr>
        <td>
            <label>Reference</label>
            <div class="field bordered">{{ $abonne->ETAT_ABONNE == 3 ? $abonne->successeur : $fiche->REFERENCE }}</div>
        </td>
        <td>
            <label>ADRESSE FAB</label>
            <div class="field bordered">{{ $abonne->ADRESSE }}</div>
        </td>
        <td>
            <label>GROUPE</label>
            <div class="field bordered">{{ $abonne->GROUPE }}</div>
        </td>
    </tr>

    <!-- Name and Site Address -->
    <tr>
        <td colspan="2">
            <label>NOM</label>
            <div class="field bordered">{{ $abonne->NOM }}</div>
        </td>
        <td>
            <label>ADRESSE SITE</label>
            <div class="emptyfield2 bordered">{{ ' ' }}</div>
        </td>
    </tr>

    <!-- Phone and Consumption -->
    <tr>
        <td>
            <label>TELEPHONES</label>
            <div class="field bordered">{{ $abonne->TELEPHONE_01 }}</div>
        </td>
        <td>
            <label>NB Estimations</label>
            <div class="field bordered">{{ $abonne->NOMBRE_ESTIMATION }}</div>
        </td>
        <td>
            <label>Moy Consomation</label>
            <div class="field bordered">{{ $abonne->TELEPHONE_01 }}</div>
        </td>
    </tr>

    <!-- Mutations and Balance -->
    <tr>
        <td>
            <label>Der.Mut</label>
            <div class="field bordered">{{ ' '}}</div>
            <div class="field bordered">{{ '____/____/_______' }}</div>
            <label>Der.Mut</label>
            <div class="field bordered">{{ ' ' }}</div>
            <div class="field bordered">{{ '____/____/_______' }}</div>
        </td>
        <td class="center">
            <label class="bold">SOLDE</label>
            <div class="field bordered">{{ $abonne->SOLDE }}</div>
        </td>
        <td>
            <label>Qte Estim</label>
            <div class="field bordered">{{ $abonne->QTE_ESTIMEE }}</div>
            <label>MT Estim</label>
            <div class="field bordered">{{ $abonne->MONTANT_ESTIME }}</div>
        </td>
    </tr>

    <!-- Counter Information -->
    <tr>
        <td>
            <label>Ancien Compteur (FAB)</label>
            <div class="field bordered">{{  $abonne->ETAT_ABONNE == 3? '999999': $abonne->COMPTEUR}}</div>
            <label>Type Compteur (M / T)</label>
            <div class="field bordered">{{ substr($abonne->CODE_BRANCHEMENT, 0, 1) == '4' ? 'T':'M' }}</div>
        </td>
        <td>
            <label>INDEX (FAB)</label>
            <div class="field bordered">{{ $abonne->INDEXE}}</div>
            <label>INDEX POSE</label>
            <div class="emptyfield bordered">{{ ' ' }}</div>
        </td>
        <td>
            <div style="display: flex; justify-content: space-between;">
                <div>
                    <label>PS (FAB)</label>
                    <div class="field bordered">{{ $abonne->PS}}</div>
                </div>
                <div>
                    <label>TARIF (FAB)</label>
                    <div class="field bordered">{{ (!isset($abonne->TARIF)||(trim($abonne->TARIF)=='')) ?  '5106' : trim($abonne->TARIF) }}</div>
                </div>
            </div>
            <label class="bold">PS SITE</label>
            <div class="emptyfield bordered">{{ ' ' }}</div>
        </td>
    </tr>

    <!-- Image -->
    <tr>
        <td colspan="3">
            <img style="width: 100%" src="{{public_path('images/image.png')}}" alt="">
        </td>
    </tr>
</table>
