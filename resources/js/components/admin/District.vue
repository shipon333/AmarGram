<template>
    <div>
        <section class="content">
            <div class="row">
                <div class="col-lg-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">District</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form >
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="DivisionName">District Name</label><small class="req"> *</small>
                                    <select v-model="form.division_id" autofocus="" id="DivisionName" class="form-control" >
                                        <option value="">Select Devision</option>
                                        <option :value="division.id" v-for="division in divisions">{{division.name}}</option>
                                    </select>
                                    <small class="text-danger" v-if="errors.division_id">{{errors.division_id[0]}}</small>
                                </div>
                                <div class="form-group">
                                    <label for="name">District Name</label><small class="req"> *</small>
                                    <input autofocus="" id="name" v-model="form.name"  placeholder="District Name" type="text" class="form-control" autocomplete="off">
                                    <small class="text-danger" v-if="errors.name">{{errors.name[0]}}</small>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button  type="submit" @click.prevent="formReset" class="btn btn-info pull-left">Reset</button>
                                <button v-if="form.district_id == ''" type="submit" @click.prevent="addDistrict" class="btn btn-info pull-right">Save</button>
                                <button v-else type="submit" @click.prevent="updateDistrict" class="btn btn-info pull-right">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="box box-primary" id="exphead">
                        <div class="box-header with-border">
                            <h3 class="box-title">District List</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="download_label">District List</div>
                            <div class="table-responsive mailbox-messages">
                                <table class="table table-striped table-bordered table-hover" id="dataTable">
                                    <thead>
                                    <tr>
                                        <th>District Name</th>
                                        <th>Division Name</th>
                                        <th class="text-right no-print">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="district in districts" :key="district.id">
                                        <td class="mailbox-name">{{district.name}}</td>
                                        <td class="mailbox-name" v-if="district.division">{{district.division.name}}</td>
                                        <td class="mailbox-date pull-right no-print">
                                            <button @click="editDistrict(district)" class="btn btn-default btn-xs" data-toggle="tooltip" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button @click="deleteDistrict(district.id)" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" >
                                                <i class="fa fa-trash"></i>
                                            </button>

                                        </td>
                                    </tr>

                                    </tbody>
                                </table><!-- /.table -->
                            </div><!-- /.mail-box-messages -->
                        </div><!-- /.box-body -->
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        name: "District",
        created(){
            if (!User.loggedIn()){
                this.$router.push({name:'/'})
            }
            if ( User.loggedIn() && User.userType() != "system") {
                this.$router.push({name:'dashboard'})
            }
        },

        mounted(){
            this.dt = $('#dataTable').DataTable();
            this.allDivision();
            this.allDistrict();
            this.resetData();

        },
        watch: {
            districts(val) {
                this.dt.destroy();
                this.$nextTick(() => {
                    this.dt = $('#dataTable').DataTable()
                });
            }
        },

        data(){
            return{
                districts:[],
                divisions:[],
                form:{
                    name: null,
                    division_id:'',
                    district_id: ''
                },
                errors:{}
            }
        },

        methods:{
            allDistrict(){
                axios.get('/api/district')
                    .then(({data}) => (this.districts = data))
                    .catch()
            },
            allDivision(){
                axios.get('/api/division')
                    .then(({data}) => (this.divisions = data))
                    .catch()
            },
            addDistrict(){
                let _this = this;
                axios.post('/api/district',this.form)

                    .then(res => {
                        toastr.success('District Add Successfully', {timeOut: 500});
                        _this.allDistrict();
                        this.resetData();
                    })
                    .catch(error => {
                        _this.errors = error.response.data.errors

                    })
            },
            updateDistrict(){
                let id = this.form.district_id;
                let _this = this;
                axios.patch('/api/district/'+id,this.form)
                    .then(res=>{
                        toastr.success('District Update Successfully', {timeOut: 500});
                        _this.allDistrict();
                        this.resetData();
                    })
                    .catch(error => {
                        _this.errors = error.response.data.errors

                    })
            },
            formReset(){
                this.resetData();
            },
            editDistrict: function(district){
                this.form.district_id = district.id;
                this.form.name = district.name;
                this.form.division_id = district.division_id;
            },
            resetData(){
                this.form.name = '';
                this.form.division_id='';
                this.form.district_id = '';
                this.errors=''
            },
            deleteDistrict(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let _this = this;
                        axios.delete('/api/district/'+id)
                            .then(() =>{
                                this.districts = this.districts.filter(district=>{
                                    return district.id != id
                                })
                            })
                            .catch(() =>{
                                _this.allDistrict();
                            })

                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }
                })
            }

        }
    }
</script>

<style scoped>
    .content{
        margin-left: 200px;
    }
</style>