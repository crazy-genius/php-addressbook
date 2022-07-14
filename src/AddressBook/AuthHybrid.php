<?php

namespace AddressBook;

class AuthHybrid extends AuthLoginDb {

    // return md5($username.$md5_pass.$this->ip_date);

    function __construct($db_conn, $table) {

        parent::__construct($db_conn, $table);

        //
        // Check if user is valid in DB.
        //
        $hybrid_types = array("facebook", "google", "yahoo", "live");
        $provider = $this->getUserName();

        // create an instance for Hybridauth with the configuration file path as parameter
        $hybridauth_config = "hybridauth".DIRECTORY_SEPARATOR."config.php";
        require_once( "hybridauth".DIRECTORY_SEPARATOR."Hybrid".DIRECTORY_SEPARATOR."Auth.php" );

        $hybridauth = new Hybrid_Auth( $hybridauth_config );
        $loaded_providers = Hybrid_Auth::getConnectedProviders();

        if($provider == "" && count($loaded_providers) > 0) {
            $provider = strtolower($loaded_providers[0]);
        }

        if($provider != "" && in_array($provider, $hybrid_types)) {

            try{

                // try to authenticate the selected $provider
                $adapter = $hybridauth->authenticate( $provider );

                // grab the user profile
                $user_profile = $adapter->getUserProfile();

                // a) Does user with "xxx" = identifier exist?
                //   -> Yes, then login as user

                // b) Does email of user exist?
                //   -> No, then create new user

                // c) Does email of user exist?
                //   -> Yes, ask for regular login. Preset email = login

                $provider_uid  = $user_profile->identifier;
                $email         = $user_profile->email;

                //
                // Check if user is valid in DB.
                //
                $sql = "select user_id, domain_id, username, md5_pass from ".$table
                    ." where sso_".strtolower($provider)."_uid = '".$provider_uid."';";

                $result = mysql_query($sql);
                $rec = mysql_fetch_array($result);
                $cnt = mysql_numrows($result);

                if($cnt == 1) {
                    $this->user_id  = $rec['user_id'];
                    $this->username = $rec['username'];
                    $this->md5_pass = $rec['md5_pass'];
                    $this->user_cfg = array('domain' => $rec['domain_id']);
                }

            } catch( Exception $e ){
                // Display the recived error
                switch( $e->getCode() ){
                    case 0 : $error = "Unspecified error."; break;
                    case 1 : $error = "Hybriauth configuration error."; break;
                    case 2 : $error = "Provider not properly configured."; break;
                    case 3 : $error = "Unknown or disabled provider."; break;
                    case 4 : $error = "Missing provider application credentials."; break;
                    case 5 : $error = "Authentification failed. The user has canceled the authentication or the provider refused the connection."; break;
                    case 6 : $error = "User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again.";
                        $adapter->logout();
                        break;
                    case 7 : $error = "User not connected to the provider.";
                        $adapter->logout();
                        break;
                }
                echo $error;
            }
        }

        $this->finishConstruct();
    }
}