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

use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Thelia\Command\ContainerAwareCommand;
use TheliaSession\Entity\SessionConfigEntity;
use TheliaSession\Event\SessionConfigEvent;
use TheliaSession\Event\TheliaSessionEvents;
use TheliaSession\Helper\DataOptionCommandHelper;

/**
 * Class TheliaSessionConfigurationCommand
 * @package TheliaSession\Command
 * @author gilles bourgeat <gilles.bourgeat@gmail.com>
 */
class TheliaSessionConfigurationCommand extends ContainerAwareCommand
{
    /** @var InputInterface */
    protected $input;

    /** @var OutputInterface */
    protected $output;

    protected function configure()
    {
        $this
            ->setname('session:config')
            ->addOption(
                'handler',
                null,
                InputOption::VALUE_OPTIONAL,
                'Handler',
                null
            )
            ->addOption(
                'host',
                null,
                InputOption::VALUE_OPTIONAL,
                'Host',
                null
            )
            ->addOption(
                "port",
                null,
                InputOption::VALUE_OPTIONAL,
                'Port',
                null
            )
            ->addOption(
                "user",
                null,
                InputOption::VALUE_OPTIONAL,
                'User',
                null
            )
            ->addOption(
                "password",
                null,
                InputOption::VALUE_OPTIONAL,
                'Password',
                null
            )
            ->addOption(
                'pool',
                null,
                InputOption::VALUE_OPTIONAL,
                'Pool',
                null
            )
            ->setDescription('Set session configurations');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $output->writeln('Please enter the session configuration information:');

        $sessionConfig = $this->getSessionConfigurationInformation($input, $output);

        /** @var EventDispatcherInterface $eventDispatcher */
        $eventDispatcher = $this->getContainer()->get('event_dispatcher');

        try {
            $eventDispatcher->dispatch(TheliaSessionEvents::SESSION_CONFIG, new SessionConfigEvent($sessionConfig));

            $output->writeln(sprintf("<info>%s</info>", 'Thelia session is configured with successfully !'));
        } catch (\Exception $e) {
            $output->writeln(sprintf("<error>%s</error>", $e->getMessage()));
        }
    }

    /**
     * Ask to user all needed information
     *
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return SessionConfigEntity
     */
    protected function getSessionConfigurationInformation(InputInterface $input, OutputInterface $output)
    {
        $sessionConfig = new SessionConfigEntity();

        $sessionConfig->setHandlerName(
            $this->getData(
                'handler',
                (new DataOptionCommandHelper())
                ->setLabel('Handler : ')
                ->setErrorMessage("Please enter a valid handler.")
            )
        );

        $sessionConfig->setHost(
            $this->getData(
                'host',
                (new DataOptionCommandHelper())
                    ->setLabel('Host (127.0.0.1) : ')
                    ->setErrorMessage("Please enter a valid host.")
                    ->setEmptyValue('127.0.0.1')
                    ->setEmpty(true)
            )
        );

        $sessionConfig->setPort(
            $this->getData(
                'port',
                (new DataOptionCommandHelper())
                    ->setLabel('Port : ')
                    ->setErrorMessage("Please enter a valid port.")
            )
        );

        $sessionConfig->setUser(
            $this->getData(
                'user',
                (new DataOptionCommandHelper())
                    ->setLabel('User : ')
                    ->setErrorMessage("Please enter a valid user.")
                    ->setEmpty(true)
            )
        );

        $sessionConfig->setPassword(
            $this->getData(
                'password',
                (new DataOptionCommandHelper())
                    ->setLabel('Password : ')
                    ->setErrorMessage("Please enter a valid password.")
                    ->setEmpty(true)
            )
        );

        $sessionConfig->setPool(
            $this->getData(
                'pool',
                (new DataOptionCommandHelper())
                    ->setLabel('Pool (thelia) : ')
                    ->setErrorMessage("Please enter a valid pool name.")
                    ->setEmpty(true)
            )
        );

        return $sessionConfig;
    }

    /**
     * @param string $text
     * @return string
     */
    protected function decorateInfo($text)
    {
        return sprintf("<info>%s</info>", $text);
    }

    /**
     * @param string $name
     * @param DataOptionCommandHelper $option
     * @return string
     */
    protected function getData($name, DataOptionCommandHelper $option)
    {
        /** @var QuestionHelper $helper */
        $helper = $this->getHelper('question');

        $question = new Question($this->decorateInfo($option->getLabel()));

        if ($this->input->hasOption($name)) {
            $data = $this->input->getOption($name);

            $value = trim($data);

            if (!empty($value) || $option->isEmpty()) {
                return $value;
            }
        }

        if ($option->isHidden()) {
            $question->setHidden(true);
            $question->setHiddenFallback(false);
        }

        $question->setValidator(function ($value) use ($option) {
            $value = trim($value);

            if (empty($value) && !$option->isEmpty()) {
                throw new \Exception($option->getErrorMessage());
            }

            return $value;
        });

        return $helper->ask($this->input, $this->output, $question);
    }
}
