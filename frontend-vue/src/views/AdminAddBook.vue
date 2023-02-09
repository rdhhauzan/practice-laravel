<script>
import Sidebar from "../components/Sidebar.vue";
import Swal from "sweetalert2";
import axios from "../config/apis";
export default {
  name: "AdminAddBook",
  components: {
    Sidebar,
  },
  data() {
    return {
      isLoading: false,
      addBook: {
        name: "",
        price: 0,
        description: "",
        genreId: 1,
      },
      iamge: "",
      genres: [],
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
        // console.log(data);
        this.genres = data;
      } catch (error) {
        console.log(error);
      } finally {
        this.isLoading = false;
      }
    },

    async submitBook() {
      let data = new FormData();
      data.append("image", this.image);
      data.append("name", this.addBook.name);
      data.append("genreId", this.addBook.genreId);
      data.append("description", this.addBook.description);
      data.append("price", this.addBook.price);

      await axios
        .post("/book", data, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token"),
          },
        })
        .then(() => {
          Swal.fire({
            icon: "success",
            title: "Add Success",
            text: `Book Add Successfully!`,
          });
          this.$router.push("/books");
        })
        .catch((err) => {
          console.log(err);
        });
    },

    onChange(e) {
      this.image = e.target.files[0];
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
  <div style="margin-top: 58px">
    <div class="container pt-4">
      <h2>Add Book</h2>
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
        <form @submit.prevent="submitBook()" enctype="multipart/form-data">
          <div class="form-floating my-3">
            <input
              type="text"
              class="form-control rounded-top"
              name="name"
              id="name"
              required
              placeholder="Name"
              v-model="addBook.name"
            />
            <label for="name">Book Name</label>
          </div>
          <div class="form-floating my-3">
            <input
              type="number"
              class="form-control"
              name="price"
              id="price"
              required
              placeholder="10000"
              v-model="addBook.price"
            />
            <label for="price">Book Price</label>
          </div>
          <div class="form-floating my-3">
            <input
              type="text"
              class="form-control rounded-bottom"
              name="description"
              id="description"
              required
              placeholder="description"
              v-model="addBook.description"
            />
            <label for="description">Description</label>
          </div>

          <div class="form-floating my-3">
            <input
              type="file"
              class="form-control rounded-bottom"
              name="image"
              id="image"
              placeholder="image"
              v-on:change="onChange"
            />
            <label for="image">Image</label>
          </div>

          <div class="form-floating">
            <select
              class="form-select"
              id="floatingSelect"
              aria-label="Floating label select example"
              name="genreId"
              v-model="addBook.genreId"
            >
              <option selected disabled>--- SELECT GENRE ---</option>
              <option :value="genre.id" v-for="(genre, index) in genres">
                {{ genre.name }}
              </option>
            </select>
            <label for="floatingSelect">Genre</label>
          </div>
          <button class="w-100 btn btn-lg btn-danger my-3" type="submit">
            Edit Book
          </button>
        </form>
      </div>
    </div>
  </div>
</template>
