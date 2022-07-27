<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">Users</h5>
                <div>
                    <router-link to="/user/add" class="btn btn-outline-success">Add Users</router-link>
                </div>
            </div>
            
            <table class="table table-hover table-sm">
                <thead class="table-success">
                    <tr>
                        <th width="50" class="text-center">#</th>
                        <th>Name</th>
                        <th>email</th>
                        <th>Role</th>
                        <th class="text-center" width="200">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(user, index) in data" :key="user.id">
                        <td class="text-center">{{index+1}}.</td>
                        <td>{{user.name}}</td>
                        <td>{{user.email}}</td>
                        <td>{{ getMyRole(user.role_id) }}</td>
                        <!--<td>{{role.id}}</td>-->
                        <td class="text-center">
                            <router-link :to="{name:'edituser', params: {id:user.id}}" class="btn btn-outline-primary">Edit</router-link>
                            <button class="btn btn-outline-danger" @click="deleteUser(user.id)">Delete</button>
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
            role_data: [],
            role_namm: '',
            strSuccess: '',
            strError: ''
        }
    },
    mounted() {
        this.getData();
    },
    computed:{
        
    },
    methods: {
        async getData(url = "api/user") {
            //let loader = this.$loading.show();
            await axios.get(url, this.tableData).then((response) => {
                //let data = response.data;
                this.data = response.data;
            });
            
        },
        
        deleteUser(id) {
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    let existingObj = this;

                    if(confirm("Do you really want to delete this data?")) {
                        this.$axios.delete(`/api/user/delete/${id}`)
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
        },
        
        getMyRole(id){
            let gg="";
            if(id==1){
                this.gg="admin"
            }else if(id==2){
                this.gg="user"
            }else{
                this.gg="dsdsds"
            }
            /*
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.get(`/api/role/edit/`+id)
                .then(response => {
                    alert("name is "+response.data['name']);
                    gg = response.data['name'];
                    return response.data['name'];
                })
                .catch(function(error) {
                    console.log(error);
                });
            })*/
            return this.gg;
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