@foreach ($documents as $document)
    <tr>
        <td>{{ $document->name }}</td>
        <td>
            <a href="{{ route('documents.stream', $document->id) }}" class="btn btn-primary">Télécharger</a>
        </td>
    </tr>
@endforeach 