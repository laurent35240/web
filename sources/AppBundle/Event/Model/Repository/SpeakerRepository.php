<?php

namespace AppBundle\Event\Model\Repository;

use AppBundle\Event\Model\Event;
use AppBundle\Event\Model\JoinHydrator;
use AppBundle\Event\Model\Speaker;
use AppBundle\Event\Model\Talk;
use CCMBenchmark\Ting\Repository\HydratorSingleObject;
use CCMBenchmark\Ting\Repository\Metadata;
use CCMBenchmark\Ting\Repository\MetadataInitializer;
use CCMBenchmark\Ting\Repository\Repository;
use CCMBenchmark\Ting\Serializer\SerializerFactoryInterface;

class SpeakerRepository extends Repository implements MetadataInitializer
{
    /**
     * @param Talk $talk
     * @return \CCMBenchmark\Ting\Repository\CollectionInterface
     */
    public function getSpeakersByTalk(Talk $talk)
    {
        $query = $this->getPreparedQuery('SELECT c.conferencier_id, c.id_forum, c.civilite, c.nom, c.prenom, c.email,c.societe,
        c.biographie, c.twitter, c.user_github, c.photo
        FROM afup_conferenciers c
        LEFT JOIN afup_conferenciers_sessions cs ON cs.conferencier_id = c.conferencier_id
        WHERE cs.session_id = :talkId
        ')->setParams(['talkId' => $talk->getId()]);

        return $query->query($this->getCollection(new HydratorSingleObject()));
    }

    /**
     * Retrieve speakers with a scheduled talk for a given event
     * @param Event $event
     * @param bool $returnTalksThatWillBePublished
     *
     * @return \CCMBenchmark\Ting\Repository\CollectionInterface
     */
    public function getScheduledSpeakersByEvent(Event $event, $returnTalksThatWillBePublished = false)
    {
        $hydrator = new JoinHydrator();
        $hydrator->aggregateOn('speaker', 'talk', 'getId');

        $publishedAtFilter = '(talk.date_publication < NOW() OR talk.date_publication IS NULL)';
        if ($returnTalksThatWillBePublished) {
            $publishedAtFilter = '(1 = 1)';
        }

        $query = $this->getPreparedQuery('SELECT speaker.conferencier_id, speaker.id_forum, speaker.civilite, speaker.nom, speaker.prenom, speaker.email, speaker.societe,
        speaker.biographie, speaker.twitter, speaker.user_github, speaker.photo, talk.titre, talk.session_id,
        speaker.will_attend_speakers_diner,
        speaker.has_special_diet,
        speaker.special_diet_description,
        speaker.hotel_nights
        FROM afup_conferenciers speaker
        INNER JOIN afup_conferenciers_sessions cs ON cs.conferencier_id = speaker.conferencier_id
        INNER JOIN afup_sessions talk ON talk.session_id = cs.session_id
        WHERE speaker.id_forum = :event AND talk.plannifie=1 AND ' . $publishedAtFilter . '
        ORDER BY speaker.prenom ASC, speaker.nom ASC
        ')->setParams(['event' => $event->getId()]);

        return $query->query($this->getCollection($hydrator));
    }

    /**
     * @param Event $event
     *
     * @return \CCMBenchmark\Ting\Repository\CollectionInterface
     */
    public function getSpeakersByEvent(Event $event)
    {
        $query = $this->getPreparedQuery(
            'SELECT afup_conferenciers.*
        FROM afup_conferenciers
        JOIN afup_conferenciers_sessions ON (afup_conferenciers_sessions.conferencier_id = afup_conferenciers.conferencier_id)
        JOIN afup_sessions ON (afup_conferenciers_sessions.session_id = afup_sessions.session_id)
        JOIN afup_forum_planning ON (afup_forum_planning.id_session = afup_sessions.session_id)
        WHERE afup_sessions.id_forum = :eventId
        GROUP BY afup_conferenciers.conferencier_id
        '
        )->setParams(['eventId' => $event->getId()]);

        return $query->query($this->getCollection(new HydratorSingleObject()));
    }

    /**
     * @param Event $event
     * @param string $email
     *
     * @return Speaker|null
     */
    public function getByEventAndEmail(Event $event, $email)
    {
        return $this->getBy([
            'eventId' => $event->getId(),
            'email' => $email,
        ])->first();
    }

    /**
     * @inheritDoc
     */
    public static function initMetadata(SerializerFactoryInterface $serializerFactory, array $options = [])
    {
        $metadata = new Metadata($serializerFactory);

        $metadata->setEntity(Speaker::class);
        $metadata->setConnectionName('main');
        $metadata->setDatabase($options['database']);
        $metadata->setTable('afup_conferenciers');

        $metadata
            ->addField([
                'columnName' => 'conferencier_id',
                'fieldName' => 'id',
                'primary'       => true,
                'autoincrement' => true,
                'type' => 'int'
            ])
            ->addField([
                'columnName' => 'id_forum',
                'fieldName' => 'eventId',
                'type' => 'int'
            ])
            ->addField([
                'columnName' => 'civilite',
                'fieldName' => 'civility',
                'type' => 'string'
            ])
            ->addField([
                'columnName' => 'nom',
                'fieldName' => 'lastname',
                'type' => 'string'
            ])
            ->addField([
                'columnName' => 'prenom',
                'fieldName' => 'firstname',
                'type' => 'string'
            ])
            ->addField([
                'columnName' => 'email',
                'fieldName' => 'email',
                'type' => 'string'
            ])
            ->addField([
                'columnName' => 'societe',
                'fieldName' => 'company',
                'type' => 'string'
            ])
            ->addField([
                'columnName' => 'biographie',
                'fieldName' => 'biography',
                'type' => 'string'
            ])
            ->addField([
                'columnName' => 'twitter',
                'fieldName' => 'twitter',
                'type' => 'string'
            ])
            ->addField([
                'columnName' => 'user_github',
                'fieldName' => 'user',
                'type' => 'int'
            ])
            ->addField([
                'columnName' => 'photo',
                'fieldName' => 'photo',
                'type' => 'string'
            ])
            ->addField([
                'columnName' => 'will_attend_speakers_diner',
                'fieldName' => 'willAttendSpeakersDiner',
                'type' => 'bool'
            ])
            ->addField([
                'columnName' => 'has_special_diet',
                'fieldName' => 'hasSpecialDiet',
                'type' => 'bool'
            ])
            ->addField([
                'columnName' => 'special_diet_description',
                'fieldName' => 'specialDietDescription',
                'type' => 'string'
            ])
            ->addField([
                'columnName' => 'hotel_nights',
                'fieldName' => 'hotelNights',
                'type' => 'string'
            ])
        ;

        return $metadata;
    }
}
