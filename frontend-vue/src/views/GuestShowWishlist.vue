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
            { data: "bookDescription" },
            { data: "genreName" },
          ],
        });
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
