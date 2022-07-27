<template>
    <div class="container">
        <div class="row jutify-content-center">
            <div class="col-md-8">
                <div v-if="error !== null" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                    <strong>{{error}}</strong>
                </div>

                <div class="card card-default">
                    <div class="card-header"><h5>Register New User</h5></div>
                    <div class="card-body">
                        <form>

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

                            <div class="form-group row mt-1 mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-success" @click="handleSubmit">
                                        Register
                                    </button>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-md-8 offset-md-4">
                                    <small class="text-muted">
                                        Have an account? Please
                                        <router-link to="/login" >login</router-link>
                                    </small>
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
                name: "",
                email: "",
                password: "",
                pass_con: "",
                error: null
            }
        },

        methods: {
            handleSubmit(e) {
                e.preventDefault()
                if(this.password.length >= 8) {
                    if(this.pass_con===this.password){
                        this.$axios.get('/sanctum/csrf-cookie').then(response => {
                            this.$axios.post('api/register', {
                                name: this.name,
                                email: this.email,
                                password: this.password,
                                pass_con: this.pass_con
                            })
                            .then(response => {
                                if (response.data.success) {
                                    window.location.href = "/login"
                                } else {
                                    this.error = response.data.message
                                }
                            })
                            .catch(function (error) {
                                console.error(error);
                            });
                        })
                    }else{
                        alert("Password "+ this.password + " does not match with confirm password " +this.pass_con);
                    }
                }else{
                    alert("Password must have at least 8 characters!!")
                }
            }
        },

        beforeRouteEnter(to, from, next) {
            if (window.Laravel.isLoggedin) {
                return next('dashboard');
            }
            next();
        }
    }
</script>
