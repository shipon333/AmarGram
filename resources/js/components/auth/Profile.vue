<template>
    <div>
        <div class="content">
            <section class="content-wrapper">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <!-- Custom Tabs (Pulled to the right) -->
                        <div class="nav-tabs-custom">
                            <div class="tab-content">
                                <div class="tab-pane active">
                                    <form >
                                        <!--<div class="form-group row">-->
                                            <!--<div class="col-md-6 col-sm-6 col-xs-12">-->
                                                <!--<div class="profile-image">-->
                                                    <!--<img src="{{ asset('backend') }}/images/user.jpg" alt="">-->
                                                <!--</div>-->
                                                <!--<input class="form-control col-md-7 col-xs-12" type="file">-->
                                            <!--</div>-->
                                        <!--</div>-->
                                        <div class="form-group row">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Name</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input class="form-control col-md-7 col-xs-12" v-model="form.name" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Email</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input class="form-control col-md-7 col-xs-12" type="email" v-model="form.email">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Password</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input class="form-control col-md-7 col-xs-12" type="password" v-model="form.password" placeholder="Enter New Password">
                                            </div>
                                        </div>
                                        <div class="box-footer">
                                            <div class="form-group">
                                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                    <button type="submit" class="btn btn-info" @click.prevent="profileUpdate">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->

                            </div>
                            <!-- /.tab-content -->
                        </div>
                        <!-- nav-tabs-custom -->
                    </div>
                    <!-- /.col -->

                </div>

            </section>
        </div>
    </div>
</template>

<script>
    import User from "../../Helpers/User";

    export default {
        name: "Profile",
        created(){
            if (!User.loggedIn()){
                this.$router.push({name:'/'})
            }
        },
        mounted(){
            this.form.name = User.name();
            this.form.email = User.email();
            // this.form.token = User.hasToken();
        },

        data(){
            return{

                form:{
                    name:null,
                    email:null,
                    password:'',
                    token: '',
                }

            }
        },
        methods: {
            profileUpdate() {

                let id = User.id();
                axios.post('/api/profile/'+id,this.form)
                    .then(res=>{
                        toastr.success('Profile Update Successfully', {timeOut: 500});
                    })
            }
        }


    }
</script>

<style scoped>
    .content{
        margin-left: 200px;
    }
    .nav-tabs-custom>.tab-content {
        padding: 30px;
    }
</style>