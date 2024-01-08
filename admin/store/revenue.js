import BaseModule from "./base-module"
import { RevenueService } from "~/services/modules/revenue/RevenueService"

export const API = new RevenueService()

const crud = new BaseModule(API)

export const state = {
    ...crud.state,
    dataOverViewRevenue: {},
    dataRevenue: {},
}
export const getters = {
    ...crud.getters,
    getterOverViewRevenue: (state) => state.dataOverViewRevenue ? state.dataOverViewRevenue : {},
    getterRevenue: (state) => state.dataRevenue.data ? state.dataRevenue.data : [],
    getterPaginateRevenue: (state) => state.dataRevenue.meta ? state.dataRevenue.meta : {},
}
export const actions = {
    ...crud.actions,
    /**
     * action get overview revenue
     * @param {Object} data data overview
     * @returns
     */
    async actionGetOverViewRevenue({ commit }, data) {
        // call api get all
        return await API.getOverViewRevenue(data)
            .then((response) => {
                commit('GET_OVER_VIEW_REVENUE', response.data.result)
                // config data pagination
                if (response.data.result.meta) {
                    response.data.result.meta.current = response?.data?.result?.meta?.current_page
                    response.data.result.meta.pageSize = response?.data?.result?.meta?.per_page
                }
                return Promise.resolve(response.data.result)
            })
            .catch((err) => {
                // this.$toast.error(err.message)
                Promise.reject(err)
            })
    },

    /**
     * action get overview revenue
     * @param {Object} data data overview
     * @returns
     */
    async actionGetDetailRevenue({ commit }, data) {
        // call api get all
        return await API.getListRevenue(data)
            .then((response) => {
                commit('GET_LIST_REVENUE', response.data.result)
                // config data pagination
                if (response.data.result.meta) {
                    response.data.result.meta.current = response?.data?.result?.meta?.current_page
                    response.data.result.meta.pageSize = response?.data?.result?.meta?.per_page
                }
                return Promise.resolve(response.data.result)
            })
            .catch((err) => {
                // this.$toast.error(err.message)
                Promise.reject(err)
            })
    },
}
export const mutations = {
    ...crud.mutations,
    ['GET_OVER_VIEW_REVENUE'](state, data) {
        state.dataOverViewRevenue = data.data
    },
    ['GET_LIST_REVENUE'](state, data) {
        state.dataRevenue = data
    },
}
