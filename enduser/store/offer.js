import BaseModule, {ADD} from "./base-module"
import { OfferService } from "~/services/modules/offers/OfferService"

export const API = new OfferService()

const crud = new BaseModule(API)

export const state = {
    ...crud.state
}

export const getters = {
    ...crud.getters
}
export const actions = {
    ...crud.actions
}
export const mutations = {
    ...crud.mutations
}
