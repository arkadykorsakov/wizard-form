<template>
    <div :class="['alert', message.type]" v-if="message">
        <p class="alert-title">{{ title }}</p>
        <p>{{ message.value }}</p>
        <span class="alert-close" @click="close">&times;</span>
    </div>
</template>

<script>
import { computed } from "vue";
export default {
    props: ["message"],
    emits: ["close"],
    setup({ message }, { emit }) {
        const TITLE_MAP = {
            primary: "УСПЕХ",
            danger: "ОШИБКА",
            warning: "ПРЕДУПРЕЖДЕНИЕ",
        };
        const title = computed(() => TITLE_MAP[message.type]);
        const close = () => {
            emit("close");
        };

        return {
            title,
            close,
        };
    },
};
</script>

<style></style>
