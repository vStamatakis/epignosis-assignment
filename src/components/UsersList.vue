<template>
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">List of users</div>
        <div class="panel-body">
          <table class="table">
            <thead>
              <tr>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Email</th>
                <th>User Type</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(user, index) in users" :key="index">
                <td>{{ user.fname }}</td>
                <td>{{ user.lname }}</td>
                <td>{{ user.email }}</td>
                <td v-if="user.user_type == '1'">Admin</td>
                <td v-if="user.user_type == '0'">Employee</td>
                <td>
                  <button class="edit-button">
                    <router-link
                      class="router-link"
                      :to="{ path: `/edit-users/${user.id}` }"
                      :users="users"
                      >Edit</router-link
                    >
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
Vue.use(VueAxios, axios);
export default {
  name: "Users",

  data() {
    return {
      users: [],
    };
  },

  methods: {
    getUsers() {
      axios
        .get("http://localhost/forms/getusers.php", {
          withCredentials: true,
        })
        .then((response) => (this.users = response.data))
        .catch((error) => console.log(error.message));
    },
  },

  created() {
    this.getUsers();
  },
};
</script>

<style>
.panel-heading {
  text-align: center;
  font-size: 35px;
  font-weight: 600;
}

.table {
  text-align: center;
  align-items: center;
  margin: auto;
  padding-top: 15px;
}

tr th {
  font-size: 18px;
  padding-bottom: 10px;
}

.router-link {
  text-decoration: none;
}

tbody td {
  padding: 30px;
}

tbody tr:nth-child(odd) {
  background-color: #da6363;
  color: #fff;
}
</style>