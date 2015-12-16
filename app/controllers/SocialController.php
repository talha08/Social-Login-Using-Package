<?php

class SocialController extends BaseController {




    public function logout(){
        Auth::logout();
        return Redirect::route('user');
    }




    public function show()
    {
        $data = array();

        if (Auth::check()) {
            $data = Auth::user();
        }
        return View::make('user', array('data'=>$data));
    }








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




    public function loginWithGoogle() {


        $code = Input::get( 'code' );
        $googleService = OAuth::consumer( 'Google' );

        if ( !empty( $code ) ) {
            try {
                $token = $googleService->requestAccessToken( $code );

                $result = json_decode( $googleService->request( 'https://www.googleapis.com/oauth2/v1/userinfo' ), true );

           // return $result;

            } catch (Exception $e) {
                die("Too many requests, access denied by Google. Please wait a while.");
            }

            $profile = Profile::where('uid','=',$result['id'])->first();


            if (empty($profile)) {

                $user = new User;
                $user->name = $result['name'];
                $user->email = $result['email'];
                $user->photo = $result['picture'];
                $user->save();

                $profile = new Profile();
                $profile->uid = $result['id'];
                //$profile->access_token = $fb->requestAccessToken( $code );
                $profile->username = $result['family_name'];
                $profile->gender = $result['gender'];
                $profile = $user->profiles()->save($profile);
            }


            $profile->save();
            $user = $profile->user;

            Auth::login($user);
            Session::put('uid', Auth::user()->id);

            return Redirect::to('/')->with('message', 'Logged in with Google');



        }

        // if not ask for permission first
        else {
            // get googleService authorization
            $url = $googleService->getAuthorizationUri();

            // return to google login url
            return Redirect::to( (string)$url );
        }
    }






    public function loginWithTwitter() {


        $token = Input::get( 'oauth_token' );
        $verify = Input::get( 'oauth_verifier' );
        $tw = OAuth::consumer( 'Twitter' );

        if ( !empty( $token ) && !empty( $verify ) ) {

            try {

                $token = $tw->requestAccessToken( $token, $verify );

            $result = json_decode( $tw->request( 'account/verify_credentials.json' ), true );
                // return $result;

            } catch (Exception $e) {
                die("Too many requests, access denied by Twitter. Please wait a while.");
            }


            $profile = Profile::where('uid','=',$result['id'])->first();

            if (empty($profile)) {

                $user = new User;
                $user->name = $result['name'];
                //$user->email = $result['email'];
                $user->photo = $result['profile_image_url'];

                $user->save();

                $profile = new Profile();
                $profile->uid = $result['id'];
                // $profile->access_token = $fb->requestAccessToken( $code );
                $profile->username = $result['screen_name'];
               // $profile->gender = $result['gender'];
                $profile = $user->profiles()->save($profile);
            }


            $profile->save();

            $user = $profile->user;

            Auth::login($user);

            return Redirect::to('/')->with('message', 'Logged in with Twitter');



        }

        // if not ask for permission first
        else {
            // get request token
            $reqToken = $tw->requestRequestToken();

            // get Authorization Uri sending the request token
            $url = $tw->getAuthorizationUri(array('oauth_token' => $reqToken->getRequestToken()));

            // return to twitter login url
            return Redirect::to( (string)$url );
        }
    }




    public function loginWithLinkedin() {
             $code = Input::get( 'code' );
             $linkedinService = OAuth::consumer( 'Linkedin' );

          if ( !empty( $code ) ) {
            try {

                $token = $linkedinService->requestAccessToken($code);

                $result = json_decode($linkedinService->request('/people/~:(picture-url,id,first-name,last-name,headline,member-url-resources,picture-urls::(original),location,public-profile-url,email-address)?format=json'), true);
              // return $result;

            } catch (Exception $e) {
                die("Too many requests, access denied by Linkedin. Please wait a while.");
            }



            $profile = Profile::where('uid','=',$result['id'])->first();

            if (empty($profile)) {

                $user = new User;
                $user->name = $result['firstName'].' '.$result['lastName'];
               // $user->email = $result['email-address'];
              // $user->photo = $result['pictureUrls']['values'];
               $user->photo = $result['pictureUrl'];

                $user->save();

                $profile = new Profile();
                $profile->uid = $result['id'];
                // $profile->access_token = $fb->requestAccessToken( $code );
                $profile->username = $result['lastName'];
                //$profile->gender = $result['gender'];
                $profile = $user->profiles()->save($profile);
            }


            $profile->save();

            $user = $profile->user;

            Auth::login($user);

            return Redirect::to('/')->with('message', 'Logged in with Linkedin');



        }
        else {
            // get linkedinService authorization
            $url = $linkedinService->getAuthorizationUri(['state' => 'DCEEFWF45453sdffef424']);
            return Redirect::to( (string)$url );
        }


    }





//Works Fine
    public function loginWithGithub()
    {
        $code = Input::get( 'code' );
        $githubService = OAuth::consumer( 'Github' );

        if ( !empty( $code ) ) {
            try {

                $token = $githubService->requestAccessToken( $code );

                $result = json_decode($githubService->request('user'),true);

            } catch (Exception $e) {
                die("Too many requests, access denied by Github. Please wait a while.");
            }


            $profile = Profile::where('uid','=',$result['id'])->first();

            if (empty($profile)) {

                $user = new User;
                $user->name = $result['name'];
                $user->email = $result['email'];
                $user->photo = $result['avatar_url'];
                $user->save();

                $profile = new Profile();
                $profile->uid = $result['id'];
                // $profile->access_token = $fb->requestAccessToken( $code );
                $profile->username = $result['login'];
                $profile->gender = $result['bio'];
                $profile = $user->profiles()->save($profile);
            }


            $profile->save();
            $user = $profile->user;

            Auth::login($user);

            return Redirect::to('/')->with('message', 'Logged in with Facebook');
        }


        else {
          // get githubService authorization
            $url = $githubService->getAuthorizationUri();
            return Redirect::to( (string) $url );
        }

    }











}