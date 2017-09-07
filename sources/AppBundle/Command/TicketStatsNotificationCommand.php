<?php

namespace AppBundle\Command;

use Afup\Site\Forum\Inscriptions;
use AppBundle\Event\Model\Repository\EventRepository;
use AppBundle\Event\Model\Repository\TicketTypeRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TicketStatsNotificationCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('ticket-stats-notification')
        ;
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $forum_inscriptions = new Inscriptions($GLOBALS['AFUP_DB']);
        $eventReposotory = $this->getContainer()->get('ting')->get(EventRepository::class);
        $ticketRepository = $this->getContainer()->get('ting')->get(TicketTypeRepository::class);
        $event = $eventReposotory->getNextEvent();

        if (null === $event) {
            return;
        }

        $date = new \DateTime();
        $date->modify('- 1 day');

        $message = $this->getContainer()->get('app.slack_message_factory')->createMessageForTicketStats(
            $event,
            $forum_inscriptions,
            $ticketRepository,
            $date
        );

        $this->getContainer()->get('app.slack_notifier')->sendMessage($message);
    }
}