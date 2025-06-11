@extends('base')

@section('admin.nav')
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
                    <div class="stat-number" id="totalTickets"> </div>
                    <div class="stat-label">Total des Tickets</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" id="openTickets"> </div>
                    <div class="stat-label">Tickets Ouverts</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" id="closedTickets"> </div>
                    <div class="stat-label">Tickets En Cours</div>
                </div>
            </div>

            <!-- Section des tickets ouverts -->
            <div class="open-tickets">
                <h2 class="section-title">Tickets Ouverts</h2>
                <div class="open-tickets-grid" id="openTicketsGrid">

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

                        </tbody>
                    </table>
                    <div class="pagination-container"
                        style="margin-top: 20px; display: flex; justify-content: center; align-items: center;">
                        <div class="pagination-wrapper" style="background: white; padding: 10px 20px; border-radius: 8px;">
                            {{-- {{ $allTickets->links() }} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection