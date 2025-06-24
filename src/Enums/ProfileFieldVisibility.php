<?php

namespace Axyr\Nextcloud\Enums;

enum ProfileFieldVisibility: string
{
    case Show = 'show';
    case Hide = 'hide';
    case ShowUsersOnly = 'show_users_only';
}
