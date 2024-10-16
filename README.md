# dockertp2
# Docker TP2 Project

Les fichiers WordPress ne sont pas inclus dans ce repository car ils sont trop volumineux. Voici comment les télécharger et les ajouter au projet.

## Étape 1 : Serveur NGINX avec PHP-FPM

Dans cette première étape, nous allons configurer deux containers Docker :
1. **HTTP** : Un container avec un serveur NGINX écoutant sur le port 8080.
2. **SCRIPT** : Un container avec un interpréteur PHP-FPM.

### Instructions de Build

1. **Construisez les containers NGINX et PHP** :

   - Construisez le container PHP :

     ```bash
     docker build -t custom-php -f Dockerfile.php .
     ```

   - Construisez le container NGINX :

     ```bash
     docker build -t custom-nginx -f Dockerfile.nginx .
     ```

2. **Démarrez les containers** :

   - Démarrez le container PHP-FPM :

     ```bash
     docker run -d --name script custom-php
     ```

   - Démarrez le container NGINX :

     ```bash
     docker run -d --name http --link script:script -p 8080:8080 custom-nginx
     ```

## Étape 2 : Ajout de MariaDB et exécution des requêtes CRUD

Dans cette étape, nous allons ajouter un troisième container Docker pour MariaDB. Un fichier `test_bdd.php` sera utilisé pour exécuter des requêtes CRUD (Create, Read, Update, Delete) sur la base de données.

### Instructions de Build

1. **Démarrez le container MariaDB** :

   - Démarrez le container MariaDB avec un mot de passe root et une base de données nommée `testdb` :

     ```bash
     docker run -d --name data -e MYSQL_ROOT_PASSWORD=password -e MYSQL_DATABASE=testdb mariadb
     ```

2. **Construisez et démarrez les containers PHP et NGINX** :

   - Construisez le container PHP-FPM :

     ```bash
     docker build -t custom-php -f Dockerfile.php .
     ```

   - Construisez le container NGINX :

     ```bash
     docker build -t custom-nginx -f Dockerfile.nginx .
     ```

   - Démarrez le container PHP-FPM :

     ```bash
     docker run -d --name script custom-php
     ```

   - Démarrez le container NGINX :

     ```bash
     docker run -d --name http --link script:script -p 8080:8080 custom-nginx
     ```


## Étape 3 : Installation de WordPress

Dans cette étape, nous allons remplacer les pages PHP simples par une installation complète de WordPress. Vous allez configurer NGINX, PHP-FPM et MariaDB pour faire fonctionner WordPress dans des containers Docker.

### Instructions de Build

1. **Téléchargez WordPress** :

   Avant de lancer les containers, vous devez télécharger WordPress et l'ajouter au dossier `src`.

   - Téléchargez WordPress :

     ```bash
     curl -O https://wordpress.org/latest.tar.gz
     ```

   - Extrayez WordPress dans le dossier `src` :

     ```bash
     mkdir -p etape3/src
     tar -xvzf latest.tar.gz -C src --strip-components=1
     ```

2. **Démarrez le container MariaDB** :

   - Démarrez MariaDB avec les informations de connexion nécessaires pour WordPress :

     ```bash
     docker run -d --name data2 -e MYSQL_ROOT_PASSWORD=password -e MYSQL_DATABASE=wordpress mariadb
     ```

3. **Construisez et démarrez les containers PHP et NGINX** :

   - Construisez le container PHP-FPM pour WordPress :

     ```bash
     docker build -t custom-php -f Dockerfile.php .
     ```

   - Construisez le container NGINX pour WordPress :

     ```bash
     docker build -t custom-nginx -f Dockerfile.nginx .
     ```

   - Démarrez le container PHP-FPM :

     ```bash
     docker run -d --name script3 --link data2:data custom-php
     ```

   - Démarrez le container NGINX :

     ```bash
     docker run -d --name http3 --link script3:script -p 8083:8080 custom-nginx
     ```
## Étape 4 : Docker Compose pour orchestrer NGINX, PHP-FPM, et MariaDB

Dans cette étape, nous allons simplifier le processus de build et d'exécution des containers en utilisant Docker Compose. Le fichier `docker-compose.yml` orchestrera tous les services : NGINX, PHP-FPM et MariaDB, avec une installation complète de WordPress.

### Instructions de Build avec Docker Compose

1. **Téléchargez WordPress** :

   Si vous ne l'avez pas déjà fait, téléchargez WordPress et placez-le dans le dossier `src` :

   - Téléchargez WordPress :

     ```bash
     curl -O https://wordpress.org/latest.tar.gz
     ```

   - Extrayez WordPress dans le dossier `src` :

     ```bash
     mkdir -p etape4/src
     tar -xvzf latest.tar.gz -C src --strip-components=1
     ```

2. **Lancez les services avec Docker Compose** :

   Docker Compose va orchestrer les trois services : NGINX, PHP-FPM et MariaDB.

   - Exécutez la commande suivante pour construire et démarrer les services :

     ```bash
     docker-compose -f docker-compose.yml up --build
     ```

   Cette commande construira les images Docker pour PHP et NGINX, et démarrera les trois containers (NGINX, PHP-FPM, et MariaDB).





