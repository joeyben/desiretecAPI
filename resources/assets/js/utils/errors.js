// eslint-disable-next-line
export class  Errors {
  constructor () {
    this.errors = {}
  }
  get (field) {
    if (this.errors[field]) {
      return this.errors[field][0]
    }
  }
  getWithMutator (field, mutator) {
    if (this.errors[field]) {
      return this.errors[field][0].replace(field, mutator)
    }
  }
  clear (field) {
    if (this.errors !== undefined && this.errors[field]) delete this.errors[field]
  }
  drop () {
    this.errors = {}
  }
  has (field) {
    return this.errors.hasOwnProperty(field)
  }
  first (field) {
    if (this.errors[field]) {
      return this.errors[field]
    }
  }
  any () {
    return Object.keys(this.errors).length > 0
  }
  record (errors) {
    this.errors = errors
  }
  getErrors () {
    let msg = ''
    for (let field in this.errors) {
      msg += this.errors[field][0] + '<br/>'
    }
    return msg
  }
}
