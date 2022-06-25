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
 * @method static \Atomino\Carbon\Database\Finder\Comparison created($isin = null)
 * @property-read \DateTime|null $created
 * @method static \Atomino\Carbon\Database\Finder\Comparison id($isin = null)
 * @property-read int|null $id
 * @method static \Atomino\Carbon\Database\Finder\Comparison name($isin = null)
 * @property string|null $name
 * @method static \Atomino\Carbon\Database\Finder\Comparison type($isin = null)
 * @method static \Application\Atoms\EntityHelper\_Log_FINDER search( Filter $filter = null )
 */
#[RequiredField('id', \Atomino\Carbon\Field\IntField::class)]
#[Immutable("created", true)]
#[Protect("created", true, false)]
#[RequiredField("created", \Atomino\Carbon\Field\DateTimeField::class)]
#[Field("created", \Atomino\Carbon\Field\DateTimeField::class)]
#[Field("id", \Atomino\Carbon\Field\IntField::class)]
#[Protect("id", true, false)]
#[Immutable("id",false)]
#[Validator("type", \Symfony\Component\Validator\Constraints\Choice::class, ['multiple'=>false,'choices'=>['poi','map']])]
#[Field("type", \Atomino\Carbon\Field\EnumField::class, ['poi','map'])]
#[Validator("name", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>255])]
#[Field("name", \Atomino\Carbon\Field\StringField::class)]
abstract class _Log extends Entity  {
	static null|Model $model = null;
	use \Atomino\Carbon\Plugins\Created\CreatedTrait;
	const created = 'created';
	protected \DateTime|null $created = null;
    const ROLE_POI = "poi";
    const ROLE_MAP = "map";
    const type = 'type';
    public string|null $type= null;
	protected function getCreated():\DateTime|null{ return $this->created;}
	const id = 'id';
	protected int|null $id = null;
	protected function getId():int|null{ return $this->id;}
	const name = 'name';
	protected string|null $name = null;
	protected function getName():string|null{ return $this->name;}
	protected function setName(string|null $value){ $this->name = $value;}


}





