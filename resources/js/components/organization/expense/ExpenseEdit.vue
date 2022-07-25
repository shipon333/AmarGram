<template>
    <div>
        <section class="content">
            <div class="row">
                <div class="col-lg-6 col-md-offset-3">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-money"></i> Edit Expense</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form>
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
                                            <input v-model="form.date" placeholder="Expense Date" type="date" class="form-control" required>
                                            <small class="text-danger" v-if="errors.date">{{errors.date[0]}}</small>
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
                                <button type="submit" @click.prevent="updateExpense" class="btn btn-success pull-right">Update Expense</button>
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
        name: "ExpenseEdit",
        beforeCreate(){
            if (!User.loggedIn()){
                this.$router.push({name:'/'})
            }
            if ( User.loggedIn() && User.userType() != "org") {
                this.$router.back();
            }
        },
        mounted(){
            console.log(User.id())
            this.getProjects();
            this.getExpenseTypes();
        },
        computed:{
        },
        data(){
            return{
                expense:[],
                projects:[],
                expense_types:[],
                form:{
                    title: '',
                    date: '',
                    expense_type_id: '',
                    project_id: '',
                    amount: '',
                    note: '',
                    account_id: '',
                },
                errors:{}
            }
        },
        created(){
            var id = this.$route.params.id
            axios.get('/api/expense/'+id)
                .then(({data})=> (this.form = data))
                .catch(error =>{
                    this.errors = error.response.data.errors
                })
        },
        methods: {
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
            updateExpense(){
                var id = this.$route.params.id;
                axios.patch('/api/expense/'+id,this.form)
                    .then(res => {
                        this.$router.push({name:'expenseList'});
                        toastr.success('Expense Update Successfully', {timeOut: 500});

                    })
                    .catch(error => {
                        if(error.response.data != undefined) {
                            toastr.error(error.response.data, {timeOut: 500});
                        }
                        this.errors = error.response.data.errors
                    })
            },

        }
    }
</script>

<style scoped>
    .content{
        margin-left: 200px;
    }
</style>