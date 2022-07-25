<template>
    
</template>

<script>
    export default {
        name: "Logout",
        created(){
            localStorage.removeItem('token')
            localStorage.removeItem('user')
            // this.loggedInUserType = null;
            Toast.fire({
                icon: 'success',
                title: 'Logout successfully'
            })
            this.$router.push({name:'/'})
        }
    }
</script>

<style scoped>

</style>