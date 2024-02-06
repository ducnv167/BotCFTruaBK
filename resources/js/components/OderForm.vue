<template>
    <div style="max-width: 600px; margin: auto; padding: 20px">
        <a-steps :current="currentStep">
            <a-step
                v-for="(step, index) in steps"
                :key="index"
                :title="step.title"
            ></a-step>
        </a-steps>

        <div style="margin-top: 32px">
            <div
                v-if="currentStep === 0"
                style="display: flex; flex-direction: column"
            >
                <div>
                    <div>
                        <h2 style="margin-top: 10px">Please select a meal</h2>
                        <a-space>
                            <a-select
                                ref="select"
                                v-model:value="formData.meal"
                                style="width: 120px"
                                :options="meals"
                                :status="hadleMeal"
                            ></a-select>
                            <span v-if="hadleMeal == `error`" style="color: red"
                                >Please select a meal
                            </span>
                        </a-space>
                    </div>

                    <div>
                        <h2 style="margin-top: 10px">
                            Please enter number of people
                        </h2>
                        <a-space>
                            <a-input-number
                                v-model:value="formData.numberOfPeople"
                                :min="1"
                                :max="10"
                                :status="hadlePeople"
                            />
                            <span
                                v-if="hadlePeople == `error`"
                                style="color: red"
                                >Please enter number of people</span
                            >
                        </a-space>
                    </div>
                </div>
                <div style="display: flex; justify-content: flex-end">
                    <a-button
                        type="primary"
                        @click="
                            nextStep();
                            setDataRestaurant();
                        "
                        >Next</a-button
                    >
                </div>
            </div>

            <div
                v-if="currentStep === 1"
                style="
                    display: flex;
                    flex-direction: column;
                    justify-content: space-between;
                "
            >
                <div>
                    <h2 style="margin-top: 10px">Please select a restaurant</h2>
                    <a-space>
                        <a-select
                            ref="select"
                            v-model:value="formData.restaurant"
                            style="min-width: 120px"
                            :options="restaurants"
                            :status="handleRestaurant"
                        ></a-select>
                        <span
                            v-if="handleRestaurant == `error`"
                            style="color: red"
                            >Please select a restaurant
                        </span>
                    </a-space>
                </div>
                <ButtonStep
                    @prev="prevStep"
                    @next="nextStep"
                    @click="setDataDish()"
                />
            </div>

            <div
                v-if="currentStep === 2"
                style="
                    display: flex;
                    flex-direction: column;
                    justify-content: space-between;
                "
            >
                <Step3
                    :dishes="dishes"
                    :orders="formData.orders"
                    @update-orders="updateOrders"
                    @update-dish="updateDish"
                />
                <span v-if="handleNo == `error`" style="color: red"
                    >The total number of dishes should be greater
                </span>

                <ButtonStep @prev="prevStep" @next="nextStep" />
            </div>

            <div
                v-if="currentStep === 3"
                style="
                    display: flex;
                    flex-direction: column;
                    justify-content: space-between;
                "
            >
                <Step4 :formData="formData" />
                <ButtonStep @prev="prevStep" @next="nextStep" />
            </div>
        </div>
    </div>
    <a-button @click="handleSubmit">debugg</a-button>
</template>

<script>
import ButtonStep from "./ButtonStep.vue";
import Step3 from "./Step3.vue";
import Step4 from "./Step4.vue";
import dishes from "../data/dishes.json";
export default {
    components: {
        ButtonStep,
        Step3,
        Step4,
    },
    data() {
        return {
            currentStep: 0,
            hadlePeople: "",
            hadleMeal: "",
            handleRestaurant: "",
            handleNo: "",
            // form: this.$refs.form,
            formData: {
                meal: "",
                numberOfPeople: 0,
                restaurant: "",
                orders: [],
            },
            steps: [
                { title: "Step 1" },
                { title: "Step 2" },
                { title: "Step 3" },
                { title: "Review" },
            ],
            meals: [
                { value: "breakfast", label: "breakfast" },
                { value: "lunch", label: "lunch" },
                { value: "dinner", label: "dinner" },
            ],
            restaurants: [],
            dishes: [],
        };
    },
    methods: {
        handleSubmit() {
            console.log(this.formData.numberOfPeople);
            console.log(this.formData.meal);
            console.log(this.dishes);
            console.log(this.formData);
        },
        updateDish(updateDish) {
            // const _updateDish = updateDish.map((dish) => {
            //     return { value: dish.value, label: dish.label };
            // });

            // console.log(_updateDish);

            this.dishes = updateDish;
        },
        updateOrders(updatedOrders) {
            this.formData.orders = updatedOrders;
        },

        setDataDish() {
            const _dishes = dishes.dishes.filter((dish) => {
                return dish.restaurant === this.formData.restaurant;
            });
            const outputData = _dishes.map((dish) => ({
                label: dish.name,
                value: dish.id,
            }));

            this.dishes = outputData;
        },
        setDataRestaurant() {
            const uniqueRestaurants = [
                ...new Set(
                    dishes.dishes.map((dish) => {
                        if (dish.availableMeals.includes(this.formData.meal)) {
                            return dish.restaurant;
                        }
                    })
                ),
            ];

            let outputData = uniqueRestaurants.map((restaurant, index) => {
                if (typeof restaurant != "undefined") {
                    return {
                        label: restaurant,
                        value: restaurant,
                    };
                }
            });
            outputData = outputData.filter((element) => element !== undefined);
            this.restaurants = outputData;
        },
        nextStep() {
            if (this.formData.meal == "") {
                this.hadleMeal = "error";
                return;
            }
            this.hadleMeal = "";

            if (this.formData.numberOfPeople < 1) {
                this.hadlePeople = "error";
                return;
            }
            this.hadlePeople = "";

            if (this.formData.restaurant == "" && this.currentStep == 1) {
                this.handleRestaurant = "error";
                return;
            }
            this.handleRestaurant = "";

            if (this.currentStep == 2) {
                const sumNo = this.formData.orders.reduce(
                    (acc, currentValue) => acc + currentValue.no,
                    0
                );

                if (sumNo < this.formData.numberOfPeople) {
                    this.handleNo = "error";
                    return;
                }
            }
            this.handleNo = "";

            this.currentStep += 1;
        },
        prevStep() {
            this.currentStep -= 1;
        },
    },
};
</script>

<style>
/* Add your custom styles here */
</style>
