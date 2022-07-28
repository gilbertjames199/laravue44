<template>
    <div class="container">
        <div class="row jutify-content-center">
            <div class="col-md-8">
                <div v-if="error !== null" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                    <strong>{{error}}</strong>
                </div>

                <div class="card card-default">
                    <div class="card-header">
                        <div class="d-flex justify-content-between pb-2 mb-2">
                            <h5>
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="#6d727a" class="bi bi-person-lines-fill" viewBox="0 0 16 16">
                                    <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z"/>
                                </svg>
                                Add New User
                            </h5>
                            <div>
                                <router-link :to="{name: 'user'}" class="btn btn-outline-success">Go Back</router-link>
                            </div>
                        </div>
                        
                    </div>
                    <div class="card-body">
                    
                        <form method="POST">

                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Name</label>
                                <div class="col-md-8">
                                    <input id="name" type="text" class="form-control" v-model="name" required
                                           autofocus autocomplete="off"  placeholder="Enter your name">
                                </div>
                            </div>

                            <div class="form-group row mt-1">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-8">
                                    <input id="email" type="email" class="form-control" v-model="email" required
                                           autofocus autocomplete="off" placeholder="Enter your email">
                                </div>
                            </div>


                            <div class="form-group row mt-1">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-8">
                                    <input id="password" type="password" class="form-control" v-model="password"
                                           required autocomplete="off" placeholder="Enter your password">
                                </div>
                            </div>

                            <div class="form-group row mt-1">
                                <label for="pass_con" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                                <div class="col-md-8">
                                    <input id="pass_con" type="password" class="form-control" v-model="pass_con"
                                           required autocomplete="off" placeholder="Confirm your password">
                                </div>
                            </div>

                            <div class="form-group row mt-1">
                                <label for="pass_con" class="col-md-4 col-form-label text-md-right">User Role</label>
                                <div class="col-md-8">
                                    
                                    <select id="role_id" type="text" class="form-control" v-model="role_id"
                                           required autocomplete="off" >
                                        <option 
                                            type="text" 
                                            class="form-control" 
                                            style="color: black;"
                                            v-for="(role, index) in data" 
                                            :value="role.id" 
                                            :key="index">
                                                {{ role.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group row mt-1 mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-outline-success" @click="handleSubmit">
                                        Add User
                                    </button>
                                </div>
                            </div>

                            


                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                data: [],
                name: "",
                email: "",
                password: "",
                pass_con: "",
                role_id: "",
                error: null
            }
        },

        mounted() {
            this.getData();
        },
        methods: {
            handleSubmit(e) {
                e.preventDefault()
                if(this.password.length >= 8) {
                    if(this.pass_con===this.password){
                        //alert("role id: "+ this.role_id);
                        this.$axios.get('/sanctum/csrf-cookie').then(response => {
                            this.$axios.post('/api/user/add', {
                                name: this.name,
                                email: this.email,
                                password: this.password,
                                pass_con: this.pass_con,
                                role_id: this.role_id,
                            })
                            .then(response => {
                                if (response.data.success) {
                                    window.location.href = "/user"
                                } else {
                                    this.error = response.data.message
                                }
                            })
                            .catch(function (error) {
                                console.error(error);
                            });
                        })
                    }else{
                        alert("Password ("+ this.password + ") does not match with confirm password (" +this.pass_con + ")");
                    }
                }else{
                    alert("Password must have at least 8 characters!!")
                }
            },
            async getData(url = "/api/role") {
                //let loader = this.$loading.show();
                await axios.get(url).then((response) => {
                    //let data = response.data;
                    this.data = response.data;
                });
            },
        },

        beforeRouteEnter(to, from, next) {
            if (!window.Laravel.isLoggedin) {
                window.location.href = "/";
            }
            next();
        },
        /*beforeMount(){
            if (!window.Laravel.isLoggedin) {
                window.location.href = "/login";
            }
            next();
        }*/
    }
</script>
