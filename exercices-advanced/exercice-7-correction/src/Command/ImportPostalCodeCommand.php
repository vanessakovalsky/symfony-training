<?php

namespace App\Command;

use App\Entity\PostalCode;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportPostalCodeCommand extends Command
{
    protected static $defaultName = 'import-postal-code';
    private $em;
    
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }


    protected function configure()
    {
        $this
            ->setDescription('Import postal code and city from official CSV file')
            ->addArgument('filename', InputArgument::REQUIRED, 'The filename on the source folder')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filename  = $input->getArgument('filename');
        $fileLines=file($filename);
        $size      = count($fileLines);
        $progress  = new ProgressBar($output, $size);
        $progress->start();
        $in = fopen($filename, 'r');
        $out = null;
        $row_count = 0;

        while (!feof($in)) {
            $data = fgetcsv($in , 0 , ';');
            
            $postalCode = new PostalCode();
            $postalCode->setPostalCode($data[2]);
            $postalCode->setCity($data[1]);
    
            $this->em->persist($postalCode);

            if (($row_count % 20) === 0) {
                $progress->advance();
                $this->em->flush();
                $this->em->clear();
            }
            $row_count++;
        }
        $this->em->flush();
        $this->em->clear();
        fclose($in);
        $progress->finish();
        return 0;
    }
}
