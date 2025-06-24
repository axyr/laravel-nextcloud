<?php

namespace Axyr\Nextcloud\Enums;

enum WebDavNamespace: string
{
    case None = '';
    case Files = 'files';
    case Principals = 'principals';
    case Calendars = 'calendars';
    case SystemCalendars = 'system-calendars';
    case PublicCalendars = 'public-calendars';
    case AddressBooks = 'addressbooks';
    case SystemTags = 'systemtags';
    case SystemTagsRelations = 'systemtags-relations';
    case SystemTagsAssigned = 'systemtags-assigned';
    case Comments = 'comments';
    case Uploads = 'uploads';
    case Avatars = 'avatars';
    case Provisioning = 'provisioning';
    case Trashbin = 'trashbin';
    case Versions = 'versions';
}
