import "./bootstrap";
import "../css/app.css";

import { createApp } from "vue";

import app from "./app.vue";
import router from "./router";

const vue = createApp(app);

vue.use(router);
vue.mount("#app");
