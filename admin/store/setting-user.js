import BaseModule from "./base-module"
import { SettingUserService } from "~/services/modules/setting-user/SettingUserService"

export const API = new SettingUserService()

const crud = new BaseModule(API)

const SHOW = 'SHOW'

export const state = {
    ...crud.state
}
export const getters = {
    ...crud.getters
}
export const actions = {
    ...crud.actions,

      /**
     * action get detail
     * @param {Object} data param select detail
     * @returns
     */
       async getByUserId({ commit }, data = {}) {
        // call api get detail
        return await API.getByUserId(data).then((response) => {
                commit(SHOW, response.data.result.data)

                return Promise.resolve(response.data.result)
            }).catch((err) => {
                Promise.reject(err)
            })
    }
}
export const mutations = {
    ...crud.mutations
}