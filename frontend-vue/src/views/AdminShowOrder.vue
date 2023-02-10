<script>
import $ from "jquery";
import "datatables.net";
import axios from "../config/apis";
import Sidebar from "../components/Sidebar.vue";
import Swal from "sweetalert2";
export default {
  name: "AdminShowOrder",
  components: {
    Sidebar,
  },
  data() {
    return {
      isLoading: false,
      orders: [],
      lastPage: 0,
      currentPage: 0,
      orderDetail: {
        status: "",
        userId: 0,
        bookId: 0,
      },
    };
  },
  methods: {
    async fetchOrders() {
      try {
        this.isLoading = true;
        let { data } = await axios.get(`/orders`, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token"),
          },
        });
        console.log(data);
        this.initDataTable();
        this.orders = data;
      } catch (error) {
        console.log(error);
      } finally {
        this.isLoading = false;
      }
    },

    async fetchOrder(userId, bookId) {
      console.log(userId, bookId);
      try {
        this.isLoading = true;
        let { data } = await axios.get(`/order/edit/${userId}/${bookId}`, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token"),
          },
        });
        console.log(data);
        this.orderDetail.bookId = data[0].bookId;
        this.orderDetail.status = data[0].status;
        this.orderDetail.userId = data[0].userId;
      } catch (error) {
        console.log(error);
      } finally {
        this.isLoading = false;
      }
    },

    initDataTable() {
      const self = this;
      $(document).ready(() => {
        $("#mytable").dataTable({
          data: this.orders,
          columns: [
            { data: "email" },
            { data: "bookName" },
            { data: "bookPrice" },
            { data: "Status" },
            {
              data: null,
              render: function (data, type, row) {
                return `<button
                    class="btn btn-outline-warning edit-order"
                    type="button"
                    data-bs-toggle="modal"
                    data-bs-target="#exampleModal"
                    data-userid = "${row.userId}"
                    data-bookid = "${row.bookId}"
                  >
                    Edit Order
                  </button>`;
              },
            },
          ],
        });

        $("#mytable").on("click", ".edit-order", (event) => {
          const userId = $(event.currentTarget).data("userid");
          const bookId = $(event.currentTarget).data("bookid");
          this.fetchOrder(userId, bookId);
        });
      });
    },

    async submitUpdate() {
      await axios
        .post("/order/update", this.orderDetail, {
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
          this.fetchOrders();
          this.$router.push("/orders");
          document.getElementById("close").click();
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
  beforeMount() {
    this.fetchOrders();
  },
};
</script>

<template>
  <!-- eslint-disable -->
  <Sidebar />
  <div class="" style="margin-top: 58px">
    <div class="container pt-4">
      <h2>Show Order</h2>
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
              <h5 class="modal-title" id="exampleModalLabel">Edit Order</h5>
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
                  <div class="form-floating">
                    <select
                      class="form-select"
                      id="floatingSelect"
                      aria-label="Floating label select example"
                      v-model="orderDetail.status"
                    >
                      <option selected disabled>--- SELECT STATUS ---</option>
                      <option value="pending">Pending</option>
                      <option value="delivered">Delivered</option>
                      <option value="canceled">Canceled</option>
                      <option value="packaging">Packaging</option>
                      <option value="completed">Completed</option>
                    </select>
                    <label for="floatingSelect">Status</label>
                  </div>
                  <button
                    class="w-100 btn btn-lg btn-danger my-3"
                    type="submit"
                  >
                    Edit Book
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

      <div class="" v-if="!isLoading">
        <div class="" v-if="orders.length > 0">
          <table
            id="mytable"
            class="table table-bordered table-hover data-table"
            border="1"
          >
            <thead>
              <tr>
                <th scope="col">User Email</th>
                <th scope="col">Book Name</th>
                <th scope="col">Price</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(order, index) in orders">
                <td>{{ order.email }}</td>
                <td>{{ order.bookName }}</td>
                <td>{{ order.bookPrice }}</td>
                <td>
                  <span
                    class="badge bg-warning text-dark"
                    v-if="order.Status == 'pending'"
                    >Pending</span
                  >
                  <span
                    class="badge bg-secondary"
                    v-if="order.Status == 'delivered'"
                    >Delivered</span
                  >
                  <span
                    class="badge bg-info text-dark"
                    v-if="order.Status == 'packaging'"
                    >Packaging</span
                  >
                  <span
                    class="badge bg-danger"
                    v-if="order.Status == 'canceled'"
                    >Canceled</span
                  >
                  <span
                    class="badge bg-primary"
                    v-if="order.Status == 'completed'"
                    >Completed</span
                  >
                </td>
                <td>
                  <!-- <button
                    class="btn btn-outline-warning"
                    type="button"
                    data-bs-toggle="modal"
                    data-bs-target="#exampleModal"
                    @click.prevent="fetchOrder(order.userId, order.bookId)"
                  >
                    Edit Order
                  </button> -->
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
        <h3 v-if="orders.length < 1" class="mt-3">No Data Found!</h3>
      </div>
    </div>
  </div>
</template>
