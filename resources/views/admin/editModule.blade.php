<!-- Modal pour modifier un module -->
<div id="updateModalModule" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Modifier le Module</h2>
            <button class="close" onclick="closeUpdateModuleModal()">&times;</button>
        </div>
        <div class="modal-body">
            <form id="editModuleForm" method="POST" action="">
                @csrf
                @method('PUT')
                <input type="hidden" id="editModuleId" name="module_id">

                <div class="row">
                    <!-- Première colonne -->
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="editModuleName">Nom</label>
                            <input type="text" id="editModuleName" name="name" class="form-control"
                                placeholder="Nom du module" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="editModuleProject">Projet</label>
                            <select id="editModuleProject" name="project_id" required class="form-control">
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
                            <label for="editModuleDescription">Description</label>
                            <textarea id="editModuleDescription" name="description" class="form-control" rows="4"
                                placeholder="Décrivez le module..." required></textarea>
                        </div>
                    </div>
                </div>
                <button type="submit" class="submit-btn">Mettre à jour</button>
            </form>
        </div>
    </div>
</div>
