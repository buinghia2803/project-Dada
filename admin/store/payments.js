import BaseModule from "./base-module"
import { PaymentService } from "~/services/modules/payments/PaymentService"

export const API = new PaymentService()

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
