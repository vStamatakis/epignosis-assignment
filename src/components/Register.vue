<template>
  <div class="login-container">
    <div class="form-container">
      <div class="title" ref="title">Register</div>
      <form class="login-form" method="post" @submit.prevent="register()">
        <div>
          <input
            name="fname"
            placeholder="First Name"
            v-model="fname"
            required
          />
          <input name="lname" placeholder="Last Name" v-model="lname" />
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
          <input
            type="password"
            name="passConfirm"
            placeholder="Confirm Password"
            v-model="passConfirm"
            required
          />
          <div class="miniform-title">User type</div>
          <select
            class="user-type full-width"
            name="user_type"
            v-model="user_type"
            required
          >
            <option value="employee">Employee</option>
            <option value="admin">Admin</option>
          </select>
        </div>
        <input type="submit" name="submit" v-model="create" />
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
  name: "Register",

  data() {
    return {
      fname: "",
      lname: "",
      email: "",
      pass: "",
      passConfirm: "",
      create: "create",
      user_type: "",
    };
  },

  methods: {
    register() {
      if (this.pass != this.passConfirm) {
        return;
      }

      const form = new FormData();
      form.append("create", this.create);
      form.append("fname", this.fname);
      form.append("lname", this.lname);
      form.append("email", this.email);
      form.append("pass", this.pass);
      form.append("passConfirm", this.passConfirm);
      form.append("user_type", this.user_type);
      axios.post("http://localhost/forms/register.php", form).then(() => {
        this.fname = "";
        this.lname = "";
        this.email = "";
        this.pass = "";
        this.passConfirm = "";
        router.push({ path: "/" });
      });
    },
  },
};
</script>

<style>
.title {
  padding: 10px;
}

a {
  color: #7979e3 !important;
}

.login-container {
  max-width: 400px;
  background-color: #fff;
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

.login-forgot {
  color: #696969;
  margin-top: 10px;
  font-size: 15px;
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