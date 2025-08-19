<?php

declare(strict_types=1);

namespace App\Market\Infrastructure\Command;

use App\Market\Application\Create\CreateItemDto;
use App\Market\Application\Create\CreateItemUseCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportDataCommand extends Command
{
    protected static $defaultName = 'market:import-data';
    protected static $defaultDescription = 'Import data from a JSON file';

    public function __construct(
        private CreateItemUseCase $createUnitUseCase,
    )
    {
        parent::__construct(self::$defaultName);
    }

    protected function configure(): void
    {
        $this->setHelp('This command allows you to import data from a CSV file');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $data = file_get_contents(__DIR__ . '/../../../../etc/dataSet/request.json');

        $items = json_decode($data, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $output->writeln('<error>Failed to decode JSON: ' . json_last_error_msg() . '</error>');
            return Command::FAILURE;
        }

        array_map(
            function ($item) use ($output) {
                $this->createUnitUseCase->__invoke(
                    new CreateItemDto(
                        $item['name'],
                        (int) $item['quantity'],
                        $item['type'],
                        $item['unit']
                    )
                );

                $output->writeln(sprintf(
                    '<info>Item %s of type %s with weight %d %s created successfully.</info>',
                    $item['name'],
                    $item['type'],
                    (int) $item['quantity'],
                    $item['unit']
                ));
            },
            $items
        );

        return Command::SUCCESS;
    }
}