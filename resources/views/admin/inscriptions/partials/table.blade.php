<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle text-center">
        <thead class="table-dark">
            <tr>
                <th>Étudiant</th>
                <th>Formation</th>
                <th>Date</th>
                <th>Admin</th>
                <th>Pédagogique</th>
                <th>État</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($inscriptions as $inscription)
                <tr>
                    <td>{{ $inscription->etudiant?->name ?? 'Non défini' }}</td>
                    <td>{{ $inscription->formation?->titre ?? 'Non défini' }}</td>
                    <td>{{ $inscription->created_at->format('d/m/Y') }}</td>

                    {{-- Validation Admin --}}
                    <td>
                        @if($inscription->valide_admin)
                            <span class="badge bg-success">✓ Validé</span><br>
                            <small>Par: {{ $inscription->adminValidator?->name ?? 'Admin' }}</small><br>
                            <small>Le: {{ $inscription->date_validation_admin?->format('d/m/Y H:i') }}</small>
                        @elseif(Auth::user()->role === 'responsable administratif')
                            <form method="POST" action="{{ route('admin.valider.admin', $inscription->id) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm rounded-pill px-3 shadow-sm mb-1">
                                    <i class="fas fa-check-circle me-1"></i> Valider
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.refuser.admin', $inscription->id) }}" class="d-inline ms-2">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm rounded-pill px-3 shadow-sm mb-1">
                                    <i class="fas fa-times-circle me-1"></i> Refuser
                                </button>
                            </form>
                        @else
                            <span class="text-warning">En attente</span>
                        @endif
                    </td>

                    {{-- Validation Pédagogique --}}
                    <td>
                        @if($inscription->valide_pedagogique)
                            <span class="badge bg-success">✓ Validé</span><br>
                            <small>Par: {{ $inscription->pedagogiqueValidator?->name ?? 'Responsable' }}</small><br>
                            <small>Le: {{ $inscription->date_validation_pedagogique?->format('d/m/Y H:i') }}</small>
                        @elseif(Auth::user()->role === 'responsable pedagogique' && $inscription->valide_admin)
                            <form method="POST" action="{{ route('pedagogique.valider.pedagogique', $inscription->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm rounded-pill px-3 shadow-sm">
                                    <i class="fas fa-check-circle me-1"></i> Valider
                                </button>
                            </form>
                        @else
                            <span class="text-warning">En attente</span>
                        @endif
                    </td>

                    {{-- État global --}}
                    <td>
                        @if($inscription->valide_admin && $inscription->valide_pedagogique)
                            <span class="badge bg-success px-3 py-2">Dossier validé</span>
                        @elseif($inscription->valide_admin)
                            <span class="badge bg-info text-dark px-3 py-2">Validé par l'admin</span>
                        @elseif($inscription->etat === 'refuse')
                            <span class="badge bg-danger px-3 py-2">Refusé</span>
                        @else
                            <span class="badge bg-warning text-dark px-3 py-2">En attente</span>
                        @endif
                    </td>

                    {{-- Actions --}}
                    <td> 
                        <div class="btn-group btn-group-sm" role="group" aria-label="Actions">
                            <a href="{{ route('admin.etudiant.profil', $inscription->user_id) }}" class="btn btn-outline-info rounded-pill px-3 shadow-sm" title="Voir le profil">
                                <i class="fas fa-eye"></i> Profil
                            </a>
                            @if(Auth::user()->role === 'responsable administratif')
                                <form method="POST" action="{{ route('admin.inscriptions.destroy', $inscription->id) }}" class="d-inline" onsubmit="return confirm('Voulez-vous vraiment supprimer cette inscription ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger rounded-pill px-3 shadow-sm" title="Supprimer">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-muted">Aucune inscription trouvée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>