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
 * @property-read \Atomino\Bundle\Attachment\Collection $avatar
 * @method static \Atomino\Carbon\Database\Finder\Comparison attachments($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison created($isin = null)
 * @property-read \DateTime|null $created
 * @method static \Atomino\Carbon\Database\Finder\Comparison email($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison group($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison guid($isin = null)
 * @property-read string|null $guid
 * @method static \Atomino\Carbon\Database\Finder\Comparison id($isin = null)
 * @property-read int|null $id
 * @method static \Atomino\Carbon\Database\Finder\Comparison name($isin = null)
 * @property string|null $name
 * @method static \Atomino\Carbon\Database\Finder\Comparison password($isin = null)
 * @property-read string|null $password
 * @method static \Atomino\Carbon\Database\Finder\Comparison updated($isin = null)
 * @property-read \DateTime|null $updated
 * @method static \Application\Atoms\EntityHelper\_User_FINDER search( Filter $filter = null )
 */
#[RequiredField('id', \Atomino\Carbon\Field\IntField::class)]
#[Immutable( 'guid', true )]
#[Protect( 'guid', true, false )]
#[RequiredField('guid', \Atomino\Carbon\Field\StringField::class)]
#[Immutable("created", true)]
#[Protect("created", true, false)]
#[RequiredField("created", \Atomino\Carbon\Field\DateTimeField::class)]
#[Protect("updated", true, false)]
#[RequiredField("updated", \Atomino\Carbon\Field\DateTimeField::class)]
#[Immutable( 'attachments', true )]
#[Protect( 'attachments', false, false )]
#[RequiredField( 'attachments', \Atomino\Carbon\Field\JsonField::class )]
#[Protect("password", true, false)]
#[RequiredField("email", \Atomino\Carbon\Field\StringField::class)]
#[RequiredField("password", \Atomino\Carbon\Field\StringField::class)]
#[Field("attachments", \Atomino\Carbon\Field\JsonField::class)]
#[Field("created", \Atomino\Carbon\Field\DateTimeField::class)]
#[Validator("email", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>255])]
#[Field("email", \Atomino\Carbon\Field\StringField::class)]
#[Validator("group", \Symfony\Component\Validator\Constraints\Choice::class, ['multiple'=>false,'choices'=>['admin','visitor']])]
#[Field("group", \Atomino\Carbon\Field\EnumField::class, ['admin','visitor'])]
#[Validator("guid", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>36])]
#[Field("guid", \Atomino\Carbon\Field\StringField::class)]
#[Field("id", \Atomino\Carbon\Field\IntField::class)]
#[Protect("id", true, false)]
#[Immutable("id",false)]
#[Validator("name", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>16])]
#[Field("name", \Atomino\Carbon\Field\StringField::class)]
#[Validator("password", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>128])]
#[Field("password", \Atomino\Carbon\Field\StringField::class)]
#[Field("updated", \Atomino\Carbon\Field\DateTimeField::class)]
abstract class _User extends Entity implements \Atomino\Bundle\Attachment\AttachmentableInterface, \Atomino\Bundle\Authenticate\AuthenticableInterface, \Atomino\Bundle\Authorize\AuthorizableInterface{
	static null|Model $model = null;
	use \Atomino\Carbon\Plugins\Guid\GuidTrait;
	use \Atomino\Carbon\Plugins\Created\CreatedTrait;
	use \Atomino\Carbon\Plugins\Updated\UpdatedTrait;
	use \Atomino\Carbon\Plugins\Attachment\AttachmentableTrait;
	protected final function __getAvatar(){return $this->getAttachmentCollection("avatar");}
	use \Atomino\Carbon\Plugins\Authenticate\AuthenticableTrait;
	use \Atomino\Carbon\Plugins\Authorize\AuthorizableTrait;
	const ROLE_ADMIN = "admin";
	const ROLE_VISITOR = "visitor";
	const attachments = 'attachments';
	protected array $attachments = [];
	const created = 'created';
	protected \DateTime|null $created = null;
	protected function getCreated():\DateTime|null{ return $this->created;}
	const email = 'email';
	public string|null $email = null;
	const group = 'group';
	public string|null $group = null;
	const group__admin = 'admin';
	const group__visitor = 'visitor';
    const guid = 'guid';
	protected string|null $guid = null;
	protected function getGuid():string|null{ return $this->guid;}
	const id = 'id';
	protected int|null $id = null;
	protected function getId():int|null{ return $this->id;}
	const name = 'name';
	protected string|null $name = null;
	protected function getName():string|null{ return $this->name;}
	protected function setName(string|null $value){ $this->name = $value;}
	const password = 'password';
	protected string|null $password = null;
	protected function getPassword():string|null{ return $this->password;}
	const updated = 'updated';
	protected \DateTime|null $updated = null;
	protected function getUpdated():\DateTime|null{ return $this->updated;}
}





