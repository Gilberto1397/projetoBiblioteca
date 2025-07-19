import {createRouter, createWebHistory} from 'vue-router'
import Login from "@/components/login/Login.vue";
import novoGenero from "@/components/gender/novoGenero.vue";
import NewPublisher from "@/components/publisher/NewPublisher.vue";
import Publishers from "@/components/publisher/Publishers.vue";
import NewAuthor from "@/components/author/NewAuthor.vue";
import Authors from "@/components/author/Authors.vue";
import NewUser from "@/components/user/NewUser.vue";
import NewBook from "@/components/book/NewBook.vue";
import Books from "@/components/book/Books.vue";
import NewLoan from "@/components/Loan/NewLoan.vue";
import EndLoan from "@/components/Loan/EndLoan.vue";
import {useAuthenticationStore} from "@/stores/authentication.js";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/login',
            name: 'login',
            component: Login,
            meta: {
                label: 'Login',
                public: true,
            }
        },
        {
            path: '/novo-genero',
            name: 'novoGenero',
            component: novoGenero,
            meta: {
                label: 'Novo genero',
                public: false,
            }
        },
        {
            path: '/nova-editora',
            name: 'novaEditora',
            component: NewPublisher,
            meta: {
                label: 'Nova Editora',
                public: false,
            }
        },
        {
            path: '/editoras',
            name: 'editoras',
            component: Publishers,
            meta: {
                label: 'Editoras',
                public: false,
            }
        },
        {
            path: '/novo-autor',
            name: 'novoAutor',
            component: NewAuthor,
            meta: {
                label: 'Novo Autor',
                public: false,
            }
        },
        {
            path: '/autores',
            name: 'autores',
            component: Authors,
            meta: {
                label: 'Autores',
                public: false,
            }
        },
        {
            path: '/novo-usuario',
            name: 'novoUsuario',
            component: NewUser,
            meta: {
                label: 'Registrar-se',
                public: true,
            }
        },
        {
            path: '/novo-livro',
            name: 'novoLivro',
            component: NewBook,
            meta: {
                label: 'Novo Livro',
                public: false,
            }
        },
        {
            path: '/livros',
            name: 'livros',
            component: Books,
            meta: {
                label: 'Livros',
                public: false,
            }
        },
        {
            path: '/novo-emprestimo',
            name: 'novoEmprestimo',
            component: NewLoan,
            meta: {
                label: 'Novo Empréstimo',
                public: false,
            }
        },
        {
            path: '/devolve-livros',
            name: 'devolveLivros',
            component: EndLoan,
            meta: {
                label: 'Devolve Livros',
                public: false,
            }
        },
        {
            path: '',
            name: 'logout',
            component: '',
            meta: {
                label: 'Logout',
                public: false,
            }
        },
        {
            path: '/:pathMatch(.*)*',
            name: 'default',
            component: Login,
            meta: {
                label: '',
                public: true,
            }
        }
    ],
})

router.beforeEach((routeTo, routeFrom, next) => {
    const authenticationStore = useAuthenticationStore();

    if (!routeTo.meta.public && !authenticationStore.state.loggedIn) {
        next({
            name: 'login',
            query: {needAuth: true}
        });
    }

    if (routeTo.path === '/login' && authenticationStore.state.loggedIn) {
        next({name: 'livros'});
    }
    next();
})

export default router
