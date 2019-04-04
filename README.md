# beer test app

Simple PHP(7.2) + Symfony(4.2) app with REST API and AngularJS (1.7) frontend

### Standard application setup steps:

- please setup env. file for DB access for both front and CLI on the basis of .env.dist
- run composer/install
- php bin/console doctrine:migrations:migrate to create DB structure
- php bin/console app:import to import data from external API
- after that please setup correct IP and host URL pointing to your machine (in e.g. symfony.local pointing to 127.0.0.0)
- once this is done you shoulde be available to access to the frontend of the app by symfony.local (beers grid shuld be available there)
- REST api of the app should then be available over:
- symfony.local/api/beers (list of the beers with pagination and searching) additionals parametrs for pagination are ?page=X&size=X
- symfony.local/api/beers/:beerId (preview of the single beer where :beerId is just an ID in symfony DB)
- symfony.local/api/brewers (list of the brewers available in the system)




### Docker application setup:

```
git clone https://github.com/eko/docker-symfony
```

- then create symfony folder in cloned docker project and pull my github source into it by
```
git clone https://github.com/mymain/beer .
```

- setup DB access in project according to docker-compose.yml db settings by coping env.dist file as env.
- ON WIN10 I had change mysql host IP in env. file from 127.0.0.1 to my WiFi/Etherned adapter IP addr 192.168.X.XX

- add symfony.local 127.0.0.1 to your hosts file

- build/run containers with (with and without detached mode)
```
docker-compose build
docker-compose up -d
```

- then update composer by command
```
docker-compose exec php composer update
```

- run symfony migrations
```
docker-compose exec php php /var/www/symfony/bin/console doctrine:migrations:migrate
```

- run data import script
```
docker-compose exec php php /var/www/symfony/bin/console app:import
```

- now you should be able to access project by http://symfony.localhost URL in your browser

- stop docker containers 
```
docker-compose down
```
