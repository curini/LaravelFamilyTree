<?php

namespace App;

enum TagsEnum: string
{
    case SINGLE_MALE = 'single_male';
    case SINGLE_FEMALE = 'single_female';
    case MAIN_MALE_CHILD = 'main_male_child';
    case MAIN_FEMALE_CHILD = 'main_female_child';
    case FAMILY_SINGLE_FEMALE = 'family_single_female';
    case FAMILY_SINGLE_MALE = 'family_single_male';
}
