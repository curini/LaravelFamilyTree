<?php

namespace App;

enum EventsEnum: string
{
    case birth = EventTypesEnum::BIRTH->value;
    case death = EventTypesEnum::DEATH->value;
    case wedding = EventTypesEnum::WEDDING->value;
    case otherwedding = EventTypesEnum::WEDDING->value;
    case military = EventTypesEnum::MILITARY->value;
    case house = EventTypesEnum::MOVE->value;
    case oldhouse = EventTypesEnum::MOVE->value;
    case papers = EventTypesEnum::OTHER->value;
    case otherpapers = EventTypesEnum::OTHER->value;
    case deathchild = EventTypesEnum::OTHER->value;
}
