@extends('base')

@section('content')
    <!-- Conteneur principal -->
    <div class="">
        <!-- Contenu principal -->
        <div class="main-content">
            <!-- Statistiques du tableau de bord -->
            <div class="stats">
                <div class="stat-card">
                    <div class="stat-number" id="totalTickets">{{ $totalTickets }}</div>
                    <div class="stat-label">Total des Tickets</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" id="openTickets">{{ $totalOpenTickets }}</div>
                    <div class="stat-label">Tickets Ouverts</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" id="closedTickets">{{ $totalClosedTickets }}</div>
                    <div class="stat-label">Tickets Fermés</div>
                </div>
            </div>

            <!-- Section des tickets ouverts -->
            <div class="open-tickets">
                <h2 class="section-title">Tickets Ouverts</h2>
                <div class="open-tickets-grid" id="openTicketsGrid">
                    @forelse ($lastTickets as $ticket)
                        <div class="ticket-card">
                            <div class="ticket-id">{{ $ticket->id }}</div>
                            <div class="ticket-description">{{ $ticket->description }}</div>
                            <div class="ticket-meta">
                                <span>{{ $ticket->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted" style="font-size: 1.1rem;">Aucun ticket ouvert</p>
                    @endforelse
                </div>
            </div>

            <!-- Tableau de tous les tickets -->
            <div class="table-section">
                <div class="table-header">
                    <div class="header-left">
                        <h2 class="section-title">Tous les Tickets</h2>
                        <div class="search-container">
                            <form method="GET" action="{{ route('user.dashboard') }}">
                                <input type="text" id="ticketSearch" class="search-input"
                                    placeholder="Rechercher un ticket..." name="search"
                                    value="{{ request('search') ?? '' }}">
                                <button type="submit"><i class="fas fa-search search-icon"></i></button>
                            </form>
                            <div class="search-note">
                                <i class="fas fa-info-circle"></i>
                                Recherche par titre, description, status, priorité ou type.
                            </div>
                        </div>

                    </div>
                    <button class="add-ticket-btn" onclick="openModal()">
                        <span>➕</span> Ajouter un ticket
                    </button>
                </div>
                <div class="table-container">
                    <table id="ticketsTable">
                        <thead>
                            <tr>
                                <th style="text-align: center;">N Ticket</th>
                                <th style="text-align: center;">Projet</th>
                                <th style="text-align: center;">Module</th>
                                <th style="text-align: center;">Titre</th>
                                <th style="text-align: center;">Description</th>
                                <th style="text-align: center;">Status</th>
                                <th style="text-align: center;">Type</th>
                                <th style="text-align: center;">Priorité</th>
                                <th style="text-align: center;">Date de soumission</th>
                                <th style="text-align: center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="ticketsTableBody">
                            @forelse ($allTickets as $ticket)
                                <tr>
                                    <td align="center">{{ $loop->index + 1 }}</td>
                                    <td align="center">{{ $ticket->project->name }}</td>
                                    <td align="center">{{ $ticket->module->name }}</td>
                                    <td align="center">{{ $ticket->title }}</td>
                                    <td align="center">{{ Str::limit($ticket->description, 50) }}</td>
                                    <td align="center"><span
                                            class="status {{ strtolower($ticket->status) }}">{{ $ticket->status }}</span>
                                    </td>
                                    <td align="center"><span
                                            class="type {{ strtolower($ticket->type) }}">{{ $ticket->type }}</span></td>
                                    <td align="center"><span
                                            class="priority {{ strtolower($ticket->priority) }}">{{ $ticket->priority }}</span>
                                    </td>
                                    <td align="center"><span
                                            class="date">{{ $ticket->created_at->format('d/m/Y') }}</span></td>
                                    <td align="center" class="actions">
                                        <button class="action-btn edit-btn"
                                            onclick="openEditModal('{{ $ticket->id }}')">Modifier</button>
                                        <button class="action-btn delete-btn"
                                            onclick="deleteTicket('{{ $ticket->id }}')">Supprimer</button>
                                    </td>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4" style="color: #6b7280; font-size: 1.1rem;">
                                        <i class="fas fa-ticket-alt mb-2" style="font-size: 2rem; color: #9ca3af;"></i>
                                        <p>Aucun ticket trouvé</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pagination-container"
                        style="margin-top: 20px; display: flex; justify-content: center; align-items: center;">
                        <div class="pagination-wrapper" style="background: white; padding: 10px 20px; border-radius: 8px;">
                            {{ $allTickets->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bouton d'action flottant -->
    <button class="fab" onclick="openModal()" title="Ajouter un nouveau ticket">
        ➕
    </button>

    <!-- Fenêtre modale pour ajouter un nouveau ticket -->
    @include('user.addTicket')

    <!-- Fenêtre modale pour modifier un ticket -->
    @include('user.editTicket')
@endsection


<script>
    function deleteTicket(ticketId) {
        if (confirm('Êtes-vous sûr de vouloir supprimer ce ticket ?')) {
            window.location.href = `/user/deleteTicket/${ticketId}`;
        }
    }

    function openEditModal(ticketId) {
        document.getElementById('ticketModalUpdate').style.display = 'block';
        document.body.style.overflow = 'hidden';

        // Reset image previews
        // document.getElementById('currentImagePreview').style.display = 'none';
        // document.getElementById('newImagePreview').style.display = 'none';
        // document.getElementById('fileLabel').textContent = 'Cliquez pour sélectionner une image';

        fetch(`/user/getTicket/${ticketId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const ticket = data.ticket;

                    document.getElementById('editTicketId').value = ticket.id;
                    document.getElementById('editTitle').value = ticket.title;
                    document.getElementById('editDescription').value = ticket.description;
                    document.getElementById('editProject').value = ticket.project_id;
                    document.getElementById('editModule').value = ticket.module_id;
                    document.getElementById('editStatus').value = ticket.status;
                    document.getElementById('editType').value = ticket.type;
                    document.getElementById('editPriority').value = ticket.priority;

                    // Show current image if exists
                    // if (ticket.image) {
                    //     const currentImagePreview = document.getElementById('currentImagePreview');
                    //     const currentImage = document.getElementById('currentImage');
                    //     currentImage.src = `/images/tickets/${ticket.image}`;
                    //     currentImagePreview.style.display = 'block';
                    // }

                    document.getElementById('editTicketForm').action = `/user/updateTicket/${ticket.id}`;
                } else {
                    alert('Erreur lors de la récupération du ticket');
                    closeEditModal();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erreur lors de la récupération du ticket');
                closeEditModal();
            });
    }

    // function previewNewImage(input) {
    //     const fileLabel = document.getElementById('fileLabel');
    //     const newImagePreview = document.getElementById('newImagePreview');
    //     const previewImage = document.getElementById('previewImage');

    //     if (input.files && input.files[0]) {
    //         const reader = new FileReader();

    //         reader.onload = function(e) {
    //             previewImage.src = e.target.result;
    //             newImagePreview.style.display = 'block';
    //             fileLabel.textContent = input.files[0].name;
    //         }

    //         reader.readAsDataURL(input.files[0]);
    //     } else {
    //         newImagePreview.style.display = 'none';
    //         fileLabel.textContent = 'Cliquez pour sélectionner une image';
    //     }
    // }

    function closeEditModal() {
        document.getElementById('ticketModalUpdate').style.display = 'none';
        document.body.style.overflow = 'auto';
    }
</script>
