<?php


namespace App\Service;

use Pimcore\Model\DataObject\BlogPost;
class SearchService
{
    public function search($query)
    {

        $dataObjects = $this->searchDataObjects($query);


        return [
            'dataObjects' => $dataObjects,
        ];
    }

    private function searchDataObjects($query)
    {
        $dataObjects = new BlogPost\Listing();
        $dataObjects->addConditionParam('title LIKE ?', ['%' . $query . '%']);
        $dataObjects->setLimit(10);

        return $dataObjects->getObjects();
    }
}

