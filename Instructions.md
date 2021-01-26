/*******FICHIER D'INSTRUCTION*******/

systeme d'exploitation: windows 10
wampserver 64bits v3.1.9
phpMyAdmin v4.8.5
php v7.3.5
mariadb 10.3.14
IDE: phpstorm
type de projet: Symfony


Tout dabord recuperer le projet sur git, il faut aussi recuperer la base de données sur google drive.
Placer le projet à l'endroit voulu. Il faut ensuite mettre en place la base de données.
Pour se faire allez dans phpMyAdmin et choisissez l'onglet importer, importer le fichier 'livraisonrepas.sql' et appuyer sur executer pour finaliser.
Une fois fait vous pouvez desormais lancer le server symfony a partir de ligne de commande.

Grace a un command prompt placer vous dans le projet
Faite ensuite la commande -> symfony server:start
le server local se lance et vous pouvez profiter du site en version local et tester toute ses fonctionnalités
