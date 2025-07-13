require("./bootstrap");

import axios from "axios";
import Vue from "vue";

window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
axios.defaults.headers.common["X-CSRF-TOKEN"] = document
    .querySelector('meta[name="csrf-token"]')
    ?.getAttribute("content");
