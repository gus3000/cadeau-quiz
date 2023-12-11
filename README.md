Un moteur de quiz, fait pour le streameur [cadeauAnthony](https://www.twitch.tv/cadeauanthony)

Lui dites pas, c'est une surprise !

# Kanban
https://github.com/users/gus3000/projects/2
# Lancer le projet en local

pré-requis : avoir Docker installé et configuré pour l'utilisateur courant.

1) L'application utilise Twitch pour se connecter, donc vous devez avoir créé une application Twitch ([doc](https://dev.twitch.tv/console/apps)).
2) Cloner le projet

```bash
git clone https://github.com/gus3000/cadeau-quiz
```

3) Personnaliser (en le créant si besoin) le fichier `.env` à partir du fichier `.env.example`. Il faudra notamment générer APP_KEY, et récupérer le TWITCH_CLIENT_ID et TWITCH_CLIENT_SECRET de votre application Twitch.

4) Installer les dépendances Composer en utilisant la commande décrite dans la [documentation](https://laravel.com/docs/10.x/sail#installing-composer-dependencies-for-existing-projects) :
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```

5) Lancer les conteneurs dockers du projet. Quelques configurations sont personnalisées, donc on doit build les conteneurs :
```bash
vendor/bin/sail up -d --build
```

6) Lancer le build du front Vue :
```bash

```
