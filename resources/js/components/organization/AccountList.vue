<template>
    <div>
        <section class="content">
            <div class="row">
                <div class="col-lg-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-bank"></i> Create/Update Account</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form >
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Account Name</label><small class="req"> *</small>
                                    <input v-model="form.name"  placeholder="Account Name" type="text" class="form-control" autocomplete="off">
                                    <small class="text-danger" v-if="errors.name">{{errors.name[0]}}</small>
                                </div>
                                <div class="form-group">
                                    <label>Account Type</label>
                                    <select v-model="form.type" id="project" class="form-control" >
                                        <option value="">Select Account Type</option>
                                        <option value="cash">Cash</option>
                                        <option value="bank">Bank</option>
                                        <option value="mobile_banking">Mobile Banking</option>
                                    </select>
                                    <small class="text-danger" v-if="errors.type">{{errors.type[0]}}</small>
                                </div>
                                <div class="form-group">
                                    <label>Account Number</label>
                                    <input v-model="form.account_number"  placeholder="Account Number" type="text" class="form-control" autocomplete="off">
                                    <small class="text-danger" v-if="errors.account_number">{{errors.account_number[0]}}</small>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button  type="submit" @click.prevent="formReset" class="btn btn-info pull-left">Reset</button>
                                <button v-if="form.account_id == ''" type="submit" @click.prevent="addAccount" class="btn btn-info pull-right">Save</button>
                                <button v-else type="submit" @click.prevent="updateAccount" class="btn btn-info pull-right">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="box box-primary" id="exphead">
                        <div class="box-header with-border">
                            <span class="box-title pull-left"><i class="fa fa-bank"></i> Account List</span>
                            <span class="btn btn-xs btn-success pull-right"><i class="fa fa-bank"></i> Transfer Balance</span>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="download_label">Accounts List</div>
                            <div class="table-responsive mailbox-messages">
                                <table class="table table-striped table-bordered table-hover" id="dataTable">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Account Number</th>
                                        <th>Balance</th>
                                        <th class="text-right no-print">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="account in accounts" :key="account.id">
                                        <td>{{account.name}}</td>
                                        <td>{{account.type}}</td>
                                        <td>{{ account.account_number }}</td>
                                        <td>{{ account.balance }}</td>
                                        <td class="mailbox-date pull-right no-print">
                                            <button @click="editAccount(account)" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit Account">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button @click="deleteAccount(account.id)" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete Account" >
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
        name: "AccountList",
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
            this.allAccount();
            this.resetData();

        },
        data(){
            return{
                accounts:[],
                form:{
                    name: null,
                    type: '',
                    account_number: '',
                    account_id: '',
                    user_id: User.id(),
                },
                errors:{}
            }
        },
        watch: {
            accounts(val) {
                this.dt.destroy();
                this.$nextTick(() => {
                    this.dt = $('#dataTable').DataTable()
                });
            }
        },

        methods:{
            allAccount(){
                axios.get('/api/account'+'?userId='+User.id())
                    .then(({data}) => (this.accounts = data))
                    .catch()
            },

            addAccount(){
                let _this = this;
                axios.post('/api/account',this.form)

                    .then(res => {
                        toastr.success('Account Add Successfully', {timeOut: 500});
                        _this.allAccount();
                        this.resetData();
                    })
                    .catch(error => {
                        _this.errors = error.response.data.errors

                    })
            },
            updateAccount(){
                let id = this.form.account_id;
                let _this = this;
                axios.patch('/api/account/'+id,this.form)
                    .then(res=>{
                        toastr.success('Account Update Successfully', {timeOut: 500});
                        _this.allAccount();
                        this.resetData();
                    })
                    .catch(error => {
                        _this.errors = error.response.data.errors
                    })
            },
            formReset(){
                this.resetData();
            },
            editAccount: function(account){
                this.form.name = account.name;
                this.form.type = account.type;
                this.form.account_number = account.account_number;
                this.form.account_id = account.id;
            },
            resetData(){
                this.form.name = '';
                this.form.type = '';
                this.form.account_number = '';
                this.form.account_id = '';
                this.errors=''
            },
            deleteAccount(id){
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
                        axios.delete('/api/account/'+id)
                            .then(() =>{
                                this.accounts = this.accounts.filter(account=>{
                                    return account.id != id
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