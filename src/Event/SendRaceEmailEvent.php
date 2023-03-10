<?php

namespace App\Event;

use App\Entity\Race;
use Symfony\Contracts\EventDispatcher\Event;

class SendRaceEmailEvent extends Event
{
    public const NAME = 'race.sendmail';
    public const NAME_FORCE = 'race.forcesendmail';

    protected Race $race;
    public function __construct(Race $race)
    {
        $this->race = $race;
    }
    public function getRace(): Race
    {
        return $this->race;
    }

}