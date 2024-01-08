import { get } from 'lodash'

export class SettingUserModel {
    constructor (data) {
        this.id = get(data, 'id', null)
        this.user_id = get(data, 'user_id', null)
        this.contract_notify = get(data, 'contract_notify', 1)
        this.system_notify = get(data, 'system_notify', 1)
    }
}