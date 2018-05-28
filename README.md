flyaround
=========

I-Flyaround Init

Le dépôt contient uniquement les éléments suivants à la racine : app, bin, src, tests/AppBundle/Controller, var, web, .gitignore, README.md, composer.json, composer.lock, phpunit.xml.dist.


II-Générons du CRUD

Les entités sont toutes générées dans AppBundle avec les commandes Doctrine.
Elles sont nommées en UpperCamelCase.
La config de chaque entité est en annotation.
Elles contiennent les bonnes propriétés et les propriétés sont nommées et typées correctement.
Les entités ont été persistées en BDD.
Les CRUD sont générés pour chaque entité.
Les entités Flight et Reservation ont des actions d'écriture mais pas le Site (ne pas mettre "yes" à la première question).
La config des CRUD est en annotation.
Les routes sont cohérentes et fonctionnelles (même si le générateur n'a pas réussi à tout faire tout seul).
L'accès aux tables (par PhpMyAdmin ou l'onglet Database de PhpStorm) est fonctionnel.
Les CRUD agissent bien avec la BDD (exemple : insérer un vol depuis http://localhost:8000/flight/new).


III-Mise en place des relations

Les entités correspondent exactement au nouveau schéma de BDD avec les mêmes champs / attributs.
Les entités Review et User ont été créées.
Les relations ont été respectées pour chaque entité.
Les relations bidirectionnelles sont utilisées dans le bon sens.
Les CRUD de Reservation et Flight ont été réécrits.
Toutes les entités se sont vu attribuer une méthode magique __toString().
Les getters et setters sont à jour.
Le CRUD de Review n'a pas été généré.
Les fichiers ne contiennent aucun warning relevé par PhpStorm.

Lors des tests :

Il n'y a pas d'erreur quand on lance un doctrine:schema:update --force et un server:run.
Toutes les routes (référencées en debug:router) sont fonctionnelles.
Il est possible d'ajouter dans l'ordre suivant : un avion, un utilisateur, un vol puis une réservation.


IV-Créer sa propre route

Un contrôleur et des vues sont créés avec leurs noms respectifs.
Le contrôleur et les routes sont configurés à l'aide d'annotations.
Les noms des deux méthodes d'action respectent les conventions Symfony.
Le contrôleur respecte les normes PSR.
Les routes sont cohérentes et fonctionnelles.
Les méthodes de requêtes sont en adéquation avec tes besoins futurs.

V-Créer les méthodes restantes (read, update, delete)

Les annotations respectent les conventions Symfony.
Les routes sont fonctionnelles et cohérentes.
Les méthodes de requêtes (GET, POST, DELETE) sont en adéquation avec les méthodes de la classe ReviewController.
Les redirections sont justifiées et cohérentes (editAction() -> showAction(), deleteAction() -> indexAction())
La méthode showAction() affiche un avis, avec la possibilité de le supprimer.
La méthode editAction() permet de sauvegarder les modifications d'un avis, avec la possibilité de le supprimer.
La méthode deleteAction() permet de supprimer un avis ciblé.
La persistance des données est contrôlée.


VI-Surcharger le formulaire d'enregistrement de FOSUserBundle

Un nouveau FormType RegistrationType a été créé.
Le FormType contient tous les champs obligatoires et ses champs sont non NULL.
Certains champs sont non obligatoires pour le formulaire et n'ont pas besoin d'être ajoutés automatiquement en BDD (note, creationDate).
La configuration a été mise à jour : services.yml et config.yml.
La surcharge (l'override) est fonctionnelle.
L'inscription est fonctionnelle.
Tu es authentifié et tu disposes d'un token comme sur la capture d'écran.
L’intégralité de l'application n'est accessible qu'après identification (sauf la page d'accueil et la page de login/inscription évidemment). Si l'utilisateur n'est pas authentifié, il est redirigé sur /login.






