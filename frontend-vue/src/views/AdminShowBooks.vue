<script>
import axios from "../config/apis";
import Sidebar from "../components/Sidebar.vue";
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
                        Authorization:
                            "Bearer " + localStorage.getItem("access_token"),
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
                            Authorization:
                                "Bearer " +
                                localStorage.getItem("access_token"),
                        },
                        responseType: "blob",
                    })
                    .then((response) => {
                        const url = window.URL.createObjectURL(
                            new Blob([response.data])
                        );
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
            <form action="/books/search" method="GET">
                <div class="input-group mb-3 w-25">
                    <input
                        type="text"
                        name="name"
                        placeholder="Enter Book name..."
                        class="form-control"
                    />
                    <button type="submit" class="btn btn-outline-secondary">
                        Search
                    </button>
                </div>
            </form>
            <div class="my-3">
                <a
                    class="btn btn-outline-primary"
                    @click.prevent="generatePdf()"
                    >Generate PDF</a
                >
                <a href="/books/generate-excel" class="btn btn-outline-primary"
                    >Generate Excel</a
                >
            </div>

            <div class="d-flex justify-content-center" v-if="isLoading">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>

            <div class="" v-if="!isLoading">
                <table
                    class="table table-bordered table-hover data-table"
                    border="1"
                >
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
                                <a href="#" class="btn btn-outline-primary"
                                    >Generate PDF</a
                                >
                                <a href="#" class="btn btn-outline-warning"
                                    >Edit</a
                                >
                                <a href="#" class="btn btn-outline-danger"
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
