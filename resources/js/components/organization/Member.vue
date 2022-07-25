<template>
    <div>
        <section class="content">
            <div class="row">
                <div class="col-lg-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Member</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form >
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Member Type</label><small class="req"> *</small>
                                    <select v-model="form.member_type_id" autofocus=""  class="form-control" >
                                        <option value="">Select Member Type</option>
                                        <option :value="member_type.id" v-for="member_type in member_types" >{{member_type.title}}</option>
                                    </select>
                                    <small class="text-danger" v-if="errors.member_type_id">{{errors.member_type_id[0]}}</small>
                                </div>
                                <div class="form-group">
                                    <label>Member</label><small class="req"> *</small>
                                    <select v-model="form.people_id" autofocus=""  class="form-control" >
                                        <option value="">Select Member</option>
                                        <option :value="people.id" v-for="people in peoples" >{{people.name}}</option>
                                    </select>
                                    <small class="text-danger" v-if="errors.people_id">{{errors.people_id[0]}}</small>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button  type="submit" @click.prevent="formReset" class="btn btn-info pull-left">Reset</button>
                                <button v-if="form.member_id == ''" type="submit" @click.prevent="addMember" class="btn btn-info pull-right">Save</button>
                                <button v-else type="submit" @click.prevent="updateMember" class="btn btn-info pull-right">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="box box-primary" id="exphead">
                        <div class="box-header with-border">
                            <h3 class="box-title">Member List</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="download_label">Member List</div>
                            <div class="table-responsive mailbox-messages">
                                <table class="table table-striped table-bordered table-hover" id="dataTable">
                                    <thead>
                                    <tr>
                                        <th>Member Type</th>
                                        <th>Member Name</th>
                                        <th class="text-right no-print">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="member in members" :key="member.id">
                                        <td class="mailbox-name" v-if="member.member_type">{{member.member_type.title}}</td>
                                        <td class="mailbox-name" v-if="member.people">{{member.people.name}}</td>
                                        <td class="mailbox-date pull-right no-print">
                                            <button @click="editMember(member)" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button @click="deleteMember(member.id)" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" >
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
        name: "Member",
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
            this.allMember();
            this.resetData();
            this.memberTypes();
            this.getPeoples();
        },
        watch: {
            members(val) {
                this.dt.destroy();
                this.$nextTick(() => {
                    this.dt = $('#dataTable').DataTable()
                });
            }
        },

        data(){
            return{
                members:[],
                member_types:[],
                peoples:[],
                form:{
                    member_type_id: '',
                    people_id:'',
                    member_id: '',
                    user_id: User.id(),
                },
                errors:{}
            }
        },

        methods:{
            allMember(){
                axios.get('/api/member'+'?userId='+User.id())
                    .then(({data}) => (this.members = data))
                    .catch()
            },
            memberTypes(){
                axios.get('/api/member/type'+'?userId='+User.id())
                    .then(({data}) => (this.member_types = data))
                    .catch(error=>{
                        this.errors = error.response.data.errors
                    })
            },
            getPeoples(){
                var village_id = User.villageId();
                axios.get('/api/people'+'?villageId='+village_id)
                    .then(({data})=>this.peoples = data)
                    .catch(error=>{
                        this.errors = error.response.data.errors
                    })
            },
            addMember(){
                let _this = this;
                axios.post('/api/member',this.form)

                    .then(res => {
                        toastr.success('Member Add Successfully', {timeOut: 500});
                        _this.allMember();
                        this.resetData();
                    })
                    .catch(error => {
                        _this.errors = error.response.data.errors

                    })
            },
            updateMember(){
                let id = this.form.member_id;
                let _this = this;
                axios.patch('/api/member/'+id,this.form)
                    .then(res=>{
                        toastr.success('Member Update Successfully', {timeOut: 500});
                        _this.allMember();
                        this.resetData();
                    })
                    .catch(error => {
                        _this.errors = error.response.data.errors

                    })
            },
            formReset(){
                this.resetData();
            },
            editMember: function(member){
                this.form.member_type_id = member.member_type_id;
                this.form.people_id = member.people_id;
                this.form.member_id = member.id;
            },
            resetData(){
                this.form.member_type_id = '';
                this.form.people_id = '';
                this.form.member_id = '';
                this.errors=''
            },
            deleteMember(id){
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
                        axios.delete('/api/member/'+id)
                            .then(() =>{
                                this.members = this.members.filter(Member=>{
                                    return Member.id != id
                                })
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                            })
                            .catch(() =>{
                                _this.allMember();
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