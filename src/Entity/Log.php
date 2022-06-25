<?php namespace Application\Entity;

use Application\Atoms\Entity\_Log;

use Atomino\Carbon\Attributes\Modelify;
use Atomino\Carbon\Attributes\Protect;
use Atomino\Carbon\Plugins\Created\Created;


#[Modelify(\Application\Database\DefaultConnection::class, 'log', true)]
#[Protect('name', true, true)]
#[Created()]
class Log extends _Log{


}
