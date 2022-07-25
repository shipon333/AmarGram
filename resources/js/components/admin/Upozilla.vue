<template>
    <div>
        <section class="content">
            <div class="row">
                <div class="col-lg-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Upozilla</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form >
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="DistrictName">District Name</label><small class="req"> *</small>
                                    <select v-model="form.district_id" autofocus="" id="DistrictName" class="form-control " >
                                        <option value="">Select District</option>
                                        <option :value="district.id" v-for="district in districts">{{district.name}}</option>
                                    </select>
                                    <small class="text-danger" v-if="errors.district_id">{{errors.district_id[0]}}</small>
                                </div>
                                <div class="form-group">
                                    <label for="name">Upozilla Name</label><small class="req"> *</small>
                                    <input autofocus="" id="name" v-model="form.name"  placeholder="Upozilla Name" type="text" class="form-control" autocomplete="off">
                                    <small class="text-danger" v-if="errors.name">{{errors.name[0]}}</small>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button  type="submit" @click.prevent="formReset" class="btn btn-info pull-left">Reset</button>
                                <button v-if="form.upozilla_id == ''" type="submit" @click.prevent="addUpozilla" class="btn btn-info pull-right">Save</button>
                                <button v-else type="submit" @click.prevent="updateUpozilla" class="btn btn-info pull-right">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="box box-primary" id="exphead">
                        <div class="box-header with-border">
                            <h3 class="box-title">Upozilla List</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="download_label">Upozilla List</div>
                            <div class="table-responsive mailbox-messages">
                                <table class="table table-striped table-bordered table-hover" id="dataTable">
                                    <thead>
                                    <tr>
                                        <th>Upozilla Name</th>
                                        <th>District Name</th>
                                        <th class="text-right no-print">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="upozilla in upozillas" :key="upozilla.id">
                                        <td class="mailbox-name">{{upozilla.name}}</td>
                                        <td class="mailbox-name" v-if="upozilla.district">{{upozilla.district.name}}</td>
                                        <td class="mailbox-date pull-right no-print">
                                            <button @click="editUpozilla(upozilla)" class="btn btn-default btn-xs" data-toggle="tooltip" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button @click="deleteUpozilla(upozilla.id)" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" >
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
        name: "Upozilla",
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
            this.allDistrict();
            this.allUpozilla();
            this.resetData();

        },
        watch: {
            upozillas(val) {
                this.dt.destroy();
                this.$nextTick(() => {
                    this.dt = $('#dataTable').DataTable()
                });
            }
        },

        data(){
            return{
                upozillas:[],
                districts:[],
                form:{
                    name: null,
                    district_id:'',
                    upozilla_id: ''
                },
                errors:{}
            }
        },

        methods:{
            allUpozilla(){
                axios.get('/api/upozilla')
                    .then(({data}) => (this.upozillas = data))
                    .catch()
            },
            allDistrict(){
                axios.get('/api/district')
                    .then(({data}) => (this.districts = data))
                    .catch()
            },
            addUpozilla(){
                let _this = this;
                axios.post('/api/upozilla',this.form)

                    .then(res => {
                        toastr.success('Upozilla Add Successfully', {timeOut: 500});
                        _this.allUpozilla();
                        this.resetData();
                    })
                    .catch(error => {
                        _this.errors = error.response.data.errors

                    })
            },
            updateUpozilla(){
                let id = this.form.upozilla_id;
                let _this = this;
                axios.patch('/api/upozilla/'+id,this.form)
                    .then(res=>{
                        toastr.success('Upozilla Update Successfully', {timeOut: 500});
                        _this.allUpozilla();
                        this.resetData();
                    })
                    .catch(error => {
                        _this.errors = error.response.data.errors

                    })
            },
            formReset(){
                this.resetData();
            },
            editUpozilla: function(upozilla){
                this.form.upozilla_id = upozilla.id;
                this.form.name = upozilla.name;
                this.form.district_id = upozilla.district_id;
            },
            resetData(){
                this.form.name = '';
                this.form.district_id='';
                this.form.upozilla_id = '';
                this.errors=''
            },
            deleteUpozilla(id){
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
                        axios.delete('/api/upozilla/'+id)
                            .then(() =>{
                                this.upozillas = this.upozillas.filter(upozilla=>{
                                    return upozilla.id != id
                                })
                            })
                            .catch(() =>{
                                _this.allUpozilla();
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