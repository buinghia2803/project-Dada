import { get } from 'lodash'

export class SettingAdminModel {
    constructor (data) {
        this.id = get(data, 'id', null)
        this.system_percent = get(data, 'system_percent', 1)
        this.opensea_percent = get(data, 'opensea_percent', 1)
    }
}