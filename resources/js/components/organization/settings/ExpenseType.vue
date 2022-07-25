<template>
    <div>
        <section class="content">
            <div class="row">
                <div class="col-lg-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"> <i class="fa fa-plus-square"></i> Add Expense Type</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form >
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="name">Expense Type Name</label><small class="req"> *</small>
                                    <input autofocus="" id="name" v-model="form.name"  placeholder="Expense Type Name" type="text" class="form-control" autocomplete="off">
                                    <small class="text-danger" v-if="errors.name">{{errors.name[0]}}</small>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button  type="reset" class="btn btn-info pull-left">Reset</button>
                                <button v-if="form.expense_type_id == ''" type="submit" @click.prevent="addExpenseType" class="btn btn-info pull-right">Save</button>
                                <button v-else type="submit" @click.prevent="updateExpenseType" class="btn btn-info pull-right">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="box box-primary" id="exphead">
                        <div class="box-header with-border">
                            <h3 class="box-title"> <i class="fa fa-list"></i> Expense Type List</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="download_label">Expense Type List</div>
                            <div class="table-responsive mailbox-messages">
                                <table class="table table-striped table-bordered table-hover" id="dataTable">
                                    <thead>
                                    <tr>
                                        <th>Expense Type Name</th>
                                        <th class="text-right no-print">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="expense_type in expense_types" :key="expense_type.id">
                                        <td class="mailbox-name">{{expense_type.name}}</td>
                                        <td class="mailbox-date pull-right no-print">
                                            <button @click="editExpenseType(expense_type)" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button @click="deleteExpenseType(expense_type.id)" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" >
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
        name: "ExpenseType",
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
             this.allExpenseType();
             this.resetData();
        },
        watch: {
            expense_types(val) {
                this.dt.destroy();
                this.$nextTick(() => {
                    this.dt = $('#dataTable').DataTable()
                });
            }
        },

        data(){
            return{
                expense_types:[],
                form:{
                    name: null,
                    expense_type_id: '',
                    user_id: User.id(),
                },
                errors:{}
            }
        },

        methods:{
            allExpenseType(){
                axios.get('/api/expense-type'+'?userId='+User.id())
                    .then(({data}) => (this.expense_types = data))
                    .catch()
            },

            addExpenseType(){
                let _this = this;
                axios.post('/api/expense-type',this.form)

                    .then(res => {
                        toastr.success('Expense Type Add Successfully', {timeOut: 500});
                        _this.allExpenseType();
                        this.resetData();
                    })
                    .catch(error => {
                        _this.errors = error.response.data.errors

                    })
            },
            updateExpenseType(){
                let id = this.form.expense_type_id;
                let _this = this;
                axios.patch('/api/expense-type/'+id,this.form)
                    .then(res=>{
                        toastr.success('Expense Type Update Successfully', {timeOut: 500});
                        _this.allExpenseType();
                        this.resetData();
                    })
                    .catch(error => {
                        _this.errors = error.response.data.errors

                    })
            },
            editExpenseType: function(expense_type){
                this.form.name = expense_type.name;
                this.form.expense_type_id = expense_type.id;
            },
            resetData(){
                this.form.name = '';
                this.form.expense_type_id = '';
                this.errors=''
            },
            deleteExpenseType(id){
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
                        axios.delete('/api/expense-type/'+id)
                            .then(() =>{
                                this.expense_types = this.expense_types.filter(expense_type=>{
                                    return expense_type.id != id
                                })
                            })
                            .catch(() =>{
                                _this.allExpenseType();
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