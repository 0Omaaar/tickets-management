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
                    <h2 class="section-title">Tous les Tickets</h2>
                    <button class="add-ticket-btn" onclick="openModal()">
                        <span>➕</span> Ajouter un ticket
                    </button>
                </div>
                <div class="table-container">
                    <table id="ticketsTable">
                        <thead>
                            <tr>
                                <th>N Ticket</th>
                                <th>Projet</th>
                                <th>Module</th>
                                <th>Titre</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Type</th>
                                <th>Priorité</th>
                                <th>Date de soumission</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="ticketsTableBody">
                            @forelse ($allTickets as $ticket)
                                <tr>
                                    <td>{{ $ticket->id }}</td>
                                    <td>{{ $ticket->project->name }}</td>
                                    <td>{{ $ticket->module->name }}</td>
                                    <td>{{ $ticket->title }}</td>
                                    <td>{{ $ticket->description->limit(50) }}</td>
                                    <td><span class="status">{{ $ticket->status }}</span></td>
                                    <td>{{ $ticket->type }}</td>
                                    <td>{{ $ticket->priority }}</td>
                                    <td>{{ $ticket->created_at->format('d/m/Y') }}</td>
                                    <td class="actions">
                                        <button class="action-btn edit-btn" onclick="editTicket('{{ $ticket->id }}')">Modifier</button>
                                        <button class="action-btn delete-btn" onclick="deleteTicket('{{ $ticket->id }}')">Supprimer</button>
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
@endsection
