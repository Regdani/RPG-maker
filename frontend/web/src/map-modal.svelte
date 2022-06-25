<script lang="ts">
    const modals = {};

    export function getModal(id = "") {
        return modals[id];
    }

    import { onDestroy } from "svelte";

    let visible = false;

    export let id = "";
    export let title = "";

    function keyPress(ev) {
        if (ev.key == "Escape") close(); //ESC
    }

    function open() {
        window.addEventListener("keydown", keyPress);
        visible = true;
    }

    function close() {
        if (!visible) return;
        window.removeEventListener("keydown", keyPress);
        visible = false;
    }

    modals[id] = { open, close };

    onDestroy(() => {
        delete modals[id];
        window.removeEventListener("keydown", keyPress);
    });
</script>

<div id="topModal" class:visible on:click={() => close()}>
    <div class="modal-card">
        <header class="modal-card-head p-3 px-4">
            <p class="modal-card-title is-size-6 has-text-weight-bold">{title}</p>
        </header>
        <section class="modal-card-body has-background-black-bis m-0 p-2" on:click|stopPropagation={() => {}}>
            <div class="content is-flex is-flex-wrap-wrap">
                <slot />
            </div>
        </section>
    </div>
</div>

<style>
    #topModal {
        visibility: hidden;
        z-index: 9999;
        position:absolute;
        top:0;
        left:0;
        width:100%;
        height:100%;
        background: #4448;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .visible {
        visibility: visible !important;
    }
</style>
