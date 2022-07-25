<template>
    <div>
        <section class="content">
            <div class="row">
                <div class="col-lg-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Committee Designation</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form >
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="name">Committee Designation Name</label><small class="req"> *</small>
                                    <input autofocus="" id="name" v-model="form.title"  placeholder="Committee Designation Name" type="text" class="form-control" autocomplete="off">
                                    <small class="text-danger" v-if="errors.title">{{errors.title[0]}}</small>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button  type="submit" @click.prevent="formReset" class="btn btn-info pull-left">Reset</button>
                                <button v-if="form.committeeDesignation_id == ''" type="submit" @click.prevent="addCommitteeDesignation" class="btn btn-info pull-right">Save</button>
                                <button v-else type="submit" @click.prevent="updateCommitteeDesignation" class="btn btn-info pull-right">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="box box-primary" id="exphead">
                        <div class="box-header with-border">
                            <h3 class="box-title">Committee Designation List</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="download_label">Committee Designation List</div>
                            <div class="table-responsive mailbox-messages">
                                <table class="table table-striped table-bordered table-hover" id="dataTable">
                                    <thead>
                                    <tr>
                                        <th>Designation Name</th>
                                        <th class="text-right no-print">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="committeeDesignation in committeeDesignations" :key="committeeDesignation.id">
                                        <td class="mailbox-name">{{committeeDesignation.title}}</td>
                                        <td class="mailbox-date pull-right no-print">
                                            <button @click="editCommitteeDesignation(committeeDesignation)" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button @click="deleteCommitteeDesignation(committeeDesignation.id)" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" >
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
        name: "CommitteeDesignation",
        beforeCreate(){
            if (!User.loggedIn()){
                this.$router.push({name:'/'})
            }
            if ( User.loggedIn() && User.userType() != "org") {
                this.$router.back();
            }
        },

        mounted(){
            this.dt = $('#dataTable').DataTable();
            this.allCommitteeDesignation();
            this.resetData();
        },
        watch: {
            committeeDesignations(val) {
                this.dt.destroy();
                this.$nextTick(() => {
                    this.dt = $('#dataTable').DataTable()
                });
            }
        },

        data(){
            return{
                committeeDesignations:[],
                user:[],
                form:{
                    title: null,
                    committeeDesignation_id: '',
                    user_id: User.id(),
                },
                errors:{}
            }
        },

        methods:{
            allCommitteeDesignation(){
                axios.get('/api/committee/designation'+'?userId='+User.id())
                    .then(({data}) => (this.committeeDesignations = data))
                    .catch()
            },



            addCommitteeDesignation(){
                let _this = this;
                axios.post('/api/committee/designation',this.form)

                    .then(res => {
                        toastr.success('Committee Designation Add Successfully', {timeOut: 500});
                        _this.allCommitteeDesignation();
                        this.resetData();
                    })
                    .catch(error => {
                        _this.errors = error.response.data.errors

                    })
            },
            updateCommitteeDesignation(){
                let id = this.form.committeeDesignation_id;
                let _this = this;
                axios.patch('/api/committee/designation/'+id,this.form)
                    .then(res=>{
                        toastr.success('Committee Designation Update Successfully', {timeOut: 500});
                        _this.allCommitteeDesignation();
                        this.resetData();
                    })
                    .catch(error => {
                        _this.errors = error.response.data.errors

                    })
            },
            formReset(){
                this.resetData();
            },
            editCommitteeDesignation: function(committeeDesignation){
                this.form.title = committeeDesignation.title;
                this.form.committeeDesignation_id = committeeDesignation.id;
            },
            resetData(){
                this.form.title = '';
                this.form.committeeDesignation_id = '';
                this.errors=''
            },
            deleteCommitteeDesignation(id){
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
                        axios.delete('/api/committee/designation/'+id)
                            .then(() =>{
                                this.committeeDesignations = this.committeeDesignations.filter(committeeDesignation=>{
                                    return committeeDesignation.id != id
                                })
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                            })
                            .catch(() =>{
                                _this.allCommitteeDesignation();
                            })


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