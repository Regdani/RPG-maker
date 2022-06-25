import App from "./app.svelte"
import {Board, CharacterTile, LAYER} from "./model/model";
import MapLoader from "./map-loader";
import Form from "../../admin/node_modules/gold-admin/form/form";
import FormApi from "../../admin/node_modules/gold-admin/form/form-api";

let url = "";
url = window.location.href;
let data:any = { map:"", poi:"", point:"",character:""}
let width = 0;
let height = 0;
let mapName: string;


async function doPost() {

	data = await fetch(url,{
		method: 'POST'})
		.then(res => res.json());
	}

window.addEventListener('load', ()=>{
	console.log('Atomino loaded')

	doPost().then(r => {

		mapName = data.map[0].name;
		width= data.map[0].map["floors"].length;
		height = data.map[0].map["floors"][0].length;

		const pois = data.poi
		const board: Board =  new Board(height, width);
		const maploader: MapLoader = new MapLoader(board);

		maploader.load(data.map[0].map["floors"], "",null, null)
		maploader.load(data.map[0].map["objects"], "",null,null)
		maploader.load(data.map[0].map["pois"], "",null,null)
		maploader.load(data.map[0].map["players"], data.character,parseInt(data.point[0]),parseInt(data.point[1]))


		const player = board.find(
			CharacterTile,
			LAYER.CHARACTER
		)[0] as CharacterTile;

		const app = new App({
			target: document.body,
			props: {
				board,
				player,
				pois,
				mapName
			},
		});
	});
});

