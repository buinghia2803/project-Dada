import http from '@/utils/http'
import BaseService from "~/services/BaseService"

const HTTP = new http()

export class changePasswordService extends BaseService {
    API = '/admin'

    change_password(payload) {
        return HTTP.post('admin/change-pass', payload)
    }
}
