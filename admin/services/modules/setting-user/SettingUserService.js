import BaseService from '@/services/BaseService'
import http from '@/utils/http'

const HTTP = new http()

export class SettingUserService extends BaseService {
    API = '/user/setting'

    API_GET_BY_USER = 'user/setting/get-by-user-id'

    /**
     * GetByUserId
     * @param {*} data
     * @returns
     */
    getByUserId(data) {
        return HTTP.get(this.API_GET_BY_USER, data)
    }
}
