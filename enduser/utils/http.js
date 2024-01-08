import Vue from 'vue'

export default class http {
  get(api, data, headers = {}) {
    return Vue.prototype.$http({
      method: 'get',
      url: api,
      params: data,
      headers: headers
    })
  }

  show(api, data, headers = {}) {
    return Vue.prototype.$http({
      method: 'get',
      url: `${api}/${data.id}`,
      data: data,
      headers: headers
    })
  }

  put(api, data, headers = {}) {
    return Vue.prototype.$http({
      method: 'put',
      url: `${api}/${data.id}`,
      data: data,
      headers: headers
    })
  }

    post(api, data, headers = {}, options = {}) {
        let formData;

        if (headers["Content-Type"] == 'multipart/form-data') {
            formData = new FormData;
            Object.keys(data).forEach((key) => {
                formData.append(key, data[key] ?? null)
            })
        }
        return Vue.prototype.$http({
            method: 'post',
            url: api,
            data: formData ?? data,
            headers: headers,
             ...options
        })
    }

  delete(api, data, headers = {}) {
    return Vue.prototype.$http({
      method: 'delete',
      url: `${api}/${data.id}`,
      data: data,
      headers: headers
    })
  }
}
