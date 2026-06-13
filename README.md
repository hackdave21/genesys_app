# GENESYS House - Spécifications & Architecture Backend Laravel 12

Ce document décrit la structure complète du backend et le plan d'implémentation pour rendre dynamique le site internet **GENESYS House** à partir de l'intégration des fichiers statiques situés dans le dossier `public/genesys`.

L'application est propulsée par **Laravel 12** et **PHP 8.2+**, utilisant une base de données **SQLite** par défaut (configurable en MySQL/PostgreSQL pour la production).

---

## 📂 1. Structure Globale & Cartographie du Projet

Voici l'organisation des principaux fichiers et dossiers backend à créer ou modifier pour le fonctionnement dynamique du site :

```text
genesys_app/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   ├── AdminAuthController.php      # Gestion de la connexion Admin
│   │   │   │   ├── ClientAuthController.php     # Connexion/Inscription Client & Socialite
│   │   │   │   └── GoogleAuthController.php     # Authentification Google OAuth2
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php      # Statistiques générales
│   │   │   │   ├── TestimonialController.php    # CRUD Témoignages
│   │   │   │   ├── VideoController.php          # CRUD Portfolio Vidéo
│   │   │   │   ├── QuoteController.php          # Visualisation & Gestion des Devis
│   │   │   │   └── ClientController.php         # Gestion & Modération des Clients
│   │   │   └── Frontend/
│   │   │       ├── PageController.php           # Affichage des pages publiques (Accueil, Tarifs, Portfolio...)
│   │   │       └── PublicQuoteController.php    # Soumission publique des devis
│   │   ├── Requests/
│   │   │   ├── StoreQuoteRequest.php            # Validation de la soumission de devis
│   │   │   ├── StoreTestimonialRequest.php      # Validation ajout/modification témoignage
│   │   │   └── StoreVideoRequest.php            # Validation ajout/modification vidéo
│   │   └── Middleware/
│   │       └── IsAdmin.php                      # Restriction d'accès à l'administration
│   ├── Models/
│   │   ├── User.php                             # Modèle Utilisateur (Clients + Admin)
│   │   ├── Testimonial.php                      # Modèle Témoignage
│   │   ├── Video.php                            # Modèle Vidéo Portfolio
│   │   ├── Quote.php                            # Modèle Devis (Demandes clients)
│   │   └── Project.php                          # Modèle Projet (Kanban)
│   └── Services/
│       └── VideoUrlParser.php                   # Service utilitaire d'extraction d'embed YouTube/Vimeo
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php       # Table utilisateurs (avec champs additionnels)
│   │   ├── 2026_06_13_000001_create_testimonials_table.php # Table témoignages
│   │   ├── 2026_06_13_000002_create_videos_table.php       # Table vidéos portfolio
│   │   ├── 2026_06_13_000003_create_quotes_table.php       # Table demandes de devis
│   │   └── 2026_06_13_000004_create_projects_table.php     # Table projets Kanban
│   └── seeders/
│       ├── DatabaseSeeder.php                   # Seeder principal
│       ├── AdminUserSeeder.php                  # Seeder de l'administrateur
│       ├── TestimonialSeeder.php                # Données de test Témoignages
│       └── VideoSeeder.php                      # Données de test Vidéos
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php                    # Layout public global
│   │   │   └── admin.blade.php                  # Layout d'administration global
│   │   ├── public/                              # Vues du site vitrine
│   │   │   ├── index.blade.php                  # Page d'accueil (Témoignages dynamiques)
│   │   │   ├── portfolio.blade.php              # Portfolio dynamique avec filtre de vidéos
│   │   │   ├── services.blade.php               # Services & Tarifs
│   │   │   ├── about.blade.php                  # À propos
│   │   │   ├── contact.blade.php                # Formulaire de devis publique
│   │   │   ├── login.blade.php                  # Inscription publique
│   │   │   └── register.blade.php               # Connexion publique
│   │   └── admin/                               # Vues du panneau d'administration
│   │       ├── login.blade.php                  # Espace connexion admin
│   │       ├── dashboard.blade.php              # Tableau de bord principal
│   │       ├── devis/
│   │       │   └── index.blade.php              # Liste des devis et vue détaillée tiroir
│   │       ├── projets/
│   │       │   └── index.blade.php              # Kanban interactif des projets
│   │       ├── clients/
│   │       │   └── index.blade.php              # Gestion des clients inscrits (NOUVEAU)
│   │       ├── temoignages/
│   │       │   ├── create.blade.php             # Formulaire ajout témoignage
│   │       │   └── index.blade.php              # Liste et actions témoignages
│   │       └── videos/
│   │           ├── create.blade.php             # Formulaire ajout vidéo portfolio
│   │           └── index.blade.php              # Liste et actions vidéos
└── routes/
    └── web.php                                  # Déclaration de toutes les routes de l'application
```

---

## 💾 2. Modélisation de la Base de Données (Schémas & Migrations)

### A. Table `users` (Administrateur et Clients)
Stocke à la fois les comptes clients et le compte de l'administrateur, différenciés par un rôle.
*   `id` (BigInteger, PK, Auto-increment)
*   `name` (String) : Nom complet du client ou de l'admin.
*   `email` (String, Unique) : Adresse email d'authentification.
*   `phone` (String, Nullable) : Numéro de téléphone / WhatsApp.
*   `password` (String, Nullable) : Hachage du mot de passe (nullable pour les inscriptions Google directes).
*   `role` (Enum: `['client', 'admin']`) : Par défaut `client`.
*   `google_id` (String, Nullable) : ID unique retourné par Google pour la connexion SSO.
*   `google_token` (Text, Nullable) : Token OAuth2 Google.
*   `status` (Enum: `['active', 'suspended']`) : Statut du compte (par défaut `active`).
*   `remember_token` (String, Nullable)
*   `timestamps`

### B. Table `testimonials` (Témoignages)
Contient les avis des clients affichés de manière dynamique sur la page d'accueil.
*   `id` (BigInteger, PK, Auto-increment)
*   `client_name` (String) : Nom du client ayant émis l'avis.
*   `company_role` (String, Nullable) : Entreprise et fonction (ex: "Directeur - Ecobank Togo").
*   `content` (Text) : Message du témoignage.
*   `status` (Enum: `['published', 'draft']`) : Statut de visibilité sur le site (par défaut `published`).
*   `timestamps`

### C. Table `videos` (Portfolio Vidéo)
Gère les vidéos du portfolio affichées sur la page de portfolio publique.
*   `id` (BigInteger, PK, Auto-increment)
*   `title` (String) : Titre de la réalisation (ex: "Aftermovie Gala Sarakawa").
*   `category` (Enum: `['Publicité', 'Événement', 'Reels', 'Corporate']`) : Catégorie de vidéo.
*   `description` (Text, Nullable) : Détail du projet.
*   `video_url` (String) : URL d'origine (YouTube/Vimeo).
*   `embed_url` (String) : URL transformée automatiquement en format d'intégration iframe (ex: `https://www.youtube.com/embed/...`).
*   `thumbnail_url` (String, Nullable) : Chemin vers l'image miniature générée ou hébergée.
*   `status` (Enum: `['visible', 'archive']`) : Statut de visibilité publique (par défaut `visible`).
*   `is_featured` (Boolean) : Affichage prioritaire en haut de page (par défaut `false`).
*   `timestamps`

### D. Table `quotes` (Demandes de Devis)
Enregistre les devis envoyés par les prospects depuis la page publique de contact.
*   `id` (BigInteger, PK, Auto-increment)
*   `client_name` (String) : Prénom & Nom du demandeur.
*   `company` (String, Nullable) : Entreprise.
*   `email` (String) : Email de contact.
*   `phone` (String, Nullable) : Téléphone / WhatsApp.
*   `project_type` (String) : Type de projet sélectionné (Spot, Reels, Corporate, Event, etc.).
*   `budget` (String) : Fourchette budgétaire sélectionnée (ex: "150k – 350k FCFA").
*   `description` (Text, Nullable) : Contenu/détails de la demande de projet.
*   `status` (Enum: `['Nouveau', 'Envoyé', 'Accepté', 'Refusé']`) : État du devis (par défaut `Nouveau`).
*   `user_id` (BigInteger, Foreign Key, Nullable, Cascade) : Lien optionnel vers la table `users` (si le client est authentifié lors de sa demande).
*   `timestamps`

### E. Table `projects` (Projets Kanban)
Permet le suivi des projets acceptés par l'administration (en lien avec le tableau Kanban statique existant).
*   `id` (BigInteger, PK, Auto-increment)
*   `title` (String) : Titre du projet.
*   `quote_id` (BigInteger, Foreign Key, Nullable, Set Null) : Devis d'origine associé.
*   `client_id` (BigInteger, Foreign Key, Nullable, Set Null) : Utilisateur de type client associé.
*   `progress` (Integer) : Pourcentage de progression (0 à 100).
*   `step` (Enum: `['Scripting', 'Tournage', 'Montage', 'Terminé']`) : Colonne correspondante du tableau Kanban.
*   `priority` (Enum: `['Bas', 'Moyen', 'Urgent']`) : Niveau d'urgence.
*   `team` (Json/Array) : Équipe affectée au projet (ex: `['TA', 'AK']`).
*   `deadline` (Date, Nullable) : Date limite de livraison.
*   `timestamps`

---

## 🔐 3. Système d'Authentification & Rôles

### A. Espace Administration (Admin)
*   **Connexion Seeder** : L'administrateur se connecte avec des accès créés par un seeder sécurisé (`AdminUserSeeder`).
    *   *Exemple par défaut* : `thierry.a` ou `thierryamenyah1@gmail.com` avec un mot de passe sécurisé.
*   **Protection** : Middleware `IsAdmin` activé sur le groupe de routes `/admin/*`. Si un utilisateur non-admin tente d'y accéder, il est redirigé vers une erreur 403 ou la page de connexion admin dédiée.
*   **Session** : Possibilité de garder la session active grâce au cookie `remember_token` (option persistante 30 jours présente dans l'interface de connexion).

### B. Espace Utilisateur (Clients)
*   **Inscription Standard** : Formulaire public demandant le nom, email, téléphone/WhatsApp et mot de passe.
*   **Connexion Standard** : Authentification via email et mot de passe.
*   **Connexion / Inscription Google (OAuth2)** :
    *   Utilisation de **Laravel Socialite**.
    *   Si l'adresse email retournée par Google existe déjà en base, l'utilisateur est connecté à son compte existant et son `google_id` est associé.
    *   Si l'adresse email n'existe pas, un compte utilisateur de rôle `client` est automatiquement créé avec un mot de passe aléatoire inopérant, puis l'utilisateur est connecté.

---

## ⚡ 4. Fonctionnalités & Logique Métier

### 💬 CRUD des Témoignages (Admin)
*   **Formulaire de création** (`admin/temoignages/create.blade.php`) : Saisie du nom, entreprise/poste, contenu de l'avis et statut de publication (`published` / `draft`).
*   **Visualisation & Recherche** : Tableau ordonné avec filtres de statut et recherche par mot-clé.
*   **Côté Public** : Seuls les témoignages au statut `published` sont récupérés dans l'accueil (`Frontend\PageController`) et affichés sous forme de carrousel dynamique.

### 🎥 CRUD des Vidéos Portfolio (Admin)
*   **Formulaire de création** (`admin/videos/create.blade.php`) : Saisie du titre, catégorie (Spot, Événement, Reels, Corporate), description, URL (YouTube/Vimeo), statut (Public / Archivé) et importation optionnelle d'une miniature personnalisée.
*   **Traitement automatique de l'URL** : Un service utilitaire extrait l'identifiant de la vidéo YouTube ou Vimeo pour générer automatiquement l'URL compatible iframe (`embed_url`) stockée en base de données.
*   **Côté Public** : Affichage dans la page Portfolio. Les utilisateurs peuvent filtrer en JavaScript ou via requêtes AJAX par catégorie (Spot, Événement, Reels, Corporate).

### 📋 Gestion des Demandes de Devis (Quotes)
*   **Soumission publique** : Tout visiteur (connecté ou non) peut remplir le formulaire de contact/devis (`public/contact.html`).
*   **Stockage et notification** : La requête valide les données via `StoreQuoteRequest` et crée une ligne dans `quotes` avec le statut initial `Nouveau`.
*   **Panneau d'Administration** : 
    *   La page `admin/devis.html` charge dynamiquement les devis.
    *   Les devis sont classés par onglets filtrables : *Tous*, *Nouveau*, *Devis Envoyé*, *Accepté*, *Refusé*.
    *   Un clic sur une ligne ouvre un volet latéral (tiroir) affichant le détail complet de la demande et un bouton pour mettre à jour son statut.

### 👥 Gestion des Clients (Admin)
*   **Création de la page Clients** (`admin/clients/index.blade.php`) : Cette page (qui manquait dans la maquette statique) présentera sous forme de tableau interactif la liste complète de tous les utilisateurs inscrits en tant que `client`.
*   **Fonctionnalités Admin pour les clients** :
    *   Affichage du profil complet (Nom, Email, Téléphone WhatsApp, Date d'inscription, Méthode de connexion standard ou Google).
    *   Historique des devis envoyés par ce client spécifique.
    *   Historique de ses projets en cours et passés.
    *   Action de modération (Activer / Suspendre le compte).

---

## 💡 5. Suggestions d'Améliorations & Optimisations

Pour assurer un fonctionnement optimal et enrichir l'expérience utilisateur, nous préconisons d'implémenter les mécaniques suivantes :

### 1. Synchronisation automatique Devis ➔ Kanban
*   **Logique** : Lorsqu'un administrateur change le statut d'un devis à `Accepté` dans son panneau de contrôle, le système déclenche un événement (ou une action) qui crée automatiquement un nouveau projet dans la table `projects` avec le statut `Scripting`.
*   **Bénéfice** : Évite les doubles saisies et assure un suivi fluide de la production vidéo dès la signature commerciale.

### 2. Notifications Email Automatisées
*   **Pour le Client** : Envoi d'un e-mail de confirmation élégant dès la soumission de son devis ("Nous avons bien reçu votre demande, nous vous répondons sous 24h").
*   **Pour l'Admin (Thierry Amenyah)** : Envoi d'une alerte email/WhatsApp instantanée l'informant qu'une nouvelle demande de devis vient d'être reçue.

### 3. Espace Client Sécurisé (Portail Client)
*   **Concept** : Permettre aux clients connectés (via mot de passe ou compte Google) d'accéder à un tableau de bord minimaliste public.
*   **Fonctionnalités** :
    *   Suivre en temps réel l'avancement de leurs projets vidéo actifs directement sur un mini-Kanban public en lecture seule.
    *   Visualiser l'historique de leurs devis passés et télécharger les fichiers finaux ou les liens de livrables.

### 4. Hébergement & Traitement Vidéo
*   **Recommandation** : Pour le portfolio, maintenir l'hébergement externe (YouTube/Vimeo) pour économiser la bande passante du serveur d'application.
*   **Automatisation de miniatures** : Si le client ne fournit pas d'image de couverture lors de l'ajout d'une vidéo, utiliser l'API publique de YouTube pour récupérer automatiquement la miniature de la vidéo à partir de son identifiant (`https://img.youtube.com/vi/ID_VIDEO/maxresdefault.jpg`).

---

## 🛠️ 6. Plan de Route pour le Développement Backend

Pour matérialiser cette structure, nous procéderons selon l'ordre logique suivant :

1.  **Configuration Initiale** : Configuration du fichier `.env`, de la base de données SQLite et installation des packages requis (ex: `laravel/socialite`).
2.  **Création des Modèles et Migrations** : Création séquentielle des schémas de base de données avec leurs contraintes de clés étrangères.
3.  **Mise en place des Seeders** : Création de l'administrateur par défaut et chargement de faux devis, vidéos et témoignages pour les tests.
4.  **Développement de l'Authentification** : Configuration de Laravel Fortify/Breeze ou implémentation sur mesure des contrôleurs d'authentification avec la redirection Google OAuth2.
5.  **Développement des CRUD Administrateur** : 
    *   CRUD Témoignages
    *   CRUD Vidéos Portfolio
    *   Panneau tiroir des Devis
    *   Interface de gestion et modération des Clients
6.  **Dynamisation du Frontend** : Remplacement des pages statiques publiques par des templates Blade affichant les données issues des contrôleurs (Témoignages, Portfolio, soumission fonctionnelle de devis).
7.  **Tests & Recette** : Validation des formulaires (validation des champs, sécurité csrf, gestion des exceptions).
