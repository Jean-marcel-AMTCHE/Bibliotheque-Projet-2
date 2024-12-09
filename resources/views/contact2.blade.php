@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-5">Mes Messages</h1>

    @if($messages->isEmpty())
        <div class="alert alert-info" role="alert">
            Vous n'avez envoyé aucun message pour le moment.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Sujet</th>
                        <th>Message</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($messages as $message)
                        <tr>
                            <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $message->subject }}</td>
                            <td>{{ Str::limit($message->message, 50) }}</td>
                            <td>
                                @if($message->read)
                                    <span class="badge bg-success">Lu</span>
                                @else
                                    <span class="badge bg-warning text-dark">Non lu</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#messageModal{{ $message->id }}">
                                    <i class="fas fa-eye me-1"></i>Voir
                                </button>
                            </td>
                        </tr>

                        <!-- Modal pour afficher le message complet -->
                        <div class="modal fade" id="messageModal{{ $message->id }}" tabindex="-1" aria-labelledby="messageModalLabel{{ $message->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="messageModalLabel{{ $message->id }}">Message envoyé le {{ $message->created_at->format('d/m/Y H:i') }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Sujet:</strong> {{ $message->subject }}</p>
                                        <p><strong>Message:</strong></p>
                                        <p>{{ $message->message }}</p>
                                        <p><strong>Statut:</strong> 
                                            @if($message->read)
                                                <span class="badge bg-success">Lu par l'administrateur</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Non lu par l'administrateur</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $messages->links() }}
        </div>
    @endif
</div>

<style>
    .table th, .table td {
        vertical-align: middle;
    }
    .btn {
        border-radius: 20px;
        padding: 5px 10px;
    }
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .badge {
        font-size: 0.8em;
        padding: 0.5em 0.7em;
    }
</style>
@endsection

