<script lang="ts">
    export let location: string;
    export let background: string;
    export let moveDirection:string;

</script>

<div class="Player" style="background-image: url({background}); transform: scaleX({moveDirection === 'left' ? -1 : 1});">
    <slot />
</div>

<style>
    .Player {
        background-size: 100%;
        background-repeat: no-repeat;
        position: relative;
        height: 50px;
        width: 50px;
    }
</style>
