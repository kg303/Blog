<?php

// src/Service/SearchService.php

namespace App\Service;

use Pimcore\Model\DataObject\BlogPost;
class SearchService
{
    public function search($query)
    {
        // Perform the search logic here based on your needs
        // This is just an example using DataObjects
        $dataObjects = $this->searchDataObjects($query);

        // Add other search logic for different data types (documents, assets, etc.)

        return [
            'dataObjects' => $dataObjects,
            // Add other types of results as needed
        ];
    }

    private function searchDataObjects($query)
    {
        // Example: Search DataObjects based on a custom field 'name'
        $dataObjects = new BlogPost\Listing();
        $dataObjects->addConditionParam('title LIKE ?', ['%' . $query . '%']);
        $dataObjects->setLimit(10); // Limit the number of results

        return $dataObjects->getObjects();
    }
}

