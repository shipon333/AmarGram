<template>
    <div>
        <section class="content">
            <div class="row">
                <div class="col-lg-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Committee</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form >
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="name">Committee Name</label><small class="req"> *</small>
                                    <input autofocus="" id="name" v-model="form.name"  placeholder="Committee Name" type="text" class="form-control" autocomplete="off">
                                    <small class="text-danger" v-if="errors.name">{{errors.name[0]}}</small>
                                </div>
                                <div class="form-group">
                                    <label>Beginning Date</label>
                                    <input v-model="form.start_date" placeholder="Start Date" type="date" class="form-control">
                                    <small class="text-danger" v-if="errors.start_date">{{errors.start_date[0]}}</small>
                                </div>
                                <div class="form-group">
                                    <label>Expire Date</label>
                                    <input v-model="form.end_date" placeholder="Start Date" type="date" class="form-control">
                                    <small class="text-danger" v-if="errors.end_date">{{errors.end_date[0]}}</small>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button  type="submit" @click.prevent="formReset" class="btn btn-info pull-left">Reset</button>
                                <button v-if="form.Committee_id == ''" type="submit" @click.prevent="addCommittee" class="btn btn-info pull-right">Save</button>
                                <button v-else type="submit" @click.prevent="updateCommittee" class="btn btn-info pull-right">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="box box-primary" id="exphead">
                        <div class="box-header with-border">
                            <h3 class="box-title">Committee List</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="download_label">Committee List</div>
                            <div class="table-responsive mailbox-messages">
                                <table class="table table-striped table-bordered table-hover" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Committee Name</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th class="text-right no-print">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="committee in committees" :key="committee.id">
                                        <td class="mailbox-name">{{committee.name}}</td>
                                        <td class="mailbox-name">{{committee.start_date}}</td>
                                        <td class="mailbox-name">{{committee.end_date}}</td>
                                        <td class="mailbox-date pull-right no-print">
                                            <router-link :to="{name:'committeeDetails', params:{id:committee.id}}" class="btn btn-success btn-xs" data-toggle="tooltip" title="Edit">
                                                <i class="fa fa-eye"></i>
                                            </router-link>
                                            <button @click="editCommittee(committee)" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button @click="deleteCommittee(committee.id)" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" >
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
        name: "Committee",
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
            this.allCommittee();
            this.resetData();
        },
        watch: {
            committees(val) {
                this.dt.destroy();
                this.$nextTick(() => {
                    this.dt = $('#dataTable').DataTable()
                });
            }
        },

        data(){
            return{
                committees:[],
                user:[],
                form:{
                    name: null,
                    start_date:'',
                    end_date:'',
                    Committee_id: '',
                    user_id: User.id(),
                },
                errors:{}
            }
        },

        methods:{

            allCommittee(){
                axios.get('/api/committee'+'?userId='+User.id())
                    .then(({data}) => (this.committees = data))
                    .catch()
            },
            addCommittee(){
                let _this = this;
                axios.post('/api/committee',this.form)

                    .then(res => {
                        toastr.success('Committee Add Successfully', {timeOut: 500});
                        _this.allCommittee();
                        this.resetData();
                    })
                    .catch(error => {
                        _this.errors = error.response.data.errors

                    })
            },
            updateCommittee(){
                let id = this.form.Committee_id;
                let _this = this;
                axios.patch('/api/committee/'+id,this.form)
                    .then(res=>{
                        toastr.success('Committee Update Successfully', {timeOut: 500});
                        _this.allCommittee();
                        this.resetData();
                    })
                    .catch(error => {
                        _this.errors = error.response.data.errors

                    })
            },
            formReset(){
                this.resetData();
            },
            editCommittee: function(Committee){
                this.form.name = Committee.name;
                this.form.start_date = Committee.start_date;
                this.form.end_date = Committee.end_date;
                this.form.Committee_id = Committee.id;
            },
            resetData(){
                this.form.name = '';
                this.form.start_date = '';
                this.form.end_date = '';
                this.form.Committee_id = '';
                this.errors=''
            },
            deleteCommittee(id){
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
                        axios.delete('/api/committee/'+id)
                            .then(() =>{
                                this.Committees = this.Committees.filter(Committee=>{
                                    return Committee.id != id
                                })
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                            })
                            .catch(() =>{
                                _this.allCommittee();
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