import { get } from 'lodash'

export class NotifyModel {
    constructor (data) {
        this.id = get(data, 'id', null)
        this.title = get(data, 'title', null)
        this.content = get(data, 'content', null)
        this.type = get(data, 'type', null)
        this.date_public = get(data, 'date_public', null)
        this.status = get(data, 'status', null)
        // this.is_deleted = get(data, 'is_deleted', 0)
    }
}
