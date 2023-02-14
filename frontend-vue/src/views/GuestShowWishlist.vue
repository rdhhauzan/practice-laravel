<script>
import $ from "jquery";
import "datatables.net";
import axios from "../config/apis";
import Sidebar from "../components/SidebarGuest.vue";
import Swal from "sweetalert2";
export default {
  name: "GuestShowWishlist",
  components: {
    Sidebar,
  },
  data() {
    return {
      isLoading: false,
      wishlist: [],
    };
  },
  methods: {
    async fetchWishlist() {
      try {
        this.isLoading = true;
        let { data } = await axios.get("/guest/wishlist", {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token"),
          },
        });

        console.log(data.books);
        this.wishlist = data.books;
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
          data: this.wishlist,
          columns: [
            { data: "bookName" },
            { data: "bookPrice" },
            { data: "bookDescription", targets: "no-sort", orderable: false },
            { data: "genreName" },
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
                    class="btn btn-outline-secondary delete-wishlist"
                    data-id="${row.bookId}"
                  >
                    Delete Wishlist
                  </button>
                  `;
              },
            },
          ],
        });

        $("#mytable").on("click", ".delete-wishlist", (event) => {
          const id = $(event.currentTarget).data("id");
          this.deleteWishlist(id);
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

    async deleteWishlist(id) {
      console.log("aaa");
      await axios
        .get(`/guest/wishlist/delete/${id}`, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token"),
          },
        })
        .then(() => {
          Swal.fire({
            icon: "success",
            title: "Delete Success",
            text: `Wishlist Delete Successfully!`,
          });

          this.fetchWishlist();
          this.$router.push("/guest/wishlist");
        });
    },
  },
  beforeMount() {
    this.fetchWishlist();
  },
};
</script>

<template>
  <!-- eslint-disable -->
  <Sidebar />
  <div class="" style="margin-top: 58px">
    <div class="container pt-4">
      <h2>User Wishlist</h2>
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
        <h5>Your total Wishlist : {{ wishlist.length }} Book(s)</h5>
        <table class="table table-bordered table-hover data-table" id="mytable">
          <thead>
            <tr>
              <th scope="col">Book name</th>
              <th scope="col">Price</th>
              <th scope="col">Book Description</th>
              <th scope="col">Genre</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</template>
