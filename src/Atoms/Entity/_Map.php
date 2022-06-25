<?php namespace Application\Atoms\Entity;

use Atomino\Carbon\Database\Finder\Filter;
use Atomino\Carbon\Attributes\Field;
use Atomino\Carbon\Attributes\Immutable;
use Atomino\Carbon\Attributes\Protect;
use Atomino\Carbon\Attributes\Validator;
use Atomino\Carbon\Entity;
use Atomino\Carbon\Model;
use Atomino\Carbon\Attributes\RequiredField;
use Symfony\Component\Validator\Constraints\Json;


/**
 * @method static \Atomino\Carbon\Database\Finder\Comparison created($isin = null)
 * @property-read \DateTime|null $created
 * @method static \Atomino\Carbon\Database\Finder\Comparison id($isin = null)
 * @property-read int|null $id
 * @method static \Atomino\Carbon\Database\Finder\Comparison map($isin = null)
 * @property-read json|null $map
 * @method static \Atomino\Carbon\Database\Finder\Comparison name($isin = null)
 * @property string|null $name
 * @method static \Atomino\Carbon\Database\Finder\Comparison building($isin = null)
 * @property string|null $building
 * @method static \Atomino\Carbon\Database\Finder\Comparison level($isin = null)
 * @property int|null $level
 * @method static \Atomino\Carbon\Database\Finder\Comparison updated($isin = null)
 * @property-read \DateTime|null $updated
 * @method static \Application\Atoms\EntityHelper\_Map_FINDER search( Filter $filter = null )
 */
#[Immutable("created", true)]
#[Protect("created", true, false)]
#[RequiredField("created", \Atomino\Carbon\Field\DateTimeField::class)]
#[Protect("updated", true, false)]
#[RequiredField("updated", \Atomino\Carbon\Field\DateTimeField::class)]
#[Field("created", \Atomino\Carbon\Field\DateTimeField::class)]
#[RequiredField('id', \Atomino\Carbon\Field\IntField::class)]
#[Field("id", \Atomino\Carbon\Field\IntField::class)]
#[Protect("id", true, false)]
#[Immutable("id",false)]
#[Field("building", \Atomino\Carbon\Field\StringField::class)]
#[Validator("building", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>255])]
#[Field("level", \Atomino\Carbon\Field\IntField::class)]
#[Validator("name", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>16])]
#[Field("name", \Atomino\Carbon\Field\StringField::class)]
#[Field("map", \Atomino\Carbon\Field\JsonField::class)]
#[Field("updated", \Atomino\Carbon\Field\DateTimeField::class)]
abstract class _Map extends Entity  {
    static null|Model $model = null;
    use \Atomino\Carbon\Plugins\Created\CreatedTrait;
    use \Atomino\Carbon\Plugins\Updated\UpdatedTrait;
    const id = 'id';
    protected int|null $id = null;
    protected function getId():int|null{ return $this->id;}
    const created = 'created';
    protected \DateTime|null $created = null;
    protected function getCreated():\DateTime|null{ return $this->created;}
    const name = 'name';
    protected string|null $name = null;
    const building = 'building';
    protected string|null $building= null;
    const level = 'level';
    protected int|null $level= null;
    const map = 'map';
    protected array  $map = [];
    protected function getName():string|null{ return $this->name;}
    protected function setName(string|null $value){ $this->name = $value;}
    const updated = 'updated';
    protected \DateTime|null $updated = null;
    protected function getUpdated():\DateTime|null{ return $this->updated;}
}






