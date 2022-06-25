<script lang="ts">
    export let background: string;
    export let tileId: string;
</script>

<div class="tile" id={tileId} style="background-image: url({background});">
    <slot />
</div>

<style>
    .tile {
        height: 50px;
        width: 50px;
        float: left;
        -webkit-user-drag: none;
        user-select: none;
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
    }
</style>
