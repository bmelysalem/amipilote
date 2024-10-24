<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Fiches de Pose</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px }
        /* Les autres styles... */
        .page-break {
            page-break-after: always;
        }
    </style>
     <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px
        }
        .page-break {
            page-break-after: always;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        h1,
        h2,
        h3 {
            text-align: center;
            font-size: 1.1em
        }

        /* Style pour l'entête */
        .row {
            width: 100%;
            margin-bottom: 5px;
            padding: 2px 5px;
        }

        .row .left {
            float: left;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .row .right {
            float: right;
        }

        .clear {
            clear: both;
        }

        .bordered {
            border: 1px solid black;
            border-radius: 10px;
        }

        .field {
            display: inline;
            padding: 2px 20px;
        }

        .emptyfield {
            display: inline;
            padding: 2px 50px;
        }

        .emptyfield2 {
            display: inline;
            padding: 2px 100px;
        }

        .emptyfield3 {
            display: inline;
            padding: 2px 150px;
        }

        .emptyfield7 {
            display: inline;
            padding: 10px 350px;
        }

        .mr20 {
            margin-right: 20px
        }

        .ml20 {
            margin-left: 20px
        }
        .mb5 {
            margin-bottom: 5px
        }
        .mb10 {
            margin-bottom:10px
        }
        .m20 {
            margin-bottom:20px
        }
    </style>
</head>
<body>
    @php
        $i =1;
    @endphp
    @foreach($abonnes as $fiche)

        @if(isset($fiche->abonne))
            <!-- Inclusion des lignes de la fiche-pose pour chaque abonné -->
            @include('fichier-pose.rows_fiche', ['fiche' => $fiche, 'abonne' => $fiche->abonne])
        @else
            <p class="error">Erreur : Les informations de l'abonné ne sont pas disponibles.</p>
        @endif

        @if(!$loop->last)
            @php
                $i++;
            @endphp
            {{'Page : ' .$i}}
            <div class="page-break"></div> <!-- Insère un saut de page entre les fiches -->
        @endif
    @endforeach

</body>
</html>
