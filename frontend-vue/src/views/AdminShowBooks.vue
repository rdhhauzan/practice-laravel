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
        };
    },
    methods: {
        async fetchBooks(page) {
            if (!page) {
                page = 1;
            }
            try {
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
                <button
                    type="button"
                    class="btn btn-outline-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#exampleModal"
                >
                    Add Book
                </button>
                <a href="/books/generate-pdf" class="btn btn-outline-primary"
                    >Generate PDF</a
                >
                <a href="/books/generate-excel" class="btn btn-outline-primary"
                    >Generate Excel</a
                >
            </div>

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
                            <a
                                href="book/generate-pdf/{{ $book->bookId }}"
                                class="btn btn-outline-primary"
                                >Generate PDF</a
                            >
                            <a
                                href="book/update/{{ $book->bookId }}"
                                class="btn btn-outline-warning"
                                >Edit</a
                            >
                            <a
                                href="book/delete/{{ $book->bookId }}"
                                class="btn btn-outline-danger"
                                >Delete</a
                            >
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
