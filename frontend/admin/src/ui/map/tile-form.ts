import Form, {button, buttons, form} from "gold-admin/form/form";

import FaIcon from "gold-admin/fa-icon";
import controls from "gold-admin/form-input/controls";
import CustomStringControl from "../../controls/custom-string/control";
import type Entity from "gold-admin/entity-type";
import attachmentButton from "gold-admin/form-attachment/form-button";
import AttachmentApi from "gold-admin/form-attachment/attachment-api";

@form(
    FaIcon.s("layer-group"),
    "/api/tile/item",
    (item, id) => id === null ? "new tile" : item.name
)
@button(buttons.save)
@button(buttons.delete)
@button(buttons.reload)
@button(attachmentButton(new AttachmentApi("/api/tile/attachment"), {"tile": "Tile"}))
export default class TileForm extends Form {
    build(item: Entity, options: any) {
        this.addSection("Tile properties", FaIcon.s("layer-group"))
            .addControl(new CustomStringControl("name", "name"))
            .addControl(controls.select("layer",).setOptions(options.groups))
            .addControl(controls.switch("walkable", "Walkable"))
    }
}