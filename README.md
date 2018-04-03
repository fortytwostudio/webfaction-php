[![Build Status](https://travis-ci.org/fortytwostudio/webfaction-php.svg?branch=master)](https://travis-ci.org/fortytwostudio/webfaction-php)
# webfaction-php
Simple PHP wrapper for the [WebFaction XMLRPC API](https://docs.webfaction.com/xmlrpc-api/apiref.html)


## Installation

Install using composer

`composer require fortytwo-studio/webfaction-php`

or add to your composer.json file's "require" section

```json
"require": {
  "fortytwo-studio/webfaction-php": "^1.0",
}
```
(don't forget to run `composer install` or `composer update`)

## Overview

This is a PHP wrapper for interacting with the WebFaction XMLRPC API. It's extremely thin, methods follow the naming conventions(camelCase rather than snake_case) and parameter ordering (ignoring session_id) of the [XMLRPC API](https://docs.webfaction.com/xmlrpc-api/apiref.html)

## Usage

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
    $wf = new WebFactionClient('USERNAME', 'PASSWORD', 'MACHINE', 'VERSION');
```

You can then perform interactions with the API using the methods.

## Example - Provision a new mysql database and user
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
            $wf = new WebFactionClient('USERNAME', 'PASSWORD', 'MACHINE', 'VERSION');

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

### Testing
The included tests in this package have a LOT of side-effects.
We don't mock any responses here, they run against your actual webfaction account. 
(_So one side-effect could be that a new SFTP user is created on your account._) 

If you really wish to check the PHPUnit tests please copy the supplied .env.example file to .env and fill in the webfaction credentials. You can then run `phpunit` to run all the tests.
Without this setup the tests will fail immediately.

#### _Please note that these tests **will** run commands on your webfaction account, which means that your servers will be affected;_


### Changelog

#### 03/Apr/2018 - 1.1.4
* Fixed bug on replaceInFile method where multiple replacements were erroring

#### 06/Mar/2018 - 1.1.3
* altered composer.json to require 4.* of phpxmlrpc
* update ReadMe

#### 19/Dec/2017 - 1.1.2
* fixed "Unkown Error" exception on createWebsite on v1 and v2 of the API
* update ReadMe

#### 29/Nov/2017 - 1.1.1
* small change to exception message when using an endpoint unavailable to the current version
* update ReadMe

#### 29/Nov/2017 - 1.1.0
* update to handle [Version 2](https://docs.webfaction.com/xmlrpc-api/apiref.html#api-versions) of the Webfaction API. This has support for SSL certificate management.
* fixed bug where some email methods weren't returning a response 
* update ReadMe

#### 01/Aug/2017 - 1.0.0
* update phpunit 
* travis CI build integration
* update ReadMe

#### 23/Aug/2016 - initial release.
