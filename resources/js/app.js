require("./bootstrap");

import axios from "axios";
import Vue from "vue";
import Login from "./components/auth/Login.vue";
import Dashboard from "./components/agent/dashboard/Dashboard.vue";
import Navbar from "./components/agent/Navbar.vue";

window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
axios.defaults.headers.common["X-CSRF-TOKEN"] = document
    .querySelector('meta[name="csrf-token"]')
    ?.getAttribute("content");

new Vue({
    el: "#app",
    components: {
        Login,
        Dashboard,
        Navbar,
    },
});
