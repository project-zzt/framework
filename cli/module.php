#!/usr/bin/env php
<?php

require __DIR__ . '/../../vendor/autoload.php';

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Application;

$appDir = __DIR__ . '/../../app';
$config = require $appDir . '/config/config.php';

$appName = $config['base']['app_name'];
$modulesDir = $config['base']['modules_folder'];

class ModuleCli extends Command
{
  private readonly string $templates;

  public function __construct(
    private readonly string $appDir,
    private readonly string $appName,
    private readonly string $modulesDir,
  ) {
    parent::__construct();

    $this->templates = __DIR__ . '/../templates';
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
    // Create folders
    $newModule = $input->getArgument('name');
    $path = $this->appDir . '/' . $this->modulesDir . '/' . $newModule;
    if (is_dir($path)) {
      $output->writeln(sprintf('Folder %s already exists.', $newModule));
      return Command::FAILURE;
    }
    // Module folder
    $ok = mkdir($path);
    if (! $ok) {
      $output->writeln('Could not create module folder, something went wrong.');
      return Command::FAILURE;
    }
    // Handler folder
    $ok = mkdir($path . '/handlers');
    if (! $ok) {
      $output->writeln('Could not create handlers folder, something went wrong.');
      return Command::FAILURE;
    }
    // Views folder
    $ok = mkdir($path . '/views');
    if (! $ok) {
      $output->writeln('Could not create views folder, something went wrong.');
      return Command::FAILURE;
    }

    // Copy templates
    $from = $this->templates;
    $to = $this->appDir . '/' . $this->modulesDir . '/' . $newModule;
    // Module template
    $moduleTemaplte = $to . '/module.php';
    $ok = copy($from . '/module/module.dist.php', $moduleTemaplte);
    if (! $ok) {
      $output->writeln('Could not copy module file, something went wrong.');
      return Command::FAILURE;
    }
    // Handler template
    $handlerTemplate = $to . sprintf('/handlers/%s.php', $newModule);
    $ok = copy($from . '/module/handler.dist.php', $handlerTemplate);
    if (! $ok) {
      $output->writeln('Could not copy handler file, something went wrong.');
      return Command::FAILURE;
    }

    // Resolve placeholders
    $file = file_get_contents($moduleTemaplte);
    file_put_contents($moduleTemaplte, str_replace('{{APP_NAME}}', $this->appName, $file));
    file_put_contents($moduleTemaplte, str_replace('{{MODULE_NAME}}', $newModule, $file));
    $file = file_get_contents($handlerTemplate);
    file_put_contents($moduleTemaplte, str_replace('{{APP_NAME}}', $this->appName, $file));
    file_put_contents($moduleTemaplte, str_replace('{{MODULE_NAME}}', $newModule, $file));

    // Output
    $output->writeln(
      sprintf(
        'Created module "%s" in app/%s',
        $newModule,
        $this->modulesDir
      )
    );
    return Command::SUCCESS;
  }
}

$app = new Application();
$app->add(new ModuleCli($appDir, $appName, $modulesDir));
$app->run();
