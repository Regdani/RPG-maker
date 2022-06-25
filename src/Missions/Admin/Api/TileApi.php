<?php

namespace Application\Missions\Admin\Api;

use Application\Entity\Tile;
use Atomino\Carbon\Database\Finder\Filter;
use Atomino\Carbon\Entity;
use Atomino\Gold\Gold;
use Atomino\Gold\Goldify;
use Atomino\Gold\ItemApi;
use Atomino\Gold\ListApi;
use Atomino\Gold\ListSorting;
use Atomino\Gold\ListView;



#[Goldify(Tile::class)]
class TileApi extends Gold
{
    protected function listApi(): ListApi {
        return new class($this, 50, true) extends ListApi {

           public function views(): array {
                return [
                    new ListView("All", fn() => null),
                    new ListView("Floor", fn() => Filter::where(Tile::layer(Tile::layer__floor))),
                    new ListView("Object", fn() => Filter::where(Tile::layer(Tile::layer__object)))
                ];
            }

            public function sortings(): array {
                return [
                    new ListSorting("name", fn($asc) => $asc ? [[Tile::name, "asc"]] : [[Tile::name, "desc"]]),
                ];
            }

            public function export(Entity|Tile $item): array {
                $data = parent::export($item);
                $data['tile'] = $item->tile->first?->image->crop(64, 64)->png;
                return $data;
            }

            public function quickSearchFilter(string $search): Filter {
                return Filter::where(Tile::name()->instring($search))
                    ->or(Tile::id($search));
            }
        };
    }

    protected function itemApi(): ItemApi {
        return new class($this) extends ItemApi {

            protected function options(Entity|null $item): array|null {
                return ["groups" => Tile::model()->getField(Tile::layer)->getOptions()];
            }

            protected function export(Entity|Tile $item): array {
                $data = parent::export($item);
                $data['tile'] = $item->tile->first?->image->crop(64, 64)->png;
                return $data;
            }
        };
    }







}