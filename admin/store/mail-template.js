import baseModule from './base-module';
import { MailTemplateService } from '../services/modules/mail-template/MailTemplateService'

export const API = new MailTemplateService()

var crud = new baseModule(API)

const SHOW = 'SHOW'

export const state = {
    ...crud.state
}
export const getters = {
    ...crud.getters,
};
export const mutations = {
    ...crud.mutations,
};
export const actions = {
    ...crud.actions,
    /**
     * action get detail
     * @param {Object} data param select detail
     * @returns
     */
    async getMailTemplateByType({ commit }, data = {}) {
        // call api get detail
        return await API.getMailTemplateByType(data)
            .then((response) => {
                commit(SHOW, response.data.result.data)

                return Promise.resolve(response.data.result)
            })
            .catch((err) => {
                Promise.reject(err)
            })
    }
};