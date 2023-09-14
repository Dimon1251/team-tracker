import { createStore } from 'vuex'

const store = createStore({
    state() {
        return {
            authorized: false,
            user_email: ''
        }
    }
})

export default store
