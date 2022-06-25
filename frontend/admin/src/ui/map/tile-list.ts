import List, {button, buttons,  list} from "gold-admin/list/list";
import FaIcon from "gold-admin/fa-icon";
import TileForm from "src/ui/map/tile-form";
import type Entity from "gold-admin/entity-type";

@list(
    "Tiles",
    FaIcon.s("layer-group"),
    "/api/tile/list",
    TileForm
)
@button(buttons.new)

export default class TileList extends List {
    cardifyItem(item: Entity): Entity {
        return {
            click: () => this.open(item.id),
            id: item.id,
            title: item.name,
            active: true,
            avatar: item.tile,
            subtitle: item.layer,
        }
    }
}