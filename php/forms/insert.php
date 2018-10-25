<?php
/**
 * Communication with user interface. (forms management)
 *
 * @author João Bolsson (joaovictorbolsson@gmail.com)
 * @version 2018, Oct 25.
 */

ini_set('display_errors', true);
error_reporting(E_ALL);

session_start();

spl_autoload_register(function (string $class_name) {
    include_once '../class/' . $class_name . '.class.php';
});

$form = '';

$filter = filter_input(INPUT_POST, 'form');
if (!empty($filter)) {
    $form = $filter;
}

switch ($form) {

    case 'addUser':
        $name = filter_input(INPUT_POST, 'name');
        $email = filter_input(INPUT_POST, 'email');
        if (empty($name) || empty($email)) {
            echo "Erro: variáveis indefinidas ou vazias.";
            break;
        }

        $id = Insert::addUser($name, $email);

        $farmer = !is_null(filter_input(INPUT_POST, 'farmer'));
        $agr = !is_null(filter_input(INPUT_POST, 'agr'));
        $coop = !is_null(filter_input(INPUT_POST, 'coop'));

        /**
         * By default, the user will be a farmer.
         */
        if (!$farmer && !$agr && !$coop) {
            $farmer = true;
        }

        Insert::addPermissions($id, $farmer, $agr, $coop);
        break;

    case 'startCrop':
        $id_user = filter_input(INPUT_POST, 'id_user');
        $id_cult = filter_input(INPUT_POST, 'id_cult');
        /**
         * The date must be in format d/m/Y
         */
        $dt_start = filter_input(INPUT_POST, 'dt_start');

        /**
         * Return the crop id on the database.
         */
        echo Insert::startCrop($id_user, $id_cult, $dt_start);
        break;

    case 'doImplementation':
        $id_crop = filter_input(INPUT_POST, 'id_crop');
        $labor = filter_input(INPUT_POST, 'labor');
        $machines = filter_input(INPUT_POST, 'machines');
        $fert = filter_input(INPUT_POST, 'fertilizing');
        $seeding = filter_input(INPUT_POST, 'seeding');

        Insert::doImplementation($id_crop, $labor, $machines, $fert, $seeding);
        break;

    case 'doMaintenance':
        $id_crop = filter_input(INPUT_POST, 'id_crop');
        $labor = filter_input(INPUT_POST, 'labor');
        $machines = filter_input(INPUT_POST, 'machines');

        Insert::doMaintenance($id_crop, $labor, $machines);
        break;


    case 'applyDefensives':
        // TODO
        break;

    case 'doHarvest':
        $id_crop = filter_input(INPUT_POST, 'id_crop');
        $labor = filter_input(INPUT_POST, 'labor');
        $machines = filter_input(INPUT_POST, 'machines');
        $transport = filter_input(INPUT_POST, 'transport');

        Insert::doHarvest($id_crop, $labor, $machines, $transport);
        break;

    case 'finalizeCrop':
        $id_crop = filter_input(INPUT_POST, 'id_crop');
        /**
         * The end date must be in format d/m/Y
         */
        $dt_end = filter_input(INPUT_POST, 'dt_end');
        $production = filter_input(INPUT_POST, 'production');
        $balance = filter_input(INPUT_POST, 'balance');
        $total = filter_input(INPUT_POST, 'total');

        Insert::finalizeCrop($id_crop, $dt_end, $production, $balance, $total);
        break;

    case 'addProductItem':
        // TODO
        break;

    default:
        break;
}