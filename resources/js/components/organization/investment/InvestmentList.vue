<template>
    <div>
        <section class="content">
            <div class="row">
                <div class="col-lg-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Create/Update Investment</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form >
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Investment Name</label><small class="req"> *</small>
                                    <input v-model="form.name"  placeholder="Investment Name" type="text" class="form-control" autocomplete="off">
                                    <small class="text-danger" v-if="errors.name">{{errors.name[0]}}</small>
                                </div>
                                <div class="form-group">
                                    <label>Invest Date*</label>
                                    <input v-model="form.invest_date"  placeholder="Investment Start Date" type="date" class="form-control" autocomplete="off">
                                    <small class="text-danger" v-if="errors.invest_date">{{errors.invest_date[0]}}</small>
                                </div>
                                <div class="form-group">
                                    <label>Capital Amount</label>
                                    <input v-model="form.amount"  placeholder="Investment Amount" type="text" class="form-control" autocomplete="off">
                                    <small class="text-danger" v-if="errors.amount">{{errors.amount[0]}}</small>
                                </div>
                                <div class="form-group">
                                    <label>Return Capital</label>
                                    <input v-model="form.return_capital"  placeholder="Capital Return Amount" type="text" class="form-control" autocomplete="off">
                                    <small class="text-danger" v-if="errors.return_capital">{{errors.return_capital[0]}}</small>
                                </div>
                                <div class="form-group">
                                    <label>Note</label>
                                    <textarea v-model="form.note"  placeholder="Note" class="form-control" autocomplete="off"></textarea>
                                    <small class="text-danger" v-if="errors.note">{{errors.note[0]}}</small>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button  type="submit" @click.prevent="formReset" class="btn btn-info pull-left">Reset</button>
                                <button v-if="form.investment_id == ''" type="submit" @click.prevent="addInvestment" class="btn btn-info pull-right">Save</button>
                                <button v-else type="submit" @click.prevent="updateInvestment" class="btn btn-info pull-right">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="box box-primary" id="exphead">
                        <div class="box-header with-border">
                            <h3 class="box-title">Investments List</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="download_label">Investments List</div>
                            <div class="table-responsive mailbox-messages">
                                <table class="table table-striped table-bordered table-hover" id="dataTable">
                                    <thead>
                                    <tr>
                                        <th>Investment Name</th>
                                        <th>Invest Date</th>
                                        <th>Capital</th>
                                        <th>Return Capital</th>
                                        <th>Note</th>
                                        <th class="text-right no-print">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="investment in investments" :key="investment.id">
                                        <td>{{investment.name}}</td>
                                        <td>{{investment.invest_date}}</td>
                                        <td>{{investment.amount}}</td>
                                        <td>{{investment.return_capital}}</td>
                                        <td>{{investment.note}}</td>
                                        <td class="mailbox-date pull-right no-print">
                                            <router-link :to="{name:'viewInvestment', params:{id:investment.id}}" class="btn btn-success btn-xs" data-toggle="tooltip" title="Investment Details">
                                                <i class="fa fa-eye"></i>
                                            </router-link>
                                            <button @click="editInvestment(investment)" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit Investment">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button @click="deleteInvestment(investment.id)" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete Investment" >
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
        name: "InvestmentList",
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
            this.allInvestment();
            this.resetData();

        },
        data(){
            return{
                investments:[],
                form:{
                    name: null,
                    invest_date: '',
                    return_capital: '',
                    amount: '',
                    note: '',
                    investment_id: '',
                    user_id: User.id(),
                },
                errors:{}
            }
        },
        watch: {
            investments(val) {
                this.dt.destroy();
                this.$nextTick(() => {
                    this.dt = $('#dataTable').DataTable()
                });
            }
        },

        methods:{
            allInvestment(){
                axios.get('/api/investment'+'?userId='+User.id())
                    .then(({data}) => (this.investments = data))
                    .catch()
            },

            addInvestment(){
                let _this = this;
                axios.post('/api/investment',this.form)

                    .then(res => {
                        toastr.success('Investment Add Successfully', {timeOut: 500});
                        _this.allInvestment();
                        this.resetData();
                    })
                    .catch(error => {
                        if(error.response.data != undefined) {
                            toastr.error(error.response.data, {timeOut: 500});
                        }
                        this.errors = error.response.data.errors
                    })
            },
            updateInvestment(){
                let id = this.form.investment_id;
                let _this = this;
                axios.patch('/api/investment/'+id,this.form)
                    .then(res=>{
                        toastr.success('Investment Update Successfully', {timeOut: 500});
                        _this.allInvestment();
                        this.resetData();
                    })
                    .catch(error => {
                        if(error.response.data != undefined) {
                            toastr.error(error.response.data, {timeOut: 500});
                        }
                        this.errors = error.response.data.errors
                    })
            },
            formReset(){
                this.resetData();
            },
            editInvestment: function(investment){
                this.form.name = investment.name;
                this.form.invest_date = investment.invest_date;
                this.form.return_capital = investment.return_capital;
                this.form.amount = investment.amount;
                this.form.note = investment.note;
                this.form.investment_id = investment.id;
            },
            resetData(){
                this.form.name = '';
                this.form.invest_date = '';
                this.form.return_capital = '';
                this.form.amount = '';
                this.form.note = '';
                this.errors=''
            },
            deleteInvestment(id){
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
                        axios.delete('/api/investment/'+id)
                            .then(() =>{
                                this.investments = this.investments.filter(investment=>{
                                    return investment.id != id
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