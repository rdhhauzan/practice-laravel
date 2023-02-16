<script>
import $ from "jquery";
import "datatables.net";
import axios from "../config/apis";
import Sidebar from "../components/Sidebar.vue";
import Swal from "sweetalert2";
export default {
  name: "AdminShowGenres",
  components: {
    Sidebar,
  },
  data() {
    return {
      isLoading: false,
      genres: [],
      genre: {
        id: 0,
        name: "",
      },
    };
  },
  methods: {
    async fetchGenres() {
      try {
        this.isLoading = true;
        let { data } = await axios.get(`/genres`, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token"),
          },
        });
        console.log(data);
        this.genres = data;
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
          data: this.genres,
          columns: [
            { data: "id" },
            { data: "name" },
            {
              targets: "no-sort",
              orderable: false,
              data: null,
              render: function (data, type, row) {
                return `<button
                    type="button"
                    class="btn btn-outline-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#exampleModal"
                    data-id="${row.id}"
                  >
                    Edit
                  </button>
                  <a
                    href="#"
                    class="btn btn-outline-danger"
                    data-id="${row.id}"
                    >Delete</a
                  >
                  `;
              },
            },
          ],
        });
        // Event Listener for custom button
        $("#mytable").on("click", ".btn-outline-primary", (event) => {
          const id = $(event.currentTarget).data("id");
          this.showGenreDetail(id);
        });
        $("#mytable").on("click", ".btn-outline-danger", (event) => {
          const id = $(event.currentTarget).data("id");
          this.deleteGenre(id);
        });
      });
    },

    async showGenreDetail(id) {
      try {
        this.isLoading = true;
        let { data } = await axios.get(`/genre/update/${id}`, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token"),
          },
        });
        // console.log(data[0].name);
        this.genre.id = data[0].id;
        this.genre.name = data[0].name;
      } catch (error) {
        console.log(error);
      } finally {
        this.isLoading = false;
      }
    },

    submitUpdate() {
      axios
        .post(
          `/genre/update/${this.genre.id}`,
          { name: this.genre.name },
          {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("access_token"),
            },
          }
        )
        .then(() => {
          Swal.fire({
            icon: "success",
            title: "Update Success",
            text: `Genre Update Successfully!`,
          });
          this.fetchGenres();
          this.$router.push("/genres");
          document.getElementById("close").click();
        })
        .catch((err) => {
          console.log(err);
        });
    },

    async deleteGenre(id) {
      await axios
        .get(`/genre/delete/${id}`, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token"),
          },
        })
        .then(() => {
          Swal.fire({
            icon: "success",
            title: "Delete Success",
            text: `Genre Delete Successfully!`,
          });
          this.fetchGenres();
          this.$router.push("/genres");
        });
    },
  },
  beforeMount() {
    this.fetchGenres();
  },
};
</script>

<template>
  <!-- eslint-disable -->
  <Sidebar />

  <div class="" style="margin-top: 58px">
    <div class="container pt-4">
      <h2>Genre List</h2>
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
        <div class="" v-if="genres.length > 0">
          <table
            class="table table-bordered table-hover"
            border="1"
            id="mytable"
          >
            <thead>
              <tr>
                <th scope="col">No.</th>
                <th scope="col">Genre Name</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(genre, index) in genres">
                <th scope="row">{{ index + 1 }}</th>
                <td>{{ genre.name }}</td>

                <td>
                  <!-- <button
                    type="button"
                    class="btn btn-outline-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#exampleModal"
                    @click.prevent="showGenreDetail(genre.id)"
                  >
                    Edit
                  </button> -->
                  <!-- <a
                    href="#"
                    class="btn btn-outline-danger"
                    @click.prevent="deleteGenre(genre.id)"
                    >Delete</a
                  > -->
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <h3 v-if="genres.length < 1">No Data Found!</h3>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div
    class="modal fade"
    id="exampleModal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Genre</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
            id="close"
          ></button>
        </div>
        <div class="modal-body">
          <div class="" v-if="!isLoading">
            <form @submit.prevent="submitUpdate()">
              <div class="form-floating my-3">
                <input
                  type="text"
                  class="form-control rounded-top"
                  name="name"
                  id="name"
                  required
                  placeholder="Name"
                  v-model="genre.name"
                />
                <label for="name">Genre Name</label>
              </div>
              <button class="w-100 btn btn-lg btn-danger my-3" type="submit">
                Edit Genre
              </button>
            </form>
          </div>
          <div class="d-flex justify-content-center" v-if="isLoading">
            <div
              class="spinner-border"
              role="status"
              style="width: 5rem; height: 5rem"
            >
              <span class="visually-hidden">Loading...</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Modal -->
</template>
