<template>
    <div class="row">
        <h3>Meal</h3>
        <h3>{{ formData.meal }}</h3>
    </div>

    <div class="row">
        <h3>No of people</h3>
        <h3>{{ formData.numberOfPeople }}</h3>
    </div>

    <div class="row">
        <h3>Restauramt</h3>
        <h3>{{ formData.restaurant }}</h3>
    </div>

    <div class="row">
        <h3>Dishes</h3>
        <ul>
            <li v-for="dish in formData.orders">
                {{ dish.name }} - {{ dish.no }}
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        formData: Object,
    },
};
</script>

<style>
.row {
    display: flex;
    justify-content: space-between;
    margin: 20px;
}
</style>
