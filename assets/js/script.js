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
        const fields = [
            'fournisseur-fields', 
            'fournisseur-id-fiscale',
            'fournisseur-category',
            'expert-fields',
            'agriculteur-fields',
            'admin-fields'
        ];

        fields.forEach(field => {
            document.getElementById(field).style.display = 'none';
        });

        if (role === 'fournisseur') {
            ['fournisseur-fields', 'fournisseur-id-fiscale', 'fournisseur-category'].forEach(field => {
                document.getElementById(field).style.display = 'block';
            });
        } 
        else if (role) {
            document.getElementById(`${role}-fields`).style.display = 'block';
        }
    }

    if (roleSelect) {
        roleSelect.addEventListener("change", updateRoleFields);
        updateRoleFields();
    }
});


