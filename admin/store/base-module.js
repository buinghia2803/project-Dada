/* eslint-disable no-return-await */
import { findIndex } from 'lodash'
import Vue from 'vue'

export const GET_LIST = 'GET_LIST'
export const SHOW = 'SHOW'
export const ADD = 'ADD'
export const UPDATE = 'UPDATE'
export const DELETE = 'DELETE'

export default class {
    // eslint-disable-next-line space-before-function-paren
    constructor(API) {
        this.state = {
                data: {
                    data: []
                },
                show: {}
            }

        this.getters = {
            getterList: (state) => state.data.data ? state.data.data : state.data,
            getterMeta: (state) => state.data.meta ? state.data.meta : {},
            getterShow: (state) => state.show ? state.show : {}
        }

        this.mutations = {
            [GET_LIST](state, data) {
                state.data = data
            },
            [SHOW](state, data) {
                state.show = data && data.data ? data.data : {}
            },
            [ADD](state, data) {
                if (state && state.data.data) {
                    state.data.data = [...[data], ...state.data.data]
                }
            },
            [UPDATE](state, data) {
                const index = findIndex(state.data.data, { id: data.id })
                Vue.set(state.data.data, index, data)
            },
            [DELETE](state, id) {
                const index = findIndex(state.data.data, { id })
                state.data.data.splice(index-1, 1)
            }
        }

        this.actions = {
            /**
             * action get list
             * @param {Object} data param select all
             * @returns
             */
            async actionGetAll({ commit }, data) {
                // call api get all
                return await API.getAll(data)
                    .then((response) => {
                        commit(GET_LIST, response.data.result)
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
             * action get detail
             * @param {Object} data param select detail
             * @returns
             */
            async actionShow({ commit }, data = {}) {
                // call api get detail
                return await API.show(data)
                    .then((response) => {
                        commit(SHOW, response.data.result.data)

                        return Promise.resolve(response.data.result)
                    })
                    .catch((err) => {
                        // this.$toast.error(err.message)
                        Promise.reject(err)
                    })
            },

            /**
             * action update
             *
             * @param {Object} data data update
             * @returns
             */
            async actionUpdate({ commit }, data = {}) {
                // call api update
                return await API.update(data)
                    .then((response) => {
                        commit(UPDATE, { ...data })
                        commit(SHOW, response.data.result)

                        return Promise.resolve(response.data.result)
                    })
                    .catch((err) => {
                        Promise.reject(err)
                    })
            },

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
                return await API.add(data)
                    .then((response) => {
                        commit(ADD, response.data.result.data)
                        return Promise.resolve(response.data.result)
                    })
                    .catch((err) => {
                        Promise.reject(err)
                    })
            },


            /**
             * action delete
             * @param {Integer} id id model delete
             * @returns
             */
            async actionDelete({ commit }, data) {
                // call api delete
                return await API.delete(data)
                    .then((response) => {
                        commit(DELETE, data)

                        return Promise.resolve(response.data.result.data)
                    })
                    .catch((err) => {
                        Promise.reject(err)
                    })
            }
        }
    }
}
