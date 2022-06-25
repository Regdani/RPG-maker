<?php

namespace Application\Entity;
use Application\Atoms\Entity\_Poi;
use Atomino\Carbon\Attributes\Modelify;
use Atomino\Carbon\Attributes\Protect;
use Atomino\Carbon\Plugins\Attachment\Attachmentable;
use Atomino\Carbon\Plugins\Attachment\AttachmentCollection;
use Atomino\Carbon\Plugins\Created\Created;
use Atomino\Carbon\Plugins\Updated\Updated;

#[Modelify(\Application\Database\DefaultConnection::class, 'poi', true)]
#[Protect('title', true, true)]
#[Created()]
#[Updated()]
#[Attachmentable()]
#[AttachmentCollection(field: 'images',  maxSize: 1024 * 1024, mimetype: "/image\/.*/")]
class Poi extends _Poi
{
    const GROUPS = [
        self::group__media   => [self::ROLE_MEDIA],
        self::group__teleport   => [self::ROLE_TELEPORT]
    ];
}