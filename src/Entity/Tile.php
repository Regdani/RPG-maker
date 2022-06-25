<?php

namespace Application\Entity;
use Application\Atoms\Entity\_Tile;
use Atomino\Carbon\Attributes\Modelify;
use Atomino\Carbon\Attributes\Protect;
use Atomino\Carbon\Plugins\Attachment\Attachmentable;
use Atomino\Carbon\Plugins\Attachment\AttachmentCollection;
use Atomino\Carbon\Plugins\Created\Created;
use Atomino\Carbon\Plugins\Updated\Updated;

#[Modelify(\Application\Database\DefaultConnection::class, 'tile', true)]
#[Protect('name', true, true)]
#[Created()]
#[Updated()]
#[Attachmentable()]
#[AttachmentCollection(field: 'tile', maxCount: 1, maxSize: 1024 * 1024, mimetype: "/image\/.*/")]
class Tile extends _Tile
{
    const LAYERS = [
        self::layer__floor  => [self::ROLE_FLOOR],
        self::layer__object => [self::ROLE_OBJECT]
    ];
}