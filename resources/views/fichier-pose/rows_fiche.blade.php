<!-- Entête avec la date à gauche et SOMELEC / CSMTN à droite -->
<div class="row bordered">

    <div class="left">
        <p class="center bold">SOMELEC / CSMTN <br> Projet CI</p>
    </div>
    <div class="right">
        <p>Date : {{ now()->format('d/m/Y') }}</p>
    </div>
    <div class="cnter">
        <h1 class="center">Fiche de pose Compteur Intelligent</h1>
        <h2>{{$fiche->abonne->ETAT_ABONNE == 9 ? 'Création 10E':($fiche->abonne->ETAT_ABONNE == 3 ?'Succession 20E':'Changement')}}</h2>
    </div>
    <div class="clear"></div>
</div>

<div class="row">
    <div class="left">
        <div class="left "><label>Programme ID</label>
            <div class="field bordered">{{ $fiche->idprogrammes }}</div>
        </div>
    </div>
    <div class="left ml20">
        <div class="left "><label>ID Fiche</label>
            <div class="field bordered">{{ $fiche->idprogemesdet }}</div>
        </div>
    </div>
    <div class="right">
        <div class="left "><label>Date de pose</label>
            <div class="field bordered">{{ '..../..../.......' }}</div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<div class="row">
    <div class="left">
        <div class="left "><label>Reference</label>
            <div class="field bordered">{{ $fiche->REFERENCE }}</div>
        </div>
    </div>
    <div class="right">
        <div class="left "><label>ADRESSE FAB</label>
            <div class="field bordered">{{ $abonne->ADRESSE }}</div>
        </div>
    </div>
    <div class="right mr20">
        <div class="left "><label>GROUPE</label>
            <div class="field bordered">{{ $abonne->GROUPE }}</div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<div class="row">
    <div class="left">
        <div class="left "><label>NOM</label>
            <div class="field bordered">{{ $abonne->NOM }}</div>
        </div>
    </div>
    <div class="right">
        <div class="left "><label>ADRESSE SITE</label>
            <div class="emptyfield2 bordered">{{ ' ' }}</div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<div class="row">
    <div class="left">
        <div class="left "><label>TELEPHONES</label>
            <div class="field bordered">{{ $abonne->REFERENCE }}</div>
        </div>
    </div>
    <div class="right">
        <div class="left "><label>NB Estimations</label>
            <div class="field bordered">{{ $abonne->NOMBRE_ESTIMATION }}</div>
        </div>
    </div>
    <div class="right mr20">
        <div class="left "><label>Moy Consomation</label>
            <div class="field bordered">{{ $abonne->TELEPHONE_01 }}</div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<div class="row mb5">
    <div class="left">
        <div>
            <div class="left mb5"><label>Der.Mut</label>
                <div class="field bordered">{{ ' '}}</div>
                <div class="field bordered">{{ '____/____/_______' }}</div>
            </div>
            <div class="clear"></div>
        </div>
        <div>
            <div class="left "><label>Der.Mut</label>
                <div class="field bordered">{{ ' ' }}</div>
                <div class="field bordered">{{ '____/____/_______' }}</div>
            </div>
            <div class="clear"></div>
        </div>
    </div>

    <div class="left " style="margin: 5px auto">
        <div class="left bold ml20"><label>SOLDE</label>
            <div class="field bordered">{{ $abonne->SOLDE }}</div>
        </div>
    </div>
    <div class="right">
        <div>
            <div class="left mb5"><label>Qte Estim</label>
                <div class="field bordered">{{ $abonne->QTE_ESTIMEE }}</div>
            </div>
            <div class="clear"></div>
        </div>
        <div>
            <div class="left "><label>MT  Estim</label>
                <div class="field bordered">{{ $abonne->MONTANT_ESTIME  }}</div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<div class="row" style="margin-top: 25px">
    <div class="left">
        <div>
            <div class="left mb5"><label style="width: 80px">Ancien Compteur (FAB) </label>
                <div class="field bordered">{{ $abonne->COMPTEUR}}</div>
            </div>
            <div class="clear"></div>
        </div>
        <div>
            <div class="left " ><label style="width: 80px">Type Compteur (M / T) </label>
                <div class="field bordered">{{ substr($abonne->CODE_BRANCHEMENT, 0, 1) == '4' ? 'T':'M' }}</div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="left">
        <div>
            <div class="left mb5"><label style="width: 80px">INDEX (FAB) </label>
                <div class="field bordered">{{ $abonne->INDEXE}}</div>
            </div>
            <div class="clear"></div>
        </div>
        <div>
            <div class="left " ><label style="width: 80px">INDEX POSE </label>
                <div class="emptyfield bordered">{{ ' ' }}</div>
            </div>
            <div class="clear"></div>
        </div>
    </div>

    <div class="right">
        <div class="mb5">
            <div class="right "><label>PS (FAB) </label>
                <div class="field bordered">{{ $abonne->PS}}</div>
            </div>
            <div class="right"><label>TARIF (FAB) </label>
                <div class="field bordered">{{ (isset($abonne->TARIF) &&  $abonne->TARIF!='') ? $abonne->TARIF : '5106'}}</div>
            </div>
            <div class="clear"></div>
        </div>
        <div>
            <div class="right bold" ><label>PS SITE </label>
                <div class="emptyfield bordered">{{ ' ' }}</div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<div class="row">
    <img style="width: 100%;margin-top:20px" src="{{public_path('images/image.png')}}" alt="">
</div>
