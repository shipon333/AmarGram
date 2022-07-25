<template>
    <div>
        <section class="content">
            <div class="row">
                <div class="col-lg-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Member Type</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form >
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="name">Member Type Name</label><small class="req"> *</small>
                                    <input autofocus="" id="name" v-model="form.title"  placeholder="Member Title" type="text" class="form-control" autocomplete="off">
                                    <small class="text-danger" v-if="errors.title">{{errors.title[0]}}</small>
                                </div>
                                <div class="form-group">
                                    <label for="name">Member Minimum Requirements</label><small class="req"> *</small>
                                    <textarea autofocus=""  v-model="form.minimum_requirements"  placeholder="Member Minimum Requirements" class="form-control" autocomplete="off"></textarea>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button  type="submit" @click.prevent="formReset" class="btn btn-info pull-left">Reset</button>
                                <button v-if="form.memberType_id == ''" type="submit" @click.prevent="addMemberType" class="btn btn-info pull-right">Save</button>
                                <button v-else type="submit" @click.prevent="updateMemberType" class="btn btn-info pull-right">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="box box-primary" id="exphead">
                        <div class="box-header with-border">
                            <h3 class="box-title">Member Type List</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="download_label">Member Type List</div>
                            <div class="table-responsive mailbox-messages">
                                <table class="table table-striped table-bordered table-hover" id="dataTable">
                                    <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Minimum Requirements</th>
                                        <th class="text-right no-print">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="memberType in memberTypes" :key="memberType.id">
                                        <td class="mailbox-name">{{memberType.title}}</td>
                                        <td class="mailbox-name">{{memberType.minimum_requirements}}</td>
                                        <td class="mailbox-date pull-right no-print">
                                            <button @click="editMemberType(memberType)" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button @click="deleteMemberType(memberType.id)" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" >
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
        name: "MemberType",
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
            this.allMemberType();
            this.resetData();
        },
        watch: {
            memberTypes(val) {
                this.dt.destroy();
                this.$nextTick(() => {
                    this.dt = $('#dataTable').DataTable()
                });
            }
        },

        data(){
            return{
                memberTypes:[],
                form:{
                    title: null,
                    memberType_id: '',
                    minimum_requirements:'',
                    user_id: User.id(),
                },
                errors:{}
            }
        },

        methods:{
            allMemberType(){
                axios.get('/api/member/type'+'?userId='+User.id())
                    .then(({data}) => (this.memberTypes = data))
                    .catch()
            },
            addMemberType(){
                let _this = this;
                axios.post('/api/member/type',this.form)

                    .then(res => {
                        toastr.success('Member Type Add Successfully', {timeOut: 500});
                        _this.allMemberType();
                        this.resetData();
                    })
                    .catch(error => {
                        _this.errors = error.response.data.errors

                    })
            },
            updateMemberType(){
                let id = this.form.memberType_id;
                let _this = this;
                axios.patch('/api/member/type/'+id,this.form)
                    .then(res=>{
                        toastr.success('Member Type Update Successfully', {timeOut: 500});
                        _this.allMemberType();
                        this.resetData();
                    })
                    .catch(error => {
                        _this.errors = error.response.data.errors

                    })
            },
            formReset(){
                this.resetData();
            },
            editMemberType: function(memberType){
                this.form.title = memberType.title;
                this.form.minimum_requirements = memberType.minimum_requirements;
                this.form.memberType_id = memberType.id;
            },
            resetData(){
                this.form.title = '';
                this.form.minimum_requirements = '';
                this.form.memberType_id = '';
                this.errors=''
            },
            deleteMemberType(id){
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
                        axios.delete('/api/member/type/'+id)
                            .then(() =>{
                                this.memberTypes = this.memberTypes.filter(memberType=>{
                                    return memberType.id != id
                                })
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                            })
                            .catch(() =>{
                                _this.allMemberType();
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