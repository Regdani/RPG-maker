<?php

namespace Application\Missions\Admin\Api;


use Application\Entity\Poi;
use Atomino\Carbon\Database\Finder\Filter;
use Atomino\Carbon\Entity;
use Atomino\Gold\Gold;
use Atomino\Gold\Goldify;
use Atomino\Gold\ItemApi;
use Atomino\Gold\ListApi;
use Atomino\Gold\ListSorting;
use Atomino\Gold\ListView;


#[Goldify(Poi::class)]
class PoiApi extends Gold
{
    protected function listApi(): ListApi {
        return new class($this, 50, true) extends ListApi {
            public function views(): array {
                return [
                    new ListView("All", fn() => null),
                    new ListView("Media", fn() => Filter::where(Poi::type(Poi::group__media))),
                    new ListView("Teleport", fn() => Filter::where(Poi::type(Poi::group__teleport)))
                ];
            }

            public function sortings(): array {
                return [
                    new ListSorting("title", fn($asc) => $asc ? [[Poi::title, "asc"]] : [[Poi::title, "desc"]]),
                ];
            }

            public function export(Entity|Poi $item): array {
                $data = parent::export($item);
                $data['image'] = $item->images->first?->image->crop(64, 64)->png;
                return $data;
            }

            public function searchFilter(array $filter): Filter|null {
                return Filter::where(isset($filter['title']) && $filter['title'] ? Poi::title()->instring($filter['title']) : null);
            }

            public function quickSearchFilter(string $search): Filter {
                return Filter::where(Poi::title()->instring($search))
                    ->or(Poi::id($search))
                    ;
            }
        };
    }

    protected function itemApi(): ItemApi {
        return new class($this) extends ItemApi {

            protected function options(Entity|null $item): array|null {
                return ["groups" => Poi::model()->getField(Poi::type)->getOptions()];
            }

            protected function export(Entity|Poi $item): array {
                $data = parent::export($item);
                $data['image'] = $item->images->first?->image->crop(64, 64)->png;
                return $data;
            }
        };
    }
}