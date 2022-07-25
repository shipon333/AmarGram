<template>
    <div>
        <section class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary" id="exphead">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-money"></i> Expenses List</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="download_label">Expenses List</div>
                            <div class="table-responsive mailbox-messages">
                                <table class="table table-striped table-bordered table-hover" id="dataTable">
                                    <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Expense Type</th>
                                        <th>Date</th>
                                        <th>Project Name</th>
                                        <th>Amount</th>
                                        <th>Notes</th>
                                        <th class="text-right no-print">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="expense in expenses" :key="expense.id">
                                        <td>{{ expense.title }}</td>
                                        <td>{{ expense.expense_type.name }}</td>
                                        <td>{{ expense.date }}</td>
                                        <td v-if="expense.project_id != null">
                                            <router-link :to="{name:'viewProject', params:{id:expense.project_id}}">
                                                {{ expense.project.name }}
                                            </router-link>
                                        </td>
                                        <td v-else>-</td>
                                        <td>{{ expense.amount }}</td>
                                        <td>{{ expense.note }}</td>
                                        <td class="mailbox-date pull-right no-print">
                                            <router-link :to="{name:'expenseEdit', params:{id:expense.id}}" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Expense Edit">
                                                <i class="fa fa-pencil"></i>
                                            </router-link>
                                            <button @click="deleteExpense(expense.id)" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete Expense" >
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
        name: "ExpenseList",
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
            this.allExpense();
        },
        data(){
            return{
                expenses:[]
            }
        },
        watch: {
            expenses(val) {
                this.dt.destroy();
                this.$nextTick(() => {
                    this.dt = $('#dataTable').DataTable()
                });
            }
        },

        methods:{
            allExpense(){
                axios.get('/api/expense'+'?userId='+User.id())
                    .then(({data}) => (this.expenses = data))
                    .catch()
            },
            deleteExpense(id){
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
                        axios.delete('/api/expense/'+id)
                            .then(() =>{
                                this.expenses = this.expenses.filter(expense=>{
                                    return expense.id != id

                                });
                                Swal.fire(
                                    'Deleted!',
                                    'Your record has been deleted.',
                                    'success'
                                )
                            })
                            .catch((error) =>{
                                var massage = this.errors = error.response.data.errors;
                                Toast.fire({
                                    icon: 'warning',
                                    title: 'Can Not Delete It!'
                                })
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