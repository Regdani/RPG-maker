import Form, {button, buttons, form} from "gold-admin/form/form";
import FaIcon from "gold-admin/fa-icon";
import controls from "gold-admin/form-input/controls";
import numberControl from "../form/contolrs"
import CustomStringControl from "../../controls/custom-string/control";
import type Entity from "gold-admin/entity-type";
import {get} from "svelte/store";
import toast from "gold-admin/toast";
import AttachmentModal from "gold-admin/form-attachment/components/attachment-modal.svelte";
import AttachmentApi from "gold-admin/form-attachment/attachment-api";
import FormButton from "gold-admin/form/form-button";
import {Modal} from "gold-admin/app/modal-manager";

@form(
    FaIcon.s("fa-map-marker-alt"),
    "/api/poi/item",
    (item, id) => id === null ? "new poi" : item.title
)
@button(buttons.save)
@button(buttons.delete)
@button(buttons.reload)
export default class PoiForm extends Form {
    public imageBtn: boolean = true;
        build(item: Entity, options: any) {
            this.addSection("Poi properties", FaIcon.s("fa-map-marker-alt"))
                .addControl(new CustomStringControl("title", "title"))
                .addControl(controls.select("type",).setOptions(options.groups));

            switch(item.type) {
                case "media": {
                    this.addSection("Media properties")
                        .addControl(controls.string("youtube", "youtube link"))
                        .addControl(controls.text("body", "body"));
                    if (this.imageBtn) {
                        this.addButton(new FormButton(
                            FaIcon.s("folder-open"),
                            () => (new Modal(AttachmentModal, {
                                visibleCollections: {"images": "Images"},
                                api: new AttachmentApi("/api/poi/attachment"),
                                id: item.id
                            })).open(),
                            true
                        ));
                        this.imageBtn = false;
                    }
                    break;
                }
                case "teleport": {
                    this.addSection("Teleport location")
                        .addControl(numberControl.number("x", "x"))
                        .addControl(numberControl.number("y", "y"))
                        .addControl(numberControl.number("level", "level"))
                        .addControl(controls.string("building", "building"));
                    break;
                }
            }
        };

    async saveItem(): Promise<any> {
        this.page!.loading = true;
        let item = get(this.$item);
        try {
            if(item.youtube != null){
                let linkId = item.youtube.split("=", 2)
                item.youtube = linkId[1];
            }
            let id = await (this.id === null ? this.api!.create(item) : this.api!.update(this.id, item));
            if (typeof id === "number") this.id = id;
            toast.success("Item saved");
            this.reloadList();
        } catch (e: any) {
            if (e.code === 422) this.errors = e.messages;
        }
            this.page!.loading = false;
            return this.loadItem();
    }
}