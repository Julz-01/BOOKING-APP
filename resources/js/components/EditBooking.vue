<template>
    <v-dialog v-model="dialog[data.id]" fullscreen hide-overlay transition="dialog-bottom-transition">
        <template v-slot:activator="{ on, attrs }">
            <v-btn color="primary" @click="findBookingDates(data.tour_id); findBookingPassengers();" dark v-bind="attrs"
                v-on="on">
                EDIT
            </v-btn>
        </template>
        <v-card>
            <v-toolbar dark color="primary">
                <v-btn icon dark @click="$set(dialog, data.id, false)">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-toolbar>

            <v-divider></v-divider>
            <v-card-text>
                <v-form>
                    <v-container>
                        <v-row>
                            <v-col cols="12" sm="12">
                                <v-text-field :value="data.tour.name" label="Tour Name" outlined readonly>
                                </v-text-field>
                                <v-select v-model="booking_data.tour_date" :items="bookingDates" :item-text="schedText"
                                    item-value="date" label="Choose Tour Date" outlined></v-select>
                                <v-select v-model="booking_data.status" :items="bookingStatus" :item-text="statusText"
                                    item-value="val" label="Choose Tour Date" outlined></v-select>
                                <v-btn class="primary float-right" @click="add()">ADD PASSENGER</v-btn>
                            </v-col>
                            <v-col cols="12" md="12">
                                <v-card>
                                    <v-card-text>
                                        <v-form>
                                            <v-container>
                                                <v-row v-for="passenger in bookingPassengers" :key="passenger.id">
                                                    <v-col cols="12" sm="6">
                                                        <v-text-field :value="passenger.passenger.given_name"
                                                            label="Given Name" outlined readonly>
                                                        </v-text-field>
                                                        <v-text-field :value="passenger.passenger.email" label="Email"
                                                            outlined readonly>
                                                        </v-text-field>
                                                        <v-text-field :value="passenger.passenger.passport"
                                                            label="Passport" outlined readonly></v-text-field>
                                                        <v-text-field :value="passenger.special_request"
                                                            label="Special Request" outlined readonly>
                                                        </v-text-field>
                                                    </v-col>
                                                    <v-col cols="12" sm="6">
                                                        <v-text-field :value="passenger.passenger.surname"
                                                            label="Surname" outlined readonly>
                                                        </v-text-field>
                                                        <v-text-field :value="passenger.passenger.mobile" label="Mobile"
                                                            outlined readonly>
                                                        </v-text-field>
                                                        <v-text-field :value="passenger.passenger.birth_date"
                                                            label="Birth Date" outlined readonly>
                                                        </v-text-field>

                                                        <v-btn
                                                            @click="removeBookingPassengers(passenger.id, passenger.booking_id)"
                                                            class="error">
                                                            <v-icon> mdi-delete </v-icon>
                                                        </v-btn>
                                                    </v-col>
                                                </v-row>
                                            </v-container>
                                        </v-form>

                                        <div v-for="(textField, i) in booking_data.textFields" :key="i">
                                            <v-form>
                                                <v-container>
                                                    <v-row>
                                                        <v-col cols="12" sm="6">
                                                            <v-text-field v-model="textField.given_name"
                                                                label="Given Name" outlined clearable>
                                                            </v-text-field>
                                                            <v-text-field v-model="textField.email" label="Email"
                                                                outlined clearable>
                                                            </v-text-field>
                                                            <v-text-field v-model="textField.passport" label="Passport"
                                                                outlined clearable></v-text-field>
                                                            <v-text-field v-model="textField.special_request"
                                                                label="Special Request" outlined clearable>
                                                            </v-text-field>
                                                        </v-col>
                                                        <v-col cols="12" sm="6">
                                                            <v-text-field v-model="textField.surname" label="Surname"
                                                                outlined clearable>
                                                            </v-text-field>
                                                            <v-text-field v-model="textField.mobile" label="Mobile"
                                                                outlined clearable>
                                                            </v-text-field>
                                                            <v-menu v-model="datePicker[i]"
                                                                :close-on-content-click="false" :nudge-right="40"
                                                                transition="scale-transition" offset-y min-width="auto">
                                                                <template v-slot:activator="{ on, attrs }">
                                                                    <v-text-field v-model="textField.birth_date"
                                                                        outlined readonly label="Date of Birth"
                                                                        v-bind="attrs" v-on="on">
                                                                    </v-text-field>
                                                                </template>
                                                                <v-date-picker v-model="textField.birth_date"
                                                                    @input="datePicker[i] = false">
                                                                </v-date-picker>
                                                            </v-menu>
                                                            <v-btn @click="remove(i)" class="error">
                                                                <v-icon> mdi-delete </v-icon>
                                                            </v-btn>
                                                        </v-col>
                                                    </v-row>
                                                </v-container>
                                            </v-form>
                                        </div>
                                    </v-card-text>
                                    <v-btn class="secondary float-right mt-2" text to="/">BACK</v-btn>
                                    <v-btn class="primary float-right mt-2 mr-2" @click="updateBooking(data.id)">SUBMIT
                                    </v-btn>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-form>
                <v-snackbar v-model="snackbar" class="text-center" :color="sbcolor" top right>
                    <div class="text-center">{{ msg }}</div>
                </v-snackbar>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script>
import { mapState } from 'vuex';

export default {
    props: ['data'],
    data() {
        return {
            dialog: [],
            booking_data: {
                tour_date: this.data.tour_date,
                textFields: [],
                status: this.data.status
            },
            passenger_data: {
                given_name: '',
                email: '',
                passport: '',
                special_request: '',
                surname: '',
                mobile: '',
                birth_date: ''
            },
            bookingStatus: [{ name: 'SUBMMITED', val: 1 }, { name: 'CANCELLED', val: 0 }],
            datePicker: [],
            snackbar: false,
            sbcolor: "",
            msg: ""
        }
    },
    computed: {
        ...mapState('booking', ['bookingDates', 'bookingPassengers'])
    },
    methods: {
        async findBookingDates(id) {
            try {
                const res = await this.$store.dispatch('booking/findBookingDates', id)
            } catch (err) {
                console.log(err.response)
            }
        },
        async findBookingPassengers() {
            try {
                const res = await this.$store.dispatch('booking/findBookingPassengers', this.data.id)
            } catch (err) {
                console.log(err.response)
            }
        },
        async removeBookingPassengers(id, booking_id) {
            try {
                const res = await this.$store.dispatch('booking/removeBookingPassengers', { id: id, booking_id: booking_id })
            } catch (err) {
                console.log(err.response)
            }
        },
        async updateBooking(id) {
            try {
                const res = await this.$store.dispatch('booking/updateBooking', { id: id, data: this.booking_data })
                if (res.status === 200) {
                    this.dialog[id] = false;
                    this.booking_data.textFields = [];
                    this.msg = 'BOOKING UPDATED!';
                    this.sbcolor = 'green';
                    this.snackbar = true;
                }
            } catch (err) {
                console.log(err.response)
                this.msg = 'INVALID INPUT!';
                this.sbcolor = 'red';
                this.snackbar = true;
            }
        },
        schedText(item) {
            if (item.length === 0) {
                return "no available date";
            } else {
                return `${item.date}`;
            }
        },
        statusText(item) {
            if (item.val === 1) {
                return "SUBMITTED";
            } else {
                return "CANCELLED";
            }
        },
        add() {
            this.booking_data.textFields.push({
                given_name: '',
                email: '',
                passport: '',
                special_request: '',
                surname: '',
                mobile: '',
                birth_date: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)
            })
        },
        remove(index) {
            this.booking_data.textFields.splice(index, 1)
        },
    }
}
</script>