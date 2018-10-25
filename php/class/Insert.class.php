<?php
/**
 * Class to insert data.
 *
 * @author João Bolsson (joaovictorbolsson@gmail.com)
 * @version 2018, Oct 25.
 */

ini_set('display_errors', true);
error_reporting(E_ALL);

require_once '../../defines.php';

spl_autoload_register(function (string $class_name) {
    include_once $class_name . '.class.php';
});

class Insert {

    /**
     * Insert a new user. Password will be create by system.
     *
     * @param string $name User name.
     * @param string $email User email.
     * @return int User id.
     */
    public static function insertUser(string $name, string $email): int {
        $name = Query::getInstance()->real_escape_string($name);
        $email = Query::getInstance()->real_escape_string($email);

        $p = Util::randPassword();
        // TODO: logar essa senha para dar ao usuario
        $pass = crypt($p, SALT);

        Query::getInstance()->exe("INSERT INTO usuario VALUES(NULL, '" . $name . "', '" . $email . "', '" . $pass . "');");

        return Query::getInstance()->getInsertId();
    }

    /**
     * Insert permissions for the given user.
     *
     * @param int $id_user User id.
     * @param bool $farmer Permission to access farmer part of the system.
     * @param bool $agr Permission for be an agronomist.
     * @param bool $coop Permission for be a cooperative.
     */
    public static function insertPermissions(int $id_user, bool $farmer, bool $agr, bool $coop) {
        Query::getInstance()->exe("INSERT INTO usuario_permissoes VALUES(" . $id_user . ", " . $farmer . ", " . $agr . ", " . $coop . ");");
    }

}