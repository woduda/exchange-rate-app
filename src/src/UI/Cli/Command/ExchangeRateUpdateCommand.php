<?php

namespace UI\Cli\Command;

use Application\Command\UpdateExchangeRates\UpdateExchangeRatesCommand;
use Application\CommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

final class ExchangeRateUpdateCommand extends Command
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        parent::__construct();

        $this->commandBus = $commandBus;
    }

    protected function configure()
    {
        $this
            ->setName('exchange-rate:update')
            ->setDescription('Command will synchronize all available exchange rates from NBP API')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $helper = $this->getHelper('question');
        $question = new Question('Please enter number of days in past to update: [7]', 7);
        $question->setValidator(function ($answer) {
            if (empty($answer) || is_numeric($answer) === false || $answer > 90 || $answer < 1) {
                throw new \RuntimeException(
                    'Given number of days is invalid or exceeded 90!'
                );
            }

            return $answer;
        });

        $daysInPast = $helper->ask($input, $output, $question);
        $io->success('Updating exchange rates has started!');

        $this->commandBus->dispatch(new UpdateExchangeRatesCommand($daysInPast));

        $io->success('Updating exchange rates has finished!');

        return Command::SUCCESS;
    }
}
