<script>
import Sidebar from "../components/SidebarGuest.vue";
import $ from "jquery";
import "datatables.net";
import axios from "../config/apis";

export default {
  name: "GuestShowBooks",
  components: {
    Sidebar,
  },
  data() {
    return {
      books: [],
      isLoading: false,
    };
  },
  methods: {
    async fetchBooks() {
      try {
        this.isLoading = true;
        let { data } = await axios.get("/guest/books", {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token"),
          },
        });
        console.log(data);
        this.books = data.books;
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
          data: this.books,
          columns: [
            { data: "bookName" },
            { data: "description" },
            { data: "name" },
            {
              data: "price",
              render: $.fn.dataTable.render.number(",", ".", 3, "Rp"),
            },
            {
              data: "image",
              render: function (data, type, row, meta) {
                return `<img src="http://127.0.0.1:8000/images/${data}" alt="img"
                    style="width: 180px; height: 100px"/>`;
              },
            },
            {
              data: null,
              targets: "no-sort",
              orderable: false,
              render: function (data, type, row) {
                return `<a
                    href="#"
                    class="btn btn-outline-danger buy-book
                    data-id="${row.bookId}"
                    >Buy Book</a
                  >
                  <button
                    type="button"
                    class="btn btn-outline-secondary add-wishlist"
                    data-bs-toggle="modal"
                    data-bs-target="#exampleModal"
                    data-id="${row.bookId}"
                  >
                    Add to Wishlist
                  </button>
                  `;
              },
            },
          ],
        });

      });
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
  <div class="" style="margin-top: 58px">
    <div class="container pt-4">
      <h2>Books List</h2>
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
      <table
        id="mytable"
        border="1"
        class="table table-bordered table-hover data-table"
        v-if="!isLoading"
      >
        <thead>
          <tr>
            <th>Book Title</th>
            <th>Book Description</th>
            <th>Genre</th>
            <th>Price</th>
            <th>Book Image</th>
            <th>Action</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</template>
