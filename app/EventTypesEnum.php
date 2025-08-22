<?php

namespace App;

enum EventTypesEnum: string
{
    case BIRTH = 'Birthday';
    case DEATH = 'Death date';
    case WEDDING = 'Wedding day';
    case DIVORCE = 'Date of divorce';
    case MILITARY = 'Military service';
    case GRADUATION = 'Graduation day';
    case LICENCE = 'Driving license obtained';
    case MOVE = 'Move in date';
    case COMMUNION = 'First communion';
    case WORK = 'Working period';
    case OTHER = 'Other';
}
