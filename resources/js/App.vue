<template>
    <div class="container">
        <nav class="navbar navbar-expand-sm navbar-light bg-light mb-4">
            <a class="navbar-brand" href="#">Laravel 8 + Vue 3</a>
            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId"
                aria-expanded="false" aria-label="Toggle navigation"></button>
            <div class="navbar-nav" v-if="isLoggedIn">
                <router-link to="/dashboard" class="nav-item nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-safe2-fill" viewBox="0 0 16 16">
                        <path d="M6.563 8H5.035a3.482 3.482 0 0 1 .662-1.596l1.08 1.08c-.094.16-.167.332-.214.516zm.921-1.223-1.08-1.08A3.482 3.482 0 0 1 8 5.035v1.528c-.184.047-.357.12-.516.214zM9 6.563V5.035a3.482 3.482 0 0 1 1.596.662l-1.08 1.08A1.988 1.988 0 0 0 9 6.563zm1.223.921 1.08-1.08c.343.458.577 1.003.662 1.596h-1.528a1.989 1.989 0 0 0-.214-.516zM10.437 9h1.528a3.483 3.483 0 0 1-.662 1.596l-1.08-1.08c.094-.16.167-.332.214-.516zm-.921 1.223 1.08 1.08A3.483 3.483 0 0 1 9 11.965v-1.528c.184-.047.357-.12.516-.214zM8 10.437v1.528a3.483 3.483 0 0 1-1.596-.662l1.08-1.08c.16.094.332.167.516.214zm-1.223-.921-1.08 1.08A3.482 3.482 0 0 1 5.035 9h1.528c.047.184.12.357.214.516zM7.5 8.5a1 1 0 1 1 2 0 1 1 0 0 1-2 0z"/>
                        <path d="M2.5 1A1.5 1.5 0 0 0 1 2.5V3H.5a.5.5 0 0 0 0 1H1v4H.5a.5.5 0 0 0 0 1H1v4H.5a.5.5 0 0 0 0 1H1v.5A1.5 1.5 0 0 0 2.5 16h12a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 14.5 1h-12zm6 3a4.5 4.5 0 1 1 0 9 4.5 4.5 0 0 1 0-9z"/>
                    </svg>
                    Dashboard
                </router-link>
                <!--<router-link to="/posts" class="nav-item nav-link">Posts</router-link>-->
                <router-link to="/role" class="nav-item nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sd-card-fill" viewBox="0 0 16 16">
                        <path d="M12.5 0H5.914a1.5 1.5 0 0 0-1.06.44L2.439 2.853A1.5 1.5 0 0 0 2 3.914V14.5A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-13A1.5 1.5 0 0 0 12.5 0Zm-7 2.75a.75.75 0 0 1 .75.75v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 1 .75-.75Zm2 0a.75.75 0 0 1 .75.75v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 1 .75-.75Zm2.75.75v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 1 1.5 0Zm1.25-.75a.75.75 0 0 1 .75.75v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 1 .75-.75Z"/>
                    </svg>
                    Role
                </router-link>
                <router-link to="/user" class="nav-item nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-lines-fill" viewBox="0 0 16 16">
                        <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z"/>
                    </svg>
                    User
                </router-link>
                <a class="nav-item nav-link" style="cursor: pointer;" @click="logout">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
                        <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                    </svg>
                    Logout
                </a>
            </div>
            <div class="navbar-nav" v-else>
                <!--<router-link to="/login" class="nav-item nav-link">Login</router-link>
                <router-link to="/register" class="nav-item nav-link">Register</router-link>-->
            </div>
        </nav>


        <router-view></router-view>
    </div>
</template>
<script>
    export default {
        name: "App",
        data() {
            return {
                isLoggedIn: false,
            }
        },
        created() {
            if (window.Laravel.isLoggedin) {
                this.isLoggedIn = true
            }
        },
        methods: {
            logout(e) {
                e.preventDefault()
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    this.$axios.post('/api/logout')
                    .then(response => {
                        if(response.data.success) {
                            window.location.href = "/"
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
                })
            }
        },
    }
</script>