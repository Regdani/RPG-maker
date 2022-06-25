<?php

namespace Application\Missions\Web\Api;

use Application\Entity\Map;
use Application\Entity\Poi;
use Application\Entity\User;
use Atomino\Carbon\Database\Finder\Filter;
use Atomino\Mercury\Responder\Api\Api;
use Atomino\Mercury\Responder\Api\Attributes\Route;


class MapApi extends Api
{
    #[Route("POST", "/:level([0-9]+)/:building([a-zA-Z]+)/:x([0-9]+)/:y([0-9]+)")]
    public function get( int$level, string $building,int$x, int$y){
        return [
            "map" => Map::search(Filter::where(Map::building($building))->and( Map::level($level)))->collect(),
            "poi" => [
                "media"=>Poi::search(Filter::where(Poi::type(Poi::group__media)))->collect(),
                "teleport"=>Poi::search(Filter::where(Poi::type(Poi::group__teleport)))->collect(),
            ],
            "point" => [$x,$y],
            "character" => User::search(Filter::where(User::group(User::group__visitor)))->pick()->avatar->first?->image->crop(64, 64)->webp
        ];
    }
}