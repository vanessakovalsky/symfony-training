# Doctrine : query builder et lifecycle callback

Cet exercice a pour objectifs :
* L'utilisation du query builder pour afficher les pronostics 
fait par un utilisateur dans sa fiche utilisateur
* L'ajout d'une date de création automatique sur l'enregistrement
des pronostics et la mise à jour sur le match de la date 
du dernier pronostic

## Création et utilisation du query builder
* Dans le fichier Repository adequat, créer un requête avec Doctrine
qui permettra de récupérer les pronostics faits par un utilisateur
rassemblé par match (plusieurs pronostic sur le même match possible)
* Dans la fonction show du controlleur Utilisateur, appeler la requête
créé pour ajouter la liste des pronostics par match à l'affichage
(modifier si nécessaire le template twig associé)

## Ajout d'une date de création et maj de date du dernier pronostic sur un match
*  Ajouter dans l'entité Pronostic un champ createdDate 
* Ajouter un lifecyclecallback, pour déclencher un setCreatedDate
sur l'evenement PrePersist de Doctrine via les annotations dans l'entité
* Ajouter un champ date du dernier pronostic sur l'entité Game
* Ajouter un EventListener en utilisant les évènements de Doctrine
pour mettre à jour automatiquement le champ date du dernier pronostic 
sur les games lors de l'ajout d'un pronostic
* Configurer cet EventListener dans le services.yaml

* En cas de besoin, voir la documentation : 
https://symfony.com/doc/current/doctrine/events.html

-> A vous de jouer