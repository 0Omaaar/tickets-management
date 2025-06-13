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
@section('title', 'Statistiques')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        background: #f8f9fc;
        min-height: 100vh;
        color: #5a5c69;
    }

    .dashboard-container {
        padding: 2rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    .header {
        background: #C88562;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        color: rgb(255, 255, 255);
        box-shadow: 0 4px 20px rgba(78, 115, 223, 0.3);
    }

    .header h1 {
        color: white;
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .breadcrumb {
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.9rem;
    }

    .breadcrumb a {
        color: white;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .breadcrumb a:hover {
        text-decoration: underline;
    }

    .section {
        margin-bottom: 3rem;
    }

    .section-title {
        color: #4e73df;
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        border-bottom: 2px solid #4e73df;
        padding-bottom: 0.5rem;
    }

    .section-title i {
        color: #4e73df;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 10px;
        padding: 1.5rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        border-left: 4px solid var(--border-color);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .stat-card.primary { --border-color: #4e73df; }
    .stat-card.success { --border-color: #1cc88a; }
    .stat-card.info { --border-color: #36b9cc; }
    .stat-card.warning { --border-color: #6A211F; }
    .stat-card.danger { --border-color: #e74a3b; }
    .stat-card.secondary { --border-color: #858796; }
    .stat-card.purple { --border-color: #6f42c1; }

    .stat-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: #5a5c69;
        line-height: 1;
    }

    .stat-label {
        color: #858796;
        font-size: 0.9rem;
        font-weight: 500;
        margin-top: 0.5rem;
    }

    .stat-icon {
        font-size: 2.5rem;
        opacity: 0.3;
        color: var(--border-color);
    }

    .chart-container {
        background: white;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        border-left: 4px solid #4e73df;
    }

    .chart-title {
        color: #4e73df;
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
    }

    .priority-high { color: #e74a3b; }
    .priority-medium { color: #f6c23e; }
    .priority-low { color: #1cc88a; }

    .table-responsive {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    .table {
        width: 100%;
        margin-bottom: 1rem;
        color: #5a5c69;
        border-collapse: collapse;
    }

    .table th {
        background-color: #4e73df;
        color: white;
        padding: 1rem;
        text-align: left;
    }

    .table td {
        padding: 1rem;
        background-color: white;
        border-bottom: 1px solid #f8f9fc;
    }

    .table tr:hover td {
        background-color: #f8f9fc;
    }

    .badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 600;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.35rem;
    }

    .badge-primary {
        color: white;
        background-color: #4e73df;
    }

    .badge-success {
        color: white;
        background-color: #1cc88a;
    }

    @media (max-width: 768px) {
        .dashboard-container {
            padding: 1rem;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="dashboard-container">
    

    <!-- Users Statistics -->
    <div class="section">
        <h5 class="section-title">
            <i class="fas fa-users"></i>Statistiques des Utilisateurs
        </h5>
        <div class="stats-grid">
            <div class="stat-card primary">
                <div class="stat-content">
                    <div>
                        <div class="stat-number">{{ $totalUsers }}</div>
                        <div class="stat-label">Total Utilisateurs</div>
                    </div>
                    <i class="fas fa-users stat-icon"></i>
                </div>
            </div>
            <div class="stat-card success">
                <div class="stat-content">
                    <div>
                        <div class="stat-number">{{ $adminUsers }}</div>
                        <div class="stat-label">Administrateurs</div>
                    </div>
                    <i class="fas fa-user-shield stat-icon"></i>
                </div>
            </div>
            <div class="stat-card info">
                <div class="stat-content">
                    <div>
                        <div class="stat-number">{{ $regularUsers }}</div>
                        <div class="stat-label">Utilisateurs Réguliers</div>
                    </div>
                    <i class="fas fa-user stat-icon"></i>
                </div>
            </div>
            <div class="stat-card warning">
                <div class="stat-content">
                    <div>
                        <div class="stat-number">{{ $recentUsers }}</div>
                        <div class="stat-label">Nouveaux (30j)</div>
                    </div>
                    <i class="fas fa-user-plus stat-icon"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Projects Statistics -->
    <div class="section">
        <h5 class="section-title">
            <i class="fas fa-project-diagram"></i>Statistiques des Projets
        </h5>
        <div class="stats-grid">
            <div class="stat-card primary">
                <div class="stat-content">
                    <div>
                        <div class="stat-number">{{ $totalProjects }}</div>
                        <div class="stat-label">Total Projets</div>
                    </div>
                    <i class="fas fa-project-diagram stat-icon"></i>
                </div>
            </div>
            <div class="stat-card info">
                <div class="stat-content">
                    <div>
                        <div class="stat-number">{{ $projectsWithModules }}</div>
                        <div class="stat-label">Avec Modules</div>
                    </div>
                    <i class="fas fa-puzzle-piece stat-icon"></i>
                </div>
            </div>
            <div class="stat-card warning">
                <div class="stat-content">
                    <div>
                        <div class="stat-number">{{ $projectsWithTickets }}</div>
                        <div class="stat-label">Avec Tickets</div>
                    </div>
                    <i class="fas fa-ticket-alt stat-icon"></i>
                </div>
            </div>
            <div class="stat-card purple">
                <div class="stat-content">
                    <div>
                        <div class="stat-number">{{ $recentProjects }}</div>
                        <div class="stat-label">Récents (30j)</div>
                    </div>
                    <i class="fas fa-calendar-plus stat-icon"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Modules Statistics -->
    <div class="section">
        <h5 class="section-title">
            <i class="fas fa-cubes"></i>Statistiques des Modules
        </h5>
        <div class="stats-grid">
            <div class="stat-card primary">
                <div class="stat-content">
                    <div>
                        <div class="stat-number">{{ $totalModules }}</div>
                        <div class="stat-label">Total Modules</div>
                    </div>
                    <i class="fas fa-cubes stat-icon"></i>
                </div>
            </div>
            <div class="stat-card success">
                <div class="stat-content">
                    <div>
                        <div class="stat-number">{{ $modulesWithTickets }}</div>
                        <div class="stat-label">Avec Tickets</div>
                    </div>
                    <i class="fas fa-cube stat-icon"></i>
                </div>
            </div>
            <div class="stat-card info">
                <div class="stat-content">
                    <div>
                        <div class="stat-number">{{ $recentModules }}</div>
                        <div class="stat-label">Récents (30j)</div>
                    </div>
                    <i class="fas fa-plus-circle stat-icon"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tickets Statistics -->
    <div class="section">
        <h5 class="section-title">
            <i class="fas fa-tags"></i>Statistiques des Tickets
        </h5>
        
        <div class="chart-container">
            <h6 class="chart-title">Par Statut</h6>
            <div class="stats-grid">
                <div class="stat-card primary">
                    <div class="stat-content">
                        <div>
                            <div class="stat-number">{{ $totalTickets }}</div>
                            <div class="stat-label">Total Tickets</div>
                        </div>
                        <i class="fas fa-tags stat-icon"></i>
                    </div>
                </div>
                <div class="stat-card warning">
                    <div class="stat-content">
                        <div>
                            <div class="stat-number">{{ $ticketsEnCours }}</div>
                            <div class="stat-label">En Cours</div>
                        </div>
                        <i class="fas fa-spinner stat-icon"></i>
                    </div>
                </div>
                <div class="stat-card info">
                    <div class="stat-content">
                        <div>
                            <div class="stat-number">{{ $ticketsOuverts }}</div>
                            <div class="stat-label">Ouverts</div>
                        </div>
                        <i class="fas fa-door-open stat-icon"></i>
                    </div>
                </div>
                <div class="stat-card success">
                    <div class="stat-content">
                        <div>
                            <div class="stat-number">{{ $ticketsFermes }}</div>
                            <div class="stat-label">Fermés</div>
                        </div>
                        <i class="fas fa-check-circle stat-icon"></i>
                    </div>
                </div>
                <div class="stat-card danger">
                    <div class="stat-content">
                        <div>
                            <div class="stat-number">{{ $ticketsAnnules }}</div>
                            <div class="stat-label">Annulés</div>
                        </div>
                        <i class="fas fa-times-circle stat-icon"></i>
                    </div>
                </div>
                <div class="stat-card secondary">
                    <div class="stat-content">
                        <div>
                            <div class="stat-number">{{ $recentTickets }}</div>
                            <div class="stat-label">Récents (7j)</div>
                        </div>
                        <i class="fas fa-clock stat-icon"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="chart-container">
            <h6 class="chart-title">Par Priorité</h6>
            <div class="stats-grid">
                <div class="stat-card danger">
                    <div class="stat-content">
                        <div>
                            <div class="stat-number priority-high">{{ $highPriorityTickets }}</div>
                            <div class="stat-label">Priorité Haute</div>
                        </div>
                        <i class="fas fa-exclamation-triangle stat-icon"></i>
                    </div>
                </div>
                <div class="stat-card warning">
                    <div class="stat-content">
                        <div>
                            <div class="stat-number priority-medium">{{ $mediumPriorityTickets }}</div>
                            <div class="stat-label">Priorité Moyenne</div>
                        </div>
                        <i class="fas fa-exclamation stat-icon"></i>
                    </div>
                </div>
                <div class="stat-card success">
                    <div class="stat-content">
                        <div>
                            <div class="stat-number priority-low">{{ $lowPriorityTickets }}</div>
                            <div class="stat-label">Priorité Basse</div>
                        </div>
                        <i class="fas fa-arrow-down stat-icon"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="chart-container">
            <h6 class="chart-title">Par Type</h6>
            <div class="stats-grid">
                <div class="stat-card danger">
                    <div class="stat-content">
                        <div>
                            <div class="stat-number">{{ $bugTickets }}</div>
                            <div class="stat-label">Bugs</div>
                        </div>
                        <i class="fas fa-bug stat-icon"></i>
                    </div>
                </div>
                <div class="stat-card primary">
                    <div class="stat-content">
                        <div>
                            <div class="stat-number">{{ $featureTickets }}</div>
                            <div class="stat-label">Fonctionnalités</div>
                        </div>
                        <i class="fas fa-lightbulb stat-icon"></i>
                    </div>
                </div>
                <div class="stat-card purple">
                    <div class="stat-content">
                        <div>
                            <div class="stat-number">{{ $supportTickets }}</div>
                            <div class="stat-label">Support</div>
                        </div>
                        <i class="fas fa-headset stat-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Additional Stats -->
    <div class="section">
        <div class="row">
            <!-- Monthly Trends -->
            <div class="col-md-8">
                <div class="chart-container">
                    <h5 class="chart-title">Tendance Mensuelle des Tickets</h5>
                    <canvas id="monthlyChart" height="100"></canvas>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="col-md-4">
                <div class="chart-container">
                    <h5 class="chart-title">Activité Récente</h5>
                    <div class="text-center mb-4">
                        <h3 class="stat-number">{{ $recentTickets }}</h3>
                        <p class="stat-label">Nouveaux tickets (7 derniers jours)</p>
                    </div>
                    <div class="text-center">
                        <h3 class="stat-number">{{ $recentlyClosedTickets }}</h3>
                        <p class="stat-label">Tickets fermés (7 derniers jours)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Projects and Users -->
    <div class="section">
        <div class="row">
            <div class="col-md-6">
                <div class="chart-container">
                    <h5 class="chart-title">Top 5 Projets (par nombre de tickets)</h5>
                    @if($topProjects->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Projet</th>
                                        <th>Nombre de Tickets</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topProjects as $project)
                                    <tr>
                                        <td>{{ $project->name }}</td>
                                        <td><span class="badge badge-primary">{{ $project->tickets_count }}</span></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p style="color: #858796;">Aucun projet avec des tickets.</p>
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <div class="chart-container">
                    <h5 class="chart-title">Top 5 Utilisateurs (par nombre de tickets)</h5>
                    @if($topUsers->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Utilisateur</th>
                                        <th>Nombre de Tickets</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topUsers as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td><span class="badge badge-success">{{ $user->tickets_count }}</span></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p style="color: #858796;">Aucun utilisateur avec des tickets.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Monthly trends chart
    const ctx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyData = @json($monthlyTickets);
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: monthlyData.map(item => item.month),
            datasets: [{
                label: 'Tickets créés',
                data: monthlyData.map(item => item.count),
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                tension: 0.1,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    labels: {
                        color: '#5a5c69'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        color: '#5a5c69'
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        color: '#5a5c69'
                    }
                }
            }
        }
    });
</script>
@endpush

@endsection