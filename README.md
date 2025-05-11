# Application Symfony PIDEV

## Description
**El_FIRMA** est une application web basée sur Symfony conçue pour gérer différents rôles utilisateurs, notamment les administrateurs, experts, fournisseurs et agriculteurs. L’application offre des fonctionnalités telles que l’inscription des utilisateurs, la réinitialisation de mot de passe, la gestion d’événements, la gestion de produits, et l’exportation PDF des données utilisateurs. Elle comprend également un tableau de bord pour les administrateurs afin de gérer les utilisateurs et consulter les statistiques.

## Modules du projet
L’application **El_FIRMA** est organisée en plusieurs modules clés, chacun conçu pour répondre à des besoins spécifiques des utilisateurs et offrir une plateforme numérique complète pour les interactions et services liés à l’agriculture.

### 📅 Module de gestion des événements (Module Événement)
Ce module permet aux fournisseurs de promouvoir leurs produits et de favoriser l'engagement en organisant des événements. Les fournisseurs peuvent :
- Créer et gérer des événements en ligne ou en présentiel via leur tableau de bord.
- Générer des QR codes pour les billets d’événement afin de faciliter l’enregistrement et d’améliorer l’organisation.
- Cibler un large public : les événements sont visibles et accessibles aux agriculteurs, experts et autres fournisseurs.

> Cela favorise le réseautage, le partage de connaissances et la croissance commerciale au sein de la communauté agricole.

### 🛒 Module de gestion des produits (Module Produit)
Ce module permet aux fournisseurs de présenter et de vendre leurs produits agricoles. Fonctionnalités clés :
- Ajout de fiches produits détaillées avec images, descriptions, prix et quantités.
- Achat en ligne fluide avec paiements sécurisés via Stripe.
- Filtres avancés pour permettre aux agriculteurs de rechercher par catégorie et prix.

### 💬 Module de conseil expert et forum (Module Conseil Expert)
Ce module connecte les agriculteurs aux experts en agriculture. Fonctionnalités :
- Interface de type forum pour poser des questions et recevoir des réponses d'experts vérifiés.
- Base de connaissances consultable regroupant les questions précédemment traitées.

> Favorise la collaboration et la résolution de problèmes pour améliorer les pratiques agricoles.

### 🌾 Module de location de terrains (Module Terrain)
Permet la location de terrains agricoles entre utilisateurs :
- Les propriétaires publient des annonces détaillées (localisation, superficie, type, etc.).
- Les agriculteurs peuvent rechercher et louer selon leurs besoins.

> Encourage une meilleure utilisation des terres et offre des opportunités aux agriculteurs sans propriété.

### 👤 Module de gestion des utilisateurs (Module Utilisateur)
Au cœur de l’application, ce module gère :
- Les accès et permissions basés sur les rôles (admin, expert, fournisseur, agriculteur).
- L’authentification et l’autorisation sécurisées.
- La gestion des profils et des données utilisateurs.

> Garantit la sécurité de la plateforme et personnalise l’expérience utilisateur.

---

## Table des matières
- [Fonctionnalités](#fonctionnalités)
- [Installation](#installation)
- [Utilisation](#utilisation)
- [Technologies utilisées](#technologies-utilisées)
- [Contribuer](#contribuer)
- [Licence](#licence)
- [Mots-clés](#mots-clés)

## Fonctionnalités
- **Gestion des utilisateurs** : Inscription, connexion et contrôle d’accès selon les rôles.
- **Réinitialisation de mot de passe** : Fonctionnalité sécurisée par e-mail.
- **Gestion des événements** : Création, modification et suivi des événements.
- **Gestion des produits** : Ajout et gestion de produits (nom, description, quantité, prix).
- **Tableau de bord** : Statistiques utilisateurs et outils de gestion pour les administrateurs.
- **Export PDF** : Exportation des données utilisateurs en PDF via Dompdf.
- **Design responsive** : Interface adaptée aux différents appareils.

## Installation

1. **Cloner le dépôt** :
   ```bash
   git clone https://github.com/username/pidev-symfony.git
   cd pidev-symfony
   ```

2. **Installer les dépendances** :
   ```bash
   composer install
   npm install
   ```

3. **Configurer l’environnement** :
   - Copier le fichier `.env` en `.env.local` et modifier les informations de connexion à la base de données.

4. **Lancer les migrations** :
   ```bash
   php bin/console doctrine:migrations:migrate
   ```

5. **Démarrer le serveur de développement** :
   ```bash
   symfony server:start
   ```

6. **Compiler les assets** :
   ```bash
   npm run dev
   ```

## Utilisation
- Accédez à l’application via : [http://localhost:8000](http://localhost:8000).
- Utilisez le tableau de bord admin pour gérer les utilisateurs, événements et produits.
- Inscrivez-vous avec différents rôles pour découvrir les fonctionnalités spécifiques à chacun.

## Technologies utilisées
- **Backend** : Symfony Framework
- **Frontend** : Twig, SCSS, Bootstrap
- **Base de données** : MySQL
- **Génération de PDF** : Dompdf
- **JavaScript** : Vanilla JS, jQuery
- **Template Admin** : SB Admin 2

## Contribuer
Les contributions sont les bienvenues ! Voici comment procéder :

1. Forkez le dépôt.
2. Créez une nouvelle branche :
   ```bash
   git checkout -b nouvelle-fonctionnalité
   ```
3. Effectuez vos modifications :
   ```bash
   git commit -m "Ajout de nouvelle-fonctionnalité"
   ```
4. Poussez la branche :
   ```bash
   git push origin nouvelle-fonctionnalité
   ```
5. Créez une pull request.

## Licence
Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus d'informations.

## Mots-clés
Symfony, Gestion des utilisateurs, Tableau de bord, Export PDF, Gestion des événements, Gestion des produits, Contrôle d’accès par rôle, Design responsive, Application web
