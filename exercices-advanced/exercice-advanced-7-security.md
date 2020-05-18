# Sécuriser notre application symfony

L'objectif de cet exercice est de sécuriser notre application sur plusieurs aspects :
- Mise en place d'un login
- Ajout de rôle aux utilisateurs : admin et utilisateurs connectés
- Mise en place de limitation d'accès via les chemins
- Mise en place de voters pour limiter la modification

## Mise en place d'un login :
* A l'aide du FosUserBundle ou en créant manuellement un système mettre en place les éléments suivants : 
* * page de connexion
* * deconnexion
* * mot de passe oublié avec envoi d'email
* * sécurisation du mot de passe 
* * Limitation du site aux utilisateurs connectés

## Définition des rôles et limitation d'accès aux pages: 
* Définition de deux rôles :
* * Admin
* * User
* Seul les administrateurs peuvent ajouter / modifier / supprimer les utilisateurs
* Seul les administrateurs peuvent supprimer des matchs 

## Limitation de la modification 
* A l'aide Voters, limiter la modification des pronostics aux seuls pronostics créé par l'utilisateur connecté (impossible de modifier les pronostics des autres)

-> A vous de jouer