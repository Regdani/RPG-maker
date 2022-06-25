<script  lang="ts">
    import FormApi from "gold-admin/form/form-api";
    import toast from "gold-admin/toast";
    import Form from "gold-admin/form/form";
    import {getModal} from "src/ui/map/map-modal.svelte";

    export let grid:Array<number> = [4, 4];

    let start:any = [];
    let end:any = [];
    let hover_end:any = []

    let clicked:boolean = false;

    let w:number;
    let h:number;
    let is_active:any;
    let col:string;
    let row:string;

    export let id:number = 0;
    export let name:string = "";
    export let tile:string = "";
    export let layer:string = "";
    export let walkable:boolean = false;

    export let title:string = "";
    export let  body:string = "";
    export let type:string = "";
    export let color:string = "";
    export let youtube:string = "";
    export let image = [];
    export let floorClear:boolean;
    export let objectClear:boolean;
    export let poiClear:boolean;
    export let poiX:number;
    export let poiY:number;
    export let poiLevel:number
    export let poiBuilding:string;

    export let item:any;

    export let mapName:string;
    export let map:any;
    export let level:number;
    export let building:string;

    let floors:any;
    let objects:any;
    let pois:any;
    let players:any

    let gridDivChild:any;
    let gridDiv:any;

    let count:number=0;

    Form.api = new FormApi('/api/map/item/');

    $: row = `repeat(${grid[1]}, 1fr)`;
    $: col = `repeat(${grid[0]}, 1fr)`;

    $: is_active = Array(grid[1]).fill(0).map(_ => Array(grid[0]).fill(false));

    $: floors = Array(grid[1]).fill(0).map(_ => Array(grid[0]).fill(null));

    $: objects = Array(grid[1]).fill(0).map(_ => Array(grid[0]).fill(null));

    $: pois = Array(grid[1]).fill(0).map(_ => Array(grid[0]).fill(null));

    $: players = Array(grid[1]).fill(0).map(_ => Array(grid[0]).fill("player"));

    function selectStart(i, j) {
        clicked = true;
        start = [i, j];
        check_active([i, j]);
    }

    function selectEnd(i, j) {
        end = [i, j];
        check_active([i, j]);
        clicked = false;

        for (let i = 0; i < is_active.length; i++) {
            for (let j = 0; j < is_active[i].length; j++) {
                let objectDiv = document.createElement('div');
                let poiDiv = document.createElement('div');
                gridDivChild =  gridDiv.children[`${i}:${j}`];

                if (is_active[i][j]) {
                    if (layer == "floor"){
                        gridDivChild.style = `
                        background-image: url(${tile});
                        background-size: ${w/grid[0]}px ${h/grid[1]}px;
                        background-repeat: no-repeat;
                        `;
                        floors[i][j]= {"id":id, "tile":tile, "layer":layer, "walkable":walkable};
                        is_active[i][j]=false;
                    }

                    if (floorClear){
                        gridDivChild.style ='';
                        floors[i][j] = null;
                        is_active[i][j]=false;
                    }

                    if (layer == "object" ){
                        if (!gridDivChild.hasChildNodes()){
                            gridDivChild.appendChild(objectDiv)
                        }
                        gridDivChild.children[0].className = "";
                        gridDivChild.children[0]["style"] = `
                        background-image: url(${tile});
                        background-size: ${w / grid[0]}px ${h / grid[1]}px;
                        background-repeat: no-repeat;
                        width: 100%;
                        height:100%;
                        `;
                        objects[i][j] = {"id":id, "tile":tile, "layer":layer, "walkable":walkable};
                        is_active[i][j] = false;
                    }

                    if (objectClear){
                        if (gridDivChild.hasChildNodes() && !gridDivChild.children[0].hasChildNodes()){
                            gridDivChild.children[0].remove();
                        }
                        if (gridDivChild.hasChildNodes() && gridDivChild.children[0].hasChildNodes()){
                            gridDivChild.children[0]["style"] ='';
                        }
                        objects[i][j]  = null;
                        is_active[i][j]=false;
                    }

                    if(type != '' && layer != "object" && layer != "floor"){
                        if (!gridDivChild.hasChildNodes()){
                            gridDivChild.appendChild(objectDiv)
                            gridDivChild.children[0].appendChild(poiDiv)
                        }
                        if (gridDivChild.hasChildNodes()){
                            gridDivChild.children[0].appendChild(poiDiv)
                        }
                        gridDivChild.children[0].children[0]["style"] = ``;
                        gridDivChild.children[0]["style"] = `width: ${w / grid[0]}px; height:${h / grid[1]}px;`
                        gridDivChild.children[0].children[0].className = "fas fa-map-marker-alt";
                        gridDivChild.children[0].children[0]["style"] = `

                         font-size: ${h / grid[1]/2.5}px;
                         color:${color};
                         width:100%;
                         height:100%;
                          text-align: center;
                        `;
                        pois[i][j] = {"id":id, "title":title, "body":body, "type":type, "youtube": youtube, "image":image, "x":poiX, "y":poiY, "level":poiLevel, "building":poiBuilding};
                        is_active[i][j] = false;
                    }

                    if (poiClear ){
                        if (gridDivChild.hasChildNodes()){
                            if (gridDivChild.children[0].hasChildNodes()){
                                gridDivChild.children[0].children[0].remove();
                            }
                        }
                        pois[i][j]  = null;
                        is_active[i][j]=false;
                    }
                }
            }
        }
    }

    function hover(i, j) {
        if (!clicked) return;
        hover_end = [i, j];
        check_active(hover_end);
    }

    function is_in_range([i, j], [i2, j2]) {
        return ((i - start[0]) * (i - i2) <= 0) &&
            ((j - start[1]) * (j - j2)<= 0)
    }

     function check_active (end) {
        is_active = is_active.map(
            (a, i) => a.map((_, j) => is_in_range([i, j], end)));
    }

   export function loadMap(){
       for (let i = 0; i < map.floors.length; i++) {
           for (let j = 0; j < map.floors[i].length; j++) {
               let objectDiv = document.createElement('div');
               let poiDiv = document.createElement('div');
               gridDivChild =  gridDiv.children[`${i}:${j}`];

               if(map.floors[i][j] != null){
                   gridDivChild.style = `
                        background-image: url(${map.floors[i][j].tile});
                        background-size: ${w/grid[0]}px ${h/grid[1]}px;
                        background-repeat: no-repeat;
                        `;
                   floors[i][j]= {"id":map.floors[i][j].id, "tile":map.floors[i][j].tile, "layer":map.floors[i][j].layer, "walkable":map.floors[i][j].walkable};
               }
               if(map.floors[i][j] == null){
                   gridDivChild.style ='';
               }

               if (map.objects[i][j] != null){
                   if (!gridDivChild.hasChildNodes()){
                       gridDivChild.appendChild(objectDiv)
                   }
                   gridDivChild.children[0].className = "";
                   gridDivChild.children[0]["style"] = `
                        background-image: url(${map.objects[i][j].tile});
                        background-size: ${w / grid[0]}px ${h / grid[1]}px;
                        background-repeat: no-repeat;
                        width: 100%;
                        height:100%;
                        `;
                   objects[i][j]= {"id":map.objects[i][j].id, "tile":map.objects[i][j].tile, "layer":map.objects[i][j].layer, "walkable":map.objects[i][j].walkable};

               }

               if (map.objects[i][j] == null && gridDivChild.hasChildNodes()){
                   gridDivChild.children[0].remove();
               }

               if(map.pois[i][j] != null){
                   map.pois[i][j].type == "teleport" ? color = "brown" : color = "orange";
                   if (!gridDivChild.hasChildNodes()){
                       gridDivChild.appendChild(objectDiv)
                       gridDivChild.children[0].appendChild(poiDiv)
                   }
                   if (gridDivChild.hasChildNodes()){
                       gridDivChild.children[0].appendChild(poiDiv)
                   }
                   gridDivChild.children[0].children[0]["style"] = "";
                   gridDivChild.children[0]["style"] = `width: ${w / grid[0]}px; height:${h / grid[1]}px;`
                   gridDivChild.children[0].children[0].className = "fas fa-map-marker-alt";
                   gridDivChild.children[0].children[0]["style"] = `
                         font-size: ${h / grid[1]/2.5}px;
                         color:${color};
                         width: 100%;
                         height:100%;
                         text-align: center;
                         line-height: ${h / grid[1]}px;
                        `;
                   pois[i][j] = {"id":map.pois[i][j].id, "title":map.pois[i][j].title, "body":map.pois[i][j].body, "type":map.pois[i][j].type, "youtube": map.pois[i][j].youtube, "image":map.pois[i][j].image, "x":map.pois[i][j].x, "y":map.pois[i][j].y, "level":map.pois[i][j].level, "building":map.pois[i][j].building};
               }

               if (map.pois[i][j] == null ){
                   if (gridDivChild.hasChildNodes()){
                       if (gridDivChild.children[0].hasChildNodes()){
                           gridDivChild.children[0].children[0].remove();
                       }
                   }
               }
           }
       }
   }

    export async function saveAll(){
        let data = { map:""}

        async function doPost() {
            data = await fetch("/api/tile-modal/get",{
                method: 'POST'})
                .then(res => res.json());
        }

        await doPost();

        item.name = mapName;
        item.level = level;
        item.building = building
        item.map = {
            floors,
            objects,
            pois,
            players
        };

        if (data.map != null) {
            for (let i = 0; i < data.map.length; i++) {
                if (data.map[i]["level"] == item.level && data.map[i]["building"] == item.building) {
                    try {
                        let id = await Form.api!.update(data.map[i]["id"], item);
                        toast.success("Map updated");
                    } catch (e: any) {
                        if (e.code === 422) this.errors = e.messages;
                    }
                    getModal("save").close();
                }else{
                    count++;
                }
            }
        }else {
            try {
                let id = await Form.api!.create(item);
                toast.success("Map saved");
            }catch (e: any) {
                if (e.code === 422) this.errors = e.messages;
            }
            getModal("save").close();
        }
        if (count == data.map.length){
            try {
                let id = await Form.api!.create(item);
                toast.success("Map saved");
            }catch (e: any) {
                if (e.code === 422) this.errors = e.messages;
            }
            getModal("save").close();
        }
    }

    export async function deleteItem(){
        try {
            await Form.api!.delete(id);
            toast.success("Deleted successfully ");
        } catch (exception) {
            this.errors = exception.messages;
        }
        getModal("map").close();
        return true;
    }
</script>
<div    bind:clientWidth={w} bind:clientHeight={h}
        bind:this = {gridDiv}
        class="container"
        style="grid-template-rows: {row}; grid-template-columns: {col};"
>
        {#each { length: grid[1] } as _, i (i)}
            {#each { length: grid[0] } as _, j (j)}
                <div class:active={is_active[i][j]} id="{i}:{j}"
                     on:mouseover={() => hover(i, j)}
                     on:mousedown={() => selectStart(i, j)}
                     on:mouseup={() => selectEnd(i, j)}>

                </div>
            {/each}
        {/each}
</div>
<style>
    .container {
        display: grid;
        border: 1px solid #999;
        border-radius: 2px;
        width: 1200px;
        height: 700px;
        grid-gap: 1px;
        background: #999;
        -webkit-user-drag: none;
        user-select: none;
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
    }

    .container div {
        background: #fff;
    }

    .container div:hover {
        opacity: 0.5;
        cursor: pointer;
    }

    div.active {
        opacity: 0.5;
    }

    div.active:hover{
        background: #fff;
    }
</style>