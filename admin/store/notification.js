import BaseModule from "./base-module"
import { NotifyService } from "~/services/modules/notifies/NotifyService";
export const API = new NotifyService()

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
