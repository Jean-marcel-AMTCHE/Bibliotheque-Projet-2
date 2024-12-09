@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-5">Messages des utilisateurs</h1>

    @if($messages->isEmpty())
        <div class="alert alert-info" role="alert">
            Aucun message n'a été reçu pour le moment.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Nom</th>
                        <th>Email</th>
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
                            <td>{{ $message->name }}</td>
                            <td>{{ $message->email }}</td>
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
                                @if(!$message->read)
                                    <form action="{{ route('messages.markAsRead', $message) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-success">
                                            <i class="fas fa-check me-1"></i>Marquer comme lu
                                        </button>
                                    </form>
                                @endif
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#messageModal{{ $message->id }}">
                                    <i class="fas fa-eye me-1"></i>Voir
                                </button>
                                <form action="{{ route('messages.destroy', $message) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')">
                                        <i class="fas fa-trash-alt me-1"></i>Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal pour afficher le message complet -->
                        <div class="modal fade" id="messageModal{{ $message->id }}" tabindex="-1" aria-labelledby="messageModalLabel{{ $message->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="messageModalLabel{{ $message->id }}">Message de {{ $message->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Sujet:</strong> {{ $message->subject }}</p>
                                        <p><strong>Message:</strong></p>
                                        <p>{{ $message->message }}</p>
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

