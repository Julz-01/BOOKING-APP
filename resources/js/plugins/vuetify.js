import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify)

const opts = {
    theme: {
        themes: {
            light: {
                navy: "#263e8e",
                navydark: "#3F3D3D",
                navyaqua: "#44BFFC",
                seavblue: "#019BFC",
                approveColor: "#2E7D32",
                cancelledColor: "#E53935",
                pendingColor: "#FFB300",
                expiredColor: "#2979FF",
                paymentColor: "#2E7D32",
                deniedColor: "#212121",
                customGreyColor: "#616161"
            }
        }
    }
}

export default new Vuetify(opts)