<?php namespace Application\Missions\Web\Api;

use Application\Entity\Log;
use Atomino\Mercury\Responder\Api\Api;
use Atomino\Mercury\Responder\Api\Attributes\Route;



class LogApi extends Api
{
    #[Route("POST", '/create/:name([a-zA-Z0-9- ]+)/:type([a-zA-Z]+)')]
    public function get($name, $type)
    {
        $log = Log::create();
        $log -> name = $name;
        $log -> type = $type;
        $log -> save();
    }
}