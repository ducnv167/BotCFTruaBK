<template>
    <div
        style="
            align-items: flex-end;
            justify-content: space-between;
            display: flex;
            margin: 10px;
        "
    >
        <a-button type="primary" @click="prev">Previous</a-button>
        <a-button type="primary" @click="next">Next</a-button>
    </div>
</template>

<script>
export default {
    methods: {
        prev() {
            this.$emit("prev");
        },
        next() {
            this.$emit("next");
        },
    },
};
</script>
