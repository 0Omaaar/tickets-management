// Données fictives de tickets
let tickets = [{
    id: 'TK001',
    description: 'Mon écran est cassé',
    status: 'open',
    submittedOn: '2024-03-15',
    category: 'Matériel'
},
{
    id: 'TK002',
    description: "Microsoft Excel est bloqué",
    status: 'in-progress',
    submittedOn: '2024-03-14',
    category: 'Logiciel'
},
{
    id: 'TK003',
    description: "Ma webcam ne fonctionne pas",
    status: 'open',
    submittedOn: '2024-03-13',
    category: 'Matériel'
},
{
    id: 'TK004',
    description: "Veuillez ajouter un utilisateur à BuddyBot",
    status: 'closed',
    submittedOn: '2024-03-12',
    category: 'Logiciel'
},
{
    id: 'TK005',
    description: "Mon réseau est coupé",
    status: 'open',
    submittedOn: '2024-03-11',
    category: 'Réseau'
},
{
    id: 'TK006',
    description: "Impossible de connecter l'ordinateur à l'imprimante",
    status: 'closed',
    submittedOn: '2024-03-10',
    category: 'Matériel'
}
];







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

// Soumission du formulaire
document.getElementById('ticketForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const description = document.getElementById('ticketDescription').value;
    const imageFile = document.getElementById('ticketImage').files[0];

    // Générer un nouvel ID de ticket
    const newId = 'TK' + String(tickets.length + 1).padStart(3, '0');

    // Créer un nouveau ticket
    const newTicket = {
        id: newId,
        description: description,
        status: 'open',
        submittedOn: new Date().toISOString().split('T')[0],
        category: 'Général'
    };

    // Ajouter au tableau des tickets
    tickets.push(newTicket);

    // Fermer la fenêtre modale
    closeModal();

    // Afficher un message de succès
    alert("Ticket soumis avec succès !");
});

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

function deleteTicket(ticketId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce ticket ?')) {
        tickets = tickets.filter(t => t.id !== ticketId);
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
