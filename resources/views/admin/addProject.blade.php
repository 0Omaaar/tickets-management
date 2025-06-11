<div id="addProjectModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Ajouter un nouveau projet</h2>
            <button class="close" onclick="closeProjectModal()">&times;</button>
        </div>
        <div class="modal-body">
            <form id="ticketForm" method="POST" action="{{ route('admin.storeProject') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- Première colonne -->
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label for="ticketTitle">Nom</label>
                            <input type="text" id="ticketTitle" name="name" class="form-control"
                                placeholder="Nom du projet" required>
                        </div>
                    </div>
                </div>

                <!-- Description sur toute la largeur -->
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for="ticketDescription">Description</label>
                            <textarea id="ticketDescription" name="description" class="form-control" rows="4"
                                placeholder="Décrivez le projet..."></textarea>
                        </div>
                    </div>
                </div>
                <button type="submit" class="submit-btn">Enregistrer le projet</button>
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
