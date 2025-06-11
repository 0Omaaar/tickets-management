 <div id="ticketModalUpdate" class="modal">
     <div class="modal-content">
         <div class="modal-header">
             <h2>Modifier le Ticket</h2>
             <button class="close" onclick="closeEditModal()">&times;</button>
         </div>
         <div class="modal-body">
             <form id="editTicketForm" method="POST" action="" enctype="multipart/form-data">
                 @csrf
                 @method('PUT')
                 <input type="hidden" id="editTicketId" name="ticket_id">
                 <div class="row">
                     <!-- Première colonne -->
                     <div class="col-md-6">
                         <div class="form-group mb-3">
                             <label for="editTitle">Titre</label>
                             <input type="text" id="editTitle" name="title" class="form-control"
                                 placeholder="Titre du ticket" required>
                         </div>

                         <div class="form-group mb-3">
                             <label for="editModule">Module</label>
                             <select id="editModule" name="module_id" required class="form-control">
                                 <option value="">Sélectionnez un module</option>
                                 @foreach ($modules as $module)
                                     <option value="{{ $module->id }}">{{ $module->name }}</option>
                                 @endforeach
                             </select>
                         </div>

                         <div class="form-group mb-3">
                             <label for="editPriority">Priorité</label>
                             <select id="editPriority" name="priority" required class="form-control">
                                 <option value="">Sélectionnez une priorité</option>
                                 <option value="faible"><i class="fas fa-arrow-down"></i> Faible</option>
                                 <option value="moyenne"><i class="fas fa-minus"></i> Moyenne</option>
                                 <option value="haute"><i class="fas fa-arrow-up"></i> Haute</option>
                             </select>
                         </div>


                     </div>

                     <!-- Deuxième colonne -->
                     <div class="col-md-6">


                         <div class="form-group mb-3">
                             <label for="editProject">Projet</label>
                             <select id="editProject" name="project_id" required class="form-control">
                                 <option value="">Sélectionnez un projet</option>
                                 @foreach ($projects as $project)
                                     <option value="{{ $project->id }}">{{ $project->name }}</option>
                                 @endforeach
                             </select>
                         </div>

                         <div class="form-group mb-3">
                             <label for="editStatus">Statut</label>
                             <select id="editStatus" name="status" required class="form-control">
                                 <option value="">Sélectionnez un statut</option>
                                 <option value="ouvert"><i class="fas fa-folder-open"></i> Ouvert</option>
                                 <option value="en_cours"><i class="fas fa-spinner fa-spin"></i> En cours
                                 </option>
                                 <option value="en_attente"><i class="fas fa-clock"></i> En attente</option>
                                 <option value="fermé"><i class="fas fa-check-circle"></i> Fermé</option>
                                 <option value="annulé"><i class="fas fa-times-circle"></i> Annulé</option>
                             </select>
                         </div>

                         <div class="form-group mb-3">
                             <label for="editType">Type</label>
                             <select id="editType" name="type" required class="form-control">
                                 <option value="">Sélectionnez un type</option>
                                 <option value="bug"><i class="fas fa-bug"></i> Bug</option>
                                 <option value="fonctionnalité"><i class="fas fa-plus-circle"></i>
                                     Fonctionnalité
                                 </option>
                                 <option value="amélioration"><i class="fas fa-star"></i> Amélioration
                                 </option>
                             </select>
                         </div>
                     </div>
                 </div>

                 {{-- image --}}
                 <div class="form-group">
                     <label for="ticketImage">Joindre une image (facultatif)</label>
                     <div class="file-input-wrapper">
                         <input type="file" id="ticketImage" name="image" accept="image/*" class="file-input" onchange="previewNewImage(this)">
                         <div class="file-input-display">
                             <span>📎</span>
                             <span id="fileLabel">Cliquez pour sélectionner une image</span>
                         </div>
                     </div>
                     <div id="currentImagePreview" class="image-preview mt-2" style="display: none;">
                         <p class="mb-2">Image actuelle:</p>
                         <img id="currentImage" src="" alt="Image actuelle" style="max-width: 200px; max-height: 200px; border-radius: 8px;">
                     </div>
                     <div id="newImagePreview" class="image-preview mt-2" style="display: none;">
                         <p class="mb-2">Nouvelle image:</p>
                         <img id="previewImage" src="" alt="Aperçu" style="max-width: 200px; max-height: 200px; border-radius: 8px;">
                     </div>
                 </div>

                 <!-- Description sur toute la largeur -->
                 <div class="row mt-3">
                     <div class="col-12">
                         <div class="form-group mb-3">
                             <label for="editDescription">Description</label>
                             <textarea id="editDescription" name="description" class="form-control" rows="4"
                                 placeholder="Décrivez votre problème en détail..." required></textarea>
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
