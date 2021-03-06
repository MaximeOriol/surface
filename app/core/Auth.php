<?php

class Auth
{
    // types de caracteres
    const MAJUSCULE = 0;
    const MINUSCULE = 1;
    const CHIFFRE = 2;
    const SYMBOLE = 3;

    // Structure du mot de passe a generer
    const PASSWORD_SCHEME = array(
        self::MAJUSCULE,
        self::MINUSCULE,
        self::MINUSCULE,
        self::MINUSCULE,
        self::CHIFFRE,
        self::CHIFFRE,
        self::CHIFFRE,
        self::SYMBOLE
    );

    // Liste des symboles utilisés
    const SYMBOLES = ['@', '/', '-', ':', '=', '!', '#', '+', '/', '?'];

    // une méthode static peut etre appellée sans instance
    public static function Authentification( $sEmail, $sPassword )
    {
        $lReturn = false;
        if ( !empty($sEmail) && !empty($sPassword) ) {
            $lReturn = Auth::checkPassword( $sEmail, $sPassword );
        }

        return($lReturn);
    }

    public static function checkPassword( $sEmail, $sPassword )
    {
        $lReturn = false;

        $oUser = new User;
        $oUser->readByEmail($sEmail);

        if (! is_null($oUser->usr_id)) {
            $lReturn = true;
            /*
            var_dump($oUser);
            $sPasswordHash = Auth::hashPassword($sPassword);
            echo "\nsPassword=$sPassword\n";
            echo "\nsPasswordHash=$sPasswordHash\n";
            if ( $oUser->usr_password === $sPasswordHash ) {
                $lReturn = true;
            }
            */
        }

        return($lReturn);
    }

    public static function hashPassword($sPassword)
    {
        return(password_hash($sPassword, PASSWORD_DEFAULT));
    }

    // Generation d'un mot de passe suivant la constante PASSWORD_SCHEME
    public static function generatePassword()
    {
        $sPassword = "";
        foreach(self::PASSWORD_SCHEME as $nTypeChar ) {
            switch ($nTypeChar) {
                case self::MAJUSCULE:
                    $sPassword .= self::majusculeAleatoire();
                    break;
                case self::MINUSCULE:
                    $sPassword .= self::minusculeAleatoire();
                    break;
                case self::CHIFFRE:
                    $sPassword .= self::chiffreAleatoire();
                    break;
                case self::SYMBOLE:
                    $sPassword .= self::symboleAleatoire();
                    break;
                default:
                    $sPassword .= self::symboleAleatoire();
                    break;
            }
        }

        return($sPassword);
    }

    private static function majusculeAleatoire()
    {
        return( chr( ord('A') + rand(0, 25) ) );
    }

    private static function minusculeAleatoire()
    {
        return( chr( ord('a') + rand(0, 25) ) );
    }

    private static function chiffreAleatoire()
    {
        return( chr( ord('0') + rand(0, 9) ) );
    }

    private static function symboleAleatoire()
    {
        return( self::SYMBOLES[rand(0, 9)] );
    }

}
