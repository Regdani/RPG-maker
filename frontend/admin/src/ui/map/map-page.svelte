<script lang="ts">
	import Grid from "./grid.svelte";
    import MapModal, {getModal} from "./map-modal.svelte";
    import options from "gold-admin/form-attachment/options";

    let griComponent:any;

    let id:number;

    //floor & object
    let name:string;
    let tile:string;
    let layer:string;
    let walkable:boolean;

    //poi
    let title:string;
    let body:string;
    let type:string;
    let youtube:string;
    let image:string;
    let poiX:number;
    let poiY:number;
    let poiLevel:number;
    let poiBuilding:string;

    //map
    let map:any;
    let level:number;
    let building:string;

    let grid:Array<number> = [25, 15];

    let floorButton:any;
    let floorI:any;
    let floorClear:boolean = false;

    let objectButton:any;
    let objectI:any;
    let objectClear:boolean = false;

    let poiI:any;
    let poiClear:boolean = false;

    let color:string;
    let selected:string = '';
    let mapName:string;

    let data:object = {tile:{floor:"", object:""}, poi: { media:"", teleport:""}, map:""}

    let item:any;

    async function doPost() {
        data = await fetch("/api/tile-modal/get",{
            method: 'POST'})
            .then(res => res.json());
    }


    async function saveMap() {
        mapName = "";
         item  = await fetch(`/api/map/item/blank`,{
             method: 'POST'})
             .then(res => res.json());
    }

    function tileClick(gridTile, gridName, gridWalkable, gridId, gridLayer){
        if (gridLayer == 'floor' ) {
            clear();
            floorButton.style = `background: url(${gridTile}); background-size: 55px 50px;  background-repeat: no-repeat;`;
            floorI.style= "opacity: 0;";
        }
        if (gridLayer == 'object') {
            clear();
            objectButton.style = `background: url(${gridTile});  background-size: 55px 50px;  background-repeat: no-repeat;`;
            objectI.style= "opacity: 0;";
        }

        getModal(gridLayer).close();

        name = gridName;
        id = gridId;
        tile = gridTile;
        layer = gridLayer;
        walkable = gridWalkable;
    }

    function poiClick(poiId, poiTitle, poiBody, poiType, poiYoutube, poiImage, x, y, levelValue, buildingValue){
        clear();
        title = poiTitle;
        id = poiId;
        body = poiBody;
        image = poiImage;
        type = poiType;
        youtube = poiYoutube;
        poiX = x;
        poiY = y;
        poiLevel = levelValue;
        poiBuilding = buildingValue;
        layer = "";
        poiI.style = `color:${color}`;
        getModal("poi").close();
    }

    function clearClick(modalId){
        if (modalId == 'floor'){
            clear();
            floorI.className= options.collection.full.icon;
            floorClear = true;
        }
        if (modalId == 'object'){
            clear();
            objectI.className= options.collection.full.icon;
            objectClear = true;
        }
        if (modalId == 'poi'){
            clear();
            poiI.className= options.collection.full.icon;
            poiClear = true;
        }
        getModal(modalId).close();
    }

    function mapClick(maps){
        clear();
        map = maps;
        getModal("map").close();
        grid[1] = map.floors.length;
        grid[0] = map.floors[0].length;
    }
    function mapDeleteClick(ids){
        clear();
        id = ids;
    }

    function setColor(){
        switch(selected) {
            case 'media':
                color = "orange";
                break;
            case 'teleport':
                color = "brown";
                break;
        }
    }

    function clear(){
        objectButton.style = "";
        objectI.className="fas fa-couch";
        objectI.style= "opacity: 1;";
        floorButton.style = "";
        floorI.className="fas fa-layer-group";
        floorI.style= "opacity: 1;";
        poiI.style = "color:white";
        poiI.className="fas fa-map-marker-alt";
        type = "";
        layer = "";
        floorClear = false;
        objectClear = false;
        poiClear = false;
    }

</script>

<div class="box">
    <div class="toolbar">
        <button bind:this={floorButton} on:click={() => getModal("floor").open()} on:click={() =>doPost()}><i bind:this={floorI} class="fas fa-layer-group"></i></button>
        <button bind:this={objectButton} on:click={() => getModal("object").open()} on:click={() =>doPost()}><i bind:this={objectI} class="fas fa-couch"></i></button>
        <button on:click={() => getModal("poi").open()}  on:click={() =>doPost()} ><i bind:this={poiI} class="fas fa-map-marker-alt"></i></button>
        <button on:click={() => getModal("map").open()} on:click={() =>doPost()}><i class="fas fa-map"></i></button>
        <button on:click={() => getModal("settings").open()}><i class="fas fa-cog"></i></button>
        <button on:click={() => getModal("save").open() } on:click={()=>saveMap()}><i class="fas fa-save"></i></button>
    </div>

    <div>
	    <Grid {grid}
              {name}
              {id}
              {tile}
              {layer}
              {walkable}
              {title}
              {body}
              {type}
              {color}
              {youtube}
              {image}
              {poiX}
              {poiY}
              {poiLevel}
              {poiBuilding}
              {floorClear}
              {objectClear}
              {poiClear}
              {item}
              {mapName}
              {map}
              {level}
              {building}
              bind:this={griComponent}
        />
    </div>
    <MapModal  id="floor" title="Floors">
            {#each data.tile['floor'] as value}
                {#if value.tile != null}
                    <div class="content m-3">
                        <img src="{value.tile}" alt="{value.name}" on:click={() => tileClick(value.tile, value.name, value.walkable, value.id, value.layer)}>
                        <p class="has-text-centered is-size-6">{value.name}</p>
                    </div>
                {/if}
            {/each}
            <div class="content m-3 has-text-centered">
                <div class="content-icon" on:click={() => clearClick('floor')}>
                    <i class=" is-size-1 has-text-white {options.collection.full.icon}" ></i>
                </div>
                <p class="p-1 content is-size-6">delete</p>
            </div>
    </MapModal>
    <MapModal id="object" title="Objects">
        {#each data.tile['object']as value}
            {#if value.tile != null}
                <div class="content m-3">
                    <img src="{value.tile}" alt="{value.name}" on:click={() => tileClick(value.tile, value.name, value.walkable, value.id, value.layer)}>
                    <p class="has-text-centered is-size-6">{value.name}</p>
                </div>
            {/if}
        {/each}
        <div class="content m-3 has-text-centered">
            <div class="content-icon" on:click={() => clearClick('object')}>
                <i class=" is-size-1 has-text-white {options.collection.full.icon}" ></i>
            </div>
            <p class="p-1 content is-size-6">delete</p>
        </div>
    </MapModal>
    <MapModal id="poi" title="POIs">
        <div class="select is-size-7 is-fullwidth">
            <select bind:value={selected} on:change={()=>setColor()}>
                {#each Object.getOwnPropertyNames(data.poi) as option}
                    <option value={option}>
                        {option}
                    </option>
                {/each}
            </select>
        </div>
        {#if selected != ''}
            {#each data.poi[selected] as value}
                <div class="content m-3 has-text-centered" on:click={() => poiClick(value.id,value.title,value.body,value.type, value.youtube, value.image, value.x, value.y, value.level, value.building)}>
                    <div class="content-icon">
                        <i class="fa fa-map-marker-alt" style="font-size:30px; color:{color};" ></i>
                    </div>
                    <p class=" is-size-6">{value.title}</p>
                </div>
            {/each}
            <div class="content m-3 has-text-centered">
                <div class="content-icon" on:click={() => clearClick('poi')}>
                    <i class=" is-size-1 has-text-white {options.collection.full.icon}" ></i>
                </div>
                <p class="p-1 content is-size-6">delete</p>
            </div>
        {/if}
    </MapModal>
    <MapModal id="map" title="Maps">
        {#each data.map as value}
            <div>
                <div class="content m-3 has-text-centered"  on:click={() => mapClick(value.map)}    on:click={() =>griComponent.loadMap()}>
                    <div class="content-icon">
                        <i class="fas fa-map" style="font-size:30px; " ></i>
                    </div>
                    <p class=" is-size-6">{value.name}</p>
                </div>
                <p class="delete-content m-3 has-text-centered is-size-6" on:click={() => mapDeleteClick(value.id)} on:click={() =>griComponent.deleteItem()}><i class="fas fa-trash"></i></p>
            </div>
        {/each}
    </MapModal>
    <MapModal id="settings" title="Settings">
        <div class="py-3 px-6">
            <label >Rows</label><br>
            <input bind:value={grid[1]} class="input is-small" type="number"/>
        </div>
        <div class="py-3 px-6">
            <label >Columns</label><br>
            <input bind:value={grid[0]} class="input is-small" type="number" />
        </div>
    </MapModal>
    <MapModal id="save" title="Save">
        <div class="confirm ">
            <div class="has-text-centered is-size-5 m-3">
                <p>Would you like to save your progress?</p>
            </div>
            <div class="m-3">
                <label class="has-text-left">Map name</label>
                <input bind:value={mapName} class="input is-small mb-3" type="text"/>
                <label class="has-text-left">Level</label>
                <input bind:value={level} class="input is-small mb-3" type="number"/>
                <label class="has-text-left">building</label>
                <input bind:value={building} class="input is-small mb-3" type="text"/>
            </div>
            <div class="has-text-centered is-justify-content-center p-2">
                <button class="button is-normal is-success mr-3" on:click={griComponent.saveAll()}>Save</button>
                <button class="button is-normal is-danger " on:click={()=>getModal("save").close()}>Cancel</button>
            </div>
        </div>
    </MapModal>
</div>

<style>
    .confirm{
        width: 100%;
        height: 100%;
    }

    .box{
        position:relative
    }

    .content-icon{
        height: 100px;
        width: 100px;
        text-align: center;
        line-height: 120px;

    }

    .toolbar {
        float:left;
        border-radius: 4px;
        background-color:#828282;
    }

    .toolbar button {
        display: block;
        padding: 10px;
        width: 55px;
        border: none;
        border-radius: 4px;
        text-align: center;
        font-size: 22px;
        color: white;
        background-color:#828282;
    }

    .toolbar button:hover {
        background-color: #3850b7;
        cursor: pointer;
    }

    .content:hover{
        background-color: #3850b7;
        color: black;
        cursor: pointer;
    }

    .delete-content:hover{
        background-color: darkred;
        color: black;
        cursor: pointer;
    }

</style>