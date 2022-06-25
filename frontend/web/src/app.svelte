<script lang="ts">

    import type { Board } from "./model/model";
    import type * as tiles from "./model/tiles";
    import Tile from "./tile.svelte";
    import Player from "./player.svelte";
    import Poi from "./poi.svelte";
    import Furniture from "./furniture.svelte";
    import * as PK from "./playkit/playkit";
    import Camera from "./camera";


    export let board: Board;
    export let player: tiles.Player;
    export let pois;
    export let mapName;
    let camera:Camera = new Camera(board);

    let cameraWidth:number;
    let cameraHeight:number;
    let viewPortWidth:number;
    let viewPortHeight:number;
    let outerWidth:number;
    let outerHeight:number;

    let store:any[][] | null;


    let mDown:object = { x: 0, y: 0 };
    let mUp:object = { x: 0, y: 0 };
    let moveDirection: string = "";

    let move: boolean = false;

    let xDiff: number;
    let yDiff: number;

    let item:any;
    async function doPost() {
        item  = await fetch(`/api/log/create/${mapName}/map`,{
            method: 'POST'})
            .then(res => res.json());
    }

    doPost()

    //megnézi hogy az ablak mérete osztva 50 vagy a pálya mérete a kisebb és azt elosztja 2 vel és megnézi van e maradék
    //ha van maradék akkor páratlan az oszlopok sorok száma és marad az ha páratlan -1 hoogy páratlan legyen. Így tud középen maradni a karakter ha moszog.
    $: cameraWidth =
        Math.min(Math.floor(outerWidth / 50), board.width) % 2 == 1
            ? Math.min(Math.floor(outerWidth / 50), board.width)
            : Math.min(Math.floor(outerWidth / 50), board.width) - 1;
    $: cameraHeight =
        Math.min(Math.floor(outerHeight / 50), board.height) % 2 == 1
            ? Math.min(Math.floor(outerHeight / 50), board.height)
            : Math.min(Math.floor(outerHeight / 50), board.height) - 1;

    $: viewPortWidth = cameraWidth * 50;
    $: viewPortHeight = cameraHeight * 50;

    $: outerWidth = 0;
    $: outerHeight = 0;

    //átadjuk az előbb kiszámolt cameraWidth és height számokat, hogy hány sor és oszlop fér el a kamerában.
    $: store = camera.getView(cameraWidth, cameraHeight);

    board.onChange = () => {
        let view = camera.getView(cameraWidth, cameraHeight);

        if (view != null) {
            store = view;
        }
    };

    function onMouseDown(e) {
        mDown.x = e.clientX;
        mDown.y = e.clientY;
    }

    function onMouseMove() {
        move = true;
    }

    function onMouseUp(e) {
        mUp.x = e.clientX;
        mUp.y = e.clientY;
        xDiff = mDown.x - mUp.x;
        yDiff = mDown.y - mUp.y;

        if (move) {
            if (Math.abs(xDiff) > Math.abs(yDiff)) {
                if (xDiff > 0) {
                    moveDirection = "right";
                    moving();
                }
                if (xDiff < 0) {
                    moveDirection = "left";
                    moving();
                }
            } else {
                if (yDiff > 0) {
                    moveDirection = "down";
                    moving();
                }
                if (yDiff < 0) {
                    moveDirection = "up";
                    moving();
                }
            }
        }
        move = false;
    }

    function onKeyDown(e) {
        switch (e.key) {
            case "d":
            case "ArrowRight":
                moveDirection = "right";
                moving();
                break;
            case "a":
            case "ArrowLeft":
                moveDirection = "left";
                moving();
                break;
            case "w":
            case "ArrowUp":
                moveDirection = "up";
                moving();
                break;
            case "s":
            case "ArrowDown":
                moveDirection = "down";
                moving();
                break;
        }
    }

    function moving() {
        switch (moveDirection) {
            case "right":
                player.step(PK.DIRECTION.RIGHT);
                break;
            case "left":
                player.step(PK.DIRECTION.LEFT);
                break;
            case "up":
                player.step(PK.DIRECTION.UP);
                break;
            case "down":
                player.step(PK.DIRECTION.DOWN);
        }
    }


</script>

<div
        class="camera"
        style={"width:" + viewPortWidth  + "px;height:" + viewPortHeight  + "px;"}
>
    {#each store as row}
        {#each row as column}
         <Tile tileId={column["_position"].x+":"+column["_position"].y} background={column["layers"]["floor"].images}>
             {#if column["layers"]["character"] !== null}
                 <div>
                     <div>
                         <Player location={column["_position"].x+":"+column["_position"].y} background={column["layers"]["character"].image } {moveDirection}/>
                     </div>
                 </div>
             {/if}
             {#if column["layers"]["object"] !== null}
                 <Furniture background={column["layers"]["object"].images} >
                     {#if column["layers"]["poi"] !== null}
                         <Poi title={column["layers"]["poi"].titleValue}
                              youtube={column["layers"]["poi"].youtubeValue}
                              type={column["layers"]["poi"].typeValue}
                              body={column["layers"]["poi"].bodyValue}
                              images={column["layers"]["poi"].imageValue}
                              x={column["layers"]["poi"].xValue}
                              y={column["layers"]["poi"].yValue}
                              level={column["layers"]["poi"].levelValue}
                              building={column["layers"]["poi"].buildingValue}
                              {pois}>
                         </Poi>
                     {/if}
                 </Furniture>
             {:else}
                 <div>
                     {#if column["layers"]["poi"] !== null}
                         <Poi
                                 title={column["layers"]["poi"].titleValue}
                                 youtube={column["layers"]["poi"].youtubeValue}
                                 type={column["layers"]["poi"].typeValue}
                                 body={column["layers"]["poi"].bodyValue}
                                 images={column["layers"]["poi"].imageValue}
                                 x={column["layers"]["poi"].xValue}
                                 y={column["layers"]["poi"].yValue}
                                 level={column["layers"]["poi"].levelValue}
                                 building={column["layers"]["poi"].buildingValue}
                                 {pois}
                         />
                     {/if}
                 </div>
             {/if}
        </Tile>
        {/each}
    {/each}
</div>

<svelte:window
        on:mousedown={onMouseDown}
        on:mousemove={onMouseMove}
        on:mouseup={onMouseUp}
        on:keydown={onKeyDown}
        bind:outerWidth
        bind:outerHeight
/>

<style lang="scss" global>
    @import "bulma/bulma";
    @import "bulma-prefers-dark/sass/utilities/_all";
    @import "bulma-prefers-dark/sass/base/_all";
    @import "bulma-prefers-dark/sass/elements/_all";
    @import "bulma-prefers-dark/sass/components/_all";
    @import "bulma-prefers-dark/sass/layout/_all";

    .camera {
      margin:auto;
      position:fixed;
      top:0;
      bottom:0;
      left:0;
      right:0;
    }
</style>