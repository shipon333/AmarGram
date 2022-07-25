<template>
    <div>
        <section class="content">
            <div class="row">
                <div class="col-lg-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Organization Type</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form >
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="name">Organization Type Name</label><small class="req"> *</small>
                                    <input autofocus="" id="name" v-model="form.name"  placeholder="OrganizationType Name" type="text" class="form-control" autocomplete="off">
                                    <small class="text-danger" v-if="errors.name">{{errors.name[0]}}</small>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button  type="submit" @click.prevent="formReset" class="btn btn-info pull-left">Reset</button>
                                <button v-if="form.organization_type_id == ''" type="submit" @click.prevent="addOrganizationType" class="btn btn-info pull-right">Save</button>
                                <button v-else type="submit" @click.prevent="updateOrganizationType" class="btn btn-info pull-right">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="box box-primary" id="exphead">
                        <div class="box-header with-border">
                            <h3 class="box-title">Organization Type List</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="download_label">Organization Type List</div>
                            <div class="table-responsive mailbox-messages">
                                <table class="table table-striped table-bordered table-hover" id="dataTable">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th class="text-right no-print">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="organization_type in organization_types" :key="organization_type.id">
                                        <td class="mailbox-name">
                                            <a href="#" data-toggle="popover" class="detail_popover" >
                                                {{organization_type.name}}
                                            </a>
                                        </td>
                                        <td class="mailbox-date pull-right no-print">

                                            <button @click="editOrganizationType(organization_type)" class="btn btn-default btn-xs" data-toggle="tooltip" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button @click="deleteOrganizationType(organization_type.id)" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" >
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
        name: "OrganizationType",
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
            this.allOrganizationType();
            this.resetData();
        },
        watch: {
            organization_types(val) {
                this.dt.destroy();
                this.$nextTick(() => {
                    this.dt = $('#dataTable').DataTable()
                });
            }
        },

        data(){
            return{
                organization_types:[],
                form:{
                    name: null,
                    organization_type_id:''
                },
                errors:{}
            }
        },

        methods:{
            allOrganizationType(){
                axios.get('/api/organization-type')
                    .then(({data}) => (this.organization_types = data))
                    .catch()
            },
            addOrganizationType(){
                let _this = this;
                axios.post('/api/organization-type',this.form)

                    .then(res => {
                        toastr.success('Organization Type Add Successfully', {timeOut: 500});
                        _this.allOrganizationType();
                        this.resetData();
                    })
                    .catch(error => {
                        _this.errors = error.response.data.errors

                    })
            },
            updateOrganizationType(){
                let id = this.form.organization_type_id;
                let _this = this;
                axios.patch('/api/organization-type/'+id,this.form)
                    .then(res=>{
                        toastr.success('Organization Type Update Successfully', {timeOut: 500});
                        _this.allOrganizationType();
                        this.resetData();
                    })
                    .catch(error => {
                        _this.errors = error.response.data.errors

                    })
            },
            formReset(){
                this.resetData();
            },
            editOrganizationType: function(organization_type){
                this.form.organization_type_id = organization_type.id;
                this.form.name = organization_type.name;
            },
            resetData(){
                this.form.name = '';
                this.form.organization_type_id = '';
                this.errors=''
            },
            deleteOrganizationType(id){
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
                        axios.delete('/api/organization-type/'+id)
                            .then(() =>{
                                this.organization_types = this.organization_types.filter(organization_type=>{
                                    return organization_type.id != id
                                })
                            })
                            .catch(() =>{
                                _this.allOrganizationType();
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