<template>
    <div class="checkbox">
        <label :for="option.value"
            ><input
                type="checkbox"
                :name="name"
                :value="option.value"
                :checked="modelValue.includes(option.value)"
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
        modelValue: { type: [Array, String] },
    },
    emits: ["update:modelValue"],
    setup({ modelValue }, { emit }) {
        const changeInput = (event) => {
            let valueInput = modelValue;
            if (modelValue.includes(event.target.value)) {
                valueInput = valueInput.filter(
                    (value) => value !== event.target.value
                );
            } else {
                valueInput.push(event.target.value);
            }
            emit("update:modelValue", valueInput);
        };
        return { changeInput };
    },
};
</script>

<style></style>
