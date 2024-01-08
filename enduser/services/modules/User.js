import { get } from "lodash";
import BaseService from "../BaseService";

export class User extends BaseService {
    API = "/user";
    constructor(data) {
        super();
        this.id = get(data, "id", null);
        this.first_name = get(data, "first_name", null);
        this.last_name = get(data, "last_name", null);
        this.email = get(data, "email", null);
        this.password = get(data, "password", null);
        this.organization_id = get(data, "organization_id", 0);
        this.type = get(data, "type", 3);
        this.phone = get(data, "phone", null);
        this.image = get(data, "image", null);
        this.status = get(data, "status", null);
        this.role = get(data, "role", 0);
        this.is_deleted = get(data, "is_deleted", 0);
    }
}
