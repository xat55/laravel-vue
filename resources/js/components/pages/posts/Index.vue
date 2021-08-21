<template>
    <div class="container">

        <h2>Все записи</h2>

        <div class="row">
           <div class="col-sm-6">

               <validation-errors   v-if="validationErrors"
                                    :errors="validationErrors" ></validation-errors>

               <form @submit.prevent="addPost" class="mb-4">
                   <div class="form-group">
                       <label for="title">Название</label>
                       <input v-model="post.title" type="text" class="form-control" id="title">
                   </div>

                   <div class="form-group">
                       <label for="description">Описание</label>
                       <textarea v-model="post.description" class="form-control" id="description" rows="3"></textarea>
                   </div>

                   <button type="submit" class="btn btn-primary">Сохранить</button>
                   <button v-if="edit" @click="cancelEditPost(post)" type="button" class="btn btn-warning ml-1">Очистить</button>

               </form>
           </div>
       </div>

        <div v-if="errored" class="alert alert-danger" role="alert">
            Записи не загрузились, попробуйте позже...
        </div>

        <table v-else class="table table-striped">

            <div v-if="loading" class="">Загрузка...</div>

            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Название</th>
                    <th scope="col">Описание</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="post in posts" :key="post.id">
                    <th>{{ post.id }}</th>
                    <td>{{ post.title }}</td>
                    <td>{{ post.description }}</td>
                    <td>
                        <button @click="editPost(post)" class="btn btn-success">
                            <i class="fa fa-pencil"></i>
                        </button>
                        <button @click="deletePost(post.id)" class="btn btn-danger">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <nav aria-label="Page navigation example">
          <ul class="pagination">

            <li :class="{ disabled: !pagination.prev_page_url }"
                @click.prevent="getPosts(pagination.prev_page_url)"
                class="page-item">
                <a class="page-link" href="#">Назад</a>
            </li>

            <li @click.prevent="" class="page-item">
                <a class="page-link" href="">
                    Страница {{ pagination.current_page }} из {{ pagination.last_page }}
                </a>
            </li>

            <li :class="{ disabled: !pagination.next_page_url}"
                @click.prevent="getPosts(pagination.next_page_url)"
                 class="page-item">
                <a class="page-link" href="#">Вперед</a>
            </li>
          </ul>
        </nav>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                posts: [],
                post: {
                    id: '',
                    title: '',
                    description: '',
                },
                pagination: {},
                edit: false,
                loading: true,
                errored: false,
                url: '/api/posts/',
                validationErrors: ''
            }
        },
        mounted() {
            this.getPosts();
        },
        methods: {
            getPosts(page_url) {
                page_url = page_url || this.url;

                axios(page_url)
                    // .get(page_url)
                    .then(response => {
                        this.posts = response.data.data;
                        this.makePagination(response.data);
                    })
                    .catch(error => {
                        console.log(error);
                        this.errored = true;
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            },
            makePagination(res) {
                let pagination = {
                    current_page: res.current_page,
                    last_page: res.last_page,
                    prev_page_url: res.prev_page_url,
                    next_page_url: res.next_page_url,
                };
                this.pagination = pagination;
            },
            addPost() {
                if (this.edit === false) {
                    // Добавление поста
                    axios
                        .post(this.url, {
                            title: this.post.title,
                            description: this.post.description,
                        })
                        .then(() => {
                            this.post.title = '';
                            this.post.description = '';
                            this.getPosts();
                        })
                        .catch(error => {
                            if (error.response.status === 422) {
                                this.validationErrors = error.response.data.errors;
                            }
                            console.log(error);
                        });
                } else {
                    // Редактирование поста
                    axios
                        .put(this.url + this.post.id, {
                            title: this.post.title,
                            description: this.post.description,
                        })
                        .then(response => {
                            this.edit = false;
                            this.post.title = '';
                            this.post.description = '';
                            this.getPosts();
                        })
                        .catch(error => {
                            if (error.response.status === 422) {
                                this.validationErrors = error.response.data.errors;
                            }
                            console.log(error);
                        });
                }
            },
            editPost(post) {
                this.edit = true;
                this.post.id = post.id;
                this.post.title = post.title;
                this.post.description = post.description;
            },
            cancelEditPost(post) {
                this.edit = false;
                this.post.title = '';
                this.post.description = '';
            },
            deletePost(id) {
                axios
                    .delete(this.url + id)
                    .then(() => this.getPosts())
                    .catch(error => console.log(error));
            },
        },
    }
</script>
