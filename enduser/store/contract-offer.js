import BaseModule from "./base-module"
import {ContractOfferService} from "~/services/modules/contract-offer/ContractOfferService";

export const API = new ContractOfferService()
export const GET_LIST_CONTRACT_OFFER_BY_USER = 'GET_LIST_CONTRACT_OFFER_BY_USER'
const crud = new BaseModule(API)

export const state = () => { return {
    ...crud.state
}
}
export const getters = {
    ...crud.getters,
    getterListContractOfferByUser: (state) => state.data.data ? state.data.data : state.data,
}
export const actions = {
    ...crud.actions,
    async actionGetListContractOfferByUser({ commit }, data) {
        // call api get all
        return await API.get_list_contract_offer_by_user(data)
            .then((response) => {
                commit(GET_LIST_CONTRACT_OFFER_BY_USER, response.data.result)
                // config data pagination
                if (response.data.result.meta) {
                    response.data.result.meta.current = response?.data?.result?.meta?.current_page
                    response.data.result.meta.pageSize = response?.data?.result?.meta?.per_page
                }
                return Promise.resolve(response.data.result)
            })
            .catch((err) => {
                Promise.reject(err)
            })
    },
}
export const mutations = {
    ...crud.mutations,
    [GET_LIST_CONTRACT_OFFER_BY_USER](state, data) {
        state.data = data
    },
}
