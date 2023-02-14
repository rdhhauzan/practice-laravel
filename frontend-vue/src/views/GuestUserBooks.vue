<script>
import Sidebar from "../components/SidebarGuest.vue";
import $ from "jquery";
import "datatables.net";
import axios from "../config/apis";
export default {
  name: "GuestUserBooks",
  components: {
    Sidebar,
  },
  data() {
    return {
      userBooks: [],
      isLoading: false,
      totalPrices: 0,
    };
  },
  methods: {
    async fetchUserBooks() {
      try {
        this.isLoading = true;

        let { data } = await axios.get("/guest/userBooks", {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token"),
          },
        });
        console.log(data.books);
        console.log(data.countPrices);
        this.userBooks = data.books;
        this.totalPrices = data.countPrices;
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
          data: this.userBooks,
          columns: [
            { data: "bookName" },
            { data: "bookDescription" },
            { data: "genreName" },
            {
              data: "bookPrice",
              render: $.fn.dataTable.render.number(",", ".", 3, "Rp"),
            },
            {
              data: "image",
              render: function (data, type, row, meta) {
                return `<img src="http://127.0.0.1:8000/images/${data}" alt="img"
                    style="width: 180px; height: 100px"/>`;
              },
            },
            { data: "Status" },
          ],
        });
      });
    },
  },

  beforeMount() {
    this.fetchUserBooks();
  },
};
</script>

<template>
  <!-- eslint-disable -->
  <Sidebar />
  <div class="" style="margin-top: 58px">
    <div class="container pt-4">
      <h2>User Books</h2>
      <div class="" v-if="!isLoading">
        <h5>Total Books : {{ userBooks.length }}</h5>
        <h5>Total Spend : {{ totalPrices }}</h5>

        <table id="mytable" class="table table-bordered table-hover data-table">
          <thead>
            <tr>
              <th>Book Title</th>
              <th>Book Description</th>
              <th>Genre</th>
              <th>Price</th>
              <th>Book Image</th>
              <th>Status</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</template>
