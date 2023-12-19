<?php

// src/Command/ImportNewsCommand.php

namespace App\Command;


use Pimcore\Console\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Pimcore\Model\Asset;
use Pimcore\Model\DataObject;
use Pimcore\Tool;
use Shuchkin\SimpleXLSX;
use Pimcore\Model\DataObject\BlogPost;
use Pimcore\Model\DataObject\Folder; // Import the Folder class


class ImportNewsCommand extends AbstractCommand
{

    protected function configure()
    {
        $this
            ->setName('app:import-news')
            ->setDescription('Import news data from Excel file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $excelFilePath = 'data-import/news_articles.xlsx';

        // Set the parent folder for new blog posts
        $parentFolder = Folder::getByPath('/BlogPosts/Imported');

        if (!$parentFolder instanceof Folder) {
            $output->writeln('Error: Parent folder not found.');
            return Command::FAILURE;
        }

        try {
            $xlsx = new SimpleXLSX($excelFilePath);

            foreach ($xlsx->rows() as $row) {
                // Assuming $row[0] contains the identifier for the News Data Object
                $newsId = $row[0];

                // Check if the News Data Object with the given ID exists
                $news = DataObject\BlogPost::getById($newsId);

                if (!$news instanceof BlogPost) {
                    // If the Data Object doesn't exist, you may create a new one
                    $news = new BlogPost();
                    $news->setKey($newsId); // Set the key or any other necessary properties
                }

                // Set other properties based on your Excel columns
                $news->setTitle($row[1]);
                $news->setShortDescription($row[2]);
                $news->setPostedBy($row[3]);
                // Set other properties as needed

                $news->setParent($parentFolder);

                // Save the Data Object
                $news->save();

                $output->writeln("Imported: News ID - $newsId, Title - {$news->getTitle()}, Description - {$news->getShortDescription()}, Author - {$news->getPostedBy()}");
            }

            $output->writeln('Import completed.');
        } catch (\Exception $e) {
            $output->writeln("Error: {$e->getMessage()}");
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
