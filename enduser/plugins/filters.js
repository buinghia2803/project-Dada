import Vue from 'vue'

import moment from "moment";

/**
 * date format
 * @param {Date} date
 * @param {String} format
 * @return {String} formatted date
 */
 const formatDate = (date, format = 'YYYY.MM.DD') => {
    const dateObj = moment(date)

    return dateObj.isValid() ? dateObj.format(format) : ''
  }


const filters = {
    formatDate
}

for (const propName of Object.getOwnPropertyNames(filters)) {
  if (filters[propName] instanceof Function) {
    Vue.filter(propName, filters[propName])
  }
}

