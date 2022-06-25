import List, {button, buttons,  list} from "gold-admin/list/list";
import FaIcon from "gold-admin/fa-icon";
import PoiForm from "src/ui/map/poi-form";
import type Entity from "gold-admin/entity-type";

@list(
    "POIs",
    FaIcon.s("fa-map-marker-alt"),
    "/api/poi/list",
    PoiForm
)
@button(buttons.new)

export default class PoiList extends List {
    cardifyItem(item: Entity): Entity {
        return {
            click: () => this.open(item.id),
            icon: item.type === "media" ? [FaIcon.s("fa-map-marker-alt").prop("color", "orange")] : [FaIcon.s("fa-map-marker-alt").prop("color", "brown")],
            id: item.id,
            title: item.title,
            active: true,
            subtitle: item.type,
        }
    }
}