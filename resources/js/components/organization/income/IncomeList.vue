<template>
    <div>
        <section class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary" id="exphead">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-money"></i> Incomes List</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="download_label">Incomes List</div>
                            <div class="table-responsive mailbox-messages">
                                <table class="table table-striped table-bordered table-hover" id="dataTable">
                                    <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Income Type</th>
                                        <th>Date</th>
                                        <th>Investment Name</th>
                                        <th>Amount</th>
                                        <th>Notes</th>
                                        <th class="text-right no-print">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="income in incomes" :key="income.id">
                                        <td>{{ income.title }}</td>
                                        <td>{{ income.income_type.name }}</td>
                                        <td>{{ income.date }}</td>
                                        <td v-if="income.investment_id != null">
                                            <router-link :to="{name:'viewInvestment', params:{id:income.investment_id}}">
                                                {{ income.investment.name }}
                                            </router-link>
                                        </td>
                                        <td v-else>-</td>
                                        <td>{{ income.amount }}</td>
                                        <td>{{ income.note }}</td>
                                        <td class="mailbox-date pull-right no-print">
                                            <router-link :to="{name:'incomeEdit', params:{id:income.id}}" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Income Edit">
                                                <i class="fa fa-pencil"></i>
                                            </router-link>
                                            <button @click="deleteIncome(income.id)" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete Income" >
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
        name: "IncomeList",
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
            this.allIncome();
        },
        data(){
            return{
                incomes:[]
            }
        },
        watch: {
            incomes(val) {
                this.dt.destroy();
                this.$nextTick(() => {
                    this.dt = $('#dataTable').DataTable()
                });
            }
        },

        methods:{
            allIncome(){
                axios.get('/api/income'+'?userId='+User.id())
                    .then(({data}) => (this.incomes = data))
                    .catch()
            },
            deleteIncome(id){
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
                        axios.delete('/api/income/'+id)
                            .then(() =>{
                                this.incomes = this.incomes.filter(income=>{
                                    return income.id != id

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