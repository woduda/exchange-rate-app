# Exchange Currency App

Please follow instruction to setup project. Make sure docker-compose is already installed in your environment.
Navigate to projekt root and then:

* ```cd docker```
* ```docker-compose build```
* ```docker-compose up -d```
* ```docker-compose exec workspace sh```
* ```composer install```
* ```php bin/console make:migration```
* ```php bin/console doctrine:migrations:migrate```
* to update rates ```php bin/console exchange-rates:update``` please provide number of days in past
* to run tests ```./bin/phpunit```

Now you can visit localhost:80 in your browser.

Implemented with:
* CQRS + DDD
* symfony messenger
* doctrine_transaction on each command/query
