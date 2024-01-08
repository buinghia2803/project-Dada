import BaseModule from "./base-module"
import { ContractService } from "~/services/modules/contracts/ContractService"

export const API = new ContractService()
const ADD = 'ADD';

const crud = new BaseModule(API)

export const staten = {
    ...crud.state
}
export const getters = {
    ...crud.getters
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
}
export const mutations = {
    ...crud.mutations
}
