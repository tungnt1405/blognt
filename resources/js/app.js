import "./bootstrap";
import "../css/app.css";

import { createApp } from "vue";
import app from "./app.vue";
import router from "./router";
import vuetify from "./plugins/vuetify.js";

const vue = createApp(app);

vue.use(router);
vue.use(vuetify);
vue.mount("#app");
