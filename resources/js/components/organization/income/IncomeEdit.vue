<template>
    <div>
        <section class="content">
            <div class="row">
                <div class="col-lg-6 col-md-offset-3">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-money"></i> Edit Income</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form>
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
                                            <input v-model="form.date" placeholder="Income Date" type="date" class="form-control" required>
                                            <small class="text-danger" v-if="errors.date">{{errors.date[0]}}</small>
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
                                <button type="submit" @click.prevent="updateIncome" class="btn btn-success pull-right">Update Income</button>
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
        name: "IncomeEdit",
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
            this.getInvestments();
            this.getIncomeTypes();
        },
        computed:{
        },
        data(){
            return{
                income:[],
                investments:[],
                income_types:[],
                form:{
                    title: '',
                    date: '',
                    income_type_id: '',
                    investment_id: '',
                    amount: '',
                    note: '',
                    account_id: '',
                },
                errors:{}
            }
        },
        created(){
            var id = this.$route.params.id
            axios.get('/api/income/'+id)
                .then(({data})=> (this.form = data))
                .catch(error =>{
                    this.errors = error.response.data.errors
                })
        },
        methods: {
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
            updateIncome(){
                var id = this.$route.params.id;
                axios.patch('/api/income/'+id,this.form)
                    .then(res => {
                        this.$router.push({name:'incomeList'});
                        toastr.success('Income Update Successfully', {timeOut: 500});

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