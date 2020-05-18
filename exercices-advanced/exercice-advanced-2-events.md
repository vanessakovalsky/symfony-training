# Ajouter un évènement spécifique et le déclencher avec un listener

## Pré-requis

* Repartir du corrigé (ou de l'exercice fait) de l'exercice 1

## Ajouter un évènement spécifique

* Déclarer un évènement appeler LogEvent celui-ci va permettre de générer des logs à chaque fois que l'on créé une nouvelle entité dans la BDD.
- Déclencher cet évènement sur chaque fonction new des controller

## Créer le listener 
* Déclarer un eventListener qui écoutera LogEvent et permettra en utilisant le composant Logger d'enregistrer dans les logs une trace de cette ajout (utilisateur, date et heure, type d'objet et ID de l'objet créé sont à enregistrer)

-> A vous de jouer :)