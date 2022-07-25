<template>
    <div>
        <section class="content">
            <div class="row">
                <div class="col-lg-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Create/Update Project</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form >
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Project Name</label><small class="req"> *</small>
                                    <input v-model="form.name"  placeholder="Project Name" type="text" class="form-control" autocomplete="off">
                                    <small class="text-danger" v-if="errors.name">{{errors.name[0]}}</small>
                                </div>
                                <div class="form-group">
                                    <label>Start Date</label>
                                    <input v-model="form.start_date"  placeholder="Project Start Date" type="date" class="form-control" autocomplete="off">
                                    <small class="text-danger" v-if="errors.start_date">{{errors.start_date[0]}}</small>
                                </div>
                                <div class="form-group">
                                    <label>Location</label>
                                    <input v-model="form.location"  placeholder="Project Location" type="text" class="form-control" autocomplete="off">
                                    <small class="text-danger" v-if="errors.location">{{errors.location[0]}}</small>
                                </div>
                                <div class="form-group">
                                    <label>Estimated Budget</label>
                                    <input v-model="form.budget"  placeholder="Project Estimated Budget" type="text" class="form-control" autocomplete="off">
                                    <small class="text-danger" v-if="errors.budget">{{errors.budget[0]}}</small>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea v-model="form.description"  placeholder="Note" class="form-control" autocomplete="off"></textarea>
                                    <small class="text-danger" v-if="errors.description">{{errors.description[0]}}</small>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button  type="submit" @click.prevent="formReset" class="btn btn-info pull-left">Reset</button>
                                <button v-if="form.project_id == ''" type="submit" @click.prevent="addProject" class="btn btn-info pull-right">Save</button>
                                <button v-else type="submit" @click.prevent="updateProject" class="btn btn-info pull-right">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="box box-primary" id="exphead">
                        <div class="box-header with-border">
                            <h3 class="box-title">Projects List</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="download_label">Projects List</div>
                            <div class="table-responsive mailbox-messages">
                                <table class="table table-striped table-bordered table-hover" id="dataTable">
                                    <thead>
                                    <tr>
                                        <th>Project Name</th>
                                        <th>Location</th>
                                        <th>Start Date</th>
                                        <th>Budget</th>
                                        <th>Description</th>
                                        <th class="text-right no-print" width="85px">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="project in projects" :key="project.id">
                                        <td>{{project.name}}</td>
                                        <td>{{project.location}}</td>
                                        <td>{{project.start_date}}</td>
                                        <td>{{project.budget}}</td>
                                        <td>{{project.description}}</td>
                                        <td class="mailbox-date pull-right no-print">
                                            <router-link :to="{name:'viewProject', params:{id:project.id}}" class="btn btn-success btn-xs" data-toggle="tooltip" title="Project Details">
                                                <i class="fa fa-eye"></i>
                                            </router-link>
                                            <button @click="editProject(project)" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit Project">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button @click="deleteProject(project.id)" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete Project" >
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
        name: "ProjectList",
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
            this.allProject();
            this.resetData();

        },
        data(){
            return{
                projects:[],
                form:{
                    name: null,
                    start_date: '',
                    location: '',
                    budget: '',
                    description: '',
                    project_id: '',
                    user_id: User.id(),
                },
                errors:{}
            }
        },
        watch: {
            projects(val) {
                this.dt.destroy();
                this.$nextTick(() => {
                    this.dt = $('#dataTable').DataTable()
                });
            }
        },

        methods:{
            allProject(){
                axios.get('/api/project'+'?userId='+User.id())
                    .then(({data}) => (this.projects = data))
                    .catch()
            },

            addProject(){
                let _this = this;
                axios.post('/api/project',this.form)

                    .then(res => {
                        toastr.success('Project Add Successfully', {timeOut: 500});
                        _this.allProject();
                        this.resetData();
                    })
                    .catch(error => {
                        _this.errors = error.response.data.errors

                    })
            },
            updateProject(){
                let id = this.form.project_id;
                let _this = this;
                axios.patch('/api/project/'+id,this.form)
                    .then(res=>{
                        toastr.success('Project Update Successfully', {timeOut: 500});
                        _this.allProject();
                        this.resetData();
                    })
                    .catch(error => {
                        _this.errors = error.response.data.errors
                    })
            },
            formReset(){
                this.resetData();
            },
            editProject: function(project){
                this.form.name = project.name;
                this.form.start_date = project.start_date;
                this.form.location = project.location;
                this.form.budget = project.budget;
                this.form.description = project.description;
                this.form.project_id = project.id;
            },
            resetData(){
                this.form.name = '';
                this.form.start_date = '';
                this.form.location = '';
                this.form.budget = '';
                this.project_id = '';
                this.form.description = '';
                this.errors=''
            },
            deleteProject(id){
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
                        axios.delete('/api/project/'+id)
                            .then(() =>{
                                this.projects = this.projects.filter(project=>{
                                    return project.id != id
                                })

                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                            })
                            .catch((err) =>{
                                toastr.warning('Cant Delete Data', {timeOut: 500});
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