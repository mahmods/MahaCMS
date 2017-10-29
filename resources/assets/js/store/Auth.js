export default function (Vue) {
    Vue.auth = {    
        setAuth: (api_token, user_id) => {
            localStorage.setItem('api_token', api_token)
            localStorage.setItem('user_id', user_id)
        },

        getToken: () => {
            return localStorage.getItem('api_token')
        },
        
        destroy: () => {
            localStorage.removeItem('api_token')
            localStorage.removeItem('user_id')
        }
    }

    Object.defineProperty(Vue.prototype,'$auth', {
            get: function get () { return Vue.auth }
      })

}

export const api_token = localStorage.getItem('api_token')