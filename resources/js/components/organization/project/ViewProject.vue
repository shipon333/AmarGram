<template>
    <div>
        <section class="content">
            <div class="row">
                <div class="col-md-3">
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <h3 class="profile-username text-center">Project Name: {{ project.name }}</h3>
                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item listnoback">
                                    <b>Location</b> <a class="pull-right text-aqua">{{project.location}}</a>
                                </li>
                                <li class="list-group-item listnoback">
                                    <b>Budget</b> <a class="pull-right text-aqua">{{project.budget}}</a>
                                </li>
                                <li class="list-group-item listnoback">
                                    <b>Start Date</b> <a class="pull-right text-aqua">{{project.start_date}}</a>
                                </li>
                                <li class="list-group-item listnoback">
                                    <b>End Date</b> <a class="pull-right text-aqua">{{project.end_date}}</a>
                                </li>
                                <li class="list-group-item listnoback">
                                    <b>Description</b> <a class="pull-right text-aqua">{{project.description}}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#donation" data-toggle="tab" aria-expanded="true">Donations</a></li>
                            <li class=""><a href="#expense" data-toggle="tab" aria-expanded="false">Expenses</a></li>
                            <li class=""><a href="#documents" data-toggle="tab" aria-expanded="false">Documents</a></li>

                            <li class="pull-right" v-if="project.status==1">
                                <a @click.prevent="" class="text-red" data-toggle="tooltip" title="Disable">
                                    <i class="fa fa-thumbs-o-down"></i>
                                </a>
                            </li>
                            <li class="pull-right" v-if="project.status==0">
                                <a @click.prevent="" class="text-green" data-toggle="tooltip" title="Enable">
                                    <i class="fa fa-thumbs-o-up"></i>
                                </a>
                            </li>
                            <li class="pull-right">
                                <router-link to="/donation/create" class="text-green" data-toggle="tooltip" title="Add Donation">
                                    <i class="fa fa-plus-circle"></i>
                                </router-link>
                            </li>
                            <li class="pull-right">
                                <router-link to="/expense/create" class="text-red" data-toggle="tooltip" title="Add Expense">
                                    <i class="fa fa-plus"></i>
                                </router-link>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="donation">
                                <div class="tshadow mb25 bozero">
                                    <div class="table-responsive around10 pt0">
                                        <table class="table table-striped table-bordered table-hover example" id="dataTable">
                                            <thead>
                                            <tr>
                                                <th>Donation Date</th>
                                                <th>Donor Name</th>
                                                <th>Amount</th>
                                                <th>Note</th>
                                                <th class="text-right no-print">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="donation in project.donations" :key="donation.id">
                                                <td>{{ donation.donation_date }}</td>
                                                <td v-if="donation.donor_name != null">{{ donation.donor_name }}</td>
                                                <td v-else>
                                                    <router-link :to="{name:'showPeople', params:{id:donation.people.id}}">
                                                        {{ donation.people.name }}
                                                    </router-link>
                                                </td>
                                                <td>{{ donation.amount }}</td>
                                                <td>{{ donation.note }}</td>
                                                <td class="mailbox-date pull-right no-print">
                                                    <router-link :to="{name:'donationEdit', params:{id:donation.id}}" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Donation Edit">
                                                        <i class="fa fa-pencil"></i>
                                                    </router-link>
                                                    <button @click="deleteDonation(donation.id)" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete Donation" >
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>

                                            </tbody>
                                        </table><!-- /.table -->
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="expense">
                                <div class="tshadow mb25 bozero">
                                    <div class="table-responsive around10 pt0">
                                        <table class="table table-striped table-bordered table-hover example" id="">
                                            <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Expense Type</th>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Notes</th>
                                                <th class="text-right no-print">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="expense in project.expenses" :key="expense.id">
                                                <td>{{ expense.title }}</td>
                                                <td>{{ expense.expense_type.name }}</td>
                                                <td>{{ expense.date }}</td>
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
        name: "ShowProject",
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
                project:[]
            }
        },
        mounted(){
            this.getProject(this.$route.params.id);
        },
        methods:{
            getProject(id){
                axios.get('/api/project/'+id)
                    .then(({data})=> (this.project = data))
                    .catch(error =>{
                        this.errors = error.response.data.errors
                    })
            },
            deleteDonation(id){
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
                        axios.delete('/api/donation/'+id)
                            .then(() =>{
                                this.project.donations = this.project.donations.filter(donation=>{
                                    return donation.id != id
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
                                this.project.expenses = this.project.expenses.filter(expense=>{
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
