<?php namespace Application\Atoms\Entity;

use Atomino\Carbon\Database\Finder\Filter;
use Atomino\Carbon\Attributes\Field;
use Atomino\Carbon\Attributes\Immutable;
use Atomino\Carbon\Attributes\Protect;
use Atomino\Carbon\Attributes\Validator;
use Atomino\Carbon\Entity;
use Atomino\Carbon\Model;
use Atomino\Carbon\Attributes\RequiredField;


/**
 * @property-read \Atomino\Bundle\Attachment\Collection $images
 * @method static \Atomino\Carbon\Database\Finder\Comparison attachments($isin = null)
 * @property-read \string|null $attachments
 * @method static \Atomino\Carbon\Database\Finder\Comparison created($isin = null)
 * @property-read \DateTime|null $created
 * @method static \Atomino\Carbon\Database\Finder\Comparison body($isin = null)
 * @property string|null $body
 * @method static \Atomino\Carbon\Database\Finder\Comparison youtube($isin = null)
 * @property string|null $youtube
 * @method static \Atomino\Carbon\Database\Finder\Comparison type($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison id($isin = null)
 * @property-read int|null $id
 * @method static \Atomino\Carbon\Database\Finder\Comparison x($isin = null)
 * @property-read int|null $x
 * @method static \Atomino\Carbon\Database\Finder\Comparison y($isin = null)
 * @property-read int|null $y
 * @method static \Atomino\Carbon\Database\Finder\Comparison level($isin = null)
 * @property-read int|null $level
 * @method static \Atomino\Carbon\Database\Finder\Comparison building($isin = null)
 * @property string|null $building
 * @method static \Atomino\Carbon\Database\Finder\Comparison title($isin = null)
 * @property string|null $title
 * @method static \Atomino\Carbon\Database\Finder\Comparison updated($isin = null)
 * @property-read \DateTime|null $updated
 * @method static \Application\Atoms\EntityHelper\_Poi_FINDER search( Filter $filter = null )
 */
#[RequiredField('id', \Atomino\Carbon\Field\IntField::class)]
#[Immutable("created", true)]
#[Protect("created", true, false)]
#[RequiredField("created", \Atomino\Carbon\Field\DateTimeField::class)]
#[Protect("updated", true, false)]
#[RequiredField("updated", \Atomino\Carbon\Field\DateTimeField::class)]
#[Immutable( 'attachments', true )]
#[Protect( 'attachments', false, false )]
#[Field("attachments", \Atomino\Carbon\Field\JsonField::class)]
#[RequiredField("body", \Atomino\Carbon\Field\StringField::class)]
#[Field("created", \Atomino\Carbon\Field\DateTimeField::class)]
#[Validator("body", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>999])]
#[Field("body", \Atomino\Carbon\Field\StringField::class)]
#[Field("x", \Atomino\Carbon\Field\IntField::class)]
#[Field("y", \Atomino\Carbon\Field\IntField::class)]
#[Field("building", \Atomino\Carbon\Field\StringField::class)]
#[Field("level", \Atomino\Carbon\Field\IntField::class)]
#[Validator("youtube", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>255])]
#[Field("youtube", \Atomino\Carbon\Field\StringField::class)]
#[Validator("type", \Symfony\Component\Validator\Constraints\Choice::class, ['multiple'=>false,'choices'=>['media', 'teleport']])]
#[Field("type", \Atomino\Carbon\Field\EnumField::class, ['media','teleport'])]
#[Field("id", \Atomino\Carbon\Field\IntField::class)]
#[Protect("id", true, false)]
#[Immutable("id",false)]
#[Validator("title", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>255])]
#[Field("title", \Atomino\Carbon\Field\StringField::class)]
#[Field("updated", \Atomino\Carbon\Field\DateTimeField::class)]
abstract class _Poi extends Entity implements \Atomino\Bundle\Attachment\AttachmentableInterface{
	static null|Model $model = null;
	use \Atomino\Carbon\Plugins\Created\CreatedTrait;
	use \Atomino\Carbon\Plugins\Updated\UpdatedTrait;
    use \Atomino\Carbon\Plugins\Attachment\AttachmentableTrait;
    protected final function __getImages(){return $this->getAttachmentCollection("images");}
	const ROLE_MEDIA = "media";
    const ROLE_TELEPORT= "teleport";
    const attachments = 'attachments';
    protected array $attachments = [];
	const created = 'created';
	protected \DateTime|null $created = null;
	protected function getCreated():\DateTime|null{ return $this->created;}
	const body = 'body';
	public string|null $body = null;
    const x = 'x';
    public int|null $x = null;
    const y = 'y';
    public string|null $building = null;
    const building = 'building';
    public int|null $level = null;
    const level = 'level';
    public int|null $y = null;
    const youtube = 'youtube';
    public string|null $youtube = null;
	const type = 'type';
	public string|null $type = null;
	const group__media= 'media';
    const group__teleport = 'teleport';
	const id = 'id';
	protected int|null $id = null;
	protected function getId():int|null{ return $this->id;}
	const title = 'title';
	protected string|null $title = null;
	protected function getTitle():string|null{ return $this->title;}
	protected function setTitle(string|null $value){ $this->title = $value;}
	const updated = 'updated';
	protected \DateTime|null $updated = null;
	protected function getUpdated():\DateTime|null{ return $this->updated;}
}





