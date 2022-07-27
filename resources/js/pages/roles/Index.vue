<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">Roles</h5>
                <div>
                    <!--class="btn btn-outline-danger nav-item nav-link    bg-dark text-light" -->
                    <router-link to="/role/add" class="btn btn-outline-success">Add Roles</router-link>
                </div>
            </div>
            
            <table class="table table-hover table-sm">
                <thead class="table-success">
                    <tr>
                        <th width="50" class="text-center">#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th class="text-center" width="200">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(role, index) in data" :key="role.id">
                        <td class="text-center">{{index+1}}.</td>
                        <td>{{role.name}}</td>
                        <td>{{role.desc}}</td>
                        <!--<td>{{role.id}}</td>-->
                        <td class="text-center">
                            <router-link :to="{name:'editrole', params: {id:role.id}}" class="btn btn-outline-primary">Edit</router-link>
                            <button class="btn btn-outline-danger" @click="deleteRole(role.id)">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>


        </div>
    </div>
</template>
<script>

export default{
    data(){
        return{
            data: [],
            strSuccess: '',
            strError: ''
        }
    },
    mounted() {
        this.getData();
    },
    
    methods: {
        async getData(url = "api/role") {
            //let loader = this.$loading.show();
            await axios.get(url, this.tableData).then((response) => {
                //let data = response.data;
                this.data = response.data;
            });
        },
        deleteRole(id) {
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    let existingObj = this;

                    if(confirm("Do you really want to delete this data?")) {
                        this.$axios.delete(`/api/role/delete/${id}`)
                        .then(response => {
                            let i = this.posts.map(item => item.id).indexOf(id); // find index of your object
                            this.posts.splice(i, 1);
                            existingObj.strError = "";
                            existingObj.strSuccess = "Deleted successfully";
                            
                        })
                        .catch(function(error) {
                            existingObj.strError = "";
                            existingObj.strSuccess = "Error deleting";
                        });
                        location.reload();
                    }
                });
            }
    },
    created() {
        if (window.Laravel.user) {
            this.name = window.Laravel.user.name
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