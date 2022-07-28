<template>
    <div class="container">
        <div class="row jutify-content-center">
            <div class="col-md-8">
                <div v-if="error !== null" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                    <strong>{{error}}</strong>
                </div>

                <div class="card card-default">
                    <div class="card-header"><h5>Add Roles</h5></div>
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
