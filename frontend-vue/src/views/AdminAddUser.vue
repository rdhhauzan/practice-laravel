<script>
import Sidebar from "../components/Sidebar.vue";
import Swal from "sweetalert2";
import axios from "../config/apis";
export default {
  name: "AdminAddUser",
  components: {
    Sidebar,
  },
  data() {
    return {
      user: {
        name: "",
        email: "",
        password: "",
        role: "",
      },
    };
  },
  methods: {
    async addUser() {
      await axios
        .post(`/user`, this.user, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token"),
          },
        })
        .then(() => {
          Swal.fire({
            icon: "success",
            title: "Add Success",
            text: `User Add Successfully!`,
          });
          this.$router.push("/users");
        });
    },
  },
};
</script>

<template>
  <!-- eslint-disable -->
  <Sidebar />
  <div class="" style="margin-top: 58px">
    <div class="container pt-4">
      <h2>Add User</h2>
      <form @submit.prevent="addUser()">
        <div class="form-floating my-3">
          <input
            type="text"
            class="form-control rounded-top"
            name="name"
            id="name"
            required
            placeholder="Name"
            v-model="user.name"
          />
          <label for="name">Name</label>
        </div>
        <div class="form-floating my-3">
          <input
            type="text"
            class="form-control"
            name="email"
            id="email"
            required
            placeholder="10000"
            v-model="user.email"
          />
          <label for="email">Email</label>
        </div>
        <div class="form-floating my-3">
          <input
            type="password"
            class="form-control rounded-bottom"
            name="password"
            id="password"
            required
            placeholder="password"
            v-model="user.password"
          />
          <label for="password">password</label>
        </div>
        <div class="form-floating my-3">
          <select
            class="form-select"
            id="floatingSelect"
            aria-label="Floating label select example"
            name="role"
            v-model="user.role"
          >
            <option selected disabled>--- SELECT ROLE ---</option>
            <option value="admin">Admin</option>
            <option value="guest">Guest</option>
          </select>
          <label for="floatingSelect">Role</label>
        </div>
        <button class="w-100 btn btn-lg btn-danger mt-3" type="submit">
          Add user
        </button>
      </form>
    </div>
  </div>
</template>
