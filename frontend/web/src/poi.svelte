<script lang="ts">
    import Fa from 'svelte-fa'
    import { faMapMarkerAlt} from '@fortawesome/free-solid-svg-icons'
    import MapModal from "./map-modal.svelte";


    export let title: string;
    export let type: string;
    export let body: string;
    export let youtube: string;
    export let x:number;
    export let y:number;
    export let level:number;
    export let building:string;
    export let images: string[];
    export let pois;

    let item: string;
    let modalComponent;

    let mediaNames: string[] = [];
    let teleportNames: string[] = [];

    async function doPost() {
        item  = await fetch(`/api/log/create/${title}/poi`,{
            method: 'POST'})
            .then(res => res.json());
    }

    for (let i = 0; i < pois["media"].length; i++) {
        mediaNames.push(pois["media"][i].title)
    }

    for (let i = 0; i < pois["teleport"].length; i++) {
        teleportNames.push(pois["teleport"][i].title)
    }





</script>

<div class="poi" on:click={() => modalComponent.getModal("poi").open()} on:click = {() => doPost()}>
    <Fa icon={faMapMarkerAlt}  size="1.7x" color={type === "teleport" ? "brown" : "orange"}/>
</div>

<MapModal id="poi" title={title}   bind:this={modalComponent}>
    <div class="modal-content has-text-centered">
        {#if type === "media"}
            {#if body != null}
                <p class=" has-text is-size-6">
                    {body}
                </p>
            {/if}
            {#if youtube != null}
                <iframe
                        width="500"
                        height="350"
                        title="{title}"
                        src="https://www.youtube.com/embed/{youtube}"
                ></iframe>
            {/if}
            {#if images != null}
                {#each images as value}
                    <img src={value}  alt="{title}">
                {/each}
            {/if}
        {/if}
        {#if type === "teleport"}
            {#if x !== null && y !== null && level !== null && building !== null}
                <p>{title}</p>
                <a href="/map/{level}/{building}/{x}/{y}">
                    <button class="button is-link">Teleport</button>
                </a>
            {/if}
        {/if}
    </div>
</MapModal>

<style>
    .poi {
        cursor: pointer;
        text-align: center;
        width: 50px;
        height:50px;
        line-height: 60px;
        -webkit-user-drag: none;
        user-select: none;
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
    }

    .poi-list li:hover{
        background-color: #3850b7;
        color: black;
        cursor: pointer;
    }

    img{
        width: 300px;
        height: auto;
    }
</style>
