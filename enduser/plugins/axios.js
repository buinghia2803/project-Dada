import Vue from 'vue'

export default function ({ $axios, store, redirect, $toast }) {
  $axios.onRequest((config) => {
    config.paramsSerializer = (params) => {
      return require('qs').stringify(params, {
        arrayFormat: 'brackets',
        encode: false,
      })
    }
    return config
  })

  $axios.onResponse((response) => {
      if(response.status === 201) {
          $toast.success(response.data.message)
      }
    if (response.data.status === 301) {
      redirect(response.data.redirectTo)
    }
    return response
  })

  $axios.onError((error) => {
    const code = parseInt(error.response && error.response.status)
      if (code === 401) {
          redirect('/login')
          store.commit('login', false)
      }
      if(code == 422) {
          error.response.data.result.forEach((item) => {
              $toast.error(item)
          })
      }
  })

  Vue.prototype.$http = $axios
}
