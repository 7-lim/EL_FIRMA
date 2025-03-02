<?php

namespace App\EventSubscriber;

use App\Repository\EvenementRepository;
use CalendarBundle\CalendarEvents as CalendarBundleCalendarEvents;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
use CalendarBundle\CalendarEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Event\PreSetDataEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CalendarSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly EvenementRepository $evenementRepository,
        private readonly UrlGeneratorInterface $router
    ) {}

    // public static function getSubscribedEvents(): array
    // {
    //     return [
    //         SetDataEvent::class => 'onCalendarSetData',
    //     ];
    // }

    // src/EventSubscriber/CalendarSubscriber.php
public static function getSubscribedEvents(): array
{
    return [
        CalendarEvents::SET_DATA => 'onCalendarSetData',
    ];
}

public function onCalendarSetData(CalendarEvent $calendarEvent): void
{
    $start = $calendarEvent->getStart();
    $end = $calendarEvent->getEnd();
    $filters = $calendarEvent->getFilters();

    dump('Subscriber triggered!');
    dump($calendarEvent->getStart());
    dump($calendarEvent->getEnd());

    // Keep your existing query logic
    $evenements = $this->evenementRepository
        ->createQueryBuilder('e')
        ->where('e.dateFin >= :start AND e.dateDebut <= :end')
        ->setParameter('start', $start->format('Y-m-d H:i:s'))
        ->setParameter('end', $end->format('Y-m-d H:i:s'))
        ->getQuery()
        ->getResult();
    
        foreach ($evenements as $evenement) {
            // Create event with proper time handling
            $event = new Event(
                $evenement->getTitre(),
                $evenement->getDateDebut(),
                $evenement->getDateFin()->modify('+1 day') // Add 1 day for fullcalendar inclusive end
            );
    
            // Set complete event options
            $event->setOptions([
                'url' => $this->router->generate('app_evenement_show', ['id' => $evenement->getId()]),
                'backgroundColor' => '#3788d8',
                'borderColor' => '#3788d8',
                'textColor' => '#ffffff',
                'allDay' => true,
                'extendedProps' => [
                    'lieu' => $evenement->getLieu(),
                    'description' => $evenement->getDescription(),
                    'places' => $evenement->getNombreDePlaces(),
                    'prix' => $evenement->getPrix()
                ]
            ]);
    
            $calendarEvent->addEvent($event);
            dump(count($evenements));
        }
    }
}