<template>
    <div>
        <section class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary" id="exphead">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-money"></i> Donations List</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="download_label">Donations List</div>
                            <div class="table-responsive mailbox-messages">
                                <table class="table table-striped table-bordered table-hover" id="dataTable">
                                    <thead>
                                    <tr>
                                        <th>Donation Date</th>
                                        <th>Donor Name</th>
                                        <th>Project Name</th>
                                        <th>Amount</th>
                                        <th>Note</th>
                                        <!--<th>Received By</th>-->
                                        <th class="text-right no-print">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="donation in donations" :key="donation.id">
                                        <td>{{ donation.donation_date }}</td>
                                        <td v-if="donation.donor_name != null">{{ donation.donor_name }}</td>
                                        <td v-else>
                                            <router-link :to="{name:'showPeople', params:{id:donation.people.id}}">
                                                {{ donation.people.name }}
                                            </router-link>
                                        </td>
                                        <td v-if="donation.project_id != ''">
                                            <router-link :to="{name:'viewProject', params:{id:donation.project.id}}">
                                                {{ donation.project.name }}
                                            </router-link>
                                        </td>
                                        <td v-else>-</td>
                                        <td>{{ donation.amount }}</td>
                                        <td>{{ donation.note }}</td>
                                        <!--<td>-->
                                            <!--<router-link :to="{name:'showPeople', params:{id:donation.received_by.id}}">-->
                                                <!--{{ donation.received_by.name }}-->
                                            <!--</router-link>-->
                                        <!--</td>-->
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
        name: "DonationList",
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
            this.allDonation();

        },
        data(){
            return{
                donations:[]
            }
        },
        watch: {
            donations(val) {
                this.dt.destroy();
                this.$nextTick(() => {
                    this.dt = $('#dataTable').DataTable()
                });
            }
        },

        methods:{
            allDonation(){
                axios.get('/api/donation'+'?userId='+User.id())
                    .then(({data}) => (this.donations = data))
                    .catch()
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
                                this.donations = this.donations.filter(donation=>{
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
            }
        }
    }
</script>

<style scoped>
    .content{
        margin-left: 200px;
    }
</style>