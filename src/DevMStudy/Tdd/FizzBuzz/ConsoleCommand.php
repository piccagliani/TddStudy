<?php
namespace DevMStudy\Tdd\FizzBuzz;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConsoleCommand extends \Symfony\Component\Console\Command\Command
{
    protected function configure()
    {
        $this
            ->setName("tddstudy:fizzbuzz")
            ->setDescription("generate fizzbuzz")
            ->addArgument("start", InputArgument::REQUIRED)
            ->addArgument("end", InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $start = $input->getArgument("start");
        $end = $input->getArgument("end");

        if (!preg_match('/^[0-9]+$/', $start)) {
            throw new \Exception('"start" must be integer.');
        }
        if (!preg_match('/^[0-9]+$/', $end)) {
            throw new \Exception('"end" must be integer.');
        }
        if ($end < $start) {
            throw new \Exception('"start" must be smaller than "end".');
        }

        $generator = new FizzBuzzGenerator();
        $result = $generator->generate($start, $end);
        $output->writeln($result);
    }
}