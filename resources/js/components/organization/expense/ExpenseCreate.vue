<template>
    <div>
        <section class="content">
            <div class="row">
                <div class="col-lg-6 col-md-offset-3">
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-money"></i> New Expense</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form >
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Expense Title</label><small class="req"> *</small>
                                            <input v-model="form.title"  placeholder="Expense Title" type="text" class="form-control">
                                            <small class="text-danger" v-if="errors.title">{{errors.title[0]}}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date of Expense</label><small class="req"> *</small>
                                            <input v-model="form.expense_date" placeholder="Expense Date" type="date" class="form-control" required>
                                            <small class="text-danger" v-if="errors.expense_date">{{errors.expense_date[0]}}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="project">Project Name</label>
                                            <select v-model="form.project_id" id="project" class="form-control" >
                                                <option value="">Select Project</option>
                                                <option :value="project.id" v-for="project in projects">{{project.name}}</option>
                                            </select>
                                            <small class="text-danger" v-if="errors.project_id">{{errors.project_id[0]}}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="project">Expense Type*</label>
                                            <select v-model="form.expense_type_id" class="form-control" required>
                                                <option value="">Select a Type</option>
                                                <option :value="type.id" v-for="type in expense_types">{{type.name}}</option>
                                            </select>
                                            <small class="text-danger" v-if="errors.expense_type_id">{{errors.expense_type_id[0]}}</small>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Expense Amount</label>
                                            <input v-model="form.amount"  placeholder="Expense Amount" type="text" class="form-control">
                                            <small class="text-danger" v-if="errors.amount">{{errors.amount[0]}}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="account">Expense From</label><small class="req"> *</small>
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
                                <button type="submit" @click.prevent="addExpense" class="btn btn-success pull-right">Save Expense</button>
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
        name: "ExpenseCreate",
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
            this.getProjects();
            this.getExpenseTypes();
            this.getAccounts();
        },
        data(){
            return{
                projects:[],
                expense_types:[],
                accounts:[],
                form:{
                    title: '',
                    expense_date: '',
                    expense_type_id: '',
                    project_id: '',
                    amount: '',
                    note: '',
                    account_id: '',
                    user_id: User.id(),
                },
                errors:{}
            }
        },
        methods:{
            getProjects(){
                axios.get('/api/projects/active'+'?userId='+User.id())
                    .then(({data}) => (this.projects = data))
                    .catch()
            },
            getExpenseTypes(){
                axios.get('/api/expense-type'+'?userId='+User.id())
                    .then(({data}) => (this.expense_types = data))
                    .catch()
            },
            getAccounts(){
                axios.get('/api/account'+'?userId='+User.id())
                    .then(({data}) => (this.accounts = data))
                    .catch()
            },

            addExpense(){
                let _this = this;
                axios.post('/api/expense',this.form)

                    .then(res => {
                        toastr.success('Expense Add Successfully', {timeOut: 500});
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
                this.form.expense_type_id = '';
                this.form.amount = '';
                this.form.expense_date = '';
                this.form.project_id = '';
                this.form.account_id = '';
                this.form.note = '';
                this.errors=''
            }
        }
    }
</script>
