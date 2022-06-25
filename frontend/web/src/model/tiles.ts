import {CharacterTile, FloorTile, ObjectTile, PoiTile} from "./model";

export class Floor extends FloorTile {
    constructor(private images: string, private wal:boolean) {
        super();
    }

    get image(): string {
        return this.images;
    }
    get walkable(): boolean {
        return this.wal;
    }
}
export class Object extends ObjectTile {
    constructor(private images: string, private wal:boolean) {
        super();
    }
    get image(): string {
        return this.images;
    }

   get walkable(): boolean {
        return this.wal;
    }
}
export class Poi extends PoiTile {
    constructor(private typeValue: string, private bodyValue: string, private youtubeValue: string, private titleValue: string, private imageValue:string, private xValue:number, private yValue:number, private levelValue:number, private buildingValue:string) {
        super();
    }
    get title():string{
        return this.titleValue;
    }

    get type():string{
        return this.typeValue;
    }

    get body():string{
        return this.bodyValue;
    }

    get youtube():string{
        return this.youtubeValue;
    }

    get x():number{
        return this.xValue;
    }
    get y():number{
        return this.yValue;
    }
    get level():number{
        return this.levelValue;
    }
    get building():string{
        return this.buildingValue;
    }
}

export class Player extends CharacterTile {
    constructor(private characterImage: string, ) {
        super();
    }
    get image(): string {
        return this.characterImage;
    }
}
