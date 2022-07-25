<template>
    <div>
        <section class="content">
            <div class="row">
                <div class="col-lg-6 col-md-offset-3">
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-money"></i> New Income</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form >
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Income Title</label><small class="req"> *</small>
                                            <input v-model="form.title"  placeholder="Income Title" type="text" class="form-control">
                                            <small class="text-danger" v-if="errors.title">{{errors.title[0]}}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date of Income</label><small class="req"> *</small>
                                            <input v-model="form.income_date" placeholder="Income Date" type="date" class="form-control" required>
                                            <small class="text-danger" v-if="errors.income_date">{{errors.income_date[0]}}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="investment">Investment Name</label>
                                            <select v-model="form.investment_id" id="investment" class="form-control" >
                                                <option value="">Select Investment</option>
                                                <option :value="investment.id" v-for="investment in investments">{{investment.name}}</option>
                                            </select>
                                            <small class="text-danger" v-if="errors.investment_id">{{errors.investment_id[0]}}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="investment">Income Type*</label>
                                            <select v-model="form.income_type_id" class="form-control" required>
                                                <option value="">Select a Type</option>
                                                <option :value="type.id" v-for="type in income_types">{{type.name}}</option>
                                            </select>
                                            <small class="text-danger" v-if="errors.income_type_id">{{errors.income_type_id[0]}}</small>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Income Amount</label>
                                            <input v-model="form.amount"  placeholder="Income Amount" type="text" class="form-control">
                                            <small class="text-danger" v-if="errors.amount">{{errors.amount[0]}}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="account">Received Account</label><small class="req"> *</small>
                                            <select v-model="form.account_id" id="account" class="form-control">
                                                <option value="">Select Account Name</option>
                                                <option :value="account.id" v-for="account in accounts">{{account.name}}</option>
                                            </select>
                                            <small class="text-danger" v-if="errors.account_id">{{errors.account_id[0]}}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Comment/Note</label>
                                            <textarea v-model="form.note"  placeholder="Note" class="form-control" rows="5"></textarea>
                                            <small class="text-danger" v-if="errors.note">{{errors.note[0]}}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button  type="reset" class="btn btn-danger pull-left">Reset</button>
                                <button type="submit" @click.prevent="addIncome" class="btn btn-success pull-right">Save Income</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        name: "IncomeCreate",
        beforeCreate(){
            if (!User.loggedIn()){
                this.$router.push({name:'/'})
            }
            if ( User.loggedIn() && User.userType() != "org") {
               this.$router.back();
            }
        },

        mounted(){
            this.resetData();
            this.getInvestments();
            this.getIncomeTypes();
            this.getAccounts();
        },
        data(){
            return{
                investments:[],
                income_types:[],
                accounts:[],
                form:{
                    title: '',
                    income_date: '',
                    income_type_id: '',
                    investment_id: '',
                    amount: '',
                    note: '',
                    account_id: '',
                    user_id: User.id(),
                },
                errors:{}
            }
        },
        methods:{
            getInvestments(){
                axios.get('/api/investments/active'+'?userId='+User.id())
                    .then(({data}) => (this.investments = data))
                    .catch()
            },
            getIncomeTypes(){
                axios.get('/api/income-type'+'?userId='+User.id())
                    .then(({data}) => (this.income_types = data))
                    .catch()
            },
            getAccounts(){
                axios.get('/api/account'+'?userId='+User.id())
                    .then(({data}) => (this.accounts = data))
                    .catch()
            },

            addIncome(){
                let _this = this;
                axios.post('/api/income',this.form)

                    .then(res => {
                        toastr.success('Income Add Successfully', {timeOut: 500});
                        this.formReset();
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
            resetData(){
                this.form.title = '';
                this.form.income_type_id = '';
                this.form.amount = '';
                this.form.income_date = '';
                this.form.investment_id = '';
                this.form.account_id = '';
                this.form.note = '';
                this.errors=''
            }
        }
    }
</script>
