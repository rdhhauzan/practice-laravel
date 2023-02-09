<script>
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
        let { data } = await axios.get(`/users`)
      } catch (error) {}
    },
  },
};
</script>

<template>
  <!-- eslint-disable -->
  <Sidebar />
  <div class="" style="margin-top: 58px">
    <div class="container pt-4">
      <h2>User Lists</h2>
    </div>
  </div>
</template>
