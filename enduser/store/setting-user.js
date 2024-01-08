import BaseModule from "./base-module";
import { SettingUserService } from "~/services/modules/setting-user/SettingUserService";

export const API = new SettingUserService();

const crud = new BaseModule(API);

const SHOW = "SHOW";
const SET_SETTING = "SET_SETTING";

export const state = {
    ...crud.state,
    setting: {}
};
export const getters = {
    ...crud.getters,
    getSetting: (state) => state.setting ? state.setting : {},
};
export const actions = {
    ...crud.actions,

    /**
     * action get detail
     * @param {Object} data param select detail
     * @returns
     */
    async getByUserId({ commit }, data = {}) {
        try {
            // call api get detail
            const response = await API.getByUserId(data)
            if(response) {
                commit(SHOW, response.data.result.data);

                return Promise.resolve(response);
            }
        } catch (error) {
            Promise.reject(error);
        }
    },

    /**
     * action get detail
     * @param {Object} data param select detail
     * @returns
     */
    async getNotificationByUser({ commit }, data = {}) {
        try {
            // call api get detail
            const response = await API.getNotificationByUser(data)
            commit(SET_SETTING, response.data.result.data);

            return Promise.resolve(response);
        } catch (error) {
            Promise.reject(error);
        }


    }
};
export const mutations = {
    ...crud.mutations,

    [SET_SETTING](state, data) {
        state.setting = data ? data : {}
    },
};
