#!/usr/bin/env php
<?php

require __DIR__ . '/../../vendor/autoload.php';

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Application;

class ModuleCli extends Command
{
  public function __construct(public readonly string $appName, public readonly string $moduleFolder)
  {
    parent::__construct();
  }

  protected function configure(): void
  {
    $this->setName('create')
      ->setDescription('Creates a zzt module')
      ->setHelp('Help text goes here!')
      ->addArgument('name', InputArgument::REQUIRED, 'Module name')
    ;
  }

  protected function execute(InputInterface $input, OutputInterface $output): int
  {
    $output->writeln(
      sprintf(
        'Created module "%s" in app/%s',
        $input->getArgument('name'),
        $this->moduleFolder
      )
    );
    return Command::SUCCESS;
  }
}

$appDir = __DIR__ . '/../../app';
$config = require $appDir . '/config/config.php';

$appName = $config['base']['app_name'];
$modulesDir = $config['base']['modules_folder'];

$app = new Application();
$app->add(new ModuleCli($appName, $modulesDir));
$app->run();
