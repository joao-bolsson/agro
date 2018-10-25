<?php
/**
 * Class with login functions.
 *
 * @author João Bolsson (joaovictorbolsson@gmail.com)
 * @version 2018, Oct 25.
 */

ini_set('display_errors', true);
error_reporting(E_ALL);

spl_autoload_register(function (string $class_name) {
    include_once $class_name . '.class.php';
});

final class Login {

    /**
     * Fields to check on database.
     */
    private $table, $idField, $nameField, $passField, $emailField;
    private static $INSTANCE;

    public static function getInstance(): Login {
        if (empty(self::$INSTANCE)) {
            self::$INSTANCE = new Login();
        }
        return self::$INSTANCE;
    }

    private function __construct() {
        $this->table = 'usuario';
        $this->idField = 'id';
        $this->nameField = 'nome';
        $this->passField = 'senha';
        $this->emailField = 'email';
    }

    /**
     * Try to do login.
     *
     * @param string $email User e-mail.
     * @param string $pass User password.
     * @return bool Login ok - true, otherwise - false.
     */
    public function login(string $email, string $pass): bool {
        // avoid SQL Injections
        $email = Query::getInstance()->real_escape_string($email);

        $query = Query::getInstance()->exe("SELECT {$this->idField}, {$this->nameField}, {$this->passField}, {$this->emailField} FROM {$this->table} WHERE BINARY {$this->emailField} = '{$email}' LIMIT 1");

        if ($query->num_rows > 0) {
            //colocando o retorno da query em um objeto
            $usuario = $query->fetch_object();
            $pass = Query::getInstance()->real_escape_string($pass);

            // verificando a senha com o php e não mysql
            if (crypt($pass, $usuario->{$this->passField}) == $usuario->{$this->passField}) {
                //atribuindo valores à sessão
                $_SESSION[$this->idField] = $usuario->{$this->idField};
                $_SESSION[$this->nameField] = $usuario->{$this->nameField};
                $_SESSION[$this->emailField] = $usuario->{$this->emailField};

                return true;
            }
        }
        return false;
    }

}
