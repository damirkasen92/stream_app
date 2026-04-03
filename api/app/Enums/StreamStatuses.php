<?php

namespace App\Enums;

enum StreamStatuses: string
{
    case live = 'live';
    case offline = 'offline';
    case ended = 'ended';
}
