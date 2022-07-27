<template>
    <div class="row">
        <h2>Home</h2>
    </div>
</template>
<script>
export default {
    name: "Home",
    data() {
        return {
            //
        }
    },
    created() {
    },
    methods: {
        
    },
    beforeMount(){
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/login";
        }else{
            window.location.href = "/dashboard";
        }
        next();
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/login";
        }else{
            window.location.href = "/dashboard";
        }
        next();
    }
}
</script>