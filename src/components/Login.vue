<template>
  <div class="page">
    <div class="login-container">
      <h1 class="welcome-title">Welcome to Epignosis!</h1>

      <form class="login-form" method="post" @submit.prevent="loginUser()">
        <input
          type="email"
          name="email"
          placeholder="Email"
          v-model="email"
          required
        />
        <input
          type="password"
          name="pass"
          placeholder="Password"
          v-model="pass"
          required
        />
        <router-link to="/register">
          <span class="register">Don't have an account? Register now!</span>
        </router-link>
        <input type="submit" name="login_user" v-model="SignIn" />
      </form>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import router from "@/router";
Vue.use(VueAxios, axios);
export default {
  name: "Login",

  data() {
    return {
      SignIn: "SignIn",
      email: "",
      pass: "",
    };
  },

  methods: {
    loginUser() {
      const form = new FormData();
      form.append("SignIn", this.SignIn);
      form.append("email", this.email);
      form.append("pass", this.pass);
      axios
        .post("http://localhost/forms/login.php", form, {
          withCredentials: true,
        })
        .then(response =>  {
          if(response.data.type == 'success' && response.data.user_type == 1){
            router.push({ path: "/users" });
          }
          if(response.data.type == 'success' && response.data.user_type == 0){
            router.push({ path: "/user_submissions" });
          }
          if(response.data.type == 'error'){
            alert("Something is wrong. Please try again")
          }
        });
    },
  },
};
</script>

<style scoped>
.page {
  padding: 0;
  margin: 0;
  width: 100%;
  min-height: 100%;
}

a {
  color: #7979e3 !important;
}

a:hover {
  text-decoration: underline;
}

.login-container {
  max-width: 400px;
  background-color: rgb(190, 187, 223);
  padding: 20px 30px;
  border-radius: 5px;
  margin: auto;
  text-align: center;
  box-shadow: 0 16px 24px 20px rgba(0, 0, 0, 0.2);
  position: relative;
  align-items: center;
}

.login-title {
  font-size: 24px;
  padding: 20px;
  color: #2c2c2c;
}

.register {
  color: #696969;
  margin-top: 10px;
  font-size: 15px;
  text-decoration: none;
}

.register:hover {
  color: #ce8080;
  margin-top: 10px;
  font-size: 15px;
  text-decoration: none;
}

.login-forgot:hover {
  text-decoration: underline;
}

.login-form input,
.login-create {
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 3px;
  width: 90%;
  margin: 10px 0;
  font-size: 14px;
}

.login-form input:focus {
  box-shadow: 0 0 5px 2px #b1c9f9;
}

.login-form input[type="submit"],
.login-create {
  max-width: 250px;
  margin-top: 20px;
  padding: 13px 10px;
  cursor: pointer;
}

.login-form input[type="submit"] {
  background-color: #f55c5c;
  color: #fff;
  font-weight: bold;
  font-size: 14px;
}

.login-create {
  margin-top: 0;
  background-color: #f2f2f2;
  color: #444;
  border: 1px solid #ccc;
}
</style>