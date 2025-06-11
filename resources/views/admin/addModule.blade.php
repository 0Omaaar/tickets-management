<!-- Modal pour ajouter un nouveau module -->
<div id="addModuleModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Ajouter un nouveau module</h2>
            <button class="close" onclick="closeModuleModal()">&times;</button>
        </div>
        <div class="modal-body">
            <form id="moduleForm" method="POST" action="{{ route('admin.storeModule') }}">
                @csrf
                <div class="row">
                    <!-- Première colonne -->
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="moduleName">Nom</label>
                            <input type="text" id="moduleName" name="name" class="form-control"
                                placeholder="Nom du module" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="moduleProject">Projet</label>
                            <select id="moduleProject" name="project_id" required class="form-control">
                                <option value="">Sélectionnez un projet</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Deuxième colonne -->
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="moduleDescription">Description</label>
                            <textarea id="moduleDescription" name="description" class="form-control" rows="4"
                                placeholder="Décrivez le module..." required></textarea>
                        </div>
                    </div>
                </div>
                <button type="submit" class="submit-btn">Ajouter le module</button>
            </form>
        </div>
    </div>
</div>
