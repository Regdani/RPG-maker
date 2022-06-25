<script lang="ts">
    import type Control from "./control";
    import {Input} from "svelma"
    import options from "gold-admin/form-input/options";
    import type Page from "gold-admin/form/form-page";

    export let page: Page;
    export let control: Control;
    export let item;
    export let onChange: Function;

    let input: Input;

    function onLocalChange() {
        item.update(item => {
            let val: number;
            if (control.step % 1 !== 0) {
                // float
                val = parseFloat(item[control.field]);
                if (isNaN(val)) val = 0;
                else {
                    let ten = Math.floor(1 / control.step).toString().length;
                    let mul = Math.pow(10, ten);
                    let step = mul * control.step;
                    console.log(step);
                    let d = (mul * val) % step;
                    val = (mul * val - d) / mul;
                }
            } else {
                val = parseInt(item[control.field]);
                if (isNaN(val)) val = 0;
                else {
                    let d = val % control.step;
                    val = val - d;
                }
            }

            if (control.min !== null && val < control.min) val = control.min;
            if (control.max !== null && val > control.max) val = control.max;
            item[control.field] = val;
            return item;
        });
        onChange();
    }

</script>

<div class="field has-addons">
    <div class="control is-expanded">
        <div class="is-fullwidth">
            <input bind:this={input} min={control.min} max={control.max} step={control.step} class="input is-small" type="number" bind:value={$item[control.field]} on:change={onLocalChange}>
        </div>
    </div>
    <div class="control">
        <button on:click={()=>{input.stepUp();$item[control.field] = input.value;} } class="button is-dark is-small ml-2 has-text-link" >{@html options.number.up.icon.tag }</button>
    </div>
    <div class="control">
        <button on:click={()=>{input.stepDown();$item[control.field] = input.value;}} class="button is-dark is-small ml-2 has-text-link">{@html options.number.down.icon.tag}</button>
    </div>
</div>

<style>
    	input::-webkit-outer-spin-button,
    	input::-webkit-inner-spin-button
     {
        -webkit-appearance: none;
        margin: 0;
    }
        input[type=number] {
            -moz-appearance: textfield;
        }
</style>
