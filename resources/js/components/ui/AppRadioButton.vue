<template>
    <div class="checkbox">
        <label :for="option.value"
            ><input
                type="radio"
                :name="name"
                :value="option.value"
                :checked="option.value === modelValue"
                :id="option.value"
                @input="changeInput"
            />
            {{ option.label }}</label
        >
    </div>
</template>

<script>
export default {
    props: {
        name: {
            type: String,
            required: true,
        },
        option: { type: Object, required: true },
        modelValue: { type: String, required: true },
    },
    emits: ["update:modelValue"],
    setup(_, { emit }) {
        const changeInput = (event) => {
            emit("update:modelValue", event.target.value);
        };
        return { changeInput };
    },
};
</script>

<style></style>
