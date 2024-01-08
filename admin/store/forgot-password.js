import BaseModule from "~/store/base-module"
import Authservice from "~/services/authservice"

export const API = new Authservice()

const crudAuth = new BaseModule(API)

export const state = {
    ...crudAuth.state
}

export const getters = {
    ...crudAuth.getters
}

export const mutations = {
    ...crudAuth.mutations
}

export const actions = {
    ...crudAuth.actions,
    async actionForgotPassword({ commit }, payload) {
        return API.forgot_password(payload)
            .then((response) => {
                return Promise.resolve(response.data)
            })
            .catch((error) => {
                Promise.reject(error)
            })
    },

    async actionCheckTokenResetPassWord({ commit }, payload) {
        return API.check_token_password_reset(payload)
            .then((response) => {
                return Promise.resolve(response.data)
            })
            .catch((error) => {
                this.$router.push('/auth/login')
                Promise.reject(error)
            })

    },
    async actionResetPassword({ commit }, payload) {
        return API.reset_password(payload)
            .then((response) => {
                this.$router.push('/auth/login')
                return Promise.resolve(response.data)
            })
            .catch((error) => {
                Promise.reject(error)
            })
    },

    async loginUser({ commit }, payload) {
        return API.login_user(payload)
            .then((response) => {
                return Promise.resolve(response)
            })
            .catch((error) => {
                Promise.reject(error)
            })
    },
}
