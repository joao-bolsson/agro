<?php
/**
 * Class to insert data.
 *
 * @author João Bolsson (joaovictorbolsson@gmail.com)
 * @version 2018, Oct 25.
 */

ini_set('display_errors', true);
error_reporting(E_ALL);

require_once __DIR__ . '/../../defines.php';

spl_autoload_register(function (string $class_name) {
    include_once $class_name . '.class.php';
});

class Insert {
    // **************************************************************************
    //                              USER
    // **************************************************************************

    /**
     * Insert a new user. Password will be create by system.
     *
     * @param string $name User name.
     * @param string $email User e-mail.
     * @return int User id.
     */
    public static function addUser(string $name, string $email): int {
        $name = Query::getInstance()->real_escape_string($name);
        $email = Query::getInstance()->real_escape_string($email);

        $p = Util::randPassword();
        // TODO: enviar a senha dele para o e-mail do usuario
        $pass = crypt($p, SALT);

        $builder = new SQLBuilder(SQLBuilder::$INSERT);
        $builder->setTables(['usuario']);
        $builder->setValues([NULL, $name, $email, $pass]);

        Query::getInstance()->exe($builder->__toString());

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
    public static function addPermissions(int $id_user, bool $farmer, bool $agr, bool $coop) {
        $builder = new SQLBuilder(SQLBuilder::$INSERT);
        $builder->setTables(['usuario_permissoes']);
        $builder->setValues([$id_user, $farmer, $agr, $coop]);
        Query::getInstance()->exe($builder->__toString());
    }


    // **************************************************************************
    //                              SAFRA
    // **************************************************************************

    /**
     * Starts a new crop.
     *
     * @param int $id_user User owner of the crop.
     * @param int $id_cult Crop culture.
     * @param string $dt_start Start date of the crop. (d/m/Y format)
     * @return int Crop id.
     */
    public static function startCrop(int $id_user, int $id_cult, string $dt_start): int {
        $dt_start = Util::dateFormat($dt_start);

        $builder = new SQLBuilder(SQLBuilder::$INSERT);
        $builder->setTables(['safras']);
        $builder->setColumns(['id', 'id_usuario', 'id_cultura', 'inicio']);
        $builder->setValues([NULL, $id_user, $id_cult, $dt_start]);

        Query::getInstance()->exe($builder->__toString());

        return Query::getInstance()->getInsertId();
    }

    // **************************************************************************
    //                              IMPLANTAÇÃO
    // **************************************************************************

    /**
     * Does the implementation of the crop.
     *
     * @param int $id_crop Crop's id.
     * @param float $labor Labor cost.
     * @param float $machines Cost with machines.
     * @param float $fertilizing Cost with fertilizers.
     * @param float $seeding Cost with seeding.
     */
    public static function doImplementation(int $id_crop, float $labor, float $machines, float $fertilizing, float $seeding) {
        $builder = new SQLBuilder(SQLBuilder::$INSERT);
        $builder->setTables(['implantacao']);
        $builder->setValues([$id_crop, $labor, $machines, $fertilizing, $seeding]);

        Query::getInstance()->exe($builder->__toString());
    }

    // **************************************************************************
    //                              MANUTENÇÃO
    // **************************************************************************

    /**
     * Does maintenance on the crop.
     *
     * @param int $id_crop Crop's id.
     * @param float $labor Labor cost.
     * @param float $machines Machines cost.
     */
    public static function doMaintenance(int $id_crop, float $labor, float $machines) {
        $builder = new SQLBuilder(SQLBuilder::$INSERT);
        $builder->setTables(['manutencao']);
        $builder->setValues([$id_crop, $labor, $machines]);

        Query::getInstance()->exe($builder->__toString());
    }

    /**
     * Applies defensives on the crop.
     *
     * @param int $id_crop Crop's id.
     * @param array $defensives Array with defensives to apply.
     */
    public static function applyDefensives(int $id_crop, array $defensives) {
        $builder = new SQLBuilder(SQLBuilder::$INSERT);
        $builder->setTables(['defensivo']);
        foreach ($defensives as $defensive) {
            if ($defensive instanceof Defensive) {
                $builder->setValues([$id_crop, $defensive->getId(), $defensive->getApplications(), $defensive->getValue()]);

                Query::getInstance()->exe($builder->__toString());
            }
        }
    }

    // **************************************************************************
    //                              COLHEITA
    // **************************************************************************

    /**
     * Does the crop harvest.
     *
     * @param int $id_crop Crop's id.
     * @param float $labor
     * @param float $machines
     * @param float $transport
     */
    public static function doHarvest(int $id_crop, float $labor, float $machines, float $transport) {
        $builder = new SQLBuilder(SQLBuilder::$INSERT);
        $builder->setTables(['colheita']);
        $builder->setValues([$id_crop, $labor, $machines, $transport]);

        Query::getInstance()->exe($builder->__toString());
    }

    /**
     * Finalize a crop.
     *
     * @param int $id_crop Crop id.
     * @param string $dt_end Date of the finalization.
     * @param int $production Production (bags).
     * @param int $balance Balance (bags).
     * @param float $total Crop sale.
     */
    public static function finalizeCrop(int $id_crop, string $dt_end, int $production, int $balance, float $total) {
        $dt_end = Util::dateFormat($dt_end);
        $builder = new SQLBuilder(SQLBuilder::$UPDATE);
        $builder->setTables(['safras']);
        $builder->setColumns(['fim', 'producao', 'saldo', 'total_venda']);
        $builder->setValues([$dt_end, $production, $balance, $total]);
        $builder->setWhere('id = ' . $id_crop);

        Query::getInstance()->exe($builder->__toString());
    }

    // **************************************************************************
    //                              ESTOQUE
    // **************************************************************************

    /**
     * Adds a list of products in the user stock.
     *
     * @param array $products Products to add. (containing the user's id)
     */
    public static function addProductItem(array $products) {
        $builder = new SQLBuilder(SQLBuilder::$INSERT);
        $builder->setTables(['estoque']);
        foreach ($products as &$p) {
            if ($p instanceof Product) {
                $builder->setValues([NULL, $p->getIdUser(), $p->getIdType(), $p->getCod(), $p->getDescription(), $p->getUnit(), $p->getQtd(), $p->getVlUnit(), $p->getVlTotal()]);

                Query::getInstance()->exe($builder->__toString());

                $p->setId(intval(Query::getInstance()->getInsertId()));
            }
        }
    }

}