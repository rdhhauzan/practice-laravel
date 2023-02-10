import { createRouter, createWebHistory } from "vue-router";
import AdminHomeView from "../views/AdminHomeView.vue";
import LoginView from "../views/LoginView.vue";
import AdminShowBooks from "../views/AdminShowBooks.vue";
import AdminAddBook from "../views/AdminAddBook.vue";
import AdminShowOrder from "../views/AdminShowOrder.vue";
import AdminShowGenres from "../views/AdminShowGenres.vue";
import AdminAddGenre from "../views/AdminAddGenre.vue";
import AdminShowUsers from "../views/AdminShowUsers.vue";
import AdminAddUser from "../views/AdminAddUser.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "AdminHome",
      component: AdminHomeView,
      meta: {
        title: "Admin Homepage",
      },
    },
    {
      path: "/login",
      name: "Login",
      component: LoginView,
      meta: {
        title: "Login Page",
      },
    },
    {
      path: "/books",
      name: "ShowBooks",
      component: AdminShowBooks,
      meta: {
        title: "Admin Book List Page",
      },
    },
    {
      path: "/book/add",
      name: "AddBook",
      component: AdminAddBook,
      meta: {
        title: "Admin Add Book Page",
      },
    },
    {
      path: "/orders",
      name: "Orders",
      component: AdminShowOrder,
      meta: {
        title: "Admin Order List Page",
      },
    },
    {
      path: "/genres",
      name: "ShowGenres",
      component: AdminShowGenres,
      meta: {
        title: "Admin Genre List Page",
      },
    },
    {
      path: "/genre/add",
      name: "AddGenre",
      component: AdminAddGenre,
      meta: {
        title: "Admin Add Book Page",
      },
    },
    {
      path: "/users",
      name: "ShowUsers",
      component: AdminShowUsers,
      meta: {
        title: "Admin User list page",
      },
    },
    {
      path: "/user/add",
      name: "AddUser",
      component: AdminAddUser,
      meta: {
        title: "Admin Add User Page",
      },
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

  const title = to.meta.title;
  if (title) {
    document.title = title;
  }
});

export default router;
