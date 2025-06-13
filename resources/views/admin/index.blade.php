@extends('base')

@section('admin.nav')
<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.statistics') }}"
        style="color: rgba(255,255,255,0.8); font-weight: 500; padding: 0.5rem 1rem; border-radius: 8px; transition: all 0.3s ease;">Statistiques</a>
</li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.settings') }}"
            style="color: rgba(255,255,255,0.8); font-weight: 500; padding: 0.5rem 1rem; border-radius: 8px; transition: all 0.3s ease;">Paramètres</a>
    </li>


    
@endsection



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
                    <div class="stat-number" id="openTickets">{{ $openTickets }}</div>
                    <div class="stat-label">Tickets Ouverts</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" id="closedTickets">{{ $closedTickets }}</div>
                    <div class="stat-label">Tickets En Cours</div>
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
                            <form method="GET" action="{{ route('admin.dashboard') }}" id="searchForm">
                                <input type="text" id="ticketSearch" class="search-input"
                                    placeholder="Rechercher un ticket..." name="ticket_search"
                                    value="{{ request('ticket_search') ?? '' }}">
                                <input type="hidden" name="search_status" id="searchStatus"
                                    value="{{ request('search_status') ?? '' }}">
                                <button type="submit"><i class="fas fa-search search-icon"></i></button>
                            </form>
                            <div class="search-note">
                                <i class="fas fa-info-circle"></i>
                                Recherche par titre, description, status, priorité ou type.
                            </div>
                        </div>
                    </div>
                    <div class="status-filter">
                        <button
                            class="filter-btn {{ request('search_status') == '' || !request('search_status') ? 'active' : '' }}"
                            data-status="" onclick="updateStatusFilter('')">
                            <i class="fas fa-filter"></i> Tous
                        </button>
                        <button class="filter-btn {{ request('search_status') == 'ouvert' ? 'active' : '' }}"
                            data-status="ouvert" onclick="updateStatusFilter('ouvert')">
                            <i class="fas fa-folder-open"></i> Ouvert
                        </button>
                        <button class="filter-btn {{ request('search_status') == 'fermé' ? 'active' : '' }}"
                            data-status="fermé" onclick="updateStatusFilter('fermé')">
                            <i class="fas fa-check-circle"></i> Fermé
                        </button>
                        <button class="filter-btn {{ request('search_status') == 'en_cours' ? 'active' : '' }}"
                            data-status="en_cours" onclick="updateStatusFilter('en_cours')">
                            <i class="fas fa-spinner fa-spin"></i> En cours
                        </button>
                        <button class="filter-btn {{ request('search_status') == 'en_attente' ? 'active' : '' }}"
                            data-status="en_attente" onclick="updateStatusFilter('en_attente')">
                            <i class="fas fa-clock"></i> En attente
                        </button>
                        <button class="filter-btn {{ request('search_status') == 'annulé' ? 'active' : '' }}"
                            data-status="annulé" onclick="updateStatusFilter('annulé')">
                            <i class="fas fa-times-circle"></i> Annulé
                        </button>
                    </div>
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
                            @forelse ($tickets as $ticket)
                                <tr style="cursor: pointer;">
                                    <td align="center" onclick="openShowTicketModal('{{ $ticket->id }}')" >{{ $loop->index + 1 }}</td>
                                    <td align="center" onclick="openShowTicketModal('{{ $ticket->id }}')">{{ $ticket->project->name }}</td>
                                    <td align="center" onclick="openShowTicketModal('{{ $ticket->id }}')">{{ $ticket->module->name }}</td>
                                    <td align="center" onclick="openShowTicketModal('{{ $ticket->id }}')">{{ $ticket->title }}</td>
                                    <td align="center" onclick="openShowTicketModal('{{ $ticket->id }}')">{{ Str::limit($ticket->description, 50) }}</td>
                                    <td align="center" onclick="openShowTicketModal('{{ $ticket->id }}')"><span
                                            class="status {{ strtolower($ticket->status) }}">{{ $ticket->status }}</span>
                                    </td>
                                    <td align="center" onclick="openShowTicketModal('{{ $ticket->id }}')"><span
                                            class="type {{ strtolower($ticket->type) }}">{{ $ticket->type }}</span></td>
                                    <td align="center" onclick="openShowTicketModal('{{ $ticket->id }}')"><span
                                            class="priority {{ strtolower($ticket->priority) }}">{{ $ticket->priority }}</span>
                                    </td>
                                    <td align="center" onclick="openShowTicketModal('{{ $ticket->id }}')"><span
                                            class="date">{{ $ticket->created_at->format('d/m/Y') }}</span></td>
                                    <td align="center" class="actions">
                                        <select class="action-btn edit-btn status-select"
                                            onchange="updateTicketStatus('{{ $ticket->id }}', this.value)"
                                            style="
                                            padding: 6px 12px;
                                            border-radius: 4px;
                                            border: 1px solid #e2e8f0;
                                            font-size: 0.875rem;
                                            cursor: pointer;
                                            transition: all 0.2s ease;
                                            min-width: 120px;
                                        ">
                                            <option value="ouvert" style="color: #059669;"
                                                {{ $ticket->status == 'ouvert' ? 'selected' : '' }}>Ouvert</option>
                                            <option value="fermé" style="color: #dc2626;"
                                                {{ $ticket->status == 'fermé' ? 'selected' : '' }}>Fermé</option>
                                            <option value="en_cours" style="color: #2563eb;"
                                                {{ $ticket->status == 'en_cours' ? 'selected' : '' }}>En cours</option>
                                            <option value="en_attente" style="color: #d97706;"
                                                {{ $ticket->status == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                            <option value="annulé" style="color: #6b7280;"
                                                {{ $ticket->status == 'annulé' ? 'selected' : '' }}>Annulé</option>
                                        </select>
                                        <button class="action-btn delete-btn"
                                            onclick="deleteTicket('{{ $ticket->id }}')">Supprimer</button>
                                    </td>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4"
                                        style="color: #6b7280; font-size: 1.1rem;">
                                        <i class="fas fa-ticket-alt mb-2" style="font-size: 2rem; color: #9ca3af;"></i>
                                        <p>Aucun ticket trouvé</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pagination-container"
                        style="margin-top: 20px; display: flex; justify-content: center; align-items: center;">
                        <div class="pagination-wrapper"
                            style="background: white; padding: 10px 20px; border-radius: 8px;">
                            {{ $tickets->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fenêtre modale pour afficher un ticket -->
    @include('admin.showTicket')
@endsection

<script>
    function updateTicketStatus(ticketId, status) {
        try {
            fetch(`/admin/updateTicketStatus/${ticketId}/${status}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    // flash('Erreur lors de la mise à jour du ticket', 'error');
                });
        } catch (error) {
            console.error('Erreur:', error);
            // flash('Erreur lors de la mise à jour du ticket', 'error');
        }
    }

    function updateStatusFilter(status) {
        document.getElementById('searchStatus').value = status;
        document.getElementById('searchForm').submit();
    }

    function deleteTicket(ticketId) {
        if (confirm('Êtes-vous sûr de vouloir supprimer ce ticket ?')) {
            window.location.href = `/admin/deleteTicket/${ticketId}`;
        }
    }

    function openShowTicketModal(ticketId) {
        document.getElementById('showTicketModal').style.display = 'block';
        document.body.style.overflow = 'hidden';

        // Reset image previews
        document.getElementById('currentImagePreview').style.display = 'none';

        fetch(`/admin/getTicket/${ticketId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const ticket = data.ticket;
                    const user = data.user[0];
                    document.getElementById('editTicketId').value = ticket.id;
                    document.getElementById('editTitle').value = ticket.title;
                    document.getElementById('editDescription').value = ticket.description;
                    document.getElementById('editProject').value = ticket.project_id;
                    document.getElementById('editModule').value = ticket.module_id;
                    document.getElementById('editStatus').value = ticket.status;
                    document.getElementById('editType').value = ticket.type;
                    document.getElementById('editPriority').value = ticket.priority;
                    document.getElementById('ticketUser').textContent = user.name;

                    // Show current image if exists
                    if (ticket.image) {
                        const currentImagePreview = document.getElementById('currentImagePreview');
                        const currentImage = document.getElementById('currentImage');
                        currentImage.src = `/images/tickets/${ticket.image}`;
                        currentImagePreview.style.display = 'block';
                    }

                } else {
                    alert('Erreur lors de la récupération du ticket');
                    closeShowTicketModal();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erreur lors de la récupération du ticket');
                closeShowTicketModal();
            });
    }

    function closeShowTicketModal() {
        document.getElementById('showTicketModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }
</script>
