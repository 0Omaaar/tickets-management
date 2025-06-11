<div id="updateModalProject" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Modifier le projet</h2>
            <button class="close" onclick="closeUpdateProjectModal()">&times;</button>
        </div>
        <div class="modal-body">
            <form id="editProjectForm" method="POST" action="" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="editProjectId" name="project_id">
                <div class="row">
                    <!-- Première colonne -->
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label for="editProjectName">Nom</label>
                            <input type="text" id="editProjectName" name="name" class="form-control"
                                placeholder="Nom du projet" required>
                        </div>
                    </div>
                </div>


                <!-- Description sur toute la largeur -->
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for="editProjectDescription">Description</label>
                            <textarea id="editProjectDescription" name="description" class="form-control" rows="4"
                                placeholder="Décrivez le projet..."></textarea>
                        </div>
                    </div>
                </div>
                <button type="submit" class="submit-btn">Mettre à jour</button>
            </form>
        </div>
    </div>
</div>

<style>
    .modal-content {
        max-width: 800px;
        margin: 0 auto;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .form-group label {
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: #374151;
    }

    .form-control {
        border-radius: 0.5rem;
        border: 1px solid #e5e7eb;
        padding: 0.625rem 1rem;
    }
</style>
