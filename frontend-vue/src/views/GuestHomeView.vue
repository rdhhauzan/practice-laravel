<script>
import axios from "../config/apis";
import Sidebar from "../components/SidebarGuest.vue";
export default {
  name: "GuestHomeView",
  components: {
    Sidebar,
  },
  data() {
    return {
      countBooks: [],
      isLoading: false,
    };
  },
  methods: {
    async ShowBooks() {
      try {
        this.isLoading = true;
        let { data } = await axios.get("/guest/books", {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token"),
          },
        });
        this.countBooks = data.books;
      } catch (error) {
        console.log(error);
      } finally {
        this.isLoading = false;
      }
    },
  },
  beforeMount() {
    this.ShowBooks();
  },
};
</script>

<template>
  <!-- eslint-disable -->
  <Sidebar />
  <div style="margin-top: 58px">
    <div class="container pt-4">
      <h2>Dashboard</h2>
      <div class="row">
        <div class="col-sm-6">
          <div class="card my-4" style="width: 18rem">
            <div class="card-body">
              <h4
                class="card-title align-items-center d-flex justify-content-center"
              >
                Total Books
              </h4>
              <p class="card-text"></p>
              <div class="d-flex justify-content-center" v-if="isLoading">
                <div class="spinner-border" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
              </div>
              <p
                v-if="!isLoading"
                style="font-size: 20px"
                class="align-items-center d-flex justify-content-center"
              >
                {{ this.countBooks.length }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
