<script>
import $ from "jquery";
import "datatables.net";
import axios from "../config/apis";
import Sidebar from "../components/Sidebar.vue";
import Swal from "sweetalert2";
export default {
  name: "AdminShowUsers",
  components: {
    Sidebar,
  },
  data() {
    return {
      users: [],
      isLoading: false,
    };
  },
  methods: {
    async fetchUsers() {
      try {
        this.isLoading = true;
        let { data } = await axios.get(`/users`, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token"),
          },
        });
        this.users = data.users;
        console.log(this.users);
        console.log(this.users.length);
        this.initDataTable();
      } catch (error) {
        console.log(error);
      } finally {
        this.isLoading = false;
      }
    },

    initDataTable() {
      $(document).ready(() => {
        $("#mytable").dataTable({
          data: this.users,
          columns: [{ data: "name" }, { data: "email" }, { data: "role" }],
        });
      });
    },
  },
  beforeMount() {
    this.fetchUsers();
  },
};
</script>

<template>
  <!-- eslint-disable -->
  <Sidebar />
  <div class="" style="margin-top: 58px">
    <div class="container pt-4">
      <h2>User Lists</h2>
      <!-- Loading -->
      <div class="d-flex justify-content-center" v-if="isLoading">
        <div
          class="spinner-border"
          role="status"
          style="width: 5rem; height: 5rem"
        >
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
      <!-- End Loading -->

      <div class="" v-if="!isLoading">
        <div class="" v-if="users.length > 0">
          <table
            class="table table-bordered table-hover data-table"
            id="mytable"
          >
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(user, index) in users">
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>
                  <p v-if="user.role == 'admin'">Admin</p>
                  <p v-if="user.role == 'guest'">Guest</p>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <h2 v-if="users.length < 1">No Data Found</h2>
      </div>
    </div>
  </div>
</template>
