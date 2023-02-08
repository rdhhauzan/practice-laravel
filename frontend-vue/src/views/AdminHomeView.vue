<script>
import axios from "../config/apis";
import Sidebar from "../components/Sidebar.vue";
export default {
    name: "AdminHomeView",
    components: {
        Sidebar,
    },
    data() {
        return {
            countBooks: null,
            isLoading: false,
        };
    },
    methods: {
        async ShowBooks() {
            try {
                this.isLoading = true;
                let { data } = await axios.get("/books", {
                    headers: {
                        Authorization:
                            "Bearer " + localStorage.getItem("access_token"),
                    },
                });
                this.countBooks = data.books.total;
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
            <div class="card my-4" style="width: 18rem">
                <div class="card-body">
                    <h5 class="card-title">Total Books</h5>
                    <p class="card-text">
                        <div class="d-flex justify-content-center" v-if="isLoading">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        {{ this.countBooks }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
