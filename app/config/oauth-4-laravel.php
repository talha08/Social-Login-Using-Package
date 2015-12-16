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

        //facebook Works
        'Facebook' => array(
            'client_id'     => '690725167737338',
            'client_secret' => '80d30d85718c60c53836b24821e3fe2f',
            'scope'         => array('email'),
        ),
      //works Fine
        'Google' => array(
            'client_id'     => '204699774975-sgsbvg8plfpj4hbtb88u624dsd0f2ubf.apps.googleusercontent.com',
            'client_secret' => 'ateAnhGDlDS5I3fd6OT1VLDP',
           'scope'         => array('userinfo_email','userinfo_profile'),
        ),


        'Twitter' => array(
            'client_id'     => 'OQuzyMuj9m75ciea9BUE3WpbC',
            'client_secret' => 'axoHPzZcES86fJmhZFFamObIhuZWjQyb6iMiEcbEDUznM9Tvfv',
            // No scope - oauth1 doesn't need scope
        ),

        'Linkedin' => array(
            'client_id'     => '75ws5fei2l0iqq',
            'client_secret' => 'Jw0FLsVNAu3LVB1d',
        ),
        //working Github
        'Github' => array(
            'client_id'     => '116a743540adb2ac9762',
            'client_secret' => '4ac72ab135b0dceaadd7ded9a1f6e555423e0695',
        ),


    )



);