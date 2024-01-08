import BaseModule from "@/store/base-module"
import { SettingAdminService } from "~/services/modules/setting-admin/SettingAdminService"

export const API = new SettingAdminService()

const crud = new BaseModule(API)

export const state = {
    ...crud.state
}
export const getters = {
    ...crud.getters
}
export const actions = {
    ...crud.actions,
}
export const mutations = {
    ...crud.mutations
}
