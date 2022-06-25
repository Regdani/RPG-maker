import  { Board, CharacterTile, LAYER } from "./model/model";
import { Position } from "./playkit/playkit";

export default class Camera {
    constructor(private _borad: Board) {
    }

    getView(width: number, height: number) {

        let player = this._borad.find(CharacterTile, LAYER.CHARACTER)[0]?.position;
        if (player == null) {
            return null;
        }

        //megnézzük hogy melyik a kisebb az átadott érték vagy a pálya mérete
        height = Math.min(height, this._borad.height);
        width = Math.min(width, this._borad.width);

        if (width % 2 !== 1) width--;
        if (height % 2 !== 1) height--;

        let x = player.x - (width - 1) / 2;
        let y = player.y - (height - 1) / 2;
        if (x < 0) x = 0;
        // ha az x nagyobb mint a pálya szélessége - a kamera szélessége akkor legyen a az x fixen a pálya szélessége - a kamera szélessége tehát a maximum érték ameddig eltud menni
        if (x > this._borad.width - width) x = this._borad.width - width;

        if (y < 0) y = 0;
        // ha az x nagyobb mint a pálya magassága - a kamera magassága akkor legyen a az x fixen a pálya magassága - a kamera magassága tehát a maximum érték ameddig eltud menni
        if (y > this._borad.height - height) y = this._borad.height - height;

        let viewport: any[][] = [];
        for (let i = 0; i < height; i++) {
            viewport[i] = [];
            for (let j = 0; j < width; j++) {
                viewport[i][j] = this._borad.at(new Position(j + x, i + y));
            }
        }
        return viewport;
    }
}

