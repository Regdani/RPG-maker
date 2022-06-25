<?php namespace Application\Missions\Admin\Api;

use Application\Entity\Map;
use Atomino\Gold\Gold;
use Atomino\Gold\Goldify;
use Atomino\Carbon\Entity;
use Atomino\Gold\ItemApi;


#[Goldify(Map::class)]
class MapApi extends Gold {
    protected function itemApi(): ItemApi {
        return new class($this) extends ItemApi {

            protected function export(Entity|Map $item): array {
                $data = parent::export($item);
                return $data;
            }

            protected function update(Entity|Map $item, array $data): int|null {
                return parent::update($item, $data);
            }
        };
    }
}
