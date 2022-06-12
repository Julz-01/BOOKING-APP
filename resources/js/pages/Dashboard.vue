<template>
    <v-card>
        <v-card-title>
            <v-btn class="success" to="/tour">Create new tour</v-btn>
            <v-btn class="primary ml-2" to="/bookings">VIEW BOOKINGS</v-btn>
        </v-card-title>
        <v-card-text>
            <v-data-table :headers="headers" :items="tours" :items-per-page="10" class="elevation-1">
                <template v-slot:item.actions="{ item }">
                    <Edit :data="item" />
                    <v-btn class="success" :to="`/booking/${item.id}`">BOOKING</v-btn>
                </template>
            </v-data-table>
        </v-card-text>
    </v-card>
</template>

<script>
import { mapState } from 'vuex';
import Edit from '../components/EditTour.vue';

export default {
    data() {
        return {
            headers: [
                {
                    text: 'Tour ID',
                    align: 'start',
                    sortable: true,
                    value: 'id',
                },
                { text: 'Tour Name', value: 'name' },
                { text: 'Actions', value: 'actions' },
            ],
        }
    },
    mounted() {
        this.findAll();
    },
    computed: {
        ...mapState('tour', ['tours'])
    },
    methods: {
        async findAll() {
            try {
                await this.$store.dispatch('tour/findTours')
            } catch (err) {
                console.log(err.response)
            }
        }
    },
    components: { Edit }
}
</script>