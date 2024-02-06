import './bootstrap';
// import { Button, message } from 'ant-design-vue';
import { createRouter, createWebHistory } from 'vue-router';

import { createApp } from 'vue';
import App from './App.vue';
// import { Steps, Step, Form, Input, Select, Button, List } from "ant-design-vue";
import Antd from 'ant-design-vue';

import 'ant-design-vue/dist/reset.css';

const app = createApp(App);
// app.component(Step, Steps, Form, Input, Select, Button, List);
app.use(Antd);


app.mount("#app");

