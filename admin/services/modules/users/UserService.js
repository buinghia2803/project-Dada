import Http from '@/utils/http'
const HTTP = new Http();
import BaseService from '@/services/BaseService'

export class UserService extends BaseService {
    API = '/admin/user'

    addNew(data) {
        return HTTP.post(this.API, data, {'Content-Type': 'multipart/form-data'});
    }

    update(data) {
        return HTTP.post(this.API, data, {'Content-Type': 'multipart/form-data'}, 'PUT');
    }
}
