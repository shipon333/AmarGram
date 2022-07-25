<template>
    <div>
        <section class="content">
            <div class="row">
                <div class="col-md-3">
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <h3 class="profile-username text-center">Investment Name: {{ investment.name }}</h3>
                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item listnoback">
                                    <b>Amount</b> <a class="pull-right text-aqua">{{investment.amount}}</a>
                                </li>
                                <li class="list-group-item listnoback">
                                    <b>Return Capital</b> <a class="pull-right text-aqua">{{investment.return_capital}}</a>
                                </li>
                                <li class="list-group-item listnoback">
                                    <b>Invest Date</b> <a class="pull-right text-aqua">{{investment.invest_date}}</a>
                                </li>
                                <li class="list-group-item listnoback">
                                    <b>Note</b> <a class="pull-right text-aqua">{{investment.note}}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#income" data-toggle="tab" aria-expanded="true">Income</a></li>
                            <li class=""><a href="#documents" data-toggle="tab" aria-expanded="false">Documents</a></li>

                            <!--<li class="pull-right" v-if="investment.status==1">-->
                                <!--<a @click.prevent="" class="text-red" data-toggle="tooltip" title="Disable">-->
                                    <!--<i class="fa fa-thumbs-o-down"></i>-->
                                <!--</a>-->
                            <!--</li>-->
                            <!--<li class="pull-right" v-if="investment.status==0">-->
                                <!--<a @click.prevent="" class="text-red" data-toggle="tooltip" title="Enable">-->
                                    <!--<i class="fa fa-thumbs-o-up"></i>-->
                                <!--</a>-->
                            <!--</li>-->
                            <li class="pull-right">
                                <router-link to="/income/create" class="text-green" data-toggle="tooltip" title="Add Income">
                                    <i class="fa fa-plus"></i>
                                </router-link>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="income">
                                <div class="tshadow mb25 bozero">
                                    <div class="table-responsive around10 pt0">
                                        <table class="table table-striped table-bordered table-hover example" id="dataTable">
                                            <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Date</th>
                                                <th>Type</th>
                                                <th>Amount</th>
                                                <th>Note</th>
                                                <th class="text-right no-print">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="income in investment.incomes" :key="income.id">
                                                <td>{{ income.title }}</td>
                                                <td>{{ income.date }}</td>
                                                <td>{{ income.income_type.name }}</td>
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
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="documents">
                                <div class="timeline-header no-border">
                                    <button type="button" class="btn btn-xs btn-primary pull-right"> <i class="fa fa-upload"></i>  Upload Documents</button>

                                    <!-- <h2 class="page-header"> </h2> -->
                                    <div class="table-responsive" style="clear: both;">
                                        <div class="row">
                                        </div><table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Name</th>
                                            <th class="mailbox-date text-right">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td colspan="5" class="text-danger text-center">No Record Found</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        name: "ShowInvestment",
        beforeCreate(){
            if (!User.loggedIn()){
                this.$router.push({name:'/'})
            }
            if ( User.loggedIn() && User.userType() != "org") {
                this.$router.back();
            }
        },
        data(){
            return{
                investment:[]
            }
        },
        mounted(){
            this.getInvestment(this.$route.params.id);
        },
        methods:{
            getInvestment(id){
                axios.get('/api/investment/'+id)
                    .then(({data})=> (this.investment = data))
                    .catch(error =>{
                        this.errors = error.response.data.errors
                    })
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
                                this.investment.incomes = this.investment.incomes.filter(income=>{
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
