import axios from 'axios';

const booking = {
    namespaced: true,
    state: {
        bookings: [],
        booking: [],
        bookingDates: [],
        bookingPassengers: []
    },
    getters: {},
    mutations: {
        MUTATE_BOOKINGS(state, payload) {
            state.bookings = payload;
        },
        MUTATE_BOOKING(state, payload) {
            state.booking = payload;
        },

        MUTATE_BOOKINGDATES(state, payload) {
            state.bookingDates = payload;
        },

        MUTATE_BOOKINGPASSENGERS(state, payload) {
            state.bookingPassengers = payload;
        }
    },
    actions: {
        async store({ }, payload) {
            const res = await axios.post('/api/booking', payload)

            return res;
        },

        async findAll({ commit }) {
            const res = await axios.get('/api/booking')
            if (res.status === 200) {
                commit('MUTATE_BOOKINGS', res.data.bookings)
            }

            return res;
        },

        async findBooking({ commit }, payload) {
            const res = await axios.get('/api/booking/' + payload)
            if (res.status === 200) {
                commit('MUTATE_BOOKING', res.data.booking)
            }

            return res;
        },

        async findBookingDates({ commit }, payload) {
            const res = await axios.get('/api/booking/date/' + payload)
            if (res.status === 200) {
                commit('MUTATE_BOOKINGDATES', res.data.dates)
            }

            return res;
        },

        async findBookingPassengers({ commit }, payload) {
            const res = await axios.get('/api/booking/passengers/' + payload)
            if (res.status === 200) {
                commit('MUTATE_BOOKINGPASSENGERS', res.data.passengers);
            }

            return res;
        },

        async removeBookingPassengers({ dispatch }, payload) {
            const res = await axios.delete('/api/booking/passenger/' + payload.id)
            if (res.status == 200) {
                dispatch('findBookingPassengers', payload.booking_id);
                dispatch('findAll');
            }

            return res;
        },

        async updateBooking({ dispatch }, payload) {
            const res = await axios.post('/api/booking/update/' + payload.id, payload.data)
            if (res.status === 200) {
                dispatch('findAll');
            }

            return res;
        }
    }
}

export default booking;