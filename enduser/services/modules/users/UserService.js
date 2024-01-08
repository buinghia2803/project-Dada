import Http from '@/utils/http'
const HTTP = new Http();
import BaseService from '@/services/BaseService'

export class UserService extends BaseService {
    API = '/user'

    // addNew(data) {
    //     return HTTP.post(this.API, data, {'Content-Type': 'multipart/form-data'});
    // }

    updateType(payload) {
        return HTTP.put('/user/update_type', payload)
    }

    API_EDIT_PROFILE = 'user/update-profile'

    /**
     * EditProfile
     * @param {*} data
     * @returns
     */
    editProfile(data) {
        const formData = new FormData()
        for (const key in data) {
            if (Object.hasOwnProperty.call(data, key)) {
                const element = data[key];
                if (element) {
                    formData.append(key, data[key])
                }
            }
        }

        return HTTP.post(this.API_EDIT_PROFILE, formData, { 'Content-Type': 'multipart/form-data' }, 'PUT')
    }

    getNumberContractUser(payload) {
        return HTTP.get('/user/dad', payload)
    }
}
