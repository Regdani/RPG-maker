<script lang="ts">
    export let background: string;
</script>

<div class="tile" style="background-image: url({background});">
    <slot />
</div>


<style>
    .tile {
        background-size: 50px 50px;
        height: 50px;
        width: 50px;
        -webkit-user-drag: none;
        user-select: none;
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
    }
</style>
