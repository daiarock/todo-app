import http from '../services/http'

export default {
  debug: true,
  state: {
    user: {},
    authenticated: false,
  },

  login (email, password, successCb = null, errorCb = null) {
    var login_param = {email: email, password: password}
    http.post('authenticate', login_param, res => {
      this.state.user = res.data.user
      this.state.authenticated = true
      successCb()
    }, error => {
      errorCb()
    })
  },

  setCurrentUser () {
    http.get('me', res => {
      this.state.user = res.data.user
      this.state.authenticated = true
    })
  },

  // To log out, we just need to remove the token
  logout (successCb = null, errorCb = null) {
    http.get('logout', () => {
      localStorage.removeItem('jwt-token')
      this.state.authenticated = false
      successCb()
    }, errorCb)
  },

  /**
   * Init the store.
   */
  init () {
    this.setCurrentUser()
  }
}