<template>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="#6d727a" class="bi bi-person-lines-fill" viewBox="0 0 16 16">
                        <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z"/>
                    </svg>
                    Update User Data
                </h5>
                <div>
                    <router-link :to="{name: 'user'}" class="btn btn-outline-success">Go Back</router-link>
                </div>
            </div>

            <div v-if="strSuccess" class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{strSuccess}}</strong>
            </div>

            <div v-if="strError" class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{strError}}</strong>
            </div>

            <input type="hidden" v-model=role_id />
            <form @submit.prevent="updateUser" enctype="multipart/form-data">
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
                    <!--<div class="form-group row mt-1">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-8">
                                    <input id="password" type="text" class="form-control" v-model="password"
                                           required autocomplete="off" >
                                </div>
                    </div>
                    <div class="form-group row mt-1">
                                <label for="pass_con" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                                <div class="col-md-8">
                                    <input id="pass_con" type="text" class="form-control" v-model="pass_con"
                                           required autocomplete="off" >
                                </div>
                    </div>  :key="index"-->
                    <div class="form-group row mt-1">
                        <label for="pass_con" class="col-md-4 col-form-label text-md-right">User Role</label>
                        <div class="col-md-8">
                            <select id="role_id" class="form-control" autocomplete="chrome-off" v-model="role_id">
                                <option>___________________________</option>
                                <option 
                                    type="text" 
                                    class="form-control" 
                                    style="color: black;"
                                    v-for="role in data" 
                                    :value="role.id" 
                                    :key="role.id">
                                        {{ role.name }}
                                </option>
                            </select>
                        </div>
                    </div>

                <button type="submit" class="btn btn-outline-success"> Update User</button>

            </form>
            
        </div>
    </div>
</template>

<script>
export default{
    data() {
        return {
            id:'',
            name: '',
            email: '',
            password: '',
            pass_con: '',
            role_id: '',
            rr: '',
            role_name: '',
            data: [],
            strSuccess: '',
            strError: '',
        }
    },

    created() {
        
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get(`/api/user/edit/${this.$route.params.id}`)
            .then(response => {
                //alert("created role_id is "+response.data['role_id']);
                this.name = response.data['name'];
                this.email = response.data['email'];
                //this.password = response.data['password'];
                //this.pass_con = response.data['pass_con'];
                this.role_id = response.data['role_id'];
                this.rr = response.data['role_id'];
            })
            .catch(function(error) {
                console.log(error);
            });
        })
        //alert("created: "+this.role_id);
    },
    mounted() {
        this.getUserData();
        
    },
    methods: {
        
        /*nChange(e) {
            this.img = e.target.files[0];
            let reader = new FileReader();
            reader.addEventListener("load", function () {
                this.imgPreview = reader.result;
            }.bind(this), false);

            if (this.img) {
                if ( /\.(jpe?g|png|gif)$/i.test( this.img.name ) ) {
                    reader.readAsDataURL( this.img );
                }
            }
        },*/
        async getUserData(){
            await this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.get(`/api/user/edit/${this.$route.params.id}`)
                .then(response => {
                    //alert("role_id is mounted "+response.data['role_id']);
                    this.name = response.data['name'];
                    this.email = response.data['email'];
                    //this.password = response.data['password'];
                    //this.pass_con = response.data['pass_con'];
                    this.role_id = response.data['role_id'];
                    this.rr = response.data['role_id'];
                })
                .catch(function(error) {
                    console.log(error);
                });
            });
            this.getData();
        },

        async getData(url = "/api/role") {
            
            await axios.get(url).then((response) => {
                    //let data = response.data;
                    this.data = response.data;
                });
            
            /*this.$axios.get('/sanctum/csrf-cookie').then(response => {    
                //let loader = this.$loading.show();
                this.$axios.get(url).then((response) => {
                    //let data = response.data;
                    this.data = response.data;
                });*/
                
                //alert("getData role_id: "+this.role_id);
                //
        },
        
        updateUser(e) {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                let existingObj = this;
                const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }

                const formData = new FormData();
                formData.append('name', this.name);
                formData.append('email', this.email);
                formData.append('role_id', this.role_id	);
                //alert("role_id	: "+this.role_id	)
                this.$axios.post(`/api/user/update/${this.$route.params.id}`, formData, config)
                .then(response => {
                    existingObj.strError = "";
                    existingObj.strSuccess = response.data.success;
                    window.location.href = "/user";
                })
                .catch(function(error) {
                    existingObj.strSuccess ="";
                    existingObj.strError = error.response.data.message;
                });
            });
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    },
    /*beforeMount(){
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    }*/
}

</script>