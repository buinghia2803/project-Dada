import { get } from 'lodash'

export class NotifyModel {

    constructor (data) {
        this.id = get(data, 'id', null)
        this.notification = get(data, 'notification', null)
        this.admin = get(data, 'admin', 1)
        this.user_from = get(data, 'user_from', 1)
        this.user_to = get(data, 'user_to', 1)
        this.status = get(data, 'status', 1)
    }
}
