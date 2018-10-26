<?php
/**
 * Class to select data.
 *
 * @author João Bolsson (joaovictorbolsson@gmail.com)
 * @version 2018, Oct 25.
 */

ini_set('display_errors', true);
error_reporting(E_ALL);

spl_autoload_register(function (string $class_name) {
    include_once $class_name . '.class.php';
});

class Select {

    // **************************************************************************
    //                              SAFRAS
    // **************************************************************************

    /**
     * Gets user's crops.
     *
     * @param int $id_user User id.
     * @return array Array with all user crops.
     */
    public static function getCropsByUser(int $id_user): array {
        $builder = new SQLBuilder(SQLBuilder::$SELECT);
        $builder->setTables(['safras', 'cultura', 'tipo_cultura']);
        $builder->setColumns(['safras.id', 'safras.id_usuario', 'safras.id_cultura', 'cultura.nome AS cultura', 'tipo_cultura.nome AS tipo_cultura', "DATE_FORMAT(safras.inicio, '%d/%m/%Y') AS inicio", "DATE_FORMAT(safras.fim, '%d/%m/%Y') AS fim", 'safras.producao', 'safras.saldo', 'safras.total_venda']);
        $builder->setWhere('safras.id_usuario = ' . $id_user . ' AND cultura.id = safras.id_cultura AND cultura.id_tipo = tipo_cultura.id');

        $query = Query::getInstance()->exe($builder->__toString());

        $array = [];
        $i = 0;
        if ($query->num_rows > 0) {
            while ($obj = $query->fetch_object()) {
                $crop = new Crop($obj->id, $obj->id_usuario, $obj->id_cultura, $obj->inicio, $obj->cultura, $obj->tipo_cultura);

                $array[$i++] = $crop;
            }
        }

        return $array;
    }

    // **************************************************************************
    //                              IMPLANTAÇÃO
    // **************************************************************************

    /**
     * Gets informations about the implementation of the given crop.
     *
     * @param int $id_crop Crop id.
     * @return Implementation Object with info about implementation proccess, or null if there is no info available.
     */
    public static function getInfoImplementation(int $id_crop): Implementation {
        $builder = new SQLBuilder(SQLBuilder::$SELECT);
        $builder->setTables(['implantacao']);
        $builder->setColumns(['mao_de_obra', 'maquinario', 'adubacao', 'semeadura']);
        $builder->setWhere('id_safra = ' . $id_crop);

        $query = Query::getInstance()->exe($builder->__toString());

        if ($query->num_rows > 0) {
            while ($obj = $query->fetch_object()) {
                $impl = new Implementation($id_crop, floatval($obj->mao_de_obra), floatval($obj->maquinario), floatval($obj->adubacao), floatval($obj->semeadura));
                return $impl;
            }
        }
        return null;
    }

    // **************************************************************************
    //                              MANUTENÇÃO
    // **************************************************************************

    // TODO

    // **************************************************************************
    //                              COLHEITA
    // **************************************************************************


    /**
     * Gets informations about harvest process.
     *
     * @param int $id_crop Crop id.
     * @return Harvest Object with informations.
     */
    public static function getInfoHarvest(int $id_crop): Harvest {
        $builder = new SQLBuilder(SQLBuilder::$SELECT);
        $builder->setTables(['colheita']);
        $builder->setColumns(['mao_de_obra', 'maquinario', 'transporte']);
        $builder->setWhere('id_safra = ' . $id_crop);

        $query = Query::getInstance()->exe($builder->__toString());
        if ($query->num_rows > 0) {
            while ($obj = $query->fetch_object()) {
                return new Harvest($id_crop, floatval($obj->mao_de_obra), floatval($obj->maquinario), floatval($obj->transporte));
            }
        }
        return null;
    }

    // **************************************************************************
    //                              CULTURAS
    // **************************************************************************


    /**
     * Gets all cultures used in the system.
     *
     * @return array Array with Culture objects that contains informations about each culture.
     */
    public static function getCultures(): array {
        $builder = new SQLBuilder(SQLBuilder::$SELECT);
        $builder->setTables(['cultura', 'tipo_cultura']);
        $builder->setColumns(['cultura.id', 'cultura.id_tipo', 'tipo_cultura.nome AS tipo', 'cultura.nome']);
        $builder->setWhere('cultura.id_tipo = tipo_cultura.id');

        $query = Query::getInstance()->exe($builder->__toString());

        $array = [];
        $i = 0;
        if ($query->num_rows > 0) {
            while ($obj = $query->fetch_object()) {
                $array[$i++] = new Culture($obj->id, $obj->id_tipo, $obj->tipo, $obj->nome);
            }
        }

        return $array;

    }

    // **************************************************************************
    //                              ESTOQUE
    // **************************************************************************


    /**
     * Gets informations about the user stock.
     *
     * @param int $id_user Given id user.
     * @return array Array with Product objects that contains informations about each product in the stock.
     */
    public static function getStock(int $id_user): array {
        $builder = new SQLBuilder(SQLBuilder::$SELECT);
        $builder->setTables(['estoque', 'tipo_prod']);
        $builder->setColumns(['estoque.id', 'estoque.id_tipo', 'tipo_prod.nome_tipo AS tipo_prod', 'estoque.cod', 'estoque.descricao', 'estoque.unidade', 'estoque.qtd', 'estoque.vl_unitario', 'estoque.vl_total']);
        $builder->setWhere('estoque.id_usuario = ' . $id_user . ' AND estoque.id_tipo = tipo_prod.id');

        $query = Query::getInstance()->exe($builder->__toString());
        $array = [];
        $i = 0;

        if ($query->num_rows > 0) {
            while ($obj = $query->fetch_object()) {
                $array[$i++] = new Product($id_user, $obj->id_tipo, $obj->tipo_prod, $obj->cod, $obj->descricao, $obj->unidade, $obj->qtd, $obj->vl_unitario, $obj->vl_total);
            }
        }
        return $array;
    }

    /**
     * Gets the product type name by given id.
     *
     * @param int $id_type Given id type.
     * @return string Type name.
     */
    public static function getProductTypeName(int $id_type): string {
        // SELECT nome_tipo FROM tipo_prod WHERE id = 2;
        $builder = new SQLBuilder(SQLBuilder::$SELECT);
        $builder->setTables(['tipo_prod']);
        $builder->setColumns(['nome_tipo']);
        $builder->setWhere('id=' . $id_type);

        $query = Query::getInstance()->exe($builder->__toString());
        if ($query->num_rows > 0) {
            $obj = $query->fetch_object();
            return $obj->nome_tipo;
        }
        return "";
    }

}