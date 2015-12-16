## Installation

Add oauth-4-laravel to your composer.json file:

```
"require": {
  "artdarek/oauth-4-laravel": "dev-master"
}
```

Use composer to install this package.

```
$ composer update
```

### Registering the Package

Register the service provider within the ```providers``` array found in ```app/config/app.php```:

```php
'providers' => array(
	// ...
	
	'Artdarek\OAuth\OAuthServiceProvider'
)
```

Add an alias within the ```aliases``` array found in ```app/config/app.php```:


```php
'aliases' => array(
	// ...
	
	'OAuth' => 'Artdarek\OAuth\Facade\OAuth',
)
```

## Configuration

There are two ways to configure oauth-4-laravel.
You can choose the most convenient way for you. 
You can use package config file which can be 
generated through command line by artisan (option 1) or 
you can simply create a config file called ``oauth-4-laravel.php`` in 
your ``app\config\`` directory (option 2).

#### Option 1

Create configuration file for package using artisan command

```
$ php artisan config:publish artdarek/oauth-4-laravel
```

#### Option 2

Create configuration file manually in config directory ``app/config/oauth-4-laravel.php`` and put there code from below.

```php
<?php
return array( 
	
	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session', 

	/**
	 * Consumers
	 */
	'consumers' => array(

		/**
		 * Facebook
		 */
		'Facebook' => array(
		    'client_id'     => '',
		    'client_secret' => '',
		    'scope'         => array(),
		),		

	)

);
