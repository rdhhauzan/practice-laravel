<script>
import axios from "../config/apis";
import Sidebar from "../components/Sidebar.vue";
import Swal from "sweetalert2";
export default {
  name: "AdminShowBooks",
  components: {
    Sidebar,
  },
  data() {
    return {
      books: [],
      lastPage: 0,
      currentPage: 0,
      isLoading: false,
      search: "",
      showBook: {
        name: "",
        price: 0,
        description: "",
        genreId: 0,
        id: 0,
      },
      image: "",
      genres: [],
    };
  },
  methods: {
    async fetchBooks(page) {
      if (!page) {
        page = 1;
      }
      try {
        this.isLoading = true;
        let { data } = await axios.get(`/books?page=${page}`, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token"),
          },
        });
        console.log(data);
        this.books = data.books.data;
        this.lastPage = data.books.last_page;
        this.currentPage = data.books.current_page;
      } catch (error) {
        console.log(error);
      } finally {
        this.isLoading = false;
      }
    },

    async generatePdf() {
      try {
        this.isLoading = true;
        await axios
          .get("/books/generate-pdf", {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("access_token"),
            },
            responseType: "blob",
          })
          .then((response) => {
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement("a");
            link.href = url;
            link.setAttribute("download", "file.pdf");
            document.body.appendChild(link);
            link.click();
          });
      } catch (error) {
        console.log(error);
      } finally {
        this.isLoading = false;
      }
    },

    async generateExcel() {
      try {
        this.isLoading = true;
        await axios
          .get("/books/generate-excel", {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("access_token"),
            },
            responseType: "blob",
            onDownloadProgress: function (progressEvent) {
              console.log(
                Math.round((progressEvent.loaded * 100) / progressEvent.total) +
                  "%"
              );
            },
          })
          .then((response) => {
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement("a");
            link.href = url;
            link.setAttribute("download", "file.xlsx");
            document.body.appendChild(link);
            link.click();
          });
      } catch (error) {
        console.log(error);
      } finally {
        this.isLoading = false;
      }
    },

    async generateOneDataPdf(id) {
      console.log(id);
      try {
        this.isLoading = true;
        await axios
          .get(`/book/generate-pdf/${id}`, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("access_token"),
            },
            responseType: "blob",
          })
          .then((response) => {
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement("a");
            link.href = url;
            link.setAttribute("download", "file.pdf");
            document.body.appendChild(link);
            link.click();
          });
      } catch (error) {
        console.log(error);
      } finally {
        this.isLoading = false;
      }
    },

    async deleteBook(id) {
      await axios
        .get(`/book/delete/${id}`, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token"),
          },
        })
        .then(() => {
          this.fetchBooks();
          Swal.fire({
            icon: "success",
            title: "Delete Success",
            text: `Book Delete Successfully!`,
          });
        });
    },

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

    onChange(e) {
      this.image = e.target.files[0];
    },

    async editBook(id) {
      this.fetchGenres();
      try {
        this.isLoading = true;
        let { data } = await axios.get(`/book/update/${id}`, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token"),
          },
        });
        console.log(data[0]);
        this.showBook.description = data[0].description;
        this.showBook.genreId = data[0].genreId;
        this.showBook.name = data[0].name;
        this.showBook.price = data[0].price;
        this.showBook.id = data[0].id;
        // console.log(this.showBook[0].name, "state");
      } catch (error) {
        console.log(error);
      } finally {
        this.isLoading = false;
      }
    },

    async submitUpdateBook(id) {
      let data = new FormData();
      if (this.image == "") {
        data.append("name", this.showBook.name);
        data.append("genreId", this.showBook.genreId);
        data.append("description", this.showBook.description);
        data.append("price", this.showBook.price);
      } else {
        data.append("image", this.image);
        data.append("name", this.showBook.name);
        data.append("genreId", this.showBook.genreId);
        data.append("description", this.showBook.description);
        data.append("price", this.showBook.price);
      }

      await axios
        .post(`/book/update/${id}`, data, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token"),
          },
        })
        .then(() => {
          Swal.fire({
            icon: "success",
            title: "Update Success",
            text: `Book Update Successfully!`,
          });
          this.fetchBooks();
          this.$router.push("/books");
          document.getElementById("close").click();
        })
        .catch((err) => {
          console.log(err);
        });
    },

    async searchBooks(page) {
      if (!page) {
        page = 1;
      }
      try {
        this.isLoading = true;
        let { data } = await axios.get(
          `/books/search?page=${page}&name=${this.search}`,
          {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("access_token"),
            },
          }
        );
        this.books = data.books.data;
        this.lastPage = data.books.last_page;
        this.currentPage = data.books.current_page;
      } catch (error) {
        console.log(error);
      } finally {
        this.isLoading = false;
      }
    },
  },
  beforeMount() {
    this.fetchBooks();
  },
};
</script>

<template>
  <!-- eslint-disable -->
  <Sidebar />
  <div style="margin-top: 58px">
    <div class="container pt-4">
      <h2>Book List</h2>
      <form @submit.prevent="searchBooks()">
        <div class="input-group mb-3 w-25">
          <input
            type="text"
            placeholder="Enter Book name..."
            class="form-control"
            v-model="search"
          />
          <button type="submit" class="btn btn-outline-secondary">
            Search
          </button>
        </div>
      </form>
      <div class="my-3">
        <a class="btn btn-outline-primary" @click.prevent="generatePdf()"
          >Generate PDF</a
        >
        <a class="btn btn-outline-primary" @click.prevent="generateExcel()"
          >Generate Excel</a
        >
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
              <h5 class="modal-title" id="exampleModalLabel">Edit Book</h5>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
                id="close"
              ></button>
            </div>
            <div class="modal-body">
              <form
                @submit.prevent="submitUpdateBook(showBook.id)"
                enctype="multipart/form-data"
              >
                <div class="form-floating my-3">
                  <input
                    type="text"
                    class="form-control rounded-top"
                    name="name"
                    id="name"
                    required
                    placeholder="Name"
                    v-model="showBook.name"
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
                    v-model="showBook.price"
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
                    v-model="showBook.description"
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
                    v-model="showBook.genreId"
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
      </div>
      <!-- End Modal -->
      <div class="d-flex justify-content-center" v-if="isLoading">
        <div
          class="spinner-border"
          role="status"
          style="width: 5rem; height: 5rem"
        >
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>

      <div class="" v-if="!isLoading">
        <table class="table table-bordered table-hover data-table" border="1">
          <thead>
            <tr>
              <th scope="col">No.</th>
              <th scope="col">Book Name</th>
              <th scope="col">Book Price</th>
              <th scope="col">Description</th>
              <th scope="col">Genre</th>
              <th scope="col">Image</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(book, index) in books">
              <th scope="row">{{ index + 1 }}</th>
              <td>{{ book.bookName }}</td>
              <td>{{ book.price }}</td>
              <td>{{ book.description }}</td>
              <td>{{ book.name }}</td>
              <td align="center">
                <img
                  :src="`http://127.0.0.1:8000/images/${book.image}`"
                  alt="img"
                  style="width: 180px; height: 100px"
                />
              </td>
              <td>
                <a
                  href="#"
                  class="btn btn-outline-primary"
                  @click.prevent="generateOneDataPdf(book.bookId)"
                  >Generate PDF</a
                >
                <button
                  type="button"
                  class="btn btn-outline-primary"
                  data-bs-toggle="modal"
                  data-bs-target="#exampleModal"
                  @click.prevent="editBook(book.bookId)"
                >
                  Edit
                </button>
                <a
                  href="#"
                  class="btn btn-outline-danger"
                  @click.prevent="deleteBook(book.bookId)"
                  >Delete</a
                >
              </td>
            </tr>
          </tbody>
        </table>
        <div class="pagination-div text-center mt-5">
          <ul class="pagination justify-content-center">
            <li class="page-item">
              <a
                class="page-link"
                href="#"
                @click.prevent="fetchBooks(currentPage - 1)"
                v-if="currentPage > 1"
                >Previous</a
              >
            </li>
            <div class="" v-for="index in lastPage">
              <li class="page-item">
                <a
                  class="page-link"
                  href="#"
                  @click.prevent="fetchBooks(index)"
                  >{{ index }}</a
                >
              </li>
            </div>
            <li class="page-item">
              <a
                class="page-link"
                href="#"
                @click.prevent="fetchBooks(currentPage + 1)"
                v-if="currentPage != lastPage"
                >Next</a
              >
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>
