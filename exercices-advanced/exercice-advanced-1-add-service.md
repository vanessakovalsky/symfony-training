# Exercice 1 - Ajouter un service à notre bundle

Cette exercice va nous permettre d'ajouter un service à notre application.
Ce service permettra de déclencher l'envoi d'email de manière centralisé

## Pré-requis :
- Récupérer l'application qui est dans le dépôt dans le dossier : exercices-advanced/code-base
- Installer le symfony avec composer à partir du composer.json

## Etape 1 - Création du service
- Créer un service qui utilisera Mailer pour gérer de manière centralisé l'envoi de SwiftMailer
- Vérifier que le service est déclaré et accessible avec la console (si besoin modifier le fichier services.yaml)

## Etape 2 - Utiliser le service créé
- Dans le controller PronosticController, envoyer un mail pour chaque
ajout de pronostic à votre adresse email 

--> A vous de jouer