import { createStore } from 'vuex'

const store = createStore({
    state() {
        return {
            authorized: false
        }
    }
})

export default store