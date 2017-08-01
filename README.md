[![Build Status](https://travis-ci.org/fortytwostudio/webfaction-php.svg?branch=master)](https://travis-ci.org/fortytwostudio/webfaction-php)
# webfaction-php
Simple PHP wrapper for the [WebFaction XMLRPC API](https://docs.webfaction.com/xmlrpc-api/apiref.html)


##Installation

Install using composer

`composer require fortytwo-studio/webfaction-php dev-master`

or add to your composer.json file's "require" section

```json
"require": {
  "fortytwo-studio/webfaction-php": "dev-master",
}
```
(don't forget to run `composer install` or `composer update`)

##Overview

This is a PHP wrapper for interacting with the WebFaction XMLRPC API. It's extremely thin, methods follow the naming conventions(camelCase rather than snake_case) and parameter ordering (ignoring session_id) of the [XMLRPC API](https://docs.webfaction.com/xmlrpc-api/apiref.html)

##Usage

include the client in your project class.

```php
<?php
    use FortyTwoStudio\WebFactionPHP\WebFactionClient;
    use FortyTwoStudio\WebFactionPHP\WebFactionException;
    
    class MyAwesomeClass {
        ...
    }
```

To create a connection to the API new up an instance of the WebFactionClient with your API credentials:
```php
    $wf = new WebFactionClient('USERNAME', 'PASSWORD', 'MACHINE');
```

You can then perform interactions with the API using the methods.

##Example - Provision a new mysql database and user
```php
<?php

// include composer's autoloader (this'll vary depending on your application)
// presuming this file is in a "webroot" type folder...
include(__DIR__ . '/../vendor/autoload.php');

use FortyTwoStudio\WebFactionPHP\WebFactionClient;
use FortyTwoStudio\WebFactionPHP\WebFactionException;

class MyAwesomeClass
{

    public function createDatabase($username = "new_db_user", $dbname = "my_new_db")
    {
        try
        {
            // create a connection to the API, use your own credentials here, obvs
            $wf = new WebFactionClient('USERNAME', 'PASSWORD', 'MACHINE');

            // static method to generate random strings of given length
            $db_pass = WebFactionClient::generatePassword(21);

            // https://docs.webfaction.com/xmlrpc-api/apiref.html#method-create_db
            $database = $wf->createDb($dbname, 'mysql', $db_pass, $username);

            // https://docs.webfaction.com/xmlrpc-api/apiref.html#method-change_db_user_password
            //otherwise it doesn't seem to use it. Possibly because we're creating the user at the same time as the DB above
            $wf->changeDbUserPassword($username, $db_pass, 'mysql');

        } catch (WebFactionException $e)
        {
            // Something went wrong, find out what with $e->getMessage() but be warned, WebFaction exception messages are often
            // vague and unhelpful!
            return "rut roh, this went wrong: " . $e->getMessage();
        }

        // database created, keep a record of $db_pass if you want to use it somewhere!
        return "$db_pass";
    }

}

echo (new MyAwesomeClass())->createDatabase(); // if you didn't change the credentials in this example => rut roh, this went wrong: LoginError
```
###Changelog

23/Aug/2016 - initial release.