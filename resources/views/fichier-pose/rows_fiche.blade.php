<!-- Header section -->
<table class="full-width bordered">
    <tr>
        <td class="left">
            <p class="center bold">SOMELEC / CSMTN <br> Projet CI</p>
        </td>
        <td class="right">
            <p>Date : {{ now()->format('d/m/Y') }}</p>
        </td>
    </tr>
    <tr>
        <td colspan="2" class="center">
            <h1>Fiche de pose Compteur Intelligent</h1>
            <h2>{{$fiche->abonne->ETAT_ABONNE == 9 ? 'Création 10E':($fiche->abonne->ETAT_ABONNE == 3 ?'Succession 20E':'Changement')}}</h2>
        </td>
    </tr>
</table>

<!-- Program and ID information -->
<table class="full-width mt10">
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
</table>

<!-- Reference and Address information -->
<table class="full-width mt10">
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
</table>

<!-- Name and Site Address -->
<table class="full-width mt10">
    <tr>
        <td width="50%">
            <label>NOM</label>
            <div class="field bordered">{{ $abonne->NOM }}</div>
        </td>
        <td width="50%">
            <label>ADRESSE SITE</label>
            <div class="emptyfield2 bordered">{{ ' ' }}</div>
        </td>
    </tr>
</table>

<!-- Phone and Consumption -->
<table class="full-width mt10">
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
</table>

<!-- Mutations and Balance -->
<table class="full-width mt10">
    <tr>
        <td width="33%">
            <table class="full-width">
                <tr>
                    <td>
                        <label>Der.Mut</label>
                        <div class="field bordered">{{ ' '}}</div>
                        <div class="field bordered">{{ '____/____/_______' }}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Der.Mut</label>
                        <div class="field bordered">{{ ' ' }}</div>
                        <div class="field bordered">{{ '____/____/_______' }}</div>
                    </td>
                </tr>
            </table>
        </td>
        <td width="33%" class="center">
            <label class="bold">SOLDE</label>
            <div class="field bordered">{{ $abonne->SOLDE }}</div>
        </td>
        <td width="33%">
            <table class="full-width">
                <tr>
                    <td>
                        <label>Qte Estim</label>
                        <div class="field bordered">{{ $abonne->QTE_ESTIMEE }}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>MT Estim</label>
                        <div class="field bordered">{{ $abonne->MONTANT_ESTIME }}</div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<!-- Counter Information -->
<table class="full-width mt25">
    <tr>
        <td width="33%">
            <table class="full-width">
                <tr>
                    <td>
                        <label style="width: 80px">Ancien Compteur (FAB)</label>
                        <div class="field bordered">{{  $abonne->ETAT_ABONNE == 3? '999999': $abonne->COMPTEUR}}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label style="width: 80px">Type Compteur (M / T)</label>
                        <div class="field bordered">{{ substr($abonne->CODE_BRANCHEMENT, 0, 1) == '4' ? 'T':'M' }}</div>
                    </td>
                </tr>
            </table>
        </td>
        <td width="33%">
            <table class="full-width">
                <tr>
                    <td>
                        <label style="width: 80px">INDEX (FAB)</label>
                        <div class="field bordered">{{ $abonne->INDEXE}}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label style="width: 80px">INDEX POSE</label>
                        <div class="emptyfield bordered">{{ ' ' }}</div>
                    </td>
                </tr>
            </table>
        </td>
        <td width="33%">
            <table class="full-width">
                <tr>
                    <td>
                        <label>PS (FAB)</label>
                        <div class="field bordered">{{ $abonne->PS}}</div>
                    </td>
                    <td>
                        <label>TARIF (FAB)</label>
                        <div class="field bordered">{{ (!isset($abonne->TARIF)||(trim($abonne->TARIF)=='')) ?  '5106' : trim($abonne->TARIF) }}</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label class="bold">PS SITE</label>
                        <div class="emptyfield bordered">{{ ' ' }}</div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<!-- Image -->
<table class="full-width">
    <tr>
        <td>
            <img style="width: 100%;margin-top:20px" src="{{public_path('images/image.png')}}" alt="">
        </td>
    </tr>
</table>
