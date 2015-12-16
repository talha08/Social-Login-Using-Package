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






#### Option 3
In The Route:

```php
Route::get('/', function()
{
	return Redirect::route('user');
});
Route::get('home', ['as'=>'user','uses' => 'SocialController@show']);
Route::get('login/fb', ['as'=>'login/fb','uses' => 'SocialController@loginWithFacebook']);
Route::get('logout', ['as' => 'logout', 'uses' => 'SocialController@logout']);



#### Option 4
In The Controller:

```php
####For Auth Check---

public function show()
    {
        $data = array();

        if (Auth::check()) {
            $data = Auth::user();
        }
        return View::make('user', array('data'=>$data));
    }


####Facebook Login & Sign up

public function loginWithFacebook() {

        $code = Input::get( 'code' );

        $fb = OAuth::consumer( 'Facebook' );

        if ( !empty( $code ) ) {

            try {

                $token = $fb->requestAccessToken( $code );

                $result = json_decode($fb->request( '/me?fields=id,name,first_name,last_name,email,picture,gender' ), true);

            } catch (Exception $e) {
                die("Too many requests, access denied by Facebook. Please wait a while.");
            }


            $profile = Profile::where('uid','=',$result['id'])->first();

            if (empty($profile)) {

                $user = new User;
                $user->name = $result['first_name'].' '.$result['last_name'];
                $user->email = $result['email'];
                $user->photo = 'https://graph.facebook.com/'.$result['id'].'/picture?type=large';
                $user->save();

                $profile = new Profile();
                $profile->uid = $result['id'];
               // $profile->access_token = $fb->requestAccessToken( $code );
                $profile->username = $result['last_name'].'_'. $result['id'];
                $profile->gender = $result['gender'];
                $profile = $user->profiles()->save($profile);
            }


            $profile->save();
            $user = $profile->user;

            Auth::login($user);
            Session::put('uid', Auth::user()->id);

            return Redirect::to('/')->with('message', 'Logged in with Facebook');

        }
        // if not ask for permission first
        else {
            // get fb authorization
            $url = $fb->getAuthorizationUri();

            // return to facebook login url
            return Redirect::to( (string)$url );
        }

    }
    
   ####Logout
   
    public function logout(){
        Auth::logout();
        return Redirect::route('user');
    }
    
