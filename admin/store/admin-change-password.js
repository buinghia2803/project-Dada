import BaseModule from "~/store/base-module"
import { changePasswordService } from "~/services/modules/admin/changePasswordService";

export const API = new changePasswordService()

const adminChangePassword = new BaseModule(API)

export const state = {
    ...adminChangePassword.state
}

export const getters = {
    ...adminChangePassword.getters
}

export const mutations = {
    ...adminChangePassword.mutations
}

export const actions = {
    ...adminChangePassword.actions,
    async changePassword({ commit }, payload) {
        return API.change_password(payload)
            .then((response) => {
                this.$router.push('/revenue')
                // this.$toast.success('パスワードの変更に成功しました。')
                return Promise.resolve(response)
            })
            .catch((error) => {
                // this.$toast.error('現在パスワードが正しくありません。。')
                // Promise.reject(error)
            })
    }
}
