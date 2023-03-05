# DockerComp

Ce projet est un template pour démarrer un projet Symfony avec Docker. Il utilise Apache comme serveur web, une base de données MySQL et PhpMyAdmin. Le projet est divisé en 3 conteneurs : un pour PHP, un pour MySQL et un pour PhpMyAdmin.

### Pré-requis

Ce qu'il est requis pour commencer avec notre projet

- Il faut avoir Docker Desktop

### Installation

1. Clonez le projet depuis GitHub :

`git clone https://github.com/SamEPK/DockerComp.git` 

2. Entrez dans le répertoire du projet :

`cd DockerComp`

## Démarrage

1. Builder le projet :

`docker-compose build`

2. Lancez les containers :

`docker-compose up -d`

3. Executer le bash du container php :

`docker exec -it www_docker_project bash`

4. Entrez dans le répertoire du projet php :

`cd project`

5. Créez la base de données en exécutant la commande suivante :

`php bin/console doctrine:database:create`

6. Migrez les données vers la base de donnée :

`php bin/console doctrine:migrations:migrate`

7. Accédez à la base de donnée :

`http://localhost:8000`

`Utilisateur : root
Mot de passe : `

Vous êtes prêt à utiliser votre application Symfony avec Docker !

## Utilisation

Vous pouvez accéder à votre application Symfony en ouvrant votre navigateur web et en allant à l'adresse suivante :

`http://127.0.0.1:8743/book/`

## Arrêt

Pour arrêter les conteneurs, exécutez la commande suivante :

`docker-compose down`

Cela arrêtera les conteneurs et supprimera les données de la base de données. Si vous souhaitez conserver les données de la base de données, utilisez la commande suivante pour arrêter les conteneurs :

`docker-compose stop`

## Fabriqué avec

_exemples :_
* [Symfony] - Le framework PHP utilisé
* [Docker]- Plateforme de conteneurisation utilisée
* [Apache]- Serveur web utilisé
* [MySQL]- Système de gestion de base de données relationnelles utilisé
* [PhpMyAdmin]- Interface web pour gérer les bases de données MySQL

## Auteurs
Les auteurs qui ont contribué à ce projet !
* **Samuel**
* **Vithushan**
* **Abdallah** 
