import * as PK from "../playkit/playkit";

export enum LAYER {
    FLOOR = "floor",
    OBJECT = "object",
    POI = "poi",
    CHARACTER = "character",
}
export class Board extends PK.Board<Cell, Tile> {
    get layers(): Array<string> {
        return [LAYER.FLOOR, LAYER.OBJECT, LAYER.CHARACTER, LAYER.POI];
    }
    protected createBlankCell(position: PK.Position): Cell {
        return new Cell(this, position);
    }
}

export abstract class Tile extends PK.Tile<Board, Cell> {}

export class Cell extends PK.Cell<Board, Tile> {
    get objectWalkable(): boolean {
        return this.object === null ? true : this.object.walkable;
    }

    get floorWalkable(): boolean {
        return this.floor === null ? true : this.floor.walkable;
    }
    get character(): ObjectTile | null {
        return this.layers[LAYER.CHARACTER] as ObjectTile;
    }
    get object(): ObjectTile | null {
        return this.layers[LAYER.OBJECT] as ObjectTile;
    }
    get floor(): FloorTile | null {
        return this.layers[LAYER.FLOOR] as FloorTile;
    }
    get poi(): PoiTile | null {
        return this.layers[LAYER.POI] as PoiTile;
    }
}

export abstract class FloorTile extends Tile {
    get layer(): string {
        return LAYER.FLOOR;
    }

    get walkable(): boolean {
        return this.walkable;
    }
}
export abstract class ObjectTile extends Tile {
    get layer(): string {
        return LAYER.OBJECT;
    }

    get walkable(): boolean {
        return this.walkable;
    }
}

export abstract class PoiTile extends Tile {
    get layer(): string {
        return LAYER.POI;
    }

}
export abstract class CharacterTile extends Tile {
    get layer(): string {
        return LAYER.CHARACTER;
    }

    public step(direction: PK.DIRECTION): boolean {
        const target = this.position.step(direction);
        if (!this.board?.isValidPosition(target)) return false;
        if (
            !this.cell.board.at(target).objectWalkable||
            !this.cell.board.at(target).floorWalkable
        )
            return false;

        this.cell = this.cell.board.at(target);
        return true;
    }
}
