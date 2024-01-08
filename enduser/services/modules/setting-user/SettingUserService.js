import BaseService from '@/services/BaseService'
import http from '@/utils/http'

const HTTP = new http()

export class SettingUserService extends BaseService {
    API = '/user/setting'

    API_GET_NOTIFICATION_BY_USER = 'user/setting'
    
    API_GET_BY_USER = 'user/setting/user_id'

    /**
     * GetNotificationByUser
     * @param {*} data
     * @returns
     */
    getNotificationByUser(data) {
        return HTTP.get(this.API_GET_NOTIFICATION_BY_USER, data)
    }

    /**
     * GetByUserId
     * @param {*} data
     * @returns
     */
    getByUserId(data) {
        return HTTP.get(this.API_GET_BY_USER, data)
    }
}
