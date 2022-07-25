<template>
    <div>
        <section class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Organization Registration</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form >
                            <div class="box-body row">

                                    <div class="col-lg-6">
                                        <div class="form-group ">
                                            <label>Division</label><small class="req"> *</small>
                                            <select  autofocus="" v-model="form.division_id"  class="form-control" @change="loadDistrict()" >
                                                <option value="">Select Division</option>
                                                <option v-for="division in divisions" :value="division.id" >{{division.name}}</option>
                                            </select>
                                        </div>
                                        <div class="form-group ">
                                            <label>District</label><small class="req"> *</small>
                                            <select  autofocus="" v-model="form.district_id"  class="form-control" @change="loadUpozilla()">
                                                <option value="">Select District</option>
                                                <option v-for="district in districts" :value="district.id">{{district.name}}</option>
                                            </select>
                                        </div>
                                        <div class="form-group ">
                                            <label>Upozilla</label><small class="req"> *</small>
                                            <select  autofocus="" v-model="form.upozilla_id" class="form-control" @change="unionLoad()" >
                                                <option value="">Select Upozilla</option>
                                                <option v-for="upozilla in upozillas" :value="upozilla.id">{{upozilla.name}}</option>
                                            </select>
                                        </div>
                                        <div class="form-group ">
                                            <label>Union</label><small class="req"> *</small>
                                            <select  autofocus="" v-model="form.union_id" class="form-control">
                                                <option value="">Select Union</option>
                                                <option v-for="union in unions" :value="union.id">{{union.name}}</option>
                                            </select>
                                            <small class="text-danger" v-if="errors.union_id">{{errors.union_id[0]}}</small>
                                        </div>
                                        <div class="form-group ">
                                            <label>Village</label><small class="req"> *</small>
                                            <input autofocus="" v-model="form.villageName"  placeholder="Village Name" type="text" class="form-control" autocomplete="off">
                                            <small class="text-danger" v-if="errors.villageName">{{errors.villageName[0]}}</small>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group ">
                                            <label>Organization Type</label><small class="req"> *</small>
                                            <select  autofocus="" v-model="form.organization_type_id" class="form-control" >
                                                <option value="">Select Type</option>
                                                <option v-for="organizationType in organizationTypes" :value="organizationType.id">{{organizationType.name}}</option>
                                            </select>
                                            <small class="text-danger" v-if="errors.organization_type_id">{{errors.organization_type_id[0]}}</small>
                                        </div>
                                        <div class="form-group ">
                                            <label>Organization Name</label><small class="req"> *</small>
                                            <input autofocus="" v-model="form.organizationName"  placeholder="Organization Name" type="text" class="form-control" autocomplete="off">
                                            <small class="text-danger" v-if="errors.organizationName">{{errors.organizationName[0]}}</small>
                                        </div>
                                        <div class="form-group ">
                                            <label>Your Name</label><small class="req"> *</small>
                                            <input autofocus="" v-model="form.name"  placeholder="Your Name" type="text" class="form-control" autocomplete="off">
                                            <small class="text-danger" v-if="errors.name">{{errors.name[0]}}</small>
                                        </div>
                                        <div class="form-group ">
                                            <label>Email</label><small class="req"> *</small>
                                            <input autofocus="" v-model="form.email"  placeholder="Email" type="email" class="form-control" autocomplete="off">
                                            <small class="text-danger" v-if="errors.email">{{errors.email[0]}}</small>
                                        </div>
                                        <div class="form-group ">
                                            <label>Password</label><small class="req"> *</small>
                                            <input autofocus="" v-model="form.password"  placeholder="Password" type="password" class="form-control" autocomplete="off">
                                            <small class="text-danger" v-if="errors.password">{{errors.password[0]}}</small>
                                        </div>
                                    </div>
                            </div>
                            <div class="box-footer text-center">
                                <router-link  to="/"  class="btn btn-info">Login</router-link>
                                <button type="submit" @click.prevent="addRegistration" class="btn btn-info">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        name: "Registration",
        mounted(){
            // this.dt = $('#dataTable').DataTable();
             this.allDivision();
             this.allOrganizationType();
            // this.resetData();
        },
        watch: {

        },

        data(){
            return{
                organizationTypes:[],
                divisions:[],
                districts:[],
                upozillas:[],
                unions:[],
                form:{
                    division_id:'',
                    district_id:'',
                    upozilla_id:'',
                    union_id:'',
                    villageName:'',
                    organizationName:'',
                    name: null,
                    email:'',
                    password:'',
                    organization_type_id:''
                },
                errors:{}
            }
        },

        methods:{
            allOrganizationType(){
                axios.get('/api/organization-type')
                    .then(({data}) => (this.organizationTypes = data))
                    .catch()
            },
            allDivision(){
                axios.get('/api/division')
                    .then(({data}) => (this.divisions = data))
                    .catch()
            },
            loadDistrict() {
                let id = this.form.division_id;
                axios.get('/api/loadDistrict/'+id)
                    .then(({data}) => (this.districts = data))
                    .catch()
            },
            loadUpozilla(){
                let id = this.form.district_id;
                axios.get('/api/loadUpozilla/'+id)
                    .then(({data}) => (this.upozillas = data))
                    .catch()
            },
            unionLoad(){
                let id = this.form.upozilla_id;
                axios.get('/api/unionLoad/'+id)
                    .then(({data}) => (this.unions = data))
                    .catch()
            },
            addRegistration(){
                var _this = this;
                axios.post('/api/organization/register',this.form)
                    .then(res => {
                        toastr.success('Organization Registration Successfully', {timeOut: 500});
                        this.resetData();
                        this.$router.push({name:'/'})
                    })
                    .catch(error => {
                        _this.errors = error.response.data.errors

                    })
            },
            formReset(){
                this.resetData();
            },
            resetData(){
                this.form.name = '';
                this.form.division_id='';
                this.form.district_id='';
                this.form.upozilla_id='';
                this.form.union_id='';
                this.form.villageName='';
                this.form.organizationName='';
                this.form.email='';
                this.form.password='';
                this.form.organization_type_id = '';
                this.errors=''
            },

        }
    }
</script>

<style scoped>
    .content{
        width: 600px;
        margin: 0 auto;
    }
</style>