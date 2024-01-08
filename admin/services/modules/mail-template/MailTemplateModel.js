import {get } from 'lodash'

export class MailTemplateModel {
    constructor(data) {
        this.id = get(data, 'id', null)
        this.subject = get(data, 'subject', null)
        this.content = get(data, 'content', '')
        this.type = get(data, 'type', null)
    }
}