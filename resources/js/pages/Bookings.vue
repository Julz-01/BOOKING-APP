<template>
    <v-card>
        <v-card-title>
            <v-btn class="success" to="/">TOURS</v-btn>
        </v-card-title>
        <v-card-text>
            <v-data-table :headers="headers" :items="bookings" :items-per-page="10" class="elevation-1">
                <template v-slot:item.number="{ item }">
                    <span>{{ item.booking_passengers.length }}</span>
                </template>
                <template v-slot:item.action="{ item }">
                    <Edit :data="item" />
                </template>
            </v-data-table>
        </v-card-text>
    </v-card>
</template>

<script>
import { mapState } from 'vuex'
import Edit from '../components/EditBooking.vue';

export default {
    data() {
        return {
            headers: [
                {
                    text: 'Booking ID',
                    align: 'start',
                    sortable: true,
                    value: 'id',
                },
                { text: 'Tour Name', value: 'tour.name' },
                { text: 'Tour Date', value: 'tour_date' },
                { text: 'Number of Passenger', value: 'number' },
                { text: 'Actions', value: 'action' },
            ],
        }
    },
    mounted() {
        this.findAll();
    },
    computed: {
        ...mapState('booking', ['bookings'])
    },
    methods: {
        async findAll() {
            try {
                const res = await this.$store.dispatch('booking/findAll')
            } catch (err) {
                console.log(err.response)
            }
        }
    },
    components: { Edit }
}
</script>