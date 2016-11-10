<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Loads fixtures for tests
 */
class LoadFixturesCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:load-fixtures')
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
            throw new \InvalidArgumentException('You must load fixtures in "test" env, or use the --force (-f) flag');
        }

        $output->write('<comment>Purging database... </comment>');
        $purger = $this->getContainer()->get('app.testing.purger');
        $purger->purge();
        $output->writeln('<info>OK</info>');

        $output->write('<comment>Loading fixtures... </comment>');
        $loader = $this->getContainer()->get('app.testing.fixtures_loader');
        $loader->load();
        $output->writeln('<info>OK</info>');
    }
}
