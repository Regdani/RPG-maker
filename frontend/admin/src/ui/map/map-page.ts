import FaIcon from "gold-admin/fa-icon";
import AbstractPage from "gold-admin/app/abstract-page";
import type {SvelteComponent} from "svelte";
import MapComponent from "./map-page.svelte";
import {writable} from "svelte/store";
import type {Writable} from "svelte/store";

export default class MapPage extends AbstractPage {
    public closeable: boolean = true;
    get $title(): Writable<string> {return writable('Map');}
    get $icon(): Writable<FaIcon> {return writable(FaIcon.s('map'));}
    get component(): typeof SvelteComponent { return MapComponent; }
}
