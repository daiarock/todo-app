<template>
  <div class="row">
    <div class="col-md-4 col-md-offset-4">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Please sign in</h3>
        </div>
        <div class="panel-body">
          <form accept-charset="UTF-8" role="form" onsubmit="return false;">
            <div class="alert alert-danger" role="alert" v-if="showAlert">
                {{ alertMessage }}
              </div>
            <fieldset>
              <div class="form-group">
                <input id="email" type="email" class="form-control" placeholder="E-mail"
                         v-model="email" @keyup.enter="login" required autofocus>
              </div>
              <div class="form-group">
                <input id="password" type="password" class="form-control" placeholder="Password"
                         v-model="password" @keyup.enter="login" required autofocus>
              </div>
              <!-- <div class="checkbox">
                <label>
                  <input name="remember" type="checkbox" value="Remember Me"> Remember Me
                </label>
              </div> -->
              <input @click="login" class="btn btn-lg btn-success btn-block" type="submit" value="Login">
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import userStore from '../stores/userStore'
  import http from '../services/http'

  export default {
    data() {
      return {
        email: '',
        password: '',
        showAlert: false,
        alertMessage: '',
      }
    },
    methods: {
      login () {
        userStore.login(this.email, this.password, res => {
          this.$router.push('/')
        }, error => {
          this.showAlert = true
          this.alertMessage = 'Wrong email or password.'
        })
      },
    }
  }
</script>