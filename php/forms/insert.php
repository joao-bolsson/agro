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
        $id_crop = filter_input(INPUT_POST, 'id_crop');
        $id_def = filter_input(INPUT_POST, 'id_defensives', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        $apli = filter_input(INPUT_POST, 'aplications', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        $values = filter_input(INPUT_POST, 'values', FILTER_DEFAULT, FILTER_FORCE_ARRAY);

        $defensives = [];
        $size = count($id_def);
        for ($i = 0; $i < $size; $i++) {
            $defensives[$i] = new Defensive($id_def[$i], $apli[$i], $values[$i]);
            $i++;
        }

        Insert::applyDefensives($id_crop, $defensives);
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
        $id_user = filter_input(INPUT_POST, 'id_crop'); // pode pegar pela sessão
        $id_type = filter_input(INPUT_POST, 'id_type');
        $type = Select::getProductTypeName($id_type);
        $cod = filter_input(INPUT_POST, 'cod');
        $descr = filter_input(INPUT_POST, 'descr');
        $unit = filter_input(INPUT_POST, 'unit');
        $qtd = filter_input(INPUT_POST, 'qtd');
        $vl_unit = filter_input(INPUT_POST, 'vl_unit');

        $vl_total = $vl_unit * $qtd;
        $prod = new Product($id_user, $id_type, $type, $cod, $descr, $unit, $qtd, $vl_unit, $vl_total);

        Insert::addProductItem([$prod]);
        break;

    default:
        break;
}