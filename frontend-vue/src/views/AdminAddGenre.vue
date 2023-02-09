<script>
import Sidebar from "../components/Sidebar.vue";
import Swal from "sweetalert2";
import axios from "../config/apis";
export default {
  name: "AdminAddGenre",
  components: {
    Sidebar,
  },
  data() {
    return {
      genreName: "",
    };
  },
  methods: {
    async addGenre() {
      await axios
        .post(
          `/genre`,
          { name: this.genreName },
          {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("access_token"),
            },
          }
        )
        .then(() => {
          Swal.fire({
            icon: "success",
            title: "Add Success",
            text: `Genre Add Successfully!`,
          });
          this.$router.push("/genres");
        })
        .catch((err) => {
          console.log(err);
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
      <h2>Add Genre</h2>
      <form @submit.prevent="addGenre()">
        <div class="form-floating my-3">
          <input
            type="text"
            class="form-control rounded-top"
            name="name"
            id="name"
            required
            placeholder="Name"
            v-model="genreName"
          />
          <label for="name">Genre Name</label>
        </div>
        <button class="w-100 btn btn-lg btn-danger my-3" type="submit">
          Add Genre
        </button>
      </form>
    </div>
  </div>
</template>
