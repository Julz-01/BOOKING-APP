<template>
    <v-card>
        <v-card-text>
            <v-form>
                <v-container>
                    <v-row>
                        <v-col cols="12" sm="12">
                            <v-text-field :value="tour.name" label="Tour Name" outlined readonly></v-text-field>
                            <v-select v-model="booking_data.tour_date" :items="tourDates" :item-text="schedText"
                                item-value="date" label="Choose Tour Date" outlined></v-select>
                            <v-btn class="primary float-right" @click="add()">ADD PASSENGERS</v-btn>
                        </v-col>
                        <v-col cols="12" md="12">
                            <v-card>
                                <v-card-text>
                                    <div v-for="(textField, i) in booking_data.textFields" :key="i">
                                        <v-form>
                                            <v-container>
                                                <v-row>
                                                    <v-col cols="12" sm="6">
                                                        <v-text-field v-model="textField.given_name" label="Given Name"
                                                            outlined clearable>>
                                                        </v-text-field>
                                                        <v-text-field v-model="textField.email" label="Email" outlined
                                                            clearable>>
                                                        </v-text-field>
                                                        <v-text-field v-model="textField.passport" label="Passport"
                                                            outlined clearable></v-text-field>
                                                        <v-text-field v-model="textField.special_request"
                                                            label="Special Request" outlined clearable></v-text-field>
                                                    </v-col>
                                                    <v-col cols="12" sm="6">
                                                        <v-text-field v-model="textField.surname" label="Surname"
                                                            outlined clearable>>
                                                        </v-text-field>
                                                        <v-text-field v-model="textField.mobile" label="Mobile" outlined
                                                            clearable>
                                                        </v-text-field>
                                                        <v-menu v-model="datePicker[i]" :close-on-content-click="false"
                                                            :nudge-right="40" transition="scale-transition" offset-y
                                                            min-width="auto">
                                                            <template v-slot:activator="{ on, attrs }">
                                                                <v-text-field v-model="textField.birth_date" outlined
                                                                    readonly label="Date of Birth" v-bind="attrs"
                                                                    v-on="on">
                                                                </v-text-field>
                                                            </template>
                                                            <v-date-picker v-model="textField.birth_date"
                                                                @input="datePicker[i] = false">
                                                            </v-date-picker>
                                                        </v-menu>
                                                        <!-- <v-text-field v-model="textField.birth_date"
                                                            label="Date of Birth" outlined clearable></v-text-field> -->
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
                                <v-btn class="primary float-right mt-2 mr-2"
                                    :disabled="booking_data.textFields.length === 0" @click="store()">SUBMIT</v-btn>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-container>
            </v-form>
        </v-card-text>
        <v-snackbar v-model="snackbar" class="text-center" :color="sbcolor" top right>
            <div class="text-center">{{ msg }}</div>
        </v-snackbar>
    </v-card>
</template>

<script>
import { mapState } from 'vuex';

export default {
    data() {
        return {
            booking_data: {
                tour_id: "",
                tour_date: "",
                textFields: [],
            },
            datePicker: [],
            snackbar: false,
            sbcolor: "",
            msg: ""
        }
    },
    mounted() {
        this.findTour();
        this.findTourDates();
    },
    computed: {
        ...mapState('tour', ['tour', 'tourDates'])
    },
    methods: {
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
        schedText(item) {
            if (item.length < 1) {
                return "no available date";
            } else {
                return `${item.date}`;
            }
        },
        async findTour() {
            try {
                const res = await this.$store.dispatch('tour/findTour', this.$route.params.id)
                if (res.status === 200) {
                    this.booking_data.tour_id = res.data.tour.id;
                }
            } catch (err) {
                console.log(err.response)
            }
        },
        async findTourDates() {
            try {
                const res = await this.$store.dispatch('tour/findTourDates', this.$route.params.id)
                console.log(res)
            } catch (err) {
                console.log(err.response)
            }
        },
        async store() {
            try {
                const res = await this.$store.dispatch('booking/store', this.booking_data)
                if (res.status === 201) {
                    this.booking_data.textFields = [];
                    this.msg = 'PASSENGER ADDED!';
                    this.sbcolor = 'green';
                    this.snackbar = true;
                }
            } catch (err) {
                console.log(err.response)
                this.msg = 'INVALID INPUT!';
                this.sbcolor = 'red';
                this.snackbar = true;
            }
        }
    }
}
</script>