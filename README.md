flyaround
=========

I-Flyaround Init

Le défi est simple : Tu initialiseras un dépôt Git hébergé sur GitHub avec une release "Quête nouveau projet" et, pour tag "q_new", tu entreras l'URL de la release dans le champ solution.

    L'URL d'une release GitHub ressemble à ça : https://github.com/USER_NAME/flyaround/tree/q_new

Critéres de validation

Le dépôt contient uniquement les éléments suivants à la racine : app, bin, src, tests/AppBundle/Controller, var, web, .gitignore, README.md, composer.json, composer.lock, phpunit.xml.dist.


II-Générons du CRUD

Pour finir en beauté, je te propose de générer les entités suivantes et les CRUD qui vont avec. Seuls les administrateurs pourront créer de nouveaux terrains (et non pas des simples utilisateurs), alors nous ne générerons pas les actions d'écriture pour cette entité. Poste le lien de la release (q_crud) quand tu as fini (n'oublie pas de push).

Schéma entités

    Pas de panique, Symfony n'est pas qu'une histoire de génération. Nous mettrons les mains dans le code dès la prochaine quête. Par ailleurs, si tu vois un "?" à coté d'un champ, cela veut dire qu'il peut être nullable (non rempli).

Pour info, en aviation les terrains (aéroports, aérodromes, altiports, ...) sont identifiés par un code à quatre lettres, attribué par l'ICAO (International Civil Aviation Organization).

    Pour finir, pense toujours à mettre à jour le schéma de ta BDD une fois les entités créées.

Critéres de validation

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

Le challenge est simple :D. Il te faut mettre à jour les entités et les configs de Doctrine pour qu'elles correspondent au nouveau schéma de BDD.

Pour la table (l'entité) User, il te faut :

    Créer l'entité avec la commande Doctrine et les champs du schéma bien respectés.
    Ajouter une méthode __toString() qui retourne le prénom concaténé au nom.
    Persister tes modifications puis générer le CRUD.

CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, firstName VARCHAR(32) NOT NULL, lastName VARCHAR(32) NOT NULL, phoneNumber VARCHAR(32) NOT NULL, birthDate DATE NOT NULL, creationDate DATETIME NOT NULL, note SMALLINT NOT NULL, isACertifiedPilot TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

Pour la table (l'entité) Review, il te faut :

    Créer l'entité avec la commande Doctrine et les champs du schéma bien respectés (sans les clés étrangères, que tu ajouteras juste après).
    Ajouter une méthode __toString() qui return l'id de Review.
    Ajouter le champ userRated, relation ManyToOne vers User sans bidirectionnalité. La relation est simple, pas de OneToMany dans l'autre sens (comme au début de la quête).
    Ajouter le champ reviewAuthor, relation ManyToOne vers User avec une bidirectionnalité (identique à departure).
    Persister tes modifications ET NE PAS GÉNÉRER LE CRUD. Tu le verras dans une autre quête.

CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, user_rated_id INT NOT NULL, review_author_id INT NOT NULL, text LONGTEXT NOT NULL, publicationDate DATETIME NOT NULL, note SMALLINT NOT NULL, INDEX IDX_794381C6AA3E2149 (user_rated_id), INDEX IDX_794381C66184681A (review_author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE review ADD CONSTRAINT FK_794381C6AA3E2149 FOREIGN KEY (user_rated_id) REFERENCES user (id);
ALTER TABLE review ADD CONSTRAINT FK_794381C66184681A FOREIGN KEY (review_author_id) REFERENCES user (id);

Pour la table (l'entité) Flight, il te faut :

    Ajouter une méthode __toString() qui retourne le départ concaténé à l'arrivée.
    Ajouter le champ arrival, relation ManyToOne vers Site avec une bidirectionnalité (identique à departure).
    Ajouter le champ plane, relation ManyToOne vers PlaneModel avec une bidirectionnalité (identique à departure et à arrival).
    Ajouter le champ pilot, relation ManyToOne vers User avec une bidirectionnalité (identique à ci-dessus).
    Persister tes modifications, réécrire le CRUD et régénérer les getters/setters.

ALTER TABLE flight ADD arrival_id INT NOT NULL, ADD plane_id INT NOT NULL, ADD pilot_id INT NOT NULL;
ALTER TABLE flight ADD CONSTRAINT FK_C257E60E62789708 FOREIGN KEY (arrival_id) REFERENCES site (id);
ALTER TABLE flight ADD CONSTRAINT FK_C257E60EF53666A8 FOREIGN KEY (plane_id) REFERENCES plane_model (id);
ALTER TABLE flight ADD CONSTRAINT FK_C257E60ECE55439B FOREIGN KEY (pilot_id) REFERENCES user (id);
CREATE INDEX IDX_C257E60E62789708 ON flight (arrival_id);
CREATE INDEX IDX_C257E60EF53666A8 ON flight (plane_id);
CREATE INDEX IDX_C257E60ECE55439B ON flight (pilot_id);

Pour la table (l'entité) Reservation, il te faut :

    Ajouter une méthode __toString() qui return l'id de Reservation.
    Ajouter le champ passenger, relation ManyToOne vers User avec une bidirectionnalité (identique à ci-dessus).
    Ajouter le champ flight, relation ManyToOne vers Flight avec une bidirectionnalité (identique à ci-dessus).
    Persister tes modifications, réécrire le CRUD et régénérer les getters/setters.

ALTER TABLE reservation ADD passenger_id INT NOT NULL, ADD flight_id INT NOT NULL;
ALTER TABLE reservation ADD CONSTRAINT FK_42C849554502E565 FOREIGN KEY (passenger_id) REFERENCES user (id);
ALTER TABLE reservation ADD CONSTRAINT FK_42C8495591F478C5 FOREIGN KEY (flight_id) REFERENCES flight (id);
CREATE INDEX IDX_42C849554502E565 ON reservation (passenger_id);
CREATE INDEX IDX_42C8495591F478C5 ON reservation (flight_id);

    Ce challenge implique d'être rigoureux. Tu dois avoir approximativement 16 requêtes exécutées. Attention à bien mettre "yes" lors des réécritures de CRUD et à bien régénérer les entités (getters/setters) à la fin. Pour finir, relis bien chaque entité et compare-les au schéma. Encore une fois, ne génère pas le CRUD pour l'entité Review.

    Une fois le challenge terminé, regarde si tu n'as pas d'erreurs de syntaxe dans tes fichiers (warnings). Il en va de même pour les chemins absolus générés par la CLI Doctrine.

Les relations bidirectionnelles ne sont pas pertinentes à chaque fois. Veille à bien visualiser les relations entre les tables, notamment en imaginant le fonctionnement général du projet et en te posant plusieurs questions-clés :

    Y a-t-il plusieurs utilisateurs pour un seul avis, ou plusieurs avis pour un utilisateur ?
    Un vol de particuliers contient-il plusieurs pilotes ou un seul ? Est-ce qu'un pilote peut réaliser plusieurs vols ? etc.

Pour finir, voici un petit conseil : lorsque tu ajoutes des relations entre les tables (ex: FK), évite de le faire avec celles-ci remplies, car tu peux tomber sur des contraintes d'intégrité et de violations.
Critéres de validation

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

Afin d'introduire ta prochaine quête, tu peux préparer ton plan de travail, c'est-à-dire un contrôleur et sa route.

    Tu te souviens de ton entité Review, qui correspond aux avis attribués entre utilisateurs ? Eh bien tu n'as pas mis à jour son CRUD exprès, et ça tombe bien !

Pour ça, crée un contrôleur nommé ReviewController.php dans un nouveau fichier ReviewController.php, qui aura deux méthodes et donc deux routes : /review/ et /review/new, ainsi que leurs vues associées. La page pointée par /new/ contiendra un futur formulaire. Par conséquent, veille bien à la configuration de ta route et ses méthodes.

    Pense aux méthodes de requêtes et à ce que tu souhaites obtenir. N'oublie pas toutes les liaisons qu'il y a de fichier à fichier. Good luck !

Critéres de validation

    Un contrôleur et des vues sont créés avec leurs noms respectifs.
    Le contrôleur et les routes sont configurés à l'aide d'annotations.
    Les noms des deux méthodes d'action respectent les conventions Symfony.
    Le contrôleur respecte les normes PSR.
    Les routes sont cohérentes et fonctionnelles.
    Les méthodes de requêtes sont en adéquation avec tes besoins futurs.

V-Créer les méthodes restantes (read, update, delete)

Durant cette quête assez difficile, tu as vu toutes les notions-clés des formulaires Symfony. Tu as appris à créer un formulaire de A à Z sans les commandes Symfony, et ce, pour les méthodes indexAction() et newAction().

    Mais ton CRUD n'est pas complet, Jammy ?

En effet ! Pour ce challenge tu devras :

    Créer la méthode showAction(), sa route, et sa vue affichant un objet $review avec la possibilité de pouvoir le supprimer.
    Créer la méthode editAction(), sa route, et sa vue permettant de modifier un avis déjà existant.
    Créer la méthode deleteAction() et sa route permettant la suppression d'un avis.

    Indice : Les routes de ces 3 méthodes ont quelque chose en commun. De plus, tu disposes déjà de tout ce dont tu as besoin.
Critéres de validation

    Les annotations respectent les conventions Symfony.
    Les routes sont fonctionnelles et cohérentes.
    Les méthodes de requêtes (GET, POST, DELETE) sont en adéquation avec les méthodes de la classe ReviewController.
    Les redirections sont justifiées et cohérentes (editAction() -> showAction(), deleteAction() -> indexAction())
    La méthode showAction() affiche un avis, avec la possibilité de le supprimer.
    La méthode editAction() permet de sauvegarder les modifications d'un avis, avec la possibilité de le supprimer.
    La méthode deleteAction() permet de supprimer un avis ciblé.
    La persistance des données est contrôlée.

La solution sera comme toujours postée via un lien pointant vers un repository de ton github.

VI-Surcharger le formulaire d'enregistrement de FOSUserBundle

Tu as dû constater que tu ne pouvais pas ajouter d'utilisateur sur la route fos_user_registration_register et que tu avais, de plus, une erreur de ce type lors de la validation :

Et c'est tout à fait normal ! Lors du challenge, tu devras corriger cette erreur :

    Créer un nouveau FormType RegistrationType qui va surcharger celui de FOSUserBundle.
    Mettre à jour services.yml et config.yml avec les bons chemins relatifs à la surcharge de FOSUserBundle:RegistrationType.
    Pouvoir t'inscrire comme tu le souhaites avec tous les champs de ta classe User.
    Être redirigé automatiquement sur la page login, si l'utilisateur n'est pas authentifié.

Critéres de validation

    Un nouveau FormType RegistrationType a été créé.
    Le FormType contient tous les champs obligatoires et ses champs sont non NULL.
    Certains champs sont non obligatoires pour le formulaire et n'ont pas besoin d'être ajoutés automatiquement en BDD (note, creationDate).
    La configuration a été mise à jour : services.yml et config.yml.
    La surcharge (l'override) est fonctionnelle.
    L'inscription est fonctionnelle.
    Tu es authentifié et tu disposes d'un token comme sur la capture d'écran.
    L’intégralité de l'application n'est accessible qu'après identification (sauf la page d'accueil et la page de login/inscription évidemment). Si l'utilisateur n'est pas authentifié, il est redirigé sur /login.






