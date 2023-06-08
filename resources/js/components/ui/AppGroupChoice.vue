<template>
    <div class="form-checkbox">
        <label>{{ label }}</label>
        <slot />

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
        errors: { type: Array, default: [] },
    },
};
</script>

<style></style>
