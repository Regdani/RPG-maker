import NumberControl from "./number/control";

export default {
    "number": (field: string, label: string | null = null):NumberControl => new NumberControl(field, label),

}