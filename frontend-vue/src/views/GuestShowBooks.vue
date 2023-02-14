<script>
import Sidebar from "../components/SidebarGuest.vue";
import $ from "jquery";
import "datatables.net";
import axios from "../config/apis";
import Swal from "sweetalert2";

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
                return `<button
                    class="btn btn-outline-danger buy-book"
                    data-id="${row.bookId}"
                    >Buy Book</button>
                  <button
                    type="button"
                    class="btn btn-outline-secondary add-wishlist"
                    data-id="${row.bookId}"
                  >
                    Add to Wishlist
                  </button>
                  `;
              },
            },
          ],
        });

        $("#mytable").on("click", ".add-wishlist", (event) => {
          const id = $(event.currentTarget).data("id");
          this.addToWishlist(id);
        });

        $("#mytable").on("click", ".buy-book", (event) => {
          const id = $(event.currentTarget).data("id");
          console.log(id, "button<<<<<<<<<<");
          this.buyBook(id);
        });
      });
    },

    async buyBook(id) {
      try {
        let { data } = await axios.get(`/guest/book/buy/${id}`, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token"),
          },
        });

        let snapToken = data.snapToken;

        snap.pay(snapToken, {
          onSuccess: async function (result) {
            console.log("success!");

            await axios
              .post(
                `/guest/book/add`,
                { bookId: id },
                {
                  headers: {
                    Authorization:
                      "Bearer " + localStorage.getItem("access_token"),
                  },
                }
              )
              .then(() => {
                Swal.fire({
                  icon: "success",
                  title: "Buy Success",
                  text: `Book Success to buy!`,
                });
              });
          },
        });
      } catch (error) {
        console.log(error);
      }
    },

    async addToWishlist(id) {
      try {
        await axios
          .post(
            `/guest/wishlist/add/${id}`,
            { id: id },
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
              text: `Book Add to Wishlist Successfully!`,
            });
          });
      } catch (error) {
        console.log(error);
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
