<?php

namespace JsonEntityGenerator\Command;

use JsonEntityGenerator\Generator\EntityGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateFromJsonCommand extends Command
{
    protected static $defaultName = 'generate:from-json';

    public function __construct(private EntityGenerator $generator)
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Génère entités, repositories, et contrôleurs depuis un fichier JSON')
            ->addArgument('file', InputArgument::REQUIRED, 'Chemin vers le fichier JSON');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $file = $input->getArgument('file');
        $json = file_get_contents($file);

        $this->generator->generateFromJson($json, $output);

        $output->writeln('<info>Génération terminée !</info>');
        return Command::SUCCESS;
    }
}
