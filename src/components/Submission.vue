<template>
  <div class="page">
    <div class="login-container">
      <h1 class="welcome-title">Submit Form</h1>

      <form class="login-form" method="post" @submit.prevent="request()">
        <Datepicker
          placeholder="Date From"
          class="date"
          name="from"
          :format="customFormatterFrom"
          v-model="from"
          required
        ></Datepicker>
        <Datepicker
          placeholder="Date Until"
          class="date"
          name="until"
          :format="customFormatterUntil"
          v-model="until"
          required
        ></Datepicker>
        <textarea
          name="reason"
          placeholder="Type the reason..."
          v-model="reason"
          required
        />
        <input type="submit" name="submit" v-model="Submit" />
      </form>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import Datepicker from "vuejs-datepicker";
import router from "@/router";
import moment from "moment";
Vue.use(VueAxios, axios);
export default {
  name: "Submission",
  components: {
    Datepicker,
  },

  data() {
    return {
      Submit: "submit",
      from: "",
      until: "",
      reason: "",
      dateSubmitted: "",
    };
  },

  methods: {
    request() {
      this.dateSubmitted = new Date().toLocaleDateString();
      const form = new FormData();
      form.append("from", this.from);
      form.append("dateSubmitted", this.dateSubmitted);
      form.append("until", this.until);
      form.append("reason", this.reason);
      form.append("submit", this.Submit);
      axios
        .post("http://localhost/forms/submit_form.php", form, {
          withCredentials: true,
        })
        .then(response =>  {
          if(response.data.type == 'success'){
            router.push({ path: "/user_submissions" });
          }
          else{
            alert("Something is wrong. Try again");
          }
        });
    },

    customFormatterFrom(date) {
      return (this.from = moment(date).format("YYYY-MM-DD"));
    },
    customFormatterUntil(date) {
      return (this.until = moment(date).format("YYYY-MM-DD"));
    },
  },
};
</script>

<style scoped>
.date {
  text-align: center;
}

a {
  color: #7979e3 !important;
}

a:hover {
  text-decoration: underline;
}

.login-container {
  max-width: 400px;
  background-color: rgb(238, 220, 220);
  padding: 20px 30px;
  border-radius: 5px;
  margin: auto;
  text-align: center;
  box-shadow: 0 16px 24px 20px rgba(0, 0, 0, 0.2);
  position: relative;
  align-items: center;
  /* margin-top: 50px; */
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

textarea {
  width: 100%;
  max-width: 500px;
  box-sizing: border-box;
  border: 1px solid #ccc;
  padding: 10px;
  margin-top: 15px;
  border-radius: 5px;
  margin-bottom: 20px;
  resize: none;
  height: 100px;
}
</style>