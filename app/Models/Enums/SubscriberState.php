<?php

namespace App\Models\Enums;

enum SubscriberState: string
{
    case ACTIVE = 'active';
    case UNSUBSCRIBED = 'unsubscribed';
    case JUNK = 'junk';
    case BOUNCED = 'bounced';
    case UNCONFIRMED = 'unconfirmed';
}
