// Fonction pour formater la date
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('fr-FR', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

// Fonctions de la fenêtre modale
function openModal() {
    document.getElementById('ticketModal').style.display = 'block';
    document.body.style.overflow = 'hidden';
}



function closeModal() {
    document.getElementById('ticketModal').style.display = 'none';
    document.body.style.overflow = 'auto';
    document.getElementById('ticketForm').reset();
    document.getElementById('fileLabel').textContent = 'Cliquez pour sélectionner une image';
}



// Gestion de la sélection de fichier
document.getElementById('ticketImage').addEventListener('change', function (e) {
    const file = e.target.files[0];
    const label = document.getElementById('fileLabel');
    if (file) {
        label.textContent = file.name;
    } else {
        label.textContent = 'Cliquez pour sélectionner une image';
    }
});

// Fonctions d'actions
function editTicket(ticketId) {
    const ticket = tickets.find(t => t.id === ticketId);
    if (ticket) {
        const newDescription = prompt('Modifier la description :', ticket.description);
        if (newDescription && newDescription !== ticket.description) {
            ticket.description = newDescription;
        }
    }
}


// Fermer la fenêtre modale en cliquant à l'extérieur
window.addEventListener('click', function (e) {
    const modal = document.getElementById('ticketModal');
    if (e.target === modal) {
        closeModal();
    }
});

// Fermer la fenêtre modale avec la touche Échap
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        closeModal();
    }
});

// Initialiser le tableau de bord
document.addEventListener('DOMContentLoaded', function () {
});
