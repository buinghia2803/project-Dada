import BaseModule, { ADD } from "./base-module";
import { NotifyService } from "~/services/modules/notify/NotifyService";
import { message } from "ant-design-vue";

export const API = new NotifyService();

const crud = new BaseModule(API);

const UPDATE = "Update";

export const state = {
    ...crud.state
};
export const getters = {
    ...crud.getters
};
export const actions = {
    ...crud.actions,

    /**
     * action get detail
     * @param {Object} data param select detail
     * @returns
     */
    async updateStatusNotificationByUser({ commit }, data = {}) {
        // call api get detail
        return await API.updateStatusNotificationByUser(data)
            .then(response => {
                commit(UPDATE, response.data.result.data);

                return Promise.resolve(response.data.result);
            })
            .catch(err => {
                Promise.reject(err);
            });
    }
};
export const mutations = {
    ...crud.mutations
};
