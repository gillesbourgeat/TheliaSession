<?php
/*************************************************************************************/
/*      This file is part of the TheliaSession module                                */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace TheliaSession\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Thelia\Command\ContainerAwareCommand;
use TheliaSession\Event\TheliaSessionEvents;

/**
 * Class TheliaSessionClearCommand
 * @package TheliaSession\Command
 * @author gilles bourgeat <gilles.bourgeat@gmail.com>
 */
class TheliaSessionClearCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setname('session:clear')
            ->setDescription('Clear all sessions');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var EventDispatcherInterface $eventDispatcher */
        $eventDispatcher = $this->getContainer()->get('event_dispatcher');

        try {
            $eventDispatcher->dispatch(TheliaSessionEvents::SESSION_CLEAR);

            $output->writeln(sprintf("<info>%s</info>", 'Sessions cleared !'));
        } catch (\Exception $e) {
            $output->writeln(sprintf("<error>%s</error>", $e->getMessage()));
        }
    }
}
