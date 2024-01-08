import BaseModule from "./base-module";
import {OfferArtService} from "~/services/modules/contract-art/OfferArtService";

export const API = new OfferArtService();

const crud = new BaseModule(API);

export const state = {
    ...crud.state,
};
export const getters = {
    ...crud.getters,
};
export const actions = {
    ...crud.actions,

    async getOfferForArt({commit}, payload = {}) {
        // call api get detail
        return API.getOfferForArt(payload).then(response => {
            return Promise.resolve(response.data);
        }).catch(err => {
            return Promise.reject(err);
        });
    },
    async confirmOfferForArt({commit}, payload = {}) {
        // call api get detail
        return API.confirmOfferForArt(payload).then(response => {
            return Promise.resolve(response.data);
        }).catch(err => {
            return Promise.reject(err);
        });
    },
};
export const mutations = {
    ...crud.mutations,
};
