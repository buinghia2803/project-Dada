import Http from '@/utils/http'
const HTTP = new Http();
import BaseService from '@/services/BaseService'

export class PaymentService extends BaseService {
    API = '/admin/payment'

    update(data) {
        return HTTP.post(this.API, data, { 'Content-Type': 'multipart/form-data' }, 'PUT');
    }
}
