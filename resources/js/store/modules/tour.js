import axios from 'axios';

const tour = {
    namespaced: true,
    state: {
        tours: [],
        tour: [],
        tourDates: []
    },
    getters: {},
    mutations: {
        MUTATE_TOURS(state, payload) {
            state.tours = payload;
        },

        MUTATE_TOUR(state, payload) {
            state.tour = payload;
        },

        MUTATE_TOURDATES(state, payload) {
            state.tourDates = payload;
        }
    },
    actions: {
        async findTours({ commit }) {
            const res = await axios.get('/api/tour');
            if (res.status === 200) {
                commit('MUTATE_TOURS', res.data.tours);
            }

            return res;
        },

        async store({ dispatch }, payload) {
            const res = await axios.post('/api/tour', payload);

            return res;
        },

        async findTour({ commit }, payload) {
            const res = await axios.get('/api/tour/' + payload);
            if (res.status === 200) {
                commit('MUTATE_TOUR', res.data.tour);
            }

            return res;
        },

        async updateTour({ dispatch }, payload) {
            const res = await axios.post('/api/tour/' + payload.id, payload.data);
            if (res.status === 201) {
                dispatch('findTour', payload.id);
                dispatch('findTours');
            }

            return res;
        },

        async disableTourDate({ dispatch }, payload) {
            const res = await axios.patch('/api/tour/disable/' + payload.id);
            if (res.status === 200) {
                dispatch('findTour', payload.tour_id)
            }

            return res;
        },

        async enableTourDate({ dispatch }, payload) {
            const res = await axios.patch('/api/tour/enable/' + payload.id);
            if (res.status === 200) {
                dispatch('findTour', payload.tour_id)
            }

            return res;
        },

        async findTourDates({ commit }, payload) {
            const res = await axios.get('/api/tour/date/' + payload);
            if (res.status === 200) {
                commit('MUTATE_TOURDATES', res.data.tourDates)
            }

            return res;
        }
    }
}

export default tour;
