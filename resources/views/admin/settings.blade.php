@extends('base')

@section('admin.nav')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.settings') }}">Paramètres</a>
    </li>
@endsection

@section('content')
    <div class="main-content">
        <!-- Tableau de tous les projets -->
        <div class="table-section">
            <div class="table-header">
                <div class="header-left">
                    <h2 class="section-title">Tous les Projets</h2>
                    <div class="search-container">
                        <form method="GET" action="{{ route('admin.settings') }}">
                            <input type="text" id="ProjectSearch" class="search-input"
                                placeholder="Rechercher un projet..." name="project_search"
                                value="{{ request('project_search') ?? '' }}">
                            <button type="submit"><i class="fas fa-search search-icon"></i></button>
                        </form>
                        <div class="search-note">
                            <i class="fas fa-info-circle"></i>
                            Recherche par nom ou description.
                        </div>
                    </div>
                </div>
                <button class="add-ticket-btn" onclick="openProjectModal()">
                    <span>➕</span> Ajouter un projet
                </button>
            </div>
            <div class="table-container">
                <table id="ticketsTable">
                    <thead>
                        <tr>
                            <th style="text-align: center;">N Projet</th>
                            <th style="text-align: center;">Nom</th>
                            <th style="text-align: center;">Description</th>
                            <th style="text-align: center;">Nombre de modules</th>
                            <th style="text-align: center;">Nombre de tickets</th>
                            <th style="text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="ticketsTableBody">
                        @forelse ($projects as $project)
                            <tr>
                                <td align="center">{{ $loop->index + 1 }}</td>
                                <td align="center">{{ $project->name }}</td>
                                <td align="center">{{ Str::limit($project->description, 50) ?? '--'}}</td>
                                <td align="center"><span class="status ouvert">{{ $project->modules->count() }}</span></td>
                                <td align="center"><span class="status fermé">{{ $project->tickets->count() }}</span></td>
                                <td align="center" class="actions">
                                    <button class="action-btn edit-btn"
                                        onclick="openEditProjectModal('{{ $project->id }}')">Modifier</button>
                                    <button class="action-btn delete-btn"
                                        onclick="deleteProject('{{ $project->id }}')">Supprimer</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4" style="color: #6b7280; font-size: 1.1rem;">
                                    <i class="fas fa-project-diagram mb-2" style="font-size: 2rem; color: #9ca3af;"></i>
                                    <p>Aucun projet trouvé</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="pagination-container"
                    style="margin-top: 20px; display: flex; justify-content: center; align-items: center;">
                    <div class="pagination-wrapper" style="background: white; padding: 10px 20px; border-radius: 8px;">
                        {{ $projects->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau de tous les modules -->
        <div class="table-section" style="margin-top: 40px;">
            <div class="table-header">
                <div class="header-left">
                    <h2 class="section-title">Tous les Modules</h2>
                    <div class="search-container">
                        <form method="GET" action="{{ route('admin.settings') }}">
                            <input type="text" id="ModuleSearch" class="search-input"
                                placeholder="Rechercher un module..." name="module_search"
                                value="{{ request('module_search') ?? '' }}">
                            <button type="submit"><i class="fas fa-search search-icon"></i></button>
                        </form>
                        <div class="search-note">
                            <i class="fas fa-info-circle"></i>
                            Recherche par nom, description ou projet.
                        </div>
                    </div>
                </div>
                <button class="add-ticket-btn" onclick="openModuleModal()">
                    <span>➕</span> Ajouter un module
                </button>
            </div>
            <div class="table-container">
                <table id="modulesTable">
                    <thead>
                        <tr>
                            <th style="text-align: center;">N Module</th>
                            <th style="text-align: center;">Nom</th>
                            <th style="text-align: center;">Description</th>
                            <th style="text-align: center;">Projet</th>
                            <th style="text-align: center;">Nombre de tickets</th>
                            <th style="text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="modulesTableBody">
                        @forelse ($modules as $module)
                            <tr>
                                <td align="center">{{ $loop->index + 1 }}</td>
                                <td align="center">{{ $module->name }}</td>
                                <td align="center">{{ Str::limit($module->description, 50) ?? '--'}}</td>
                                <td align="center">{{ $module->project->name }}</td>
                                <td align="center"><span class="status ouvert">{{ $module->tickets->count() }}</span></td>
                                <td align="center" class="actions">
                                    <button class="action-btn edit-btn"
                                        onclick="openEditModuleModal('{{ $module->id }}')">Modifier</button>
                                    <button class="action-btn delete-btn"
                                        onclick="deleteModule('{{ $module->id }}')">Supprimer</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4" style="color: #6b7280; font-size: 1.1rem;">
                                    <i class="fas fa-cubes mb-2" style="font-size: 2rem; color: #9ca3af;"></i>
                                    <p>Aucun module trouvé</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="pagination-container"
                    style="margin-top: 20px; display: flex; justify-content: center; align-items: center;">
                    <div class="pagination-wrapper" style="background: white; padding: 10px 20px; border-radius: 8px;">
                        {{ $modules->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fenêtre modale pour ajouter un nouveau projet -->
    @include('admin.addProject')

    <!-- Fenêtre modale pour modifier un projet -->
    @include('admin.editProject')

    <!-- Fenêtre modale pour ajouter un nouveau module -->
    @include('admin.addModule')

    <!-- Fenêtre modale pour modifier un module -->
    @include('admin.editModule')
@endsection

<script>
    // Project functions
    function openProjectModal() {
        document.getElementById('addProjectModal').style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    function closeProjectModal() {
        document.getElementById('addProjectModal').style.display = 'none';
        document.body.style.overflow = 'auto';
        document.getElementById('projectForm').reset();
    }

    function openEditProjectModal(projectId) {
        document.getElementById('updateModalProject').style.display = 'block';
        document.body.style.overflow = 'hidden';

        fetch(`/admin/getProject/${projectId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const project = data.project;
                    document.getElementById('editProjectId').value = project.id;
                    document.getElementById('editProjectName').value = project.name;
                    document.getElementById('editProjectDescription').value = project.description;
                    document.getElementById('editProjectForm').action = `/admin/updateProject/${project.id}`;
                } else {
                    alert('Erreur lors de la récupération du projet');
                    closeUpdateProjectModal();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erreur lors de la récupération du projet');
                closeUpdateProjectModal();
            });
    }

    function closeUpdateProjectModal() {
        document.getElementById('updateModalProject').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function deleteProject(projectId) {
        if (confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')) {
            window.location.href = `/admin/deleteProject/${projectId}`;
        }
    }

    // Module functions
    function openModuleModal() {
        document.getElementById('addModuleModal').style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    function closeModuleModal() {
        document.getElementById('addModuleModal').style.display = 'none';
        document.body.style.overflow = 'auto';
        document.getElementById('moduleForm').reset();
    }

    function openEditModuleModal(moduleId) {
        document.getElementById('updateModalModule').style.display = 'block';
        document.body.style.overflow = 'hidden';

        fetch(`/admin/getModule/${moduleId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const module = data.module;
                    document.getElementById('editModuleId').value = module.id;
                    document.getElementById('editModuleName').value = module.name;
                    document.getElementById('editModuleDescription').value = module.description;
                    document.getElementById('editModuleProject').value = module.project_id;
                    document.getElementById('editModuleForm').action = `/admin/updateModule/${module.id}`;
                } else {
                    alert('Erreur lors de la récupération du module');
                    closeUpdateModuleModal();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erreur lors de la récupération du module');
                closeUpdateModuleModal();
            });
    }

    function closeUpdateModuleModal() {
        document.getElementById('updateModalModule').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function deleteModule(moduleId) {
        if (confirm('Êtes-vous sûr de vouloir supprimer ce module ?')) {
            window.location.href = `/admin/deleteModule/${moduleId}`;
        }
    }

    // Close modals when clicking outside
    window.onclick = function(event) {
        if (event.target.className === 'modal') {
            event.target.style.display = 'none';
        }
    }
</script>