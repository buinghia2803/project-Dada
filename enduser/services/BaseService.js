import Http from '@/utils/http'
const HTTP = new Http();

export const ApiEndpoint = process.env.VUE_APP_URL_API

export default class BaseService {
  API = null

  getAll(data) {
    return HTTP.get(this.API, data);
  }

  show(data) {
    return HTTP.show(this.API, data);
  }

  update(data) {
    return HTTP.put(this.API, data);
  }

  add(data) {
    return HTTP.post(this.API, data);
  }

  delete(data) {
    return HTTP.delete(this.API, data);
  }
}