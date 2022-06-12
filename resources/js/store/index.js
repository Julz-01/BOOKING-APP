import Vue from 'vue';
import Vuex from 'vuex';
import tour from '../store/modules/tour';
import booking from '../store/modules/booking';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        tour,
        booking
    }
});