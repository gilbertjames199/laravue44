<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="#6d727a" class="bi bi-person-lines-fill" viewBox="0 0 16 16">
                        <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z"/>
                    </svg>
                    Users
                </h5>
                <div>
                    <router-link to="/user/add" class="btn btn-outline-success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-plus" viewBox="0 0 16 16">
                            <path d="M8.5 6a.5.5 0 0 0-1 0v1.5H6a.5.5 0 0 0 0 1h1.5V10a.5.5 0 0 0 1 0V8.5H10a.5.5 0 0 0 0-1H8.5V6z"/>
                            <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z"/>
                        </svg>
                        Add Users
                    </router-link>
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
                            <router-link :to="{name:'edituser', params: {id:user.id}}" class="btn btn-outline-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-pen-fill" viewBox="0 0 16 16">
                                    <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z"/>
                                </svg>&nbsp;Edit
                            </router-link>
                            &nbsp;
                            <button class="btn btn-outline-danger" @click="deleteUser(user.id)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                                </svg>
                                Delete
                            </button>
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
            role_namm: [],
            strSuccess: '',
            strError: '',
            temp: '',
        }
    },
    beforeMount() {
        this.getRoleData();
        
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
            next();
        }
        
    
    },
    mounted() {
        if (!window.Laravel.isLoggedin) {
                window.location.href = "/login";
                next();
            }
        this.getData();
        
    },
    computed:{
        rolemyVal(){
            return this.role_namm;
        }
    },
    methods: {
        async getData(url = "api/user") {
            await axios.get(url, this.tableData).then((response) => {
                this.data = response.data;
            });
            
        },
        
        async getRoleData(url = "/api/role") {
            
            await axios.get(url).then((response) => {
                    //let data = response.data;
                    var gg2 = response.data;
                    //this.role_namm.push(gg2);
                    this.role_namm=gg2;
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
            var aa="";
            const tempo=[];
            this.role_namm.forEach(function(numm){
                if(numm.id==id){
                    var temp = numm.name;
                    tempo.push(numm.name);
                        
                }
                    
            });
            this.aa = tempo[0];
            return this.aa;
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