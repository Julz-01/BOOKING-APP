import Vue from 'vue';
import vuetify from '../plugins/vuetify';
import router from '../router/router';
import store from '../store/index';
import MainSpa from '../pages/MainSpa';

new Vue({
    vuetify,
    router,
    store,
    el: "#content-container",
    components: { MainSpa }
});