<?php

namespace App\Enums;

use App\Traits\EnumHelpers;

enum DataSources: string
{
    use EnumHelpers;

    case NEWS_API_ORG = 'news_api_org';
    case THE_GUARDIAN_API_COM = 'the_guardian_api_com';
    case THE_NEWS_API_COM = 'the_news_api_com';
}
