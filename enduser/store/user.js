import BaseModule, { ADD, UPDATE } from "./base-module"
import { UserService } from "~/services/modules/users/UserService"

export const API = new UserService()
export const CONTRACT_USER = 'CONTRACT_USER'

const crud = new BaseModule(API)

export const state = {
    ...crud.state,
    dataCountContractUser: {},

}
export const getters = {
    ...crud.getters,
    getCountContractUser: (state) => state.dataCountContractUser ? state.dataCountContractUser : {},
}
export const actions = {
    ...crud.actions,
    /**
     * action create
     * @param {Object} data data create
     * @returns
     */
    async actionAdd({ commit }, data) {
        // remove id in data create (for postgres)
        if (!data.id) {
            delete data.id
        }

        // call api create
        return await API.addNew(data)
            .then((response) => {
                commit(ADD, response.data.result.data)

                return Promise.resolve(response.data.result)
            })
            .catch((err) => {
                this.$toast.error('エラーが発生しました。再度お試しください。')
                Promise.reject(err)
            })
    },

    async actionUpdateType({ commit }, data) {
        // remove id in data create (for postgres)
        if (!data.id) {
            delete data.id
        }

        // call api create
        return await API.updateType(data)
            .then((response) => {
                commit(UPDATE, response.data.result.data)

                return Promise.resolve(response.data.result)
            })
            .catch((err) => {
                this.$toast.error('エラーが発生しました。再度お試しください。')
                Promise.reject(err)
            })
    },

    async actionEditProfile({ commit }, data) {
        // remove id in data create (for postgres)
        if (!data.id) {
            delete data.id
        }

        // call api create
        return await API.editProfile(data)
            .then((response) => {
                commit(UPDATE, response.data.result.data)
                return Promise.resolve(response.data.result)
            })
            .catch((err) => {
                this.$toast.error('エラーが発生しました。再度お試しください。')
                Promise.reject(err)
            })
    },

    async actionGetNumberContractUser({ commit }, data) {
        return await API.getNumberContractUser(data)
            .then((response) => {
                commit(CONTRACT_USER, response.data.result)
                return Promise.resolve(response.data.result)
            })
            .catch((err) => {
                this.$toast.error('エラーが発生しました。再度お試しください。')
                Promise.reject(err)
            })
    },
}
export const mutations = {
    ...crud.mutations,
    [CONTRACT_USER](state, data) {
        state.dataCountContractUser = data.data
    },
}
