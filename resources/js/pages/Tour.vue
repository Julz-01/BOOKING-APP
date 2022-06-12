<template>
    <v-card>
        <v-card-text>
            <v-form>
                <v-container>
                    <v-row>
                        <v-col cols="12" sm="12">
                            <v-text-field v-model="tour.name" label="Tour Name" outlined clearable></v-text-field>
                            <v-textarea v-model="tour.itinerary" outlined clearable name="input-7-4" label="Itinerary">
                            </v-textarea>
                            <v-btn class="primary float-right" @click="add()">ADD DATE</v-btn>
                        </v-col>
                        <v-col cols="12" md="12">
                            <v-card>
                                <v-card-text>
                                    <div v-for="(textField, i) in tour.textFields" :key="i">
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
                                                    </template>
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
                                <v-btn class="secondary float-right mt-2" text to="/">BACK</v-btn>
                                <v-btn class="primary float-right mt-2 mr-2" :disabled="tour.textFields.length < 1"
                                    @click="store()">SUBMIT</v-btn>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-container>
            </v-form>
        </v-card-text>
    </v-card>
</template>

<script>
export default {
    data() {
        return {
            tour: {
                name: '',
                itinerary: '',
                textFields: [],
            },
            date: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
            datePick: [],
        }
    },
    methods: {
        add() {
            this.tour.textFields.push({
                date: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
            })
        },
        remove(index) {
            this.tour.textFields.splice(index, 1)
        },
        async store() {
            try {
                const res = await this.$store.dispatch('tour/store', this.tour)
                if (res.status == 201) {
                    this.tour.textFields = [];
                    this.$router.push({ path: "/" });
                }
            } catch (err) {
                console.log(err.response)
            }
        }
    }
}
</script>