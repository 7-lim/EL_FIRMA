const container = document.querySelector('.container');
const signupButton = document.querySelector('.signup-section header');
const loginButton = document.querySelector('.login-section header');


loginButton.addEventListener('click', ()=>{
    container.classList.add('active');
})

signupButton.addEventListener('click', ()=>{
    container.classList.remove('active');
});


// Fonction pour afficher les champs en fonction du rôle sélectionné


document.addEventListener("DOMContentLoaded", function () {
    const roleSelect = document.getElementById("registration_form_user_type"); // Vérifie l'ID exact dans ton HTML
    
    function updateRoleFields() {
        const role = roleSelect.value;

        // Masquer tous les champs dynamiques par défaut
        document.getElementById('fournisseur-fields').style.display = 'none';
        document.getElementById('fournisseur-id-fiscale').style.display = 'none';
        document.getElementById('fournisseur-category').style.display = 'none';
        document.getElementById('expert-fields').style.display = 'none';
        document.getElementById('agriculteur-fields').style.display = 'none';
        document.getElementById('admin-fields').style.display = 'none';

        // Afficher les champs spécifiques en fonction du rôle sélectionné
        if (role === 'fournisseur') {
            document.getElementById('fournisseur-fields').style.display = 'block';
            document.getElementById('fournisseur-id-fiscale').style.display = 'block';
            document.getElementById('fournisseur-category').style.display = 'block';
        } else if (role === 'expert') {
            document.getElementById('expert-fields').style.display = 'block';
        } else if (role === 'agriculteur') {
            document.getElementById('agriculteur-fields').style.display = 'block';
        } else if (role === 'administrateur') {
            document.getElementById('admin-fields').style.display = 'block';
        }
    }

    if (roleSelect) {
        roleSelect.addEventListener("change", updateRoleFields);
        updateRoleFields(); // Exécuter au chargement pour prendre en compte les valeurs déjà sélectionnées
    }
});


