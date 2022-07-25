<template>
    <div>
        <section class="content">
            <div class="row">
                <div class="col-lg-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"> <i class="fa fa-plus-square"></i> Add Income Type</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form >
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="name">Income Type Name</label><small class="req"> *</small>
                                    <input autofocus="" id="name" v-model="form.name"  placeholder="Income Type Name" type="text" class="form-control" autocomplete="off">
                                    <small class="text-danger" v-if="errors.name">{{errors.name[0]}}</small>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button  type="reset" class="btn btn-info pull-left">Reset</button>
                                <button v-if="form.income_type_id == ''" type="submit" @click.prevent="addIncomeType" class="btn btn-info pull-right">Save</button>
                                <button v-else type="submit" @click.prevent="updateIncomeType" class="btn btn-info pull-right">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="box box-primary" id="exphead">
                        <div class="box-header with-border">
                            <h3 class="box-title"> <i class="fa fa-list"></i> Income Type List</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="download_label">Income Type List</div>
                            <div class="table-responsive mailbox-messages">
                                <table class="table table-striped table-bordered table-hover" id="dataTable">
                                    <thead>
                                    <tr>
                                        <th>Income Type Name</th>
                                        <th class="text-right no-print">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="income_type in income_types" :key="income_type.id">
                                        <td class="mailbox-name">{{income_type.name}}</td>
                                        <td class="mailbox-date pull-right no-print">
                                            <button @click="editIncomeType(income_type)" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button @click="deleteIncomeType(income_type.id)" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" >
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
        name: "IncomeType",
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
             this.allIncomeType();
             this.resetData();
        },
        watch: {
            income_types(val) {
                this.dt.destroy();
                this.$nextTick(() => {
                    this.dt = $('#dataTable').DataTable()
                });
            }
        },

        data(){
            return{
                income_types:[],
                form:{
                    name: null,
                    income_type_id: '',
                    user_id: User.id(),
                },
                errors:{}
            }
        },

        methods:{
            allIncomeType(){
                axios.get('/api/income-type'+'?userId='+User.id())
                    .then(({data}) => (this.income_types = data))
                    .catch()
            },

            addIncomeType(){
                let _this = this;
                axios.post('/api/income-type',this.form)

                    .then(res => {
                        toastr.success('Income Type Add Successfully', {timeOut: 500});
                        _this.allIncomeType();
                        this.resetData();
                    })
                    .catch(error => {
                        _this.errors = error.response.data.errors

                    })
            },
            updateIncomeType(){
                let id = this.form.income_type_id;
                let _this = this;
                axios.patch('/api/income-type/'+id,this.form)
                    .then(res=>{
                        toastr.success('Income Type Update Successfully', {timeOut: 500});
                        _this.allIncomeType();
                        this.resetData();
                    })
                    .catch(error => {
                        _this.errors = error.response.data.errors

                    })
            },
            editIncomeType: function(income_type){
                this.form.name = income_type.name;
                this.form.income_type_id = income_type.id;
            },
            resetData(){
                this.form.name = '';
                this.form.income_type_id = '';
                this.errors=''
            },
            deleteIncomeType(id){
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
                        axios.delete('/api/income-type/'+id)
                            .then(() =>{
                                this.income_types = this.income_types.filter(income_type=>{
                                    return income_type.id != id
                                })
                            })
                            .catch(() =>{
                                _this.allIncomeType();
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