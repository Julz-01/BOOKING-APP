<template>
    <v-dialog v-model="dialog[data.id]" width="800" persistent>
        <template v-slot:activator="{ on, attrs }">
            <v-btn color="primary" dark v-bind="attrs" v-on="on" @click="findTour(data.id)">
                EDIT
            </v-btn>
        </template>

        <v-card v-if="dialogId == data.id">
            <v-card-title class="text-h5 grey lighten-2">
                {{ tour_data.name }}
            </v-card-title>

            <v-card-text>
                <v-form>
                    <v-container>
                        <v-row>
                            <v-col cols="12" sm="12">
                                <v-text-field v-model="tour_data.name" label="Tour Name" outlined>
                                </v-text-field>
                                <v-textarea v-model="tour_data.itinerary" outlined name="input-7-4" label="Itinerary">
                                </v-textarea>
                                <v-btn class="primary float-right" @click="add()">ADD DATE</v-btn>
                            </v-col>
                            <v-col cols="12" md="12">
                                <v-card>
                                    <v-card-text>
                                        <v-list-item v-for="tour_date in tour.tour_dates" :key="tour_date.id">
                                            <v-list-item-content>
                                                <span :class="tour_date.status == 0 ? 'red--text' : 'dark--text'">{{
                                                        tour_date.date
                                                }}</span>
                                            </v-list-item-content>

                                            <v-list-item-action>
                                                <v-btn v-if="tour_date.status == 1"
                                                    @click="disableTourDate(tour_date.id, data.id)" class="error">
                                                    <v-icon> mdi-close </v-icon>
                                                </v-btn>
                                                <v-btn v-else @click="enableTourDate(tour_date.id, data.id)"
                                                    class="success">
                                                    <v-icon> mdi-check </v-icon>
                                                </v-btn>
                                            </v-list-item-action>
                                        </v-list-item>
                                        <div v-for="(textField, i) in tour_data.textFields" :key="i">
                                            <v-list-item>

                                                <v-list-item-content>
                                                    <v-menu v-model="datePick[i]" :close-on-content-click="false"
                                                        :nudge-right="40" transition="scale-transition" offset-y
                                                        min-width="auto">
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <v-text-field v-model="textField.date" label="Date"
                                                                prepend-icon="mdi-calendar" readonly v-bind="attrs"
                                                                v-on="on">
                                                            </v-text-field>
                                                        </template>s
                                                        <v-date-picker v-model="textField.date"
                                                            @input="datePick[i] = false">
                                                        </v-date-picker>
                                                    </v-menu>
                                                </v-list-item-content>

                                                <v-list-item-action>
                                                    <v-btn @click="remove(i)" class="error">
                                                        <v-icon> mdi-delete </v-icon>
                                                    </v-btn>
                                                </v-list-item-action>
                                            </v-list-item>
                                        </div>
                                    </v-card-text>
                                    <!-- <v-btn class="primary float-right mt-2" :disabled="tour.textFields.length < 1" @click="store()">SUBMIT</v-btn> -->
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-form>
            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="red" text @click="$set(dialog, data.id, false), dialogId = null">
                    CLOSE
                </v-btn>
                <v-btn color="primary" :disabled="tour_data.name == '' || tour_data.itinerary == ''" text
                    @click="updateTour(data.id)">SUBMIT</v-btn>
            </v-card-actions>
        </v-card>

        <v-skeleton-loader v-show="loader == true" class="mx-auto" max-width="800" type="card"></v-skeleton-loader>

        <v-snackbar v-model="snackbar" class="text-center" :color="sbcolor" top right>
            <div class="text-center">{{ msg }}</div>
        </v-snackbar>
    </v-dialog> 
</template>

<script>
import { mapState } from 'vuex'

export default {
    props: ['data'],
    data() {
        return {
            dialog: [],
            tour_data: {
                name: '',
                itinerary: '',
                textFields: [],
            },
            datePick: [],
            snackbar: false,
            sbcolor: "",
            msg: "",
            dialogId: null,
            loader: false,
        }
    },
    computed: {
        ...mapState('tour', ['tour'])
    },
    methods: {
        add() {
            this.tour_data.textFields.push({
                date: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
            })
        },
        remove(index) {
            this.tour_data.textFields.splice(index, 1)
        },
        async findTour(id) {
            this.loader = true;
            try {
                const res = await this.$store.dispatch('tour/findTour', id)
                if (res.status === 200) {
                    this.loader = false;
                    this.dialogId = id;
                    this.tour_data.name = res.data.tour.name;
                    this.tour_data.itinerary = res.data.tour.itinerary;
                }
            } catch (err) {
                console.log(err.response)
            }
        },
        async updateTour(id) {
            try {
                const res = await this.$store.dispatch('tour/updateTour', { id: id, data: this.tour_data })
                if (res.status === 201) {
                    this.tour_data.textFields = [];
                    this.msg = 'UPDATE SUCCESS';
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
        async disableTourDate(id, tour_id) {
            try {
                const res = await this.$store.dispatch('tour/disableTourDate', { id: id, tour_id: tour_id })
                if (res.status === 200) {
                    this.msg = 'DATE DISABLED!';
                    this.sbcolor = 'secondary';
                    this.snackbar = true;
                }
            } catch (err) {
                console.log(err.response)
                this.msg = 'SOMETHING WENT WRONG!';
                this.sbcolor = 'red';
                this.snackbar = true;
            }
        },
        async enableTourDate(id, tour_id) {
            try {
                const res = await this.$store.dispatch('tour/enableTourDate', { id: id, tour_id: tour_id })
                if (res.status === 200) {
                    this.msg = 'DATE ENABLED!';
                    this.sbcolor = 'green';
                    this.snackbar = true;
                }
            } catch (err) {
                console.log(err.response)
                this.msg = 'SOMETHING WENT WRONG!';
                this.sbcolor = 'red';
                this.snackbar = true;
            }
        }
    }
}
</script>