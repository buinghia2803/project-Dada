import http from '@/utils/http'
import BaseService from "~/services/BaseService"

const HTTP = new http()

export default class Authservice extends BaseService {
    API = '/admin'

    forgot_password(payload) {
        return HTTP.post('admin/generate-link', payload)
    }

    check_token_password_reset(payload) {
        return HTTP.post('admin/check-token', payload)
    }

    reset_password(payload) {
        return HTTP.post('admin/password-reset', payload)
    }

    login_user(payload) {
        return HTTP.post('user/login_user', payload)
    }
}
