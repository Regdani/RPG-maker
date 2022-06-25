<?php

namespace Application\Missions\Admin\Api;

use Application\Entity\Map;
use Application\Entity\Poi;
use Application\Entity\Tile;
use Atomino\Carbon\Database\Finder\Filter;
use Atomino\Carbon\Entity;
use Atomino\Mercury\Responder\Api\Api;
use Atomino\Mercury\Responder\Api\Attributes\Route;

class TileModalApi extends Api
{
    public function export(Entity $item): array { return $item->export(); }

    #[Route("POST", "/get")]
    public function get(): array
    {
        $allTile = Tile::search()->collect();
        $tempTiles=[];
        $floor = [];
        $object = [];
        $allMediaPoi = Poi::search(Filter::where(Poi::type(Poi::group__media)))->collect();
        $mediaPois = [];

        for ($i = 0; $i <= count($allTile)-1; $i++) {
            $item = Tile::pick($allTile[$i]->id);
            $tempTiles[$i] = TileModalApi::export($item);
            $tempTiles[$i]['tile'] = $item->tile->first?->image->crop(100, 100)->webp;
        }


        for ($i = 0; $i <= count($tempTiles)-1; $i++) {
            if ($tempTiles[$i]["layer"] == "floor") {
                $floor[]=$tempTiles[$i];
            } else {
                $object[]=$tempTiles[$i];
            }
        }

        for ($i = 0; $i <= count($allMediaPoi)-1; $i++) {
            $poi = Poi::pick($allMediaPoi[$i]->id);
            $mediaPois[$i] = TileModalApi::export($poi);
            for ($j = 0; $j <= $poi->images->count-1; $j++){
               $poiImage[] = $poi->images->storage->getAttachment($poi->images->files[$j])?->url;
            }
            $mediaPois[$i]['image'] = $poiImage;
            $poiImage = array();
        }

        return [
            "tile" => [
                "floor" => $floor,
                "object"=>$object
            ],
            "poi" => [
                "media"=>$mediaPois,
                "teleport"=>Poi::search(Filter::where(Poi::type(Poi::group__teleport)))->collect()
            ],
            "map" => Map::search()->collect()
        ];
    }
}