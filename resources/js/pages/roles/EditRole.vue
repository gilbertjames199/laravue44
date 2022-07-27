<template>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">Update Role Data</h5>
                <div>
                    <router-link :to="{name: 'role'}" class="btn btn-success">Go Back</router-link>
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


            <form @submit.prevent="updateRole" enctype="multipart/form-data">
                <div class="form-group mb-2">
                    <label>Name</label><span class="text-danger"> *</span>
                    name: {{ name }}
                    <input type="text" class="form-control" v-model="name" placeholder="Enter role name">
                </div>

                <div class="form-group mb-2">
                    <label>Description</label><span class="text-danger"> *</span>
                   <textarea class="form-control" rows="3" v-model="desc" placeholder="Enter role description"></textarea>
                </div>

                <button type="submit" class="btn btn-primary mt-4 mb-4"> Update Role</button>

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
            desc: '',
            strSuccess: '',
            strError: '',
        }
    },

    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get(`/api/role/edit/${this.$route.params.id}`)
            .then(response => {
                //alert("name is "+response.data['name']);
                this.name = response.data['name'];
                this.desc = response.data['desc'];
            })
            .catch(function(error) {
                console.log(error);
            });
        })
    },
    mounted() {
        //this.getData();
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
        updateRole(e) {
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
                

                this.$axios.post(`/api/role/update/${this.$route.params.id}`, formData, config)
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
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    }
}

</script>