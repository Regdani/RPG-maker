<?php

namespace Application\Atoms\Entity;

use Atomino\Carbon\Attributes\Field;
use Atomino\Carbon\Attributes\Immutable;
use Atomino\Carbon\Attributes\Protect;
use Atomino\Carbon\Attributes\RequiredField;
use Atomino\Carbon\Attributes\Validator;
use Atomino\Carbon\Database\Finder\Filter;
use Atomino\Carbon\Entity;
use Atomino\Carbon\Model;

/**
 * @property-read \Atomino\Bundle\Attachment\Collection $tile
 * @method static \Atomino\Carbon\Database\Finder\Comparison attachments($isin = null)
 * @property-read \string|null $attachments
 * @method static \Atomino\Carbon\Database\Finder\Comparison created($isin = null)
 * @property-read \DateTime|null $created
 * @method static \Atomino\Carbon\Database\Finder\Comparison layer($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison id($isin = null)
 * @property-read int|null $id
 * @method static \Atomino\Carbon\Database\Finder\Comparison name($isin = null)
 * @property string|null $name
 * @method static \Atomino\Carbon\Database\Finder\Comparison updated($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison walkable($isin = null)
 * @property string|null $walkable
 * @property-read \DateTime|null $updated
 * @method static \Application\Atoms\EntityHelper\_Tile_FINDER search( Filter $filter = null )
 */
#[RequiredField('id', \Atomino\Carbon\Field\IntField::class)]
#[Immutable("created", true)]
#[Protect("created", true, false)]
#[RequiredField("created", \Atomino\Carbon\Field\DateTimeField::class)]
#[Protect("updated", true, false)]
#[RequiredField("updated", \Atomino\Carbon\Field\DateTimeField::class)]
#[Immutable( 'attachments', true )]
#[Protect( 'attachments', false, false )]
#[RequiredField( 'attachments', \Atomino\Carbon\Field\JsonField::class )]
#[Field("attachments", \Atomino\Carbon\Field\JsonField::class)]
#[Field("created", \Atomino\Carbon\Field\DateTimeField::class)]
#[Validator("layer", \Symfony\Component\Validator\Constraints\Choice::class, ['multiple'=>false,'choices'=>['floor','object']])]
#[Field("layer", \Atomino\Carbon\Field\EnumField::class, ['floor','object'])]
#[Field("id", \Atomino\Carbon\Field\IntField::class)]
#[Protect("id", true, false)]
#[Immutable("id",false)]
#[Validator("name", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>16])]
#[Field("name", \Atomino\Carbon\Field\StringField::class)]
#[Field("walkable", \Atomino\Carbon\Field\BoolField::class)]
#[Field("updated", \Atomino\Carbon\Field\DateTimeField::class)]
abstract class _Tile extends Entity implements \Atomino\Bundle\Attachment\AttachmentableInterface
{
    static null|Model $model = null;
    use \Atomino\Carbon\Plugins\Created\CreatedTrait;
    use \Atomino\Carbon\Plugins\Updated\UpdatedTrait;
    use \Atomino\Carbon\Plugins\Attachment\AttachmentableTrait;
    protected final function __getTile(){return $this->getAttachmentCollection("tile");}
    const ROLE_FLOOR = "floor";
    const ROLE_OBJECT= "object";
    const attachments = 'attachments';
    const walkable = 'walkable';
    public bool $walkable = false;
    protected array $attachments = [];
    const created = 'created';
    protected \DateTime|null $created = null;
    protected function getCreated():\DateTime|null{ return $this->created;}
    const layer = 'layer';
    public string|null $layer = null;
    const layer__floor = 'floor';
    const layer__object = 'object';
    const id = 'id';
    protected int|null $id = null;
    protected function getId():int|null{ return $this->id;}
    const name = 'name';
    protected string|null $name = null;
    protected function getName():string|null{ return $this->name;}
    protected function setName(string|null $value){ $this->name = $value;}
    const updated = 'updated';
    protected \DateTime|null $updated = null;
    protected function getUpdated():\DateTime|null{ return $this->updated;}

}