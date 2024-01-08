import BaseService from '@/services/BaseService'
import http from '@/utils/http'

const HTTP = new http()

export class MailTemplateService extends BaseService {
    API = '/admin/mail-template'
    API_MAIL_TYPE = '/admin/mail-template/get-mail-template-by-type'

    getMailTemplateByType(params) {
        return HTTP.get(this.API_MAIL_TYPE, params)
    }
}
