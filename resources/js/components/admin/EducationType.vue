<template>
    <div>
        <section class="content">
            <div class="row">
                <div class="col-lg-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Education Type</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form >
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="name">Education Type Name</label><small class="req"> *</small>
                                    <input autofocus="" id="name" v-model="form.name"  placeholder="EducationType Name" type="text" class="form-control" autocomplete="off">
                                    <small class="text-danger" v-if="errors.name">{{errors.name[0]}}</small>
                                </div>
                                <div class="form-group">
                                    <label for="name">Education Point</label><small class="req"> *</small>
                                    <input autofocus="" id="point" v-model="form.point"  placeholder="0.00" type="text" class="form-control" autocomplete="off">
                                    <small class="text-danger" v-if="errors.point">{{errors.point[0]}}</small>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button  type="reset" @click.prevent="formReset" class="btn btn-info pull-left">Reset</button>
                                <button v-if="form.education_type_id == ''" type="submit" @click.prevent="addEducationType" class="btn btn-info pull-right">Save</button>
                                <button v-else type="submit" @click.prevent="updateEducationType" class="btn btn-info pull-right">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="box box-primary" id="exphead">
                        <div class="box-header with-border">
                            <h3 class="box-title">Education Type List</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="download_label">Education Type List</div>
                            <div class="table-responsive mailbox-messages">
                                <table class="table table-striped table-bordered table-hover" id="dataTable">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Point</th>
                                        <th class="text-right no-print">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="education_type in education_types" :key="education_type.id">
                                        <td class="mailbox-name">{{education_type.name}}</td>
                                        <td class="mailbox-name">{{education_type.point}}</td>
                                        <td class="mailbox-date pull-right no-print">

                                            <button @click="editEducationType(education_type)" class="btn btn-default btn-xs" data-toggle="tooltip" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button @click="deleteEducationType(education_type.id)" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" >
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
        name: "EducationType",
        beforeCreate(){
            if (!User.loggedIn()){
                this.$router.push({name:'/'})
            }
            if ( User.loggedIn() && User.userType() != "system") {
                this.$router.push({name:'dashboard'})
            }
        },

        mounted(){
            this.dt = $('#dataTable').DataTable();
            this.allEducationType();
            this.resetData();
        },
        watch: {
            education_types(val) {
                this.dt.destroy();
                this.$nextTick(() => {
                    this.dt = $('#dataTable').DataTable()
                });
            }
        },

        data(){
            return{
                education_types:[],
                form:{
                    name: null,
                    point: '',
                    education_type_id:''
                },
                errors:{}
            }
        },

        methods:{
            allEducationType(){
                axios.get('/api/education-type')
                    .then(res => {this.education_types = res.data})
                    .catch()
            },
            addEducationType(){
                let _this = this;
                axios.post('/api/education-type',this.form)

                    .then(res => {
                        toastr.success('Education Type Add Successfully', {timeOut: 500});
                        _this.allEducationType();
                        this.resetData();
                    })
                    .catch(error => {
                        _this.errors = error.response.data.errors

                    })
            },
            updateEducationType(){
                let id = this.form.education_type_id;
                let _this = this;
                axios.patch('/api/education-type/'+id,this.form)
                    .then(res=>{
                        toastr.success('Education Type Update Successfully', {timeOut: 500});
                        _this.allEducationType();
                        this.resetData();
                    })
                    .catch(error => {
                        _this.errors = error.response.data.errors

                    })
            },
            formReset(){
                this.resetData();
            },
            editEducationType: function(education_type){
                this.form.education_type_id = education_type.id;
                this.form.name = education_type.name;
                this.form.point = education_type.point;
            },
            resetData(){
                this.form.name = '';
                this.form.point = '';
                this.form.education_type_id = '';
                this.errors=''
            },
            deleteEducationType(id){
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
                        axios.delete('/api/education-type/'+id)
                            .then(() =>{
                                this.education_types = this.education_types.filter(education_type=>{
                                    return education_type.id != id
                                })
                            })
                            .catch(() =>{
                                _this.allEducationType();
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