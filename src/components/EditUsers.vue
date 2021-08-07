<template>
  <div class="login-container">
    <div class="form-container">
      <div class="title" ref="title">Edit User</div>
      <form class="login-form" method="post" @submit.prevent="update()">
        <div class="box">
          <input
            name="fname"
            placeholder="First Name"
            v-model="user.fname"
            required
          />
          <input
            name="lname"
            placeholder="Last Name"
            v-model="user.lname"
            required
          />
          <input
            type="email"
            name="email"
            placeholder="Email"
            v-model="user.email"
            required
          />
          <input
            type="password"
            name="pass"
            placeholder="Password"
            v-model="user.pass"
            disabled
          />
          <input
            type="password"
            name="passConfirm"
            placeholder="Confirm Password"
            v-model="user.passConfirm"
            disabled
          />
          <div class="miniform-title">User type</div>
          <select
            class="user-type full-width"
            name="user_type"
            v-model="user.user_type"
            required
          >
            <option value="admin">Admin</option>
            <option value="employee">Employee</option>
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
  name: "Edit_Users",
  props: ["users"],
  data() {
    return {
      id: this.$route.params.id,
      create: "Update",
      user: {
        fname: "",
        lname: "",
        email: "",
        pass: "",
        passConfirm: "",
        user_type: "",
      },
    };
  },

  methods: {
    update() {
      const form = new FormData();
      form.append("Update", this.create);
      form.append("id", this.id);
      form.append("fname", this.user.fname);
      form.append("lname", this.user.lname);
      form.append("email", this.user.email);
      form.append("user_type", this.user.user_type);
      axios
        .post("http://localhost/forms/update_user.php", form, {
          withCredentials: true,
        })
        .then(response =>  {
          if(response.data.type == 'success'){
            router.push({ path: "/users" });
          }
          else{
            alert("Something is wrong.");
          }
        });
    },

    getUserId() {
      const forms = new FormData();
      forms.append("id", this.id);
      axios
        .post("http://localhost/forms/get_user_id.php", forms, {
          withCredentials: true,
        })
        .then((response) => (this.user = response.data))
        .catch((error) => console.log(error.message));
    },
  },

  created() {
    this.getUserId();
  },
};
</script>

<style>
a {
  color: #7979e3 !important;
}

a:hover {
  text-decoration: underline;
}

.login-container {
  max-width: 400px;
  background-color: rgb(188, 221, 206);
  padding: 20px 30px;
  border-radius: 5px;
  margin: auto;
  text-align: center;
  box-shadow: 0 16px 24px 20px rgba(0, 0, 0, 0.2);
  position: relative;
  align-items: center;
  /* margin-top: 50px; */
}

.title {
  text-align: center;
  font-size: 28px;
  font-weight: 600;
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
  background-color: #3e9c32;
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