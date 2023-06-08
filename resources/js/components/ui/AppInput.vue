<template>
    <div :class="['form-control', { invalid: errors.length }]">
        <label :for="name">{{ label }}</label>
        <input
            :type="type"
            :id="name"
            :name="name"
            :placeholder="label"
            :value="modelValue"
            @input="changeInput"
        />
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
        type: {
            type: String,
            required: false,
            default: "text",
        },
        modelValue: { type: String, required: true },
        errors: { type: Array, default: [] },
    },
    emits: ["update:modelValue"],
    setup(_, { emit }) {
        const changeInput = (event) => {
            console.log(event.target.value);
            emit("update:modelValue", event.target.value);
        };
        return { changeInput };
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
