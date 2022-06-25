<?php namespace Application\Missions\Admin\Api;

use Application\Entity\Log;
use Application\Entity\Map;
use Application\Entity\Poi;
use Application\Entity\User;
use Application\Entity\Tile;
use Atomino\Mercury\Responder\Api\Api;
use Atomino\Mercury\Responder\Api\Attributes\Auth;
use Atomino\Mercury\Responder\Api\Attributes\Route;

#[Auth(User::ROLE_ADMIN)]
class DashboardApi extends Api {
	#[Route("GET", "/")]
	public function get(){
		return [
			"userCount"=>User::search()->count(),
            "tileCount"=>Tile::search()->count(),
            "poiCount"=>Poi::search()->count(),
            "mapCount"=>Map::search()->count(),
            "log" => Log::search()->collect()
		];
	}
}
