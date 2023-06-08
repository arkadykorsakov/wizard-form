<template>
    <div :class="['form-control', { invalid: errors.length }]">
        <label :for="name">{{ label }}</label>
        <select :id="name" :name="name" @change="changeOption">
            <option disabled selected>{{ defaultOption }}</option>
            <option
                v-for="option in options"
                :key="option.value"
                :value="option.value"
                :selected="modelValue === option.value"
            >
                {{ option.label }}
            </option>
        </select>
        <div v-if="errors.length">
            <TransitionGroup>
                <div v-for="error of errors" :key="error.$uid">
                    <div class="danger">{{ error.$message }}</div>
                </div>
            </TransitionGroup>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        label: {
            type: String,
            required: true,
        },
        name: {
            type: String,
            required: true,
        },

        defaultOption: {
            type: String,
            required: true,
        },
        options: {
            type: Array,
            default: [],
        },
        errors: { type: Array, default: [] },
        modelValue: { type: String, required: true },
    },
    emits: ["update:modelValue"],
    setup(_, { emit }) {
        const changeOption = (event) => {
            emit("update:modelValue", event.target.value);
        };
        return { changeOption };
    },
};
</script>

<style>
.v-enter-active,
.v-leave-active {
    transition: opacity 0.5s ease;
}
.v-enter-from,
.v-leave-to {
    opacity: 0;
}
</style>
