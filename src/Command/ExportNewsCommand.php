<?php

namespace App\Command;

use Pimcore\Console\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Pimcore\Model\DataObject\BlogPost;
use Symfony\Component\Console\Command\Command;

class ExportNewsCommand extends AbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('app:export-news')
            ->setDescription('Export news data from Pimcore Objects');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            // Retrieve data objects (e.g., BlogPost)
            $blogPosts = new BlogPost\Listing();

            // Create a new Spreadsheet instance
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Add headers to the Excel file
            $headers = ['Title', 'Description', 'Content', 'Posted By'];
            $sheet->fromArray([$headers], null, 'A1');

            // Add data to the Excel file
            $row = 2;
            foreach ($blogPosts as $blogPost) {
                $rowData = [
                    $blogPost->getTitle(),
                    $blogPost->getShortDescription(),
                    $blogPost->getContent(),
                    $blogPost->getPostedBy(),
                ];

                $sheet->fromArray([$rowData], null, 'A' . $row);
                $row++;
            }

            // Save the Excel file
            $writer = new Xlsx($spreadsheet);
            $writer->save('exported_data.xlsx');

            $output->writeln('Export completed.');
            return Command::SUCCESS;
        } catch (\Exception $e) {
        // Error handling
    $output->writeln("Error: {$e->getMessage()}");
    return Command::FAILURE;
        }
    }
}
