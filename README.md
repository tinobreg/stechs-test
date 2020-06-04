<p align="center">
    <a href="https://www.stechs.io" target="_blank">
        <img src="https://www.stechs.io/wp-content/uploads/stechs-logo-web.png" height="100px">
    </a>
    <h1 align="center">Gestion de cablemódem</h1>
    <br>
</p>

Proyecto desarrollado en [Yii 2 Framework](http://www.yiiframework.com/).

ESTRUCTURA
-------------------
      API
      ----------------------------------------------------------------
      config/             contains application configurations
      controllers/        contains Web controller classes
      models/             contains model classes
      postman             contains POSTMAN collection for testing
      runtime/            contains files generated during runtime
      tests/              contains codeception api tests
      vendor/             contains dependent 3rd-party packages
      web/                contains the entry script and Web resources
      
      WEB
      ----------------------------------------------------------------
      webapp/             contains web frontend application

      DOCKER
      ----------------------------------------------------------------
      nginx/              contains Docker Compose Nginx files 
      data/               contains Docker Compose database backup


REQUERIMIENTOS
------------

- PHP 5.6
- Nginx / Apache
- MariaDB / MySQL
- [Composer](http://getcomposer.org/)


INSTALACION
------------

### Install via Docker

Si no tienes instalado [Docker](https://www.docker.com/), puedes instalarlo siguiendo los pasos detallados en la [Guia de Docker](https://www.docker.com/get-started).
Ademas, es necesario instalar [Docker Compose](https://docs.docker.com/compose/install/) para poder crear la imagen.

Una vez instalado, dentro de este directorio, correr el siguiente comando para generar la imagen.

~~~
docker-compose build
~~~

Una vez ya creada la imagen, correr el siguiente comando para iniciar la imagen.

~~~
docker-compose up -d
~~~

### Modificar hosts locales

No se han configurado los entornos en este sistema, por lo cual para poder correrlo sin tener que modificar el codigo es necesario modificar los hosts locales.

```
 127.0.0.1  api.stechs.local
 127.0.0.1  stechs.local
```

### Modificar URL en Endpoints

En el caso de necesitar configurar los endpoints, los mismos se encuentran en  `webapp/app.js`:

```
 Linea 40:   url: encodeURI("http://api.stechs.local/modem/list/vendor/"+vendorValue+"/empty")
 Linea 78:   url: encodeURI("http://api.stechs.local/modem/add")
```

CONFIGURACION
-------------

### Database

La condiguracion de la base de datos esta en `config/db.php`:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=mysql;dbname=stechs',
    'username' => 'root',
    'password' => '123',
    'charset' => 'utf8',
];
```

### URL Routing

La condiguracion de rutas de endpoints estan en `config/urlrules.php`:

```php
return [
    '/' =>'site/index',
    
    'OPTIONS modem/list' => 'modem/list',
    'OPTIONS modem/list/<mac:\w+>' => 'modem/list',
    'OPTIONS modem/list/vendor/<vendor:[\w-]+>/' => 'modem/list-by-vendor',
    'OPTIONS modem/list/vendor/<vendor:[\w-]+>/empty' => 'modem/no-match',
    'OPTIONS modem/add' => 'modem/add-modem',

    'GET modem/list' => 'modem/list',
    'GET modem/list/<mac:\w+>' => 'modem/list',
    'GET modem/list/vendor/<vendor:[\w-]+>/' => 'modem/list-by-vendor',
    'GET modem/list/vendor/<vendor:[\w-]+>/empty' => 'modem/no-match',
    'POST modem/add' => 'modem/add-modem',
];
```

TESTING 
-------

### Via POSTMAN
Las colecciones estan guardadas en `/postman`.

Listado de endpoints

    GET modem/list
    GET modem/list/{macaddress}
    GET modem/list/vendor/{vendor}
    GET modem/list/vendor/{vendor}/empty
    POST modem/add
    
### Via Codeception
Los test automaticos estan guardadas en `/tests/api`.

~~~
php vendor/bin/codecept run api
~~~