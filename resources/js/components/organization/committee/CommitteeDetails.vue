<template>
    <div>
        <section class="content">
            <div class="row">
                <div class="col-lg-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Committee Details</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form >
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="name">Member</label><small class="req"> *</small>
                                    <select v-model="form.member_id" autofocus=""  class="form-control" >
                                        <option value="">Select Member</option>
                                        <option :value="member.id" v-for="member in members" >{{member.people.name}}</option>
                                    </select>
                                    <small class="text-danger" v-if="errors.member_id">{{errors.member_id[0]}}</small>
                                </div>
                                <!--<div class="form-group">-->
                                    <!--<label for="name">Committee</label><small class="req"> *</small>-->
                                    <!--<select v-model="form.committee_id" autofocus=""  class="form-control" >-->
                                        <!--<option value="">Select Committee</option>-->
                                        <!--<option :value="committee.id" v-for="committee in committees" >{{committee.name}}</option>-->
                                    <!--</select>-->
                                    <!--<small class="text-danger" v-if="errors.committee_id">{{errors.committee_id[0]}}</small>-->
                                <!--</div>-->
                                <div class="form-group">
                                    <label for="name">Committee Designation</label><small class="req"> *</small>
                                    <select v-model="form.committee_designation_id" autofocus=""  class="form-control" >
                                        <option value="">Select Committee Designation</option>
                                        <option :value="committeeDesignation.id" v-for="committeeDesignation in committeeDesignations" >{{committeeDesignation.title}}</option>
                                    </select>
                                    <small class="text-danger" v-if="errors.committee_designation_id">{{errors.committee_designation_id[0]}}</small>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button  type="submit" @click.prevent="formReset" class="btn btn-info pull-left">Reset</button>
                                <button v-if="form.committeeDetails_id == ''" type="submit" @click.prevent="addCommitteeDetails" class="btn btn-info pull-right">Save</button>
                                <button v-else type="submit" @click.prevent="updateCommitteeDetails" class="btn btn-info pull-right">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="box box-primary" id="exphead">
                        <div class="box-header with-border">
                            <h3 class="box-title">Committee Details List</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="download_label">Committee Details List</div>
                            <div class="table-responsive mailbox-messages">
                                <table class="table table-striped table-bordered table-hover" id="dataTable">
                                    <thead>
                                    <tr>
                                        <th>Member</th>
                                        <th>Committee</th>
                                        <th>Committee Designation</th>
                                        <th class="text-right no-print">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="committeeDetail in committeeDetails" :key="committeeDetail.id">
                                        <td class="mailbox-name" >
                                            <router-link :to="{name:'showPeople', params:{id:committeeDetail.member.people.id}}" data-toggle="tooltip" title="View Profile">
                                                {{committeeDetail.member.people.name}}
                                            </router-link>

                                        </td>
                                        <td class="mailbox-name" >{{committeeDetail.committee.name}}</td>
                                        <td class="mailbox-name" >{{committeeDetail.committee_designation.title}}</td>
                                        <td class="mailbox-date pull-right no-print">
                                            <button @click="deleteCommitteeDetails(committeeDetail.id)" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" >
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
        name: "CommitteeDetails",
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
            this.allCommitteeDetails();
            this.allCommitteeDesignation();
            this.resetData();
            this.getCommittee();
            this.allMember();
            this.form.committee_id = this.$route.params.id;
        },
        watch: {
            committeeDetails(val) {
                this.dt.destroy();
                this.$nextTick(() => {
                    this.dt = $('#dataTable').DataTable()
                });
            }
        },

        data(){
            return{
                committeeDetails:[],
                committees:[],
                members:[],
                committeeDesignations:[],
                form:{
                    member_id: '',
                    committee_id:'',
                    committee_designation_id:'',
                    committeeDetails_id: '',
                    user_id: User.id(),
                },
                errors:{}
            }
        },

        methods:{

            allCommitteeDetails(){
                var id = this.$route.params.id;
                axios.get('/api/committee-details/'+id)
                    .then(({data}) => (this.committeeDetails = data))
                    .catch()
            },
            getCommittee(){
                axios.get('/api/committee'+'?userId='+User.id())
                    .then(({data}) => (this.committees = data))
                    .catch()
            },
            allMember(){
                axios.get('/api/member'+'?userId='+User.id())
                    .then(({data}) => (this.members = data))
                    .catch()
            },
            allCommitteeDesignation(){
                axios.get('/api/committee/designation'+'?userId='+User.id())
                    .then(({data}) => (this.committeeDesignations = data))
                    .catch()
            },
            addCommitteeDetails(){
                let _this = this;
                axios.post('/api/committee-member-store',this.form)

                    .then(res => {
                        toastr.success('Committee Details Add Successfully', {timeOut: 500});
                        _this.allCommitteeDetails();
                        this.resetData();
                    })
                    .catch(error => {
                        _this.errors = error.response.data.errors

                    })
            },
            updateCommitteeDetails(){
                let id = this.form.committeeDetails_id;
                let _this = this;
                axios.patch('/api/committee-details/'+id,this.form)
                    .then(res=>{
                        toastr.success('Committee Details Update Successfully', {timeOut: 500});
                        _this.allCommitteeDetails();
                        this.resetData();
                    })
                    .catch(error => {
                        _this.errors = error.response.data.errors

                    })
            },
            formReset(){
                this.resetData();
            },
            editCommitteeDetails: function(committeeDetails){
                this.form.member_id = committeeDetails.member_id;
                this.form.committee_id = committeeDetails.committee_id;
                this.form.committee_designation_id = committeeDetails.committee_designation_id;
                this.form.committeeDetails_id = committeeDetails.committeeDetails_id;
            },
            resetData(){
                this.form.member_id = '';
                this.form.committee_designation_id = '';
                this.form.committeeDetails_id = '';
                this.errors=''
            },
            deleteCommitteeDetails(id){
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
                        axios.post('/api/committee-member-delete/'+id)
                            .then(() =>{
                                this.committeeDetailss = this.committeeDetailss.filter(CommitteeDetails=>{
                                    return CommitteeDetails.id != id
                                })
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                            })
                            .catch(() =>{
                                _this.allCommitteeDetails();
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