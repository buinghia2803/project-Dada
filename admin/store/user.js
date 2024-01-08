import BaseModule, {ADD} from "./base-module"
import { UserService } from "~/services/modules/users/UserService"
import {message} from "ant-design-vue";

export const API = new UserService()

const crud = new BaseModule(API)

export const state = () => { return {
    ...crud.state
    }
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
