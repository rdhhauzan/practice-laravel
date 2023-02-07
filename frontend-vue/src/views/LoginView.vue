<script>
import axios from "../config/apis";
import Swal from "sweetalert2";
export default {
    name: "Login",
    data() {
        return {
            user: {
                email: "",
                password: "",
            },
        };
    },
    methods: {
        async LoginUser() {
            try {
                let { data } = await axios.post("/login", {
                    email: this.user.email,
                    password: this.user.password,
                });
                console.log(data);
                localStorage.setItem("access_token", data.access_token);
                localStorage.setItem("role", data.role);
                Swal.fire({
                    icon: "success",
                    title: "Login Success",
                    text: `Login Success`,
                });

                if (data.role == "admin") {
                    this.$router.push("/");
                } else {
                    this.$router.push("/guest");
                }
            } catch (error) {
                console.log(error);
            }
        },
    },
};
</script>

<template>
    <div class="row justify-content-center" style="margin-top: 150px">
        <div class="col-lg-6">
            <main class="form-registration">
                <h1 class="h3 mb-3 fw-normal text-center">Login</h1>
                <form @submit.prevent="LoginUser" method="POST">
                    <div class="form-floating">
                        <input
                            type="email"
                            class="form-control"
                            name="email"
                            id="email"
                            required
                            placeholder="name@example.com"
                            v-model="user.email"
                        />
                        <label for="email">Email address</label>
                    </div>
                    <div class="form-floating">
                        <input
                            type="password"
                            class="form-control rounded-bottom"
                            name="password"
                            id="password"
                            required
                            placeholder="Password"
                            v-model="user.password"
                        />
                        <label for="email">Password</label>
                    </div>

                    <button
                        class="w-100 btn btn-lg btn-danger mt-3"
                        type="submit"
                    >
                        Login
                    </button>
                </form>
                <small class="d-block mt-3"
                    >Doesn't have an account?
                    <a class="text-danger" href="/register">
                        Register Now!</a
                    ></small
                >
            </main>
        </div>
    </div>
</template>
