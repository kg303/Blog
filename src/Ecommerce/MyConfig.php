<?php
namespace App\Ecommerce;

use Pimcore\Bundle\EcommerceFrameworkBundle\IndexService\Config\DefaultMysql;

class MyConfig extends DefaultMysql
{

    public function getTablename(): string
    {
        return '__academy_index';
    }

    public function getRelationTablename(): string
    {
        return '__academy_index_relations';
    }

}
