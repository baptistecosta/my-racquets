<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

/**
 * Purge database
 */
class PurgeDatabaseCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:purge-database')
            ->addOption(
                'force',
                'f',
                InputOption::VALUE_NONE,
                'If set, the task will run even in dev or prod mode'
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ('test' !== $input->getOption('env') && !$input->getOption('force')) {
            throw new \InvalidArgumentException('You must purge database in "test" env, or use the --force (-f) flag');
        }

        $output->write('<comment>Purging database... </comment>');
        $this->getContainer()->get('app.testing.purger')->purge();
        $output->writeln('<info>OK</info>');
    }
}
