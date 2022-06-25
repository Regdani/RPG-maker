import type { Board, Tile } from "./model/model";
import * as PK from "./playkit/playkit";
import * as tiles from "./model/tiles";

export default class MapLoader {
    constructor(private board: Board) {}

    load(map: Array<any>, character:string | "", x:number | null, y:number | null ) {
        for (let i = 0; i < this.board.width; i++) {
            for (let j = 0; j <  this.board.height; j++) {
                let tile: Tile | null = null;
                if (map[j][i] != null) {
                    switch (map[j][i]["layer"]) {
                        case "floor":
                            tile = new tiles.Floor(map[j][i]["tile"],map[j][i]["walkable"]);
                            break;
                        case "object":
                            tile = new tiles.Object(map[j][i]["tile"], map[j][i]["walkable"]);
                            break;
                    }
                    if (map[j][i]["type"] != null){
                        tile = new tiles.Poi(map[j][i]['type'], map[j][i]["body"], map[j][i]["youtube"], map[j][i]["title"], map[j][i]["image"], map[j][i]["x"], map[j][i]["y"], map[j][i]["level"], map[j][i]["building"]);
                    }
                    if (map[j][i]=="player"){
                        if (x == i && y == j) {
                            tile = new tiles.Player(character);

                        }
                    }
                }
                if (tile !== null) {
                    tile.cell = this.board.at(PK.pos(i, j));
                }
            }
        }
    }
}
