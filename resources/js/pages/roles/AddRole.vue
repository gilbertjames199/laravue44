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
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="#6d727a" class="bi bi-sd-card-fill" viewBox="0 0 16 16">
                                    <path d="M12.5 0H5.914a1.5 1.5 0 0 0-1.06.44L2.439 2.853A1.5 1.5 0 0 0 2 3.914V14.5A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-13A1.5 1.5 0 0 0 12.5 0Zm-7 2.75a.75.75 0 0 1 .75.75v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 1 .75-.75Zm2 0a.75.75 0 0 1 .75.75v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 1 .75-.75Zm2.75.75v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 1 1.5 0Zm1.25-.75a.75.75 0 0 1 .75.75v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 1 .75-.75Z"/>
                                </svg>
                                Add Roles
                            </h5>
                            <div>
                                <router-link :to="{name: 'role'}" class="btn btn-outline-success">Go Back</router-link>
                            </div>
                        </div>
                        
                    </div>
                    <div class="card-body">
                        <form>

                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Role Name</label>
                                <div class="col-md-8">
                                    <input id="name" type="text" class="form-control" v-model="name" required
                                           autofocus autocomplete="off"  placeholder="Enter role name">
                                </div>
                            </div>

                            <div class="form-group row mt-1">
                                <label for="desc" class="col-sm-4 col-form-label text-md-right">Role Description</label>
                                <div class="col-md-8">
                                    <input id="desc" type="text" class="form-control" v-model="desc" required
                                           autofocus autocomplete="off" placeholder="Enter role description">
                                </div>
                            </div>
                            <div class="form-group row mt-1 mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-outline-success" @click="handleSubmit">
                                        Save
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
                name: "",
                desc: "",
                strSuccess: '',
                strError: '',
                error: null
            }
        },

        methods: {
            handleSubmit(e) {
                e.preventDefault()
                if(this.name){
                    this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    let existingObj = this;
                    const config = {
                        headers: {
                            'content-type': 'multipart/form-data'
                        }
                    }
                    const formData = new FormData();
                    formData.append('name', this.name);
                    formData.append('desc', this.desc);

                    this.$axios.post('/api/role/add', formData, config)
                    .then(response => {
                        existingObj.strError = "";
                        existingObj.strSuccess = response.data.success;
                        window.location.href = "/role";
                    })
                    .catch(function(error) {
                        existingObj.strSuccess ="";
                        existingObj.strError = error.response.data.message;
                    });
                });
                }
                
                
            }
        },

        beforeRouteEnter(to, from, next) {
            if (!window.Laravel.isLoggedin) {
                window.location.href = "/login";
            }
            next();
        }
    }
</script>
