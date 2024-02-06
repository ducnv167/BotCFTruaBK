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

        <!-- <a-button v-if="titleButton == 'Submit'" type="primary" @click="submit"
            >Submit</a-button
        >
        <a-button v-else type="primary" @click="next">Next</a-button> -->
        <a-button v-if="titleButton != 'Submit'" type="primary" @click="next"
            >Next</a-button
        >
    </div>
</template>

<script>
export default {
    props: {
        titleButton: String,
    },
    methods: {
        prev() {
            this.$emit("prev");
        },
        next() {
            this.$emit("next");
        },
        submit() {
            this.$emit("submitForm");
        },
    },
};
</script>
