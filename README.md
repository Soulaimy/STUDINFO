# Plateforme de Gestion des Inscriptions

Cette application Laravel permet à trois types d'utilisateurs (étudiant, responsable administratif, responsable pédagogique) de gérer le processus d'inscription à des formations.

## Prérequis

- PHP >= 8.1
- Composer
- MySQL ou autre base de données compatible
- Node.js et npm (facultatif, pour assets frontend)

## Installation

1. **Cloner le projet ou extraire le fichier ZIP**

```bash
unzip gestion_inscriptions.zip
cd gestion_inscriptions
```

2. **Installer les dépendances PHP**

```bash
composer install
```

3. **Configurer l'environnement**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Configurer la base de données**

Dans `.env`, modifier les champs suivants :

```
DB_DATABASE=nom_de_la_base
DB_USERNAME=utilisateur
DB_PASSWORD=mot_de_passe
```

5. **Lancer les migrations**

```bash
php artisan migrate
```

6. **Lancer le serveur**

```bash
php artisan serve
```

Visitez `http://127.0.0.1:8000`

## Accès utilisateurs

Créer manuellement les utilisateurs dans la base de données avec les rôles suivants :

- `etudiant`
- `admin`
- `pedagogique`

Le champ `role` est obligatoire dans la table `users`.

## Structure du projet

- **Étudiant** : peut s'inscrire, soumettre une demande, suivre son statut.
- **Admin** : valide les demandes d’un point de vue administratif, suit les paiements.
- **Pédagogique** : valide pédagogiquement les demandes, gère les formations.

## Sécurité

- Middleware par rôle (`CheckRole`) pour protéger les routes.
- Redirection automatique après connexion selon le rôle utilisateur.

## Auteur

Soulaimy Ahamed

