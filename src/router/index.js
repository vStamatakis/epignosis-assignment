import Vue from "vue";
import VueRouter from "vue-router";
import Login from "../components/Login.vue";
import Register from "../components/Register.vue";
import Users from "../components/UsersList.vue";
import EditUsers from "../components/EditUsers.vue";
import Submission from "../components/Submission.vue";
import UserSubmissions from "../components/UserSubmissions.vue";

Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    name: "Login",
    component: Login,
  },
  {
    path: "/register",
    name: "Register",
    component: Register,
  },
  {
    path: "/users",
    name: "Users",
    component: Users,
    props: true
  },
  {
    path: "/edit-users/:id",
    name: "Edit_Users",
    component: EditUsers,
    props: true,
    params: true
  },
  {
    path: "/user_submissions",
    name: "User_Submissions",
    component: UserSubmissions
  },
  {
    path: "/submission",
    name: "Submission",
    component: Submission,
  }
];


const router = new VueRouter({
  mode:'history',
  routes,
});

export default router;
