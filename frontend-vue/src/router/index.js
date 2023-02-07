import { createRouter, createWebHistory } from "vue-router";
import AdminHomeView from "../views/AdminHomeView.vue";
import LoginView from "../views/LoginView.vue";
import AdminShowBooks from "../views/AdminShowBooks.vue";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: "/",
            name: "AdminHome",
            component: AdminHomeView,
        },
        {
            path: "/login",
            name: "Login",
            component: LoginView,
        },
        {
            path: "/books",
            name: "ShowBooks",
            component: AdminShowBooks,
        },
    ],
});

router.beforeEach((to, from) => {
    if (!localStorage.getItem("access_token") && to.fullPath !== "/login") {
        return { name: "Login" };
    } else if (
        localStorage.getItem("access_token") &&
        to.fullPath == "/login" &&
        localStorage.getItem("role") == "admin"
    ) {
        return { name: "AdminHome" };
    }
});

export default router;
