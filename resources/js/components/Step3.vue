<template>
    <a-button
        class="editable-add-btn"
        @click="handleAdd"
        style="margin-bottom: 8px"
        >Add</a-button
    >
    <a-table
        bordered
        :data-source="dataSource"
        :columns="columns"
        :pagination="false"
    >
        <template #dish="{ text, record }">
            <div class="editable-cell">
                <a-select
                    :key="record.key"
                    class="editable-cell status-select"
                    v-model:value="record.dish"
                    label-in-value
                    @change="handleChangeDish(record, $event)"
                    style="min-width: 120px"
                >
                    <a-select-option
                        v-for="item in dishes"
                        :key="item.value"
                        :value="item.value"
                        >{{ item.label }}</a-select-option
                    >
                </a-select>
            </div>
        </template>

        <template #no="{ text, record }">
            <div class="editable-cell">
                <div>
                    <a-input-number
                        :min="1"
                        :max="10"
                        v-model:value="record.no"
                        @change="handleChangeNo(record, $event)"
                    />
                </div>
            </div>
        </template>

        <template #operation="{ record }">
            <a-popconfirm
                v-if="dataSource.length"
                title="Sure to delete?"
                @confirm="onDelete(record.key)"
            >
                <a>Delete</a>
            </a-popconfirm>
        </template>
    </a-table>
</template>
<script>
import { computed, defineComponent, reactive, ref } from "vue";
export default {
    emits: ["update-orders", "update-dish"],
    props: {
        dishes: Array,
        orders: Array,
    },
    data() {
        return {
            dataSource: [...this.orders],
        };
    },
    methods: {
        handleChangeNo(record, event) {
            this.dataSource.forEach((dish) => {
                if (dish.key === record.key) {
                    dish.no = event;
                }
            });
            this.emitOrdersUpdate();
        },
        emitOrdersUpdate() {
            const orders = this.dataSource.map(({ dish, no, key, name }) => ({
                dish,
                no,
                key,
                name,
            }));
            this.$emit("update-orders", orders);
        },
        onDelete(key) {
            this.dataSource = this.dataSource.filter(
                (item) => item.key !== key
            );
            this.emitOrdersUpdate();
        },
        emitDishUpdate(event) {
            // const _dishes = this.dishes.filter((dish) => {
            //     return dish.value != event.value;
            // });
            // console.log(_dishes);
            // this.$emit("update-dish", _dishes);
        },
        handleChangeDish(record, event) {
            this.dataSource.forEach((dish) => {
                if (dish.key === record.key) {
                    dish.dish = event.value;
                    dish.name = event.label[0].children;
                }
            });
            this.emitDishUpdate(event);
            this.emitOrdersUpdate();
        },
        handleAdd() {
            const count = this.dataSource.length + 1;
            const newData = {
                key: `${count}`,
                no: 1,
            };
            this.dataSource.push(newData);
        },
    },
    setup() {
        const editableData = reactive({});
        const columns = [
            {
                title: "Dish",
                dataIndex: "dish",
                width: "30%",
                slots: {
                    customRender: "dish",
                },
            },
            {
                title: "No",
                dataIndex: "no",
                slots: {
                    customRender: "no",
                },
            },
            {
                title: "",
                dataIndex: "operation",
                slots: {
                    customRender: "operation",
                },
            },
        ];
        return {
            columns,
            editableData,
        };
    },
};
</script>
<style lang="less">
.editable-cell {
    position: relative;
    .editable-cell-input-wrapper,
    .editable-cell-text-wrapper {
        padding-right: 24px;
    }

    .editable-cell-text-wrapper {
        padding: 5px 24px 5px 5px;
    }

    .editable-cell-icon,
    .editable-cell-icon-check {
        position: absolute;
        right: 0;
        width: 20px;
        cursor: pointer;
    }

    .editable-cell-icon {
        margin-top: 4px;
        display: none;
    }

    .editable-cell-icon-check {
        line-height: 28px;
    }

    .editable-cell-icon:hover,
    .editable-cell-icon-check:hover {
        color: #108ee9;
    }

    .editable-add-btn {
        margin-bottom: 8px;
    }
}
.editable-cell:hover .editable-cell-icon {
    display: inline-block;
}
</style>
