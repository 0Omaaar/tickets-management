<!-- Modal pour modifier un utilisateur -->
<div id="updateModalUser" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Modifier l'utilisateur</h2>
            <span class="close" onclick="closeUpdateUserModal()">&times;</span>
        </div>
        <div class="modal-body">
            <form id="editUserForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" id="editUserId" name="id">
            <div class="form-group">
                <label for="editUserName">Nom</label>
                <input type="text" id="editUserName" name="name" required>
            </div>
            <div class="form-group">
                <label for="editUserEmail">Email</label>
                <input type="email" id="editUserEmail" name="email" required>
            </div>
            <div class="form-group">
                <label for="editUserType">Type</label>
                <select id="editUserType" name="type" required class="form-control">
                    <option value="user">Utilisateur</option>
                    <option value="admin">Administrateur</option>
                </select>
            </div>
            <div class="form-actions">
                <button type="submit" class="submit-btn">Mettre à jour</button>
            </div>
        </form>
    </div>
</div>
