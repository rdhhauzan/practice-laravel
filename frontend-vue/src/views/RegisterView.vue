<script>
import axios from "../config/apis";
import Swal from "sweetalert2";
export default {
  name: "RegisterView",
  data() {
    return {
      user: {
        name: "",
        email: "",
        password: "",
      },
    };
  },
  methods: {
    async submitForm() {
      try {
        await axios.post(`/register`, {
          name: this.user.name,
          email: this.user.email,
          password: this.user.password,
        });

        Swal.fire({
          icon: "success",
          title: "Register Success",
          text: `Register Success, Please login`,
        });
        this.$router.push("/login");
      } catch (error) {
        Swal.fire({
          icon: "error",
          title: "Register Failed",
          text: error.response.data,
        });
        console.log(error);
      }
    },
  },
};
</script>

<template>
  <div class="row justify-content-center" style="margin-top: 150px">
    <div class="col-lg-6">
      <main class="form-registration">
        <h1 class="h3 mb-3 fw-normal text-center">Register</h1>
        <form @submit.prevent="submitForm">
          <div class="form-floating">
            <input
              type="text"
              class="form-control"
              name="email"
              id="email"
              required
              v-model="user.name"
            />
            <label for="email">Name</label>
          </div>
          <div class="form-floating">
            <input
              type="email"
              class="form-control"
              name="email"
              id="email"
              required
              placeholder="name@example.com"
              v-model="user.email"
            />
            <label for="email">Email address</label>
          </div>
          <div class="form-floating">
            <input
              type="password"
              class="form-control rounded-bottom"
              name="password"
              id="password"
              required
              placeholder="Password"
              v-model="user.password"
            />
            <label for="email">Password</label>
          </div>

          <button class="w-100 btn btn-lg btn-danger mt-3" type="submit">
            Register
          </button>
        </form>
        <small class="d-block mt-3"
          >Already have account?
          <a class="text-danger" href="/login"> Login Now!</a></small
        >
      </main>
    </div>
  </div>
</template>
