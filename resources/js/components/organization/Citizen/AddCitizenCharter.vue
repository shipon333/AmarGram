<template>
    <div>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-user-plus"></i> Add Citizen Charter</h3>
                        </div><!-- /.box-header -->
                        <form>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Title</label><br>
                                                    <input type="text" class="form-control" v-model="form.title" placeholder="Title">
                                                    <small class="text-danger" v-if="errors.title">{{errors.title[0]}}</small>
                                                </div>
                                            </div>
                                            <!--when use division district citizen charter then this code open then work-->
                                            <!--<div class="col-md-6">-->
                                                <!--<div class="form-group">-->
                                                    <!--<label>Division</label><br>-->
                                                    <!--<select  autofocus="" v-model="form.division_id"  class="form-control" @change="loadDistrict()" >-->
                                                        <!--<option value="">Select Division</option>-->
                                                        <!--<option v-for="division in divisions" :value="division.id" >{{division.name}}</option>-->
                                                    <!--</select>-->
                                                <!--</div>-->
                                            <!--</div>-->
                                            <!--<div class="col-md-6">-->
                                                <!--<div class="form-group">-->
                                                    <!--<label>District</label><br>-->
                                                    <!--<select  autofocus="" v-model="form.district_id"  class="form-control" @change="loadUpozilla()">-->
                                                        <!--<option value="">Select District</option>-->
                                                        <!--<option v-for="district in districts" :value="district.id">{{district.name}}</option>-->
                                                    <!--</select>-->
                                                <!--</div>-->
                                            <!--</div>-->
                                            <!--<div class="col-md-6">-->
                                                <!--<div class="form-group">-->
                                                    <!--<label>Upozilla</label><br>-->
                                                    <!--<select  autofocus="" v-model="form.upozilla_id" class="form-control" @change="unionLoad()" >-->
                                                        <!--<option value="">Select Upozilla</option>-->
                                                        <!--<option v-for="upozilla in upozillas" :value="upozilla.id">{{upozilla.name}}</option>-->
                                                    <!--</select>-->
                                                <!--</div>-->
                                            <!--</div>-->
                                            <!--<div class="col-md-6">-->
                                                <!--<select  autofocus="" v-model="form.union_id" class="form-control">-->
                                                    <!--<option value="">Select Union</option>-->
                                                    <!--<option v-for="union in unions" :value="union.id">{{union.name}}</option>-->
                                                <!--</select>-->
                                            <!--</div>-->
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Details</label><br>
                                            <textarea v-model="form.details" name="" id="" cols="30" rows="10" class="form-control details"></textarea>
                                            <small class="text-danger" v-if="errors.details">{{errors.details[0]}}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <button type="submit" @click.prevent="resetData" class="btn btn-info pull-left">Reset</button>
                                    <button type="submit" @click.prevent="addCitizenCharter" class="btn btn-info pull-right">Save</button>
                                </div>
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
        name: "AddCitizenCharter",
        beforeCreate(){
            if (!User.loggedIn()){
                this.$router.push({name:'/'})
            }
            if ( User.loggedIn() && User.userType() != "org") {
                this.$router.back();
            }
        },
        mounted(){
            // this.allDivision();
            this.resetData();
        },
        computed:{

        },
        data(){
            return{
                divisions:[],
                districts:[],
                upozillas:[],
                unions:[],
                form:{
                    title:'',
                    details:'',
                    division_id:'',
                    district_id:'',
                    upozilla_id:'',
                    union_id:'',
                    user_id: User.id(),
                },
                errors:{}
            }
        },
        methods: {
            // allDivision(){
            //     axios.get('/api/division')
            //         .then(({data}) => (this.divisions = data))
            //         .catch()
            // },
            // loadDistrict() {
            //     let id = this.form.division_id;
            //     axios.get('/api/loadDistrict/'+id)
            //         .then(({data}) => (this.districts = data))
            //         .catch()
            // },
            // loadUpozilla(){
            //     let id = this.form.district_id;
            //     axios.get('/api/loadUpozilla/'+id)
            //         .then(({data}) => (this.upozillas = data))
            //         .catch()
            // },
            // unionLoad(){
            //     let id = this.form.upozilla_id;
            //     axios.get('/api/unionLoad/'+id)
            //         .then(({data}) => (this.unions = data))
            //         .catch()
            // },
            addCitizenCharter(){
                axios.post('/api/citizen-charter',this.form)
                    .then(res => {
                        toastr.success('Citizen Charter Add Successfully', {timeOut: 500});
                        this.resetData();
                        this.getPeople();
                    })
                    .catch(error => {
                        console.log(error);
                        _this.errors = error.response.data.errors
                    })
            },
            resetData(){
                this.form.title = '';
                this.form.details = '';
                this.form.division_id = '';
                this.form.district_id = '';
                this.form.upozilla_id = '';
                this.form.union_id = '';
            },
        }
    }
</script>

<style scoped>
    .content{
        margin-left: 200px;
    }
    textarea.form-control.details {
        height: 162px;
    }
</style>