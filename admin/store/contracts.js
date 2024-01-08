import BaseModule from "./base-module"
import { ContractService } from "~/services/modules/contracts/ContractService"

export const API = new ContractService()

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
