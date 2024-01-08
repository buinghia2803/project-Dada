import Vue from 'vue'
import { ValidationObserver, ValidationProvider, extend } from 'vee-validate'

import {
  required,
  email,
  confirmed,
  regex,
  numeric
} from 'vee-validate/dist/rules'

extend('greaterThanZero', {
  ...required,
  validate(value) {
    if (value <= 0) {
      return false
    }
    return true
  },
  message: () => {
    return parent.$nuxt.$t('messages.error.required')
  }
})

extend('email', {
  ...email,
  message: () => {
    return parent.$nuxt.$t('messages.error.bad_email_format')
  }
})

extend('email_trimmed', {
  validate(value) {
    if (value) {
      // eslint-disable-next-line no-useless-escape
      const regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
      return regex.test(value.trim())
    } else {
      return false
    }
  },
  message: () => {
    return parent.$nuxt.$t('messages.error.bad_email_format')
  }
})

extend('email_trimmed_no_dash', {
    validate(value) {
        if (value) {
            // eslint-disable-next-line no-useless-escape
            const regex = /^[_a-z0-9]+(\.[_a-z0-9]+)*@[a-z0-9]+(\.[a-z0-9]+)*(\.[a-z]{2,3})$/
            return regex.test(value.trim())
        } else {
            return false
        }
    },
    message: () => {
        return parent.$nuxt.$t('messages.error.bad_email_format')
    }
})

extend('format_file', {
  validate(value) {
    if (value) {
      const regex = /^[a-zA-Z][-_\\(a-zA-Z-0-9.\\)]*\.+png|jpeg|jpg|gif/
      return regex.test(value.trim())
    } else {
      return false
    }
  },
  message: () => {
    return parent.$nuxt.$t(41516)
  }
})

extend('required', {
  ...required,
  message: name => {
    return parent.$nuxt.$t('messages.error.required', { name })
  }
})

extend('required-custom-message', {
  ...required,
  message: name => {
    return '理由は入力必須です。', { name }
  }
})

extend('requiredShort', {
  ...required,
  message: () => {
    return parent.$nuxt.$t('messages.error.shortRequired')
  }
})

extend('confirmed', {
  ...confirmed,
  message: name => {
    return parent.$nuxt.$t('messages.error.unmatch_confirmation_email', { name })
  }
})

extend('regex', {
  ...regex,
  message: () => {
    return parent.$nuxt.$t('messages.error.invalid_format')
  }
})

extend('numeric', {
  ...numeric,
  message: () => {
    return parent.$nuxt.$t('messages.error.numeric')
  }
})

extend('numeric_trimmed', {
  validate(value) {
    if (value) {
      const regex = /^([0-9\uFF10-\uFF19]+)$/
      return regex.test(value.trim())
    } else {
      return false
    }
  },
  message: () => {
    return parent.$nuxt.$t('messages.error.numeric')
  }
})

extend('moreThan', {
  params: ['target', 'name'],
  validate(value, { target }) {
    return +value >= +target
  },
  message: (name, { target }) => {
    return parent.$nuxt.$t('messages.error.more_than', { name, target })
  }
})

extend('lessThan', {
  params: ['target', 'name'],
  validate(value, { target }) {
    return +value <= +target
  },
  message: (name, { target }) => {
    return parent.$nuxt.$t('messages.error.less_than', { name, target })
  }
})

extend('dateRange', {
  params: ['target'],
  validate(value, { target }) {
    return target && value ? (target >= value) : true
  },
  message: (name, { target }) => {
    return parent.$nuxt.$t('messages.error.date_before', { name, target })
  }
})

extend('dateFromTo', {
  params: ['target'],
  validate(value, { target }) {
    return target && value ? (target <= value) : true
  },
  message: (name, { target }) => {
    return parent.$nuxt.$t('messages.error.date_after', { name, target })
  }
})

/**
 * Validate range of number
 */
extend('fieldRange', {
  params: ['range'],
  validate(value, { range }) {
    if (value.length && range) {
      if (range > value.trim().length || range < value.trim().length) {
        return false
      } else {
        return true
      }
    }
  },

  message: (name, { range }) => {
    return parent.$nuxt.$t('messages.error.invalid_range', { name, range })
  }
})

extend('temperature', {
  validate(value) {
    const regex = /^\d+(\.\d{1,1})?$/gim

    if (value && typeof value === 'number') {
      return Number(value) <= 42 && Number(value) >= 35
    } else if (value && regex.test(value.trim())) {
      return Number(value) <= 42 && Number(value) >= 35
    } else {
      return false
    }
  },
  message: name => {
    return parent.$nuxt.$t('messages.error.min_max', { name, min: '35°C', max: '42°C' })
  }
})

/**
 * Validate image
 */
extend('image', {
  validate(value) {
    if (value && value.length && value[0].type.match(/(jpg|jpeg|png|gif)$/)) {
      return true
    }
    return false
  },
  message: name => {
    return parent.$nuxt.$t('messages.error.invalid_image'), { name }
  }
})

/**
 * Validate max min
 */
extend('minmax', {
  validate(value, { min, max }) {
    if (value) {
      return value.trim().length >= min && value.trim().length <= max
    } else {
      return false
    }
  },
  message: (name, { min, max }) => {
    return parent.$nuxt.$t('messages.error.min_max', { name, min, max })
  },
  params: ['min', 'max']
})

/**
 * Validate min
 */
extend('min', {
  validate(value, { min }) {
    return value.length >= min
  },
  message: (name, { min }) => {
    return parent.$nuxt.$t('messages.error.min', { name, min })
  },
  params: ['min']
})

extend('max', {
    validate(value, { max }) {
        return value.length <= max
    },
    message: (name, { max }) => {
        return parent.$nuxt.$t('messages.error.max', { max })
    },
    params: ['max']
})

/**
 * Validate max length
 */
extend('maxlength', {
    validate(value, { max }) {
        return value.length <= max
    },
    message: (name, { max }) => {
        return parent.$nuxt.$t('messages.error.max_length')
    },
    params: ['max']
})

/**
 * Validate color code
 */
extend('color-hex', {
  validate(value) {
    const regex = /^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/gim
    return regex.test(value.trim())
  },
  message: () => {
    return parent.$nuxt.$t('messages.error.color_hex')
  }
})

extend('password', {
  params: ['target'],
  validate(value, { target }) {
      return value === target
  },
  message: () => {
    return parent.$nuxt.$t('messages.error.unmatch_password')
  }
})

/**
 * Validate phone number
 *
 */
extend('fullNumber', {
  validate(value) {
    if (value) {
      // eslint-disable-next-line no-useless-escape
      const regex = /^\d{10}$|^\d{11}|^[0-9０-９]+$/
      return regex.test(value.trim())
    } else {
      return false
    }
  },
  message: () => {
    return parent.$nuxt.$t('messages.error.numeric')
  }
})

extend('validatePassword', {
    validate(value) {
        if (value) {
            const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\d)[A-Za-z\d]{8,32}$/
            return regex.test(value.trim())
        } else {
            return false
        }
    },
    message: () => {
        return parent.$nuxt.$t('messages.error.validate_password')
    }
})

extend('validateWalletAddress', {
    validate(value) {
        if (value) {
            const regex = /^[a-zA-Z0-9]*$/
            return regex.test(value.trim())
        } else {
            return false
        }
    },
    message: () => {
        return parent.$nuxt.$t('messages.error.invalid_format')
    }
})

extend('validateFormatImage', {
    validate(value) {
    },
    message: () => {
        return parent.$nuxt.$t('messages.error.invalid_image')
    }
})

/**
 * Validate url
 */
extend('url', {
  validate(value) {
    const regex = /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\\-\\-.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/
    return regex.test(value.trim())
  },
  message: () => {
    return parent.$nuxt.$t('messages.error.invalid_url')
  }
})

/**
 * Validate url
 */
extend('url_youtube', {
  validate(value) {
    return value.match(/(http:|https:)?(\/\/)?(www\.)?(youtube.com|youtu.be)\/(watch|embed)?(\?v=|\/)?(\S+)?/)
  },
  message: () => {
    return parent.$nuxt.$t('messages.error.invalid_url_youtube')
  }
})

/**
 * Validate account ID
 */
extend('accountId', {
  validate(value) {
    const regex = /^[A-z]{3}[0-9]{4}$/
    return regex.test(value.trim())
  },
  message: () => {
    return parent.$nuxt.$t('messages.error.invalid_account')
  }
})

extend('selling_price', {
    validate(value) {
        if (value == 0) {
            return;
        }
        if (value.indexOf('.') == -1) {
            const regexNumber = /^\d+$/;
            return regexNumber.test(value.trim());
        }
        let newValue = value;
        if (value.indexOf('.') != 0 && value.lastIndexOf('.') != value.length) {
            newValue = value.replace('.','');
        }
        const regexNumber = /^\d+$/;
        if (regexNumber.test(newValue.trim())) {
            let array = value.split('.');
            if (array.length === 2) {
                return array[1].length <= 5;
            }
        }
        return false;
    },
    message: () => {
        return parent.$nuxt.$t('messages.error.selling_price')
    }
})

extend('isPercent',{
    validate(value) {
        if (value >= 0 && value <= 100) {
            if (value.indexOf('.') == -1) {
                const regexNumber = /^\d+$/;
                return regexNumber.test(value.trim());
            }
            let newValue = value;
            if (value.indexOf('.') != 0 && value.lastIndexOf('.') != value.length) {
                newValue = value.replace('.','');
            }
            const regexNumber = /^\d+$/;
            if (regexNumber.test(newValue.trim())) {
                let array = value.split('.');
                if (array.length === 2) {
                    return array[1].length <= 2;
                }
            }
        }
        return false;
    },
    message: () => {
        return parent.$nuxt.$t('messages.error.percent')
    }
})
Vue.component('ValidationObserver', ValidationObserver)
Vue.component('ValidationProvider', ValidationProvider)

export default (context, inject) => {
  inject('validator', ValidationProvider)
}
