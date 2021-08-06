<template>
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <router-link to="/submission" class="submit">
          <input type="submit" value="Submit Request" />
        </router-link>
        <div class="panel-heading">List of Submissions</div>

        <div class="panel-body">
          <table class="table">
            <thead>
              <tr>
                <th>Date Submitted</th>
                <th>Vacation Start</th>
                <th>Vacation End</th>
                <th>Days Requested</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(submission, index) in submissions" :key="index">
                <td>{{ submission.date_submitted }}</td>
                <td>{{ submission.vacation_start }}</td>
                <td>{{ submission.vacation_end }}</td>
                <td>{{ submission.days_requested }}</td>
                <td>{{ submission.status }}</td>
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
  name: "User_Submissions",

  data() {
    return {
      submissions: [],
    };
  },

  methods: {
    getUsers() {
      axios
        .get("http://localhost/forms/get_user_submissions.php", {
          withCredentials: true,
        })
        .then((response) => (this.submissions = response.data))
        .catch((error) => console.log(error.message));
    },
  },

  created() {
    this.getUsers();
  },
};
</script>

<style>
input[type="submit"] {
  background-color: #3a8049;
  color: #fff;
  font-weight: bold;
  font-size: 14px;
  padding: 5px;
}

.submit {
  position: absolute;
  top: 3;
  right: 0;
  padding-right: 20px;
  padding-top: 5px;
}
</style>